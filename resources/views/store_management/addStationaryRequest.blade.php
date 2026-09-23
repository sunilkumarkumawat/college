@php
  $classType = Helper::classType();
  $getSetting = Helper::getSetting();

  $storeItems = DB::table('store_items')->where('qty','>',0)->whereNull('deleted_at')->get();
  @endphp
@extends('layout.app') 
@section('content')

<style>
       .border_none {
            border: none;
        }
        .bg_color_heading {
            background-color: #f1f1f1;
        }
        @media print {
            button {
                display: none;
            }
            body {
                margin: 0;
                padding: 20px;
                font-family: Arial, sans-serif;
            }
            .page {
                width: 100%;
                border: 1px solid #000;
                padding: 20px;
                box-sizing: border-box;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
            }
            .bg_color_heading td {
                background-color: #f1f1f1;
                font-weight: bold;
            }
            .border_none {
                border: none;
            }
            .no-print {
                display: none;
            }
        }
     
   </style>

<div class="content-wrapper">

   <section class="content pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12">      
    <div class="card card-outline card-orange">
        <div class="card-header bg-primary">
        <h3 class="card-title"><i class="fa fa-th-large"></i> &nbsp;{{ __('Make Stationary Request') }} 
  
    </h3>
        <div class="card-tools">
        <!--<a href="{{url('Fees/add')}}" class="btn btn-primary  btn-sm" title="Add Fees"><i class="fa fa-plus"></i>{{ __('common.Add') }}</a>-->
        <a href="{{url('viewStoreRequest')}}" class="btn btn-primary  btn-sm" title="View"><i class="fa fa-eye"></i> {{ __('View Requests') }} </a>
        @if(Session::get('role_id') !== 3)
        <a href="{{ url('store-daily-collection') }}" class="btn btn-primary btn-sm" title="Back">
            <i class="fa fa-bar-chart-o mr-1"></i> {{ __('Daily Collection') }}
        </a>
        <a href="{{ Session::get('role_id') == 3 ? url('addStationaryRequest') : url('storeDashboard') }}" class="btn btn-primary  btn-sm" title="Back"><i class="fa fa-arrow-left"></i> {{ __('common.Back') }} </a>
        @endif    
    </div>
        
        </div>  

        @if (Session::get('role_id') != 3)
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <input type="search" id="studentSearch" class="form-control" placeholder="Search by Name / Adm No / Mobile / Father Name etc." />
                </div>
                <div class="col-md-12">
                    <div id="studentResults" class="mt-2"></div>
                </div>
            </div>
        </div>
        @endif
     

       



<hr class="mt-0">

<div id="selectedStudent" style="display:none;" class="">

    <div class="card shadow-sm border-0 m-2">
        
        <!-- Header -->
        <div class="card-header card-outline card-success bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                👤 <strong id="s_name"></strong>
            </div>
            <span class="badge bg-light text-dark">Selected Student</span>
        </div>

        <!-- Body -->
        <div class="card-body p-2">
            <div class="row">
                <div class="col-md-12">
                   <div class="table-responsive">
                        <table class="table table-bordered table-sm mb-0">

                            <tbody>
                                <tr>
                                    <th>Admission No</th>
                                    <td id="s_admissionNo"></td>

                                    <th>Course</th>
                                    <td id="s_course"></td>
                                </tr>

                                <tr>
                                    <th>Father Name</th>
                                    <td id="s_father_name"></td>

                                    <th>Batch</th>
                                    <td id="s_batch"></td>
                                </tr>

                                <tr>
                                    <th>Student Type</th>
                                    <td>
                                        <span id="s_student_type" class="badge bg-info"></span>
                                    </td>

                                    <th>Gender</th>
                                    <td id="s_gender_name"></td>
                                </tr>

                                <tr>
                                    <th>Session</th>
                                    <td id="s_session_name"></td>

                                    <th>Class</th>
                                    <td id="s_class_name"></td>
                                </tr>
                            </tbody>

                        </table>
                    </div>

                </div>
             </div>
           
        </div>

    </div>

