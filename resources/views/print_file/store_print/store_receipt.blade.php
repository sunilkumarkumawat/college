@php
$getSetting = Helper::getSetting();
$f = new \NumberFormatter('en_IN', \NumberFormatter::SPELLOUT);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{$data[0]['first_name'] ?? '' }}_Store_Receipt_{{ $data[0]['receipt_no'] ?? '' }}_{{date('d-m-Y', strtotime($data[0]['date'] ?? date('d-m-Y') ))}}</title>
    <style>
        /* ── Reset & Strict Structural Controls ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        
        :root {
            --brand-blue: #1e3a8a;         
            --brand-crimson: #dc2626;      
            --sun-yellow-light: #fffbeb;   
            --text-dark: #0f172a;
            --text-muted: #475569;
            --bg-canvas: #f1f5f9;
            --card-radius: 12px;
        }

        html, body {
            background: var(--bg-canvas);
            color: var(--text-dark);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            font-size: 13px;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Page Wrapper ── */
        .invoice-wrap {
            width: 820px;
            margin: 15px auto;
            page-break-inside: avoid;
            break-inside: avoid;
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

        /* ── Single-Page Card Container ── */
        .invoice-card {
            background: #ffffff;
            border-radius: var(--card-radius);
            border: 1px solid #cbd5e1;
            width: 100%;
            position: relative;
            padding: 24px 32px 90px 32px; /* Generous bottom padding protects content overlap from fixed footer */
            page-break-inside: avoid;
            break-inside: avoid;
        }

        /* ── Clean Header Layout ── */
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
        .inv-company-tag {
            font-size: 0.75rem;
            color: var(--brand-crimson);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
            /* display: grid; */
            grid-template-columns: 1.15fr 0.85fr;
            gap: 16px;
            align-items: stretch;
            margin-bottom: 5px;
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
        .terms-box ul {
            padding-left: 14px;
            margin: 0;
        }
        .terms-box ul li {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 3.5px;
            line-height: 1.45;
        }
        .terms-box ul li:last-child { margin-bottom: 0; }

        .corporate-signature-box {
            border: 1px solid #e2e8f0;
            background: #ffffff;
            border-radius: 8px;
            padding: 10px 14px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sig-meta-title {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 4px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 2px;
        }
        .sig-graphic-area {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: auto;
            padding-top: 10px;
        }
        .seal-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 1px solid var(--brand-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background: #fffdf5;
        }
        .seal-text-top { font-size: 0.45rem; color: var(--text-muted); }
        .seal-text-main { font-size: 0.52rem; color: var(--brand-blue); font-weight: 700; text-transform: uppercase; }
        
        .signature-line-wrap {
            text-align: center;
            min-width: 130px;
        }
        .signature-line {
            border-top: 1px solid #cbd5e1;
            margin-bottom: 4px;
        }
        .signature-label {
            font-size: 0.65rem;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
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
        .inv-footer-right { text-align: right; }
        .inv-footer-right a {
            font-size: 0.8rem;
            text-decoration: none;
            display: block;
            color: var(--brand-blue);
            font-weight: 600;
        }

        /* ══════════════════════════
            STRICT PRINT ECO-SYSTEM (Mobile Safe)
        ══════════════════════════ */
        @media print {
            @page { 
                size: A4; 
                margin: 0; /* Clears standard device printer margin leaks */
            }
            html, body { 
                background: #ffffff !important; 
                height: 100% !important;
                overflow: hidden !important; 
            }
            .invoice-wrap { 
                margin: 0; 
                width: 100%; 
            }
            .invoice-actions { 
                display: none !important; 
            }
            .invoice-card { 
                box-shadow: none !important; 
                border: none !important; 
                border-radius: 0 !important; 
                width: 100% !important; 
                height: 100vh !important; /* Perfect single viewport constraint lock */
                padding-bottom: 60px !important;
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
            .net-row,
            .info-box,
            .terms-box,
            .amt-words { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

<div class="invoice-wrap">

    {{-- Screen action panel bar control box --}}
    <div class="invoice-actions">
        <div>
            <div class="invoice-actions-title">Stationery & Store Receipt</div>
            <div class="invoice-actions-sub">{{ $data[0]['first_name'] ?? '' }} &bull; Institutional Inventory Registry</div>
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

        <div class="invoice-core-body">
            
            {{-- ── Institutional Header Block ── --}}
            <div class="inv-header">
                <div class="inv-logo-wrapper">
                    <div class="inv-logo">
                        <img src="{{ env('IMAGE_SHOW_PATH').'setting/left_logo/'.$getSetting->left_logo }}" alt="Gian Sagar Crest">
                    </div>
                    <div>
                        <div class="inv-company-name">{{$getSetting['name'] ?? 'Gian Sagar Educational and Charitable Trust
'}}</div>
                        <!--<div class="inv-company-tag">Education with Quality & Compassion</div>-->
                    </div>
                </div>
                <div class="inv-company-right">
                    <p><strong>Campus Address:</strong> {{$getSetting['address'] ?? 'Main Gate Compound'}}</p>
                    <p><strong>Helpdesk:</strong> {{$getSetting['mobile'] ?? 'N/A'}}</p>
                </div>
            </div>

            {{-- ── Title Banner ── --}}
            <div class="memo-title-bar">
                <div class="memo-title-text">Institutional Store Receipt</div>
                <div class="memo-date-text">Date: {{ date('d M Y', strtotime($data[0]['date'] ?? date('d-m-Y') )) }}</div>
            </div>

            {{-- ── Split Information Dataset Panels ── --}}
            <div class="meta-grid">
                
                {{-- Segment: Student Information --}}
                <div>
                    <div class="sec-label">Student Profile</div>
                    <div class="info-box">
                        <div class="info-row">
                            <span>Full Name</span>
                            <span>{{ $data[0]['first_name'] ?? '' }} {{$data[0]['last_name'] ?? '' }}</span>
                        </div>
                        <div class="info-row">
                            <span>Father's Name</span>
                            <span>{{$data[0]['father_name'] ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span>Admission Number</span>
                            <span>{{ $data[0]['admissionNo'] ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span>Class / Domain</span>
                            <span>{{ $data[0]['class_name'] ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span>Contact Metric</span>
                            <span>{{ $data[0]['mobile'] ?? '—' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Segment: Account Settlement Audit --}}
                <div>
                    <div class="sec-label">Account Settlement Audit</div>
                    <div class="info-box info-box-alt">
                        <div class="info-row">
                            <span>Receipt Number</span>
                            <span>{{ $data[0]['receipt_no'] ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span>Payment Mode</span>
                            <span style="text-transform: uppercase;">{{ $data[0]->payment_mode ?? 'Online/Cash' }}</span>
                        </div>
                        @if(!empty($data[0]->transaction_id))
                        <div class="info-row">
                            <span>Transaction Id</span>
                            <span style="font-family: monospace; font-size: 0.85rem; font-weight: bold;">{{ $data[0]->transaction_id }}</span>
                        </div>
                        @endif
                        <div class="info-row">
                            <span>Audit Date Stamp</span>
                            <span>{{ date('d-m-Y', strtotime($data[0]->date ?? now())) }}</span>
                        </div>
                        <div class="info-row">
                            <span>Transaction Status</span>
                            <span style="color: var(--brand-blue); font-weight: 700; text-transform:capitalize;"> {{ $data[0]->transaction_status ?? '' }}</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── Itemized Table ── --}}
            <div class="sec-label">Itemized Distribution Details</div>
            <table class="inv-table">
                <thead>
                    <tr>
                        <th style="width: 7%; text-align: center;">Index</th>
                        <th style="text-align: left;">Item Name</th>
                        <th class="c" style="width: 14%;">Quantity</th>
                        <th class="r" style="width: 20%;">Unit Rate</th>
                        <th class="r" style="width: 22%;">Net Balance</th>
                    </t
                </thead>
                <tbody>
                @if(!empty($data))
                    @php
                    $total = 0;
                    $receiptNo = '';
                    $srNo = 1;
                    @endphp
                    @foreach($data as $item)
                        @php
                        $store_item_name = DB::table('store_items')->where('id',$item->store_item_id)->whereNull('deleted_at')->first();
                        $receiptNo = $item->receipt_no;
                        @endphp
                        <tr>
                            <td class="c" style="color: var(--text-muted); font-weight: 600;">{{ str_pad($srNo++, 2, '0', STR_PAD_LEFT) }}</td>
                            <td><strong>{{$store_item_name->name ?? 'Academic Supply Item'}}</strong></td>
                            <td class="c" style="font-weight: 700; color: var(--brand-blue);">{{$item->qty ?? 0}}</td>
                            <td class="r">Rs. {{ number_format((float)($item->price ?? 0), 2) }}</td>
                            <td class="r" style="font-weight: 700;">Rs. {{ number_format((float)($item->qty * $item->price), 2) }}</td>
                        </tr>
                        @php
                        $total += ($item->qty * $item->price);
                        @endphp
                    @endforeach
                @endif
                </tbody>
                <tfoot>
                    @php
                    $transactions = DB::table('store_item_billing_details')->where('receipt_no',$receiptNo)->where('session_id', Session::get('session_id'))->where('branch_id', Session::get('branch_id'))->whereNull('deleted_at')->get();
                    $total_transactions = 0;
                    if(!empty($transactions)){
                        foreach($transactions as $transaction){
                            if($transaction->amount > 0){
                                $total_transactions += $transaction->amount ?? 0;
                            }
                        }
                    }
                    @endphp
                    <tr class="net-row">
                        <td colspan="4" class="r" style="font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px;">Net Paid Amount:</td>
                        <td class="r net-amt">Rs. {{ number_format((float)($total ?? 0), 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            {{-- Currency Conversion Banner ── --}}
            @php
                $words = $f->format($total);
                $words .= ' rupees';
            @endphp
            <div class="amt-words">
                Total Amount In Words: &nbsp;<span style="text-transform: capitalize; font-weight: 700;">{{ $words ?? '' }} Only</span>
            </div>

            {{-- ── Guidelines & Secure E-Stamp Verification Block ── --}}
            <div class="lower-grid">
                <div class="terms-box">
                    <div class="terms-title">⚡ Institutional Dispatch Guidelines & Terms:</div>
                    <ul>
                        <li>Please retain this store receipt safely for item verification and future semester-end inventory clearances.</li>
                        <li>This electronically generated receipt logs and acknowledges the final delivery validation of the listed material packs and academic supplies (e.g., Books, Uniforms, Kits, Stationery).</li>
                        <li>Issued securely via the single-window automated campus asset ecosystem; no manual signatures are required.</li>
                        <li>For dispatch claims, reporting item discrepancies, or billing questions, kindly contact the Inventory Helpdesk at [{{$getSetting['mobile'] ?? ''}}].</li>
                        <li>Thank you for utilizing the campus single-window student services portal of [{{$getSetting['name'] ?? ''}}].</li>
                    </ul>
                </div>
                
                <!-- <div class="corporate-signature-box">
                    <div class="sig-meta-title">Cryptographic Sync Pass</div>
                    <div class="sig-graphic-area">
                        <div class="seal-circle">
                            <span class="seal-text-top">CENTRAL</span>
                            <span class="seal-text-main">AUDIT</span>
                        </div>
                        <div class="signature-line-wrap">
                            <div class="signature-line"></div>
                            <div class="signature-label">Accounts Officer Desk</div>
                        </div>
                    </div>
                </div> -->
            </div>

        </div>{{-- /invoice-core-body --}}

        <div class="inv-footer">
            <div class="inv-footer-left">
                <strong>{{ $getSetting['name'] ?? '' }}</strong> &nbsp;|&nbsp; 
                {{ $getSetting['address'] ?? '' }} &nbsp;|&nbsp; 
                Ph No: {{ $getSetting['phone'] ?? '' }} &bull; Pin: {{ $getSetting['pincode'] ?? '' }}
            </div>
        </div>

    </div>{{-- /invoice-card --}}
</div>{{-- /invoice-wrap --}}

</body>
</html>