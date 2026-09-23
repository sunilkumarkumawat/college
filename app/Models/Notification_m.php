<?php

namespace App\Models;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends CI_Model {

    // ─── PUBLIC: Kahi se bhi call karo ──────────────────────────────────────

    /**
     * Koi bhi event notification queue mein daalo.
     * $data = ['recipient'=>'9876543210', 'message'=>'...', 'event_type'=>'fee_collected', 'ref_id'=>123]
     * Optional: 'scheduled_at' => '2025-06-01 08:00:00'  (future ke liye)
     * Optional: 'channel' => 'sms'  (default: whatsapp)
     */
    public function enqueue($data) {
        // Duplicate check: same event_type + ref_id + channel already pending/sent today?
        $exists = $this->db->where([
            'event_type' => $data['event_type'],
            'ref_id'     => $data['ref_id'],
            'channel'    => $data['channel'] ?? 'whatsapp',
        ])->where('DATE(created_at)', date('Y-m-d'))
          ->where_in('status', ['pending','sent'])
          ->count_all_results('notifications');

        if ($exists) return false;

        return $this->db->insert('notifications', [
            'channel'      => $data['channel']      ?? 'whatsapp',
            'recipient'    => $data['recipient'],
            'message'      => $data['message'],
            'event_type'   => $data['event_type'],
            'ref_id'       => $data['ref_id']        ?? null,
            'scheduled_at' => $data['scheduled_at']  ?? date('Y-m-d H:i:s'),
            'status'       => 'pending',
        ]);
    }

    // ─── CRON: Queue process karo ────────────────────────────────────────────

    public function processQueue() {
        $this->config->load('notification');

        $rows = $this->db->where('status', 'pending')
                         ->where('scheduled_at <=', date('Y-m-d H:i:s'))
                         ->where('retry_count <', $this->config->item('notif_max_retry'))
                         ->order_by('scheduled_at', 'ASC')
                         ->limit($this->config->item('notif_batch'))
                         ->get('notifications')->result_array();

        foreach ($rows as $row) {
            $success = $this->_send($row['channel'], $row['recipient'], $row['message']);

            $this->db->update('notifications', [
                'status'      => $success ? 'sent' : ($row['retry_count'] + 1 >= $this->config->item('notif_max_retry') ? 'failed' : 'pending'),
                'retry_count' => $row['retry_count'] + 1,
                'sent_at'     => $success ? date('Y-m-d H:i:s') : null,
            ], ['id' => $row['id']]);
        }
    }

    // ─── PRIVATE: Channel router (future mein sirf yahan add karo) ──────────

    private function _send($channel, $recipient, $message) {
        switch ($channel) {
            case 'whatsapp': return $this->_sendWhatsApp($recipient, $message);
            // case 'sms':      return $this->_sendSms($recipient, $message);
            // case 'push':     return $this->_sendPush($recipient, $message);
            // case 'email':    return $this->_sendEmail($recipient, $message);
            default: return false;
        }
    }

    private function _sendWhatsApp($phone, $message) {
        $this->config->load('notification');
        $ch = curl_init($this->config->item('whatsapp_url') . $phone);
        curl_setopt_array($ch, [
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => json_encode(['messageText' => $message]),
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $this->config->item('whatsapp_token'),
                'Content-Type: application/json'
            ],
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT        => 8,
        ]);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return !empty($res['result']);
    }

    /* Future channels — uncomment karo jab chahiye:

    private function _sendSms($phone, $message) {
        // TextLocal / MSG91 — 5 lines
    }
    private function _sendPush($token, $message) {
        // FCM — 5 lines
    }
    private function _sendEmail($email, $message) {
        // CI email lib — 4 lines
    }
    */
}