</div>

              

             
              <div class="row m-2">
                <div class="col-md-12">
              
              <input type='hidden' name='admission_id' id='admission_id' />
              <input type='hidden' name='class_type_id' id='class_type_id' />
              <input type='hidden' name='student_name' id='student_name' />
              <input type='hidden' name='email' id='email' />
              <input type='hidden' name='mobile' id='mobile' />
             <div class='page'>


<div class="card shadow-sm mt-3">

    <!-- HEADER -->
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <div>🧾 <strong>Store Billing</strong></div>
        <button onclick="addItem()" class="btn btn-light btn-sm">
            ➕ Add Item
        </button>
    </div>

    <!-- TABLE -->
    <div class="card-body p-2">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-sm mb-0">
                <thead style="background:#f1f5f9;">
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody id="itemTable"></tbody>

                <tfoot>
                    <tr style="background:#eef2ff;">
                        <td></td>
                        <td></td>
                        <td class="text-end"><strong>Total</strong></td>
                        <td id="totalAmount"><strong>₹ 0</strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
       <div class="card mt-4 border-0 shadow-sm">

    <div class="card-header bg-light">
        📌 <strong class="text-white">Instructions</strong>
    </div>

    <div class="card-body p-0">

        <ol class="mb-2 mt-2" style="line-height: 1.6; color: #475569;">
            <li>Please retain your transaction receipt carefully for order verification and inventory collection at the store.</li>
            <li>This purchase covers all requested academic materials, including books, kits, and stationery supplies.</li>
            <li>For any dispatch assistance or queries, please reach out to the Store Helpdesk at <strong>{{$getSetting['mobile'] ?? ''}}</strong>.</li>
            <li>Thank you for utilizing the online campus procurement portal of <strong>{{$getSetting['name'] ?? ''}}</strong>.</li>
        </ol>

        <!--<p class="text-center text-muted mb-0">-->
        <!--    This is a system-generated receipt. No signature required.-->
        <!--</p>-->

    </div>

</div>
</div>

</div>
<div class="col-md-12 text-center">
<div class="text-center mt-2 mb-3">
    <button class="btn btn-success px-4 shadow-sm"
            onclick="paymentArea()"
            id="continuePurchaseBtn"
            disabled>
        💳 Continue to Payment
    </button>
</div>
</div>

    </div>
    </div>

    </div>
</div>           
                        
                  
    </div>
  </div>
</div>
</section>
</div>


<!-- Modal -->
<div class="modal" id="amountModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Enter Amount</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
            <label> You Are Paying, Amount (₹)</label>
        <input type="number" id="amountInput" class="form-control" placeholder="Enter amount" readonly="">
        <small id="errorText" class="text-danger" style="display: none;">Amount exceeds pending value total!</small>
    </div>
        <div class="col-md-12">
            <label>Payment Mode</label>
            <select class="form-control" id="payment_mode_id" name="payment_mode_id" required="">
                <option value="">Select</option>
                            @if(Session::get('role_id') != 3) 
                            <option value="1">Cash</option>
                            <option value="10">Debit/Credit Card</option>
                            @endif
                            <option value="6">UPI/Online</option>
                                                
            </select>
        </div>
        <div class="col-md-12 manual_transaction_id_div d-none">
            <label>Transaction ID </label>
            <input type="text" id="manual_transaction_id" name="manual_transaction_id" class="form-control" placeholder="Enter transaction id..."  />
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-between">
     <div id='pendingValueTotal'>
         
     </div>
     <div>
        <button type="button" class="btn btn-primary" id="payOnline" onclick="payAndSubmit()"><i class="fa fa-money"></i> Pay & Submit</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
      








<!-- Loading screen modal -->
<div class="modal" id="loadingModal" style="background:#000000ba" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="w-100">
      <div class="modal-body text-center">
        <div class="spinner-border text-primary" role="status">
          <span class="sr-only text-white">Paying fees please wait...</span>
        </div>
        <p class="mt-2 text-white">‼️ Paying fees please wait... ‼️ </p>
        <p class="text-white">⚠️ Please do not hit refresh or back button or close this window. </p>
      </div>
    </div>
  </div>
</div>
<script>

