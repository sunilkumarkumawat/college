@php
$getSetting = Helper::getSetting();
$account = Helper::getQRCode($getSetting->account_id);
$images = $getSetting['base64logo'] ?? env('IMAGE_SHOW_PATH').'/default/rukmani_logo.png';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reg['first_name'] ?? '' }}_Registration_Receipt_{{ date('d-m-Y', strtotime($data[0]->created_at ?? date('Y-m-d'))) }}</title>
    <style>
        /* ── Reset & Strict Global Print Variables (Matching Store Theme) ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        
        :root {
            --brand-blue: #1e3a8a;         /* Logo Royal Blue */
            --brand-crimson: #dc2626;      /* Logo Crimson Red */
            --sun-yellow-light: #fffbeb;   /* Logo Sun Yellow Soft Tint */
            --text-dark: #0f172a;
            --text-muted: #475569;
            --bg-canvas: #f1f5f9;
            --card-radius: 12px;
        }

        html, body {
            background: var(--bg-canvas);
            color: var(--text-dark);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            font-size: 13px; /* High Visible Base Size */
            -webkit-font-smoothing: antialiased;
        }

        /* ── Page Wrapper ── */
        .invoice-wrap {
            width: 820px;
            margin: 15px auto;
            page-break-inside: avoid;
            break-inside: avoid;
            position: relative;
        }

        /* ── Screen Action Header ── */
        .invoice-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            background: #ffffff;
            padding: 14px 24px;
            border-radius: var(--card-radius);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
            border-left: 4px solid var(--brand-blue);
        }
        .invoice-actions-title { font-size: 1.2rem; font-weight: 700; color: var(--brand-blue); }
        .invoice-actions-sub   { font-size: 0.85rem; color: var(--text-muted); margin-top: 2px; }
        .btn-print {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--brand-blue);
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-print:hover { background: #122558; }

        /* ── Mobile Friendly Flex Container for Perfect Single Page Output ── */
        .invoice-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 100%;
            min-height: 980px;
            background: #ffffff;
            border-radius: var(--card-radius);
            border: 1px solid #cbd5e1;
            page-break-inside: avoid;
            break-inside: avoid;
            overflow: hidden;
            position: relative;
        }

        /* ── Core Content Wrapper ── */
        .invoice-core-body {
            padding: 24px 32px 10px 32px;
            flex-grow: 1;
        }

        /* ── Institutional Header Block ── */
        .inv-header {
            padding-bottom: 12px;
            margin-bottom: 16px;
            border-bottom: 1px solid #e2e8f0;
            border-left: 5px solid var(--brand-crimson);
            padding-left: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .inv-logo-wrapper {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .inv-logo img {
            height: 56px;
            width: auto;
            object-fit: contain;
        }
        .inv-company-name {
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--brand-blue);
            letter-spacing: -0.5px;
            line-height: 1.2;
        }
        .inv-company-right { text-align: right; }
        .inv-company-right p {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 2px;
            font-weight: 500;
        }

        /* ── Title Banner Ribbon ── */
        .memo-title-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f1f5f9;
            padding: 8px 16px;
            border-radius: 6px;
            margin-bottom: 16px;
        }
        .memo-title-text {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--brand-blue);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .memo-date-text {
            font-size: 0.85rem;
            color: var(--text-dark);
            font-weight: 700;
        }

        /* ── Section Label ── */
        .sec-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--brand-blue);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }
        .sec-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #cbd5e1;
            margin-left: 10px;
        }

        /* ── Twin Column Grid ── */
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 16px;
        }

        .info-box {
            background: var(--sun-yellow-light);
            border: 1px solid #fef08a;
            border-radius: 8px;
            padding: 10px 16px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px dashed #f59e0b;
            font-size: 0.85rem;
        }
        .info-box-alt .info-row { border-bottom-color: #cbd5e1; }
        .info-box-alt { background: #f8fafc; border-color: #e2e8f0; }
        
        .info-row:last-child { border-bottom: none; }
        .info-row span:first-child { color: var(--text-muted); font-weight: 500; }
        .info-row span:last-child  { color: var(--text-dark); font-weight: 700; }

        /* ── Clean Content Table ── */
        .inv-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .inv-table thead tr {
            background: var(--brand-blue);
        }
        .inv-table thead th {
            padding: 9px 14px;
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .inv-table thead th.r { text-align: right; }
        .inv-table thead th.c { text-align: center; }

        .inv-table tbody tr { border-bottom: 1px solid #e2e8f0; }
        .inv-table tbody tr:nth-child(even) { background: #f8fafc; }
        .inv-table tbody td {
            padding: 11px 14px;
            font-size: 0.9rem;
            color: var(--text-dark);
            vertical-align: middle;
        }
        .inv-table tbody td.r { text-align: right; }
        .inv-table tbody td.c { text-align: center; }

        .inv-table tfoot td {
            padding: 8px 14px;
            font-size: 0.85rem;
        }
        .inv-table tfoot td.r { text-align: right; }
        
        .bg_color_heading td {
            background-color: #f8fafc;
            font-weight: 700;
            border: 1px solid #e2e8f0;
        }
        .net-row { background: #fef2f2; }
        .net-row td { font-size: 0.92rem !important; font-weight: 700 !important; color: var(--brand-crimson) !important; border-top: 1px solid #fca5a5; }
        .net-amt { font-size: 1.1rem !important; font-weight: 800 !important; color: var(--brand-crimson) !important; }

        /* ── Amount Words Ribbon ── */
        .amt-words {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 0.85rem;
            color: #14532d;
            font-weight: 600;
            margin-bottom: 16px;
        }

        /* ── Lower Panels Matrix ── */
        .lower-grid {
            grid-template-columns: 1.15fr 0.85fr;
            gap: 16px;
            align-items: stretch;
            margin-bottom: 15px;
        }
        .terms-box {
            border: 1px solid #e2e8f0;
            background: #fafafa;
            border-radius: 8px;
            padding: 10px 14px;
        }
        .terms-title {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--brand-blue);
            margin-bottom: 4px;
        }
        .terms-box ul, .terms-box ol {
            padding-left: 14px;
            margin: 0;
        }
        .terms-box ul li, .terms-box ol li {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 3.5px;
            line-height: 1.45;
        }

        /* ── Absolute Bottom Screen/Web Footer Block ── */
        .inv-footer {
            border-top: 1px solid #cbd5e1;
            background: #f8fafc;
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
        }
        .inv-footer-left { font-size: 0.8rem; color: var(--text-muted); }
        .inv-footer-left strong { color: var(--brand-blue); }

        /* ── Print Core Ecosystem ── */
        @media print {
            @page { size: A4 portrait; margin: 0; }
            html, body { 
                background: #ffffff !important; 
                height: 100% !important;
                overflow: hidden !important; 
            }
            .invoice-wrap { margin: 0; width: 100%; }
            .invoice-actions { display: none !important; }
            .invoice-card { 
                box-shadow: none !important; 
                border: none !important; 
                border-radius: 0 !important; 
                width: 100% !important; 
                height: 100vh !important; 
            }
            
            /* FORCE FOOTER TO HARDBOUND PRINT ZONE BOTTOM */
            .inv-footer {
                position: fixed !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                width: 100% !important;
                background: #f8fafc !important;
                border-top: 1px solid #cbd5e1 !important;
                padding: 14px 32px !important;
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact;
                z-index: 9999 !important;
            }

            .inv-header,
            .memo-title-bar,
            .inv-table thead tr,
            .bg_color_heading,
            .info-box,
            .terms-box,
            .amt-words,
            .net-row { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body class="page">

<div class="invoice-wrap">

    {{-- Screen Action Controls Header --}}
    <div class="invoice-actions">
        <div>
            <div class="invoice-actions-title">Registration Fees Receipt</div>
            <div class="invoice-actions-sub">{{ $reg['first_name'] ?? '' }} &bull; Admission Desk</div>
        </div>
        <button class="btn-print" onclick="window.print()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                <rect x="6" y="14" width="12" height="8"></rect>
            </svg>
            Print/Save PDF
        </button>
    </div>

    <div class="invoice-card">

        <!-- Core Document Body -->
        <div class="invoice-core-body">
            
            {{-- ── Institutional Header Block ── --}}
            <div class="inv-header">
                <div class="inv-logo-wrapper">
                    <div class="inv-logo">
                        <img src="{{ $images }}" style="height: 56px; width: auto; object-fit: contain;" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/rukmani_logo.png' }}'">
                    </div>
                    <div>
                        <div class="inv-company-name">{{ $getSetting['name'] ?? '' }}</div>
                    </div>
                </div>
                <div class="inv-company-right">
                    <p><strong>Campus Address:</strong> {{ $getSetting['address'] ?? '' }}</p>
                    <p><strong>Helpdesk:</strong> {{ $getSetting['mobile'] ?? '' }} </p>
                </div>
            </div>

            {{-- ── Title Banner Ribbon ── --}}
            <div class="memo-title-bar">
                <div class="memo-title-text">Official Registration Acknowledgment</div>
                <div class="memo-date-text">Reg. Date: {{ date('d M Y', strtotime($data[0]->created_at ?? date('Y-m-d'))) }}</div>
            </div>

            {{-- ── Twin Column Student & Registration profiling Matrix ── --}}
            <div class="meta-grid">
                
                {{-- Box A: Applicant Demographics Info --}}
                <div>
                    <div class="sec-label">Applicant Information</div>
                    <div class="info-box">
                        <div class="info-row">
                            <span>Registration No.</span>
                            <span style="color: var(--brand-crimson);">{{ $reg['unique_registration_id'] ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span>Student Name</span>
                            <span>{{ $reg['first_name'] ?? '' }}</span>
                        </div>
                        <div class="info-row">
                            <span>Father's Name</span>
                            <span>{{ $reg['father_name'] ?? '' }}</span>
                        </div>
                        <div class="info-row">
                            <span>Gender</span>
                            <span>{{ $data[0]['gender_name'] ?? '' }}</span>
                        </div>
                        <div class="info-row">
                            <span>Category</span>
                            <span>{{ $reg['category'] ?? '' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Box B: Registration Audit Info --}}
                <div>
                    <div class="sec-label">Registry Audit</div>
                    <div class="info-box info-box-alt">
                        @php
                            $sessions = DB::table('sessions')->whereNull('deleted_at')->where('id',$getSetting['current_active_session_id'])->first();
                            $payment_name = DB::table('payment_modes')->whereNull('deleted_at')->where('id', $data[0]->payment_mode_id ?? null)->first();
                        @endphp
                        <div class="info-row">
                            <span>Student Type</span>
                            <span>{{ $reg['student_type'] ?? '' }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span>Course / Stream</span>
                            <span>{{ $data[0]['course_name'] ?? '' }}</span>
                        </div>
                        <div class="info-row">
                            <span>Batch</span>
                            <span>{{ $reg['batch'] ?? '' }}</span>
                        </div>
                        <div class="info-row">
                            <span>Academic Session</span>
                            <span>{{ $sessions->from_year ?? '' }}-{{ $sessions->to_year ?? '' }}</span>
                        </div>
                        <!-- <div class="info-row">
                            <span>Payment Mode</span>
                            <span style="text-transform: uppercase;">{{ $payment_name->name ?? 'N/A' }}</span>
                        </div> -->
                        @if(!empty($data[0]->transition_id))
                        <!-- <div class="info-row">
                            <span>Transaction Id</span>
                            <span>
                                {{ $data[0]->bank_name ? ' '.$data[0]->bank_name : '' }} 
                                {{ $data[0]->transition_id ? ' '.$data[0]->transition_id : '' }}
                            </span>
                        </div> -->
                        @endif
                        <div class="info-row">
                            <span>Transaction Status</span>
                            <span style="color: var(--brand-blue); font-weight: 700; text-transform:capitalize;"> 
                                @if($data[0]->status == 0)
                                    Success
                                @elseif($data[0]->status == 1)
                                    Pending
                                @elseif($data[0]->status == 2)
                                    Canceled
                                @endif
                                    
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── Itemized Fee Heads Table ── --}}
            <div class="sec-label">Settled Registration Fee Breakdown</div>
            <table class="inv-table">
                <thead>
                    <tr>
                        <th style="width: 10%; text-align: center;">Sr. No.</th>
                        <th style="text-align: left;">Account Fee Head Particulars</th>
                        <th style="width: 15%; text-align: center;">Payment Date</th>
                        <th style="width: 10%; text-align: right;">Payment Mode</th>
                        <th style="width: 20%; text-align: right;">Paid Amount</th>
                    </tr>
                </thead>
                <tbody>
                @if(!empty($data))
                    @php
                        $i = 1;
                        $total_amount = 0;
                    @endphp
                    @foreach($data as $item)
                        @php
                            $feesGroup = DB::table('fees_group')->whereNull('deleted_at')->where('id',$item['fees_group_id'])->first();
                            $fee_amount = $item['fees_group_amount'] ?? 0;
                            $total_amount += $fee_amount;
                        @endphp
                        <tr>
                            <td class="c" style="color: var(--text-muted); font-weight: 600;">{{ str_pad($i++, 2, '0', STR_PAD_LEFT) }}</td>
                            <td><strong>{{ $feesGroup->name ?? 'Registration Fee Head' }}</strong></td>
                            <td class="c">{{ date('d-M-Y', strtotime($item['created_at'] ?? '')) }}</td>
                            <td class="r">{{ $item['payment_mode'] ?? '' }}</td>
                            <td class="r" style="font-weight: 700;">Rs. {{ number_format($fee_amount, 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="c" style="color: var(--text-muted);">No fee data found</td>
                    </tr>
                @endif
                </tbody>
                <tfoot>
                    <tr class="net-row">
                        <td colspan="4" class="r" style="font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px;">Net Paid Amount :</td>
                        <td class="r net-amt">Rs. {{ number_format($total_amount ?? 0, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            {{-- ── Currency Conversion Banner ── --}}
            @php
                $total_amount = $total_amount ?? 0;
                $formatter = new NumberFormatter('en_IN', NumberFormatter::SPELLOUT);
                $words = $formatter->format($total_amount);
                $words = ucwords($words); 
                $words .= ' Rupees Only';
            @endphp
            <div class="amt-words">
                 Total Collection Amount In Words: &nbsp;<span style="color: var(--brand-blue);">{{ $words }}</span>
            </div>

            {{-- ── Guidelines & Secure Auto Verification Area ── --}}
            <div class="lower-grid">
                <div class="terms-box">
                    <div class="terms-title">⚡ Institutional Clearance Guidelines</div>
                    <ol style="padding-left: 14px; margin: 0; line-height: 1.45;">
                        <li style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 3px;">Please retain this official registration acknowledgement safely for further admission processes.</li>
                        <li style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 3px;">This receipt confirms ledger clearance for the specified registration heads; it is auto-validated through the central campus node.</li>
                        <li style="font-size: 0.75rem; color: var(--text-muted);">This document is generated digitally through registry desks—hence no physical signature is required.</li>
                    </ol>
                </div>
            </div>

        </div>{{-- /invoice-core-body --}}

        <!-- Absolute Base Block: Fixed Organic Bottom Footer Block Element -->
        <div class="inv-footer">
            <div class="inv-footer-left">
                <strong>{{ $getSetting['name'] ?? '' }}</strong> &nbsp;|&nbsp; 
                {{ $getSetting['address'] ?? '' }} &nbsp;|&nbsp; 
                Ph No: {{ $getSetting['mobile'] ?? '' }}
            </div>
        </div>

    </div>{{-- /invoice-card --}}
</div>{{-- /invoice-wrap --}}

</body>
</html>