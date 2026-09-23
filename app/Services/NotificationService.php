<?php
namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function enqueue(array $data): bool
    {
        // $exists = Notification::where('event_type', $data['event_type'])
        //     ->where('branch_id',  $data['branch_id']  ?? null)
        //     ->where('session_id', $data['session_id'] ?? null)
        //     ->where('user_id',    $data['user_id']    ?? null)
        //     ->where('recipient',  $data['recipient']  ?? '')
        //     ->where('ref_id',     $data['ref_id']     ?? null)
        //     ->where('channel',    $data['channel']    ?? '')
        //     ->whereDate('created_at', today())
        //     ->whereIn('status', ['pending', 'sent'])
        //     ->exists();

      //  if ($exists) return false;  // ✅ uncomment kiya

        Notification::create([
            'user_id'       => $data['user_id']       ?? null,
            'branch_id'     => $data['branch_id']     ?? null,
            'session_id'    => $data['session_id']    ?? null,
            'channel'       => $data['channel']       ?? '',
            'recipient'     => $data['recipient']     ?? '',
            'message'       => $data['message']       ?? '',
            'event_type'    => $data['event_type']    ?? '',
            'ref_id'        => $data['ref_id']        ?? null,
            'scheduled_at'  => $data['scheduled_at']  ?? now(),
            'params'        => isset($data['params']) ? json_encode($data['params']) : null,
            'media_link'    => $data['media_link']    ?? null,
            'template_name' => $data['template_name'] ?? null,
        ]);

        return true;
    }

    public function processQueue(): void
    {
        Notification::where('status', 'pending')
            ->where('scheduled_at', '<=', now())
            ->where('retry_count', '<', env('NOTIFICATION_MAX_RETRY', 3))
            ->orderBy('scheduled_at')
            ->limit((int) env('NOTIFICATION_BATCH', 30))
            ->get()
            ->each(function ($notif) {
                $success  = $this->send($notif);
                $newRetry = $notif->retry_count + 1;
                $maxRetry = (int) env('NOTIFICATION_MAX_RETRY', 3);

                $notif->update([
                    'retry_count' => $newRetry,
                    'status'      => $success ? 'sent' : ($newRetry >= $maxRetry ? 'failed' : 'pending'),
                    'sent_at'     => $success ? now()->toDateTimeString() : null,
                ]);
            });
    }

    private function send(object $notif): bool
    {
        return match($notif->channel) {
            'whatsapp' => $this->sendWhatsApp(
                              $notif->recipient,
                              $notif->template_name,
                              json_decode($notif->params, true) ?? []
                          ),
            default => false,
        };
    }

    private function sendWhatsApp(string $phone, ?string $template, array $params = []): bool
{
    if (!$template) {
        Log::warning('WhatsApp skipped: template_name missing', ['phone' => $phone]);
        return false;
    }

    $phone = preg_replace('/^\+?91/', '', $phone);

    try {
        $res = Http::withHeaders([
            'apikey'       => env('WHATSAPP_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post(env('WHATSAPP_URL'), [
            'from'         => env('WHATSAPP_FROM'),
            'campaignName' => 'erp-notification',
            'to'           => '+91' . $phone,
            'templateName' => $template,
            'components'   => [
                'body' => ['params' => array_values($params)]
            ],
            'type'         => 'template',
        ]);

        // Pehle ye dekho Laravel log mein
        // Log::info('WhatsApp API response', [
        //     'status'   => $res->status(),
        //     'body'     => $res->body(),
        //     'json'     => $res->json(),
        // ]);

        return $res->successful();  // ✅ sirf HTTP 200 check karo abhi

    } catch (\Exception $e) {
        Log::error('WhatsApp exception: ' . $e->getMessage(), ['phone' => $phone]);
        return false;
    }
}
}