//alert('This page is under development. Please do not use it now.');
    let allowRefresh = false;
    var transaction_id = "";
    var receipt_no = "";

    $(document).on("click", "#transactionResultBtn", function(){
        allowRefresh = true;
        
        let modal = document.getElementById("transactionResultModal").remove();
        window.location.reload();
    });

    checkPopUps();
    
    function checkPopUps() {

        if (!isSafari()) return;
        
        var newWindow = window.open('', '_blank'); // Try opening a new window

        if (!newWindow || newWindow.closed || typeof newWindow.closed == "undefined") {
            alert("POP-UPS ARE BLOCKED! To enable them:\n\n" + 
                "📱 FOR SAFARI (iPhone/iPad):\n" +
                "1. Open 'Settings'.\n" +
                "2. Scroll down and tap 'Safari'.\n" +
                "3. Find 'Block Pop-ups' under 'General'.\n" +
                "4. Toggle OFF 'Block Pop-ups' (it should turn gray).\n\n"
            );

                window.location.reload();
        } else {
            newWindow.close(); // Close the window if successfully opened
        }
    }

    function isSafari() {
        let ua = navigator.userAgent.toLowerCase();
        return ua.includes("safari") && !ua.includes("chrome"); // Detect Safari but exclude Chrome
    }

window.PaymentGateway = {

    onlineTransaction(receipt_no){

        var btn = $('#payOnline');
        
        $('#loadingModal').modal('show');

        let newTab = window.open("", "_blank"); // Open new blank tab
        var name = $('#student_name').val();
        var email = $('#email').val();
        var mobile = $('#mobile').val();
        var admission_id = $('#admission_id').val();
        var requestAmount = $('#amountInput').val();
        fetch("{{ url('payuPaymentInitiateUniversal') }}", { // Fetch Laravel route
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Content-Type": "application/json" // Ensures JSON format
            },
            method: "POST",
            body: JSON.stringify({amount: requestAmount, name: name, email: email, invoiceId:receipt_no, admission_id: admission_id, module: 'store'}) // Send amount, name, email, and module as JSON
        })
        .then(response => response.text()) // Get response as text (HTML content)
        .then(html => {

            // ✅ Create a DOM parser to read the HTML
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, "text/html");

            // ✅ Find the input by name
            const txnidInput = doc.querySelector('input[name="txnid"]');

            if (newTab) { // Check if newTab was successfully opened
                newTab.document.open();
                newTab.document.write(html); // Write content to new tab
                newTab.document.close();

                // Start monitoring if the tab is closed
                let checkTab = setInterval(() => {
                    if (newTab.closed) {
                        clearInterval(checkTab);

                        if(txnidInput.value){
                            PaymentGateway.checkTransactionStatusUniversal(txnidInput.value, requestAmount, receipt_no);
                        }else{
                            alert('Something went wrong !');
                        }
                        
                        $('#loadingModal').modal('hide');
                        btn.prop("disabled", false).text(btn.text()).removeClass('d-none');

                    }
                }, 500); // Check every 500ms
                
                window.onbeforeunload = function () {
                    if (!allowRefresh) {
                        return "Are you sure you want to cancel the payment?";
                    }
                };
            
            } else {
                alert("Popup blocked! Please allow popups for this site.");
            }
        })
        .catch(error => {
            if (newTab) newTab.close();
            console.error("Error loading payment page:", error);
        });
    
    },

    checkTransactionStatusUniversal(txnid, requestAmount, receipt_no) {
        fetch("{{ url('checkTransactionStatusUniversal') }}/" + txnid, { method: "GET" })
        .then(response => response.json()) 
        .then(data => {
            if(data.status == true){
                PaymentGateway.showPhonePeModal("success", requestAmount);
                transaction_id = data.txnid;
                PaymentGateway.updateStationaryRequest(transaction_id, receipt_no);
            } else {
                PaymentGateway.showPhonePeModal("failed", 0);
                
                // ✅ YE ADD KARO — fail pe reservation release
                $.post("{{ url('cancelStorePayment') }}", {
                    _token: '{{ csrf_token() }}',
                    receipt_no: receipt_no
                });
            }
        })
        .catch(error => console.error("Error:", error));
    },

    showPhonePeModal(status, amount) {
        let modalHtml = `
            <div class="phonepe-modal" id="transactionResultModal">
                <div class="modal-box ${status}">
                    <div class="icon">${status === "success" ? "✅" : "❌"}</div>
                    <h2>${status === "success" ? "Payment Successful!" : "Payment Failed"}</h2>
                    <p>${status === "success" ? `₹${amount} paid successfully` : "Your transaction was unsuccessful."}</p>
                    <button id="transactionResultBtn">OK</button>
                </div>
            </div>`;
        document.body.insertAdjacentHTML("beforeend", modalHtml);
    },

    updateStationaryRequest(transaction_id, receipt_no){
            
        // Send the data via AJAX to the Laravel route
        $.ajax({
            url: "{{ url('updateStationaryRequest') }}", // Update this with the correct route URL
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Add the CSRF token for Laravel
                transaction_id:transaction_id,
                receipt_no:receipt_no
            },
            success: function(response) {
                if(response.status == true){
                    console.log('OnlineTransaction successfully updated', response);
                    toastr.success(response.message);
                    //window.location.href= '/addStationaryRequest'
                    window.location.reload();
                }else{
                    toastr.error(response.message);
                }
            },
            error: function(error) {
                console.error('Error updating online transaction data', error);
                toastr.error('There was an error saving the data. Please try again.');
            }
        });

    }
};




$('#studentSearch').on('keyup', function () {
    let q = $(this).val();

    if (q.length < 2) {
        $('#studentResults').html('');
        return;
    }

    $.get("{{ url('searchStudentsForStationaryRequest') }}", { q: q }, function (data) {

        let html = `
        <div class="table-responsive shadow-sm border rounded">
        <table class="table table-hover table-sm mb-0">
            <thead class="bg-dark text-white">
                <tr>
                    <th>Name</th>
                    <th>Adm No</th>
                    <th>Course</th>
                    <th>Father</th>
                    <th>Batch</th>
                    <th>Type</th>
                    <th>Class</th>
                </tr>
            </thead>
            <tbody>
        `;

        if (data.length === 0) {
            html += `<tr><td colspan="7" class="text-center text-danger">No Results Found</td></tr>`;
        }

        data.forEach(s => {
            html += `
            <tr class="student-item pointer"
                data-id="${s.id}"
                data-name="${s.first_name}"
                data-course="${s.course}"
                data-class_type_id="${s.class_type_id}"
                data-batch="${s.batch}"
                data-father_name="${s.father_name}"
                data-admission-no="${s.admissionNo}"
                data-student_type="${s.student_type}"
                data-gender_name="${s.gender_name}"
                data-session_name="${s.session_from_year} - ${s.session_to_year}"
                data-class_name="${s.class_name}"
                data-email="${s.email}"
                data-mobile="${s.mobile}"
            >
                <td><b>${s.first_name}</b></td>
                <td>${s.admissionNo}</td>
                <td>${s.course}</td>
                <td>${s.father_name}</td>
                <td>${s.batch}</td>
                <td><span class="badge bg-info">${s.student_type}</span></td>
                <td>${s.class_name}</td>
            </tr>`;
        });

        html += `</tbody></table></div>`;

        $('#studentResults').html(html);
    });
});

// Select Student
$(document).on('click', '.student-item', function () {

    $('.student-item').removeClass('table-active'); // remove old
    $(this).addClass('table-active'); // highlight selected

    $('#s_name').text($(this).data('name'));
    $('#s_id').text($(this).data('id'));
    $('#s_course').text($(this).data('course'));
    $('#s_admissionNo').text($(this).data('admission-no'));
    $('#s_father_name').text($(this).data('father_name'));
    $('#s_batch').text($(this).data('batch'));
    $('#s_student_type').text($(this).data('student_type'));
    $('#s_gender_name').text($(this).data('gender_name'));
    $('#s_session_name').text($(this).data('session_name'));
    $('#s_class_name').text($(this).data('class_name'));
    


    $('#selectedStudent').fadeIn();
    $('#studentSearch').val($(this).data('name'));
    $('#admission_id').val($(this).data('id'));
    $('#class_type_id').val($(this).data('class_type_id'));
    $('#email').val($(this).data('email'));
    $('#mobile').val($(this).data('mobile'));
    $('#student_name').val($(this).data('name'));

    // optional: auto hide results
    $('#studentResults').html('');
    togglePurchaseButton(); // ✅ enable button
});

@if(Session::get('role_id') == 3 && $student)

    let s = @json($student);

    // Fill UI
    $('#s_name').text(s.first_name);
    $('#s_id').text(s.id);
    $('#s_course').text(s.course);
    $('#s_admissionNo').text(s.admissionNo);
    $('#s_father_name').text(s.father_name);
    $('#s_batch').text(s.batch);
    $('#s_student_type').text(s.student_type);
    $('#s_gender_name').text(s.gender_name ?? '');
    $('#s_session_name').text(s.session_from_year + ' - ' + s.session_to_year ?? '');
    $('#s_class_name').text(s.class_name ?? '');

    // Set hidden field
    $('#admission_id').val(s.id);
    $('#class_type_id').val(s.class_type_id);
    $('#student_name').val(s.first_name);
    $('#email').val(s.email);
    $('#mobile').val(s.mobile);

    // Show panel
    $('#selectedStudent').show();

    // Enable purchase if items exist later
    togglePurchaseButton();

@endif

    function togglePurchaseButton() {

        let admissionId = $('#admission_id').val();

        // count valid rows
        let rowCount = $('#itemTable tr').length;

        // total amount
        let total = parseFloat(pendingValueTotal) || 0;

        if (admissionId && rowCount > 0 && total > 0) {
            $('#continuePurchaseBtn').prop('disabled', false);
        } else {
            $('#continuePurchaseBtn').prop('disabled', true);
        }
    }

       
    var pendingValueTotal = 0;

    function updateItem(select) {
        const row = select.closest('tr');
        const selected = select.options[select.selectedIndex];

        const price = parseFloat(selected.getAttribute('data-price')) || 0;
        const validate_qty = parseInt(selected.getAttribute('data-validate_qty')) || 0;

        const qtyInput = row.querySelector('.qty-input');

        // ✅ update validation limit
        qtyInput.setAttribute('data-validate_qty', validate_qty);

        // ✅ reset qty if exceeds
        if (parseInt(qtyInput.value) > validate_qty) {
            qtyInput.value = validate_qty;
        }

        row.querySelector('.rate-cell').innerText = '₹ ' + price;
        updateTotal();
    }
    

    function updateTotal() {
        let total = 0;

        document.querySelectorAll('#itemTable tr').forEach(row => {

            const input = row.querySelector('.qty-input');
            const select = row.querySelector('select');

            if (!input || !select) return;

            let qty = parseInt(input.value) || 0;
            let validate_qty = parseInt(input.getAttribute('data-validate_qty')) || 0;

            const selected = select.options[select.selectedIndex];
            let price = parseFloat(selected.getAttribute('data-price')) || 0;

            // ✅ validation
            if (qty > validate_qty) {
                toastr.error(`Available quantity is: ${validate_qty}`);
                qty = validate_qty;
                input.value = qty;
            }

            let amount = qty * price;

            row.querySelector('.price-cell').innerText = '₹ ' + amount.toFixed(2);

            total += amount;
        });

        document.getElementById('totalAmount').innerText = `₹ ${total.toFixed(2)}`;
        pendingValueTotal = total;
    }


  const storeItems = @json($storeItems);

        function addItem() {
            if (storeItems.length == 0) {
                toastr.error("Items Not Found");
                return;
            }

            const table = document.getElementById('itemTable');
            const row = table.insertRow();

            let options = '';

            storeItems.forEach((item, index) => {
                let remainingQty = item.qty - item.reserved_qty - item.sold_qty;

                options += `<option value="${item.id}" 
                    data-validate_qty="${remainingQty}" 
                    data-price="${item.rate}"
                    ${index === 0 ? 'selected' : ''}>
                    ${item.name}
                </option>`;
            });

            // 👉 get FIRST selected item safely
            let firstItem = storeItems[0];
            let remainingQty = firstItem.qty - firstItem.reserved_qty - firstItem.sold_qty;

            row.innerHTML = `
                <td>
                    <select onchange="updateItem(this)" class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                        ${options}
                    </select>
                </td>
                <td>
                    <input type="tel" 
                        class="form-control qty-input" 
                        value="1" 
                        min="1"
                        data-validate_qty="${remainingQty}"
                        onchange="updateTotal()" onkeypress="javascript:return isNumber(event)" >
                </td>
                <td class="rate-cell">₹ ${firstItem.rate}</td>
                <td class="price-cell">₹ ${firstItem.rate}</td>
                <td class="no-print">
                    <button onclick="removeItem(this)" class="btn btn-danger">Remove</button>
                </td>
            `;

            // Initialize Select2 on the newly added select element
            $(row.querySelector('select')).select2({
                theme: 'bootstrap4'
            });

            updateTotal();
            togglePurchaseButton();
        }

    function removeItem(button) {
        const row = button.closest('tr');
        row.parentNode.removeChild(row);
        updateTotal();
        togglePurchaseButton();
    }
    
    function paymentArea(){
          $('#amountModal').modal('show');
          
    
      
       $('#amountInput').val(pendingValueTotal);
       $('#pendingValueTotal').html(`<h1>Total : ${pendingValueTotal}/-</h1>`);
          
    }

function payAndSubmit() {

        var enteredAmount = parseInt($('#amountInput').val());
        var payment_mode_id = $('#payment_mode_id').val();
        var manual_transaction_id = $('#manual_transaction_id').val();
        

        if(pendingValueTotal <  enteredAmount)
        {
            toastr.error('Amount not to be exceeded Rs.'+ pendingValueTotal+'.');
            return
        }
        //$('#amountModal').modal('hide');
   
        const items = [];
        const rows = document.querySelectorAll('#itemTable tr');
        rows.forEach(row => {
            const select = row.querySelector('select');
            const input = row.querySelector('input');
            if (select && input) {
                items.push({
                    item: select.options[select.selectedIndex].value,
                    quantity: input.value,
                    price: select.options[select.selectedIndex].getAttribute('data-price')
                });
            }
        });
        
        if(items.length != 0 ){

            var class_type_id = $('#class_type_id').val();
            var admission_id = $('#admission_id').val();

            if(payment_mode_id){
                if(payment_mode_id == 10 && manual_transaction_id == ''){
                    toastr.error('Please enter transaction id for card payment');
                    return;
                }
                if(payment_mode_id == 10 && manual_transaction_id != ''){
                    transaction_id = manual_transaction_id;
                }
                createStoreRequest(items, admission_id, class_type_id, enteredAmount, payment_mode_id, transaction_id);
            }else{
                toastr.error('Please Select Payment Mode');
                return;
            }

        }else{
            toastr.error('Please Select at least one item');
        }

    }

    // Initial call to set the amount in words for the preloaded items
    updateTotal();


    function createStoreRequest(items, admission_id, class_type_id, enteredAmount, payment_mode_id, transaction_id) {

    $.ajax({
        url: "{{ url('createStationaryRequest') }}",
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            items: items,
            admission_id: admission_id,
            class_type_id: class_type_id,
            enteredAmount: enteredAmount,
            payment_mode_id: payment_mode_id,
            transaction_id: transaction_id
        },
        success: function (response) {
            console.log('Data saved successfully', response);

            toastr.success(response.message);

            if (payment_mode_id == 6) {
                if(response.success == true){
                    // Online payment — gateway ko handoff karo
                    PaymentGateway.onlineTransaction(response.receipt_no);
                    return; // ✅ Yahan se niklo — reload mat karo

                }else{
                    alert('Something went wrong with online payment initiation');
                    PaymentGateway.showPhonePeModal("failed", 0);
                  
                }
                
            }else{
                // Non-online payment
                $('#amountModal').modal('hide');
                PaymentGateway.showPhonePeModal("success", enteredAmount);
            }

            

            // Form reset
            $("#payment_mode_id").prop('selectedIndex', 0);
            $("#manual_transaction_id").val('').trigger('change');
            $('#itemTable').html('');
            $('#totalAmount').text('₹ 0');
            $('#continuePurchaseBtn').prop('disabled', true);
            $('#selectedStudent').hide();
            $('#studentSearch').val('');
            $('.student-item').removeClass('table-active');
            $('#admission_id').val('');
            $('#class_type_id').val('');
            updateTotal();

            // ✅ Page reload — naya data dikhega
            //window.location.reload();
        },
        error: function (xhr) {
            // ✅ Validation errors (422) aur server errors (500) dono handle
            let message = 'There was an error saving the data. Please try again.';

            if (xhr.status === 422) {
                // Laravel validation errors
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    // Pehli error message dikhao
                    message = Object.values(errors)[0][0];
                } else {
                    message = xhr.responseJSON?.message ?? message;
                }
            } else if (xhr.status === 500) {
                message = xhr.responseJSON?.message ?? message;
            }

            toastr.error(message);
            console.error('Error saving data', xhr);
        }
    });
}

    

$(document).ready(function() {
    $('#payment_mode_id').change(function() {
        if ($(this).val() == '10') {
            $('.manual_transaction_id_div').removeClass('d-none');
        } else {
            $('.manual_transaction_id_div').addClass('d-none');
        }
    });
});


</script>

<style>
.phonepe-modal {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1050;
    background: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center;
    backdrop-filter: blur(8px);
}
.modal-box {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: white; text-align: center; padding: 20px; border-radius: 15px;
    width: 280px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); animation: slideUp 0.3s;
}
@keyframes slideUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.icon { font-size: 50px; margin: 10px 0; }
#transactionResultBtn {
    background: #ffcc00; color: #333; border: none; padding: 10px 20px;
    border-radius: 8px; cursor: pointer; font-size: 16px; margin-top: 15px;
}
#transactionResultBtn:hover { background: #ffdd44; }


        .payment-box {
            background: #1e1e1e;
            padding: 25px;
            border-radius: 10px;
            width: 100%;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.4);
            text-align: center;
        }
        .payment-box label {
            display: block;
            color: #999;
            font-size: 16px;
            text-align: left;
            margin-bottom: 5px;
        }
        .payment-input {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            border-radius: 8px;
            border: 2px solid #555;
            background: #222;
            color: #fff;
            outline: none;
        }
        .payment-input:focus {
            border-color: #4caf50;
        }
        .pay-btn {
            position: relative;
            padding: 15px 40px;
            font-size: 18px;
            font-weight: bold;
            color: white;
            background: linear-gradient(45deg, #007BFF, #0056b3);
            border: none;
            border-radius: 30px;
            cursor: pointer;
            outline: none;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 5px 15px rgba(0, 123, 255, 0.4);
        }

        .pay-btn:hover {
            background: linear-gradient(45deg, #0056b3, #003d82);
            box-shadow: 0px 8px 20px rgba(0, 123, 255, 0.6);
            transform: translateY(-2px);
        }

        .pay-btn:active {
            transform: scale(0.95);
            box-shadow: 0px 3px 10px rgba(0, 123, 255, 0.3);
        }

        /* Ripple Effect */
        .pay-btn::after {
            content: "";
            position: absolute;
            width: 300%;
            height: 300%;
            top: 50%;
            left: 50%;
            background: rgba(255, 255, 255, 0.3);
            transition: transform 0.6s ease-out, opacity 0.6s ease-out;
            transform: translate(-50%, -50%) scale(0);
            border-radius: 50%;
            opacity: 0;
        }

        .pay-btn:active::after {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
            transition: 0s;
        }

        .pointer {
            cursor: pointer;
        }

        .table-hover tbody tr:hover {
            background: #f1f7ff;
        }

        .table-active {
            background: #d0e7ff !important;
        }

        #selectedStudent .card {
            border-radius: 12px;
        }

        #selectedStudent th {
            background: #f8f9fa;
            font-weight: 600;
            width: 140px;
        }

        #selectedStudent td {
            font-weight: 500;
        }

.table th {
    font-weight: 600;
    color: #374151;
}

.table td {
    color: #111827;
}

.table-hover tbody tr:hover {
    background: #f1f5ff;
}

#totalAmount {
    color: #2563eb;
    font-weight: 700;
}

.btn-success {
    background: #16a34a;
    border: none;
}

.btn-success:hover {
    background: #15803d;
}
</style>
@endsection 