
@extends('layout.app') 
@section('content')

<div class="content-wrapper">
   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-md-12">    
            <div class="card card-outline card-orange">
            <div class="card-header bg-primary">
                <h3 class="card-title"><i class="fa fa-address-book-o"></i> &nbsp;{{ __(' Sales Inventory ') }} </h3>
                <div class="card-tools">
                    <a href="{{url('sale_inventory_view')}}" class="btn btn-primary  btn-sm"><i class="fa fa-eye"></i>{{ __('common.View') }} </a>
                    <a href="{{url('invantory_dashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> {{ __('messages.Back') }}</a>
                </div>
            </div>        
            <form id="saleInvantoryForm" action="{{ url('sales_invantory_add') }}" method="post" enctype="multipart/form-data">
            @csrf
                @if(Session::get('role_id') !=3)
                    <div class="row m-2">
                        <div class="col-md-3">
                            <label for="">Student Reg. ID</label>
                            <select name="admission_id" class="form-control select2" id="admission_id" onchange="studentList(this)">
                                <option value="">--Select--</option>
                                @foreach($admissionNo as $id => $number)
                                    <option value="{{ $id }}">{{ $number }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                
                <div class="row m-2">
                     <div class="col-md-2">
                        <div class="form-group ">
                        <label for="inputEmail3"> Invoice/Bill No.</label>
                         <input type="text" class="form-control @error('invoice_no') is-invalid @enderror" autofocus="autofocus" id="invoice_no"  name="invoice_no"  value="{{$BillCounterNo}}" placeholder="Invoice No." readonly>
        					@error('invoice_no')
        						<span class="invalid-feedback" role="alert">
        							<strong>{{ $message }}</strong>
        						</span>
        					@enderror
                        </div> 
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label> Date</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" tabindex="1" id="date" name="date" value="{{ date('Y-m-d') }}">
                            @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> 
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Student Name</label>
                            <span class="input-group-append">
                                <input id="student_name" type="text" class="form-control"  name="student_name"  value="{{old('party_name') ?? ''}}" placeholder="Student Name" style="height: 35px;" readonly>
                                @error('student_name')
        						<span class="invalid-feedback" role="alert">
        							<strong>{{ $message }}</strong>
        						</span>
        					    @enderror
                            </span>		
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ">
                            <label> Mobile</label>
                                <input type="text"  class="form-control @error('mobile') is-invalid @enderror" id="mobile"  name="mobile" value="{{old('mobile')}}" placeholder="Mobile"  onkeypress="javascript:return isNumber(event)" readonly>
                            @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                            <div class="form-group ">
                                <label> Father's Name</label>
                                 <input type="text"  class="form-control @error('father_name') is-invalid @enderror" id="father_name" tabindex="1" name="father_name" value="{{old('father_name')}}" placeholder="Father's Name" readonly>
                                @error('gstin')
            						<span class="invalid-feedback" role="alert">
            							<strong>{{ $message }}</strong>
            						</span>
            					@enderror
                            </div>
                    </div>
                </div>
                @else
                    <input type="hidden" name="admission_id" value="{{$admissionNo->id}}" >
                @endif
                  <table class="table table-bordered mb-2 mt-3" id="maindiv_room">
                <thead>
                    <tr>
                        <th>Item Name &nbsp;</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Total Amount</th>
                        <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="tr_clone" id ="append_1">
                      
                    <td style="width: 215px;">
                        <div class="form-group">
                            <input id="item_name_0" type="text" class="form-control item_name" name="item_name" required value="{{old('item_name')}}" placeholder="item Name" >
                            <input  type="hidden" id="stock_0" class="form-control">
                	    </div>
                	    <input  type="hidden" id="item_id1_0" name="inventory_item_id[]" class="form-control">
                    </td>
                     
                    <td>
                        <div class="form-group">
                            <input name="qty[]" id="qty_0" placeholder="Quantity" class="form-control qty" required onblur="calcSum(this.value,0),getItemQtyCheck(this.value,0)" maxlength="100" type="text"  value="{{ old('quantity') }}" onkeypress="javascript:return isNumber(event)">
                	   </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input name="amount[]" id="amount_0" placeholder="Amount" class="form-control" onkeyup="calcSum(this.value,0)" maxlength="100" type="text"  value="" onkeypress="javascript:return isNumber(event)" {{ Session::get('role_id') == 3 ? 'readonly' : '' }}>
                	   </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input name="total_amount[]"  id="total_amount_0" placeholder="Total Amount" class="form-control tolamount"  maxlength="100" type="text"  value="" onkeypress="javascript:return isNumber(event)" {{ Session::get('role_id') == 3 ? 'readonly' : '' }}>
                	   </div>
                    </td>
                    
                   <td style="width: 51px; cursor: pointer;"> 
                   <div class="col-sm-3" id="add">
                <input  type="button" onclick="addElement_room();" value="" title="Add More Product" class="addmoreprodtxtbx" style="color:#6445d2;" id="button"/>
      </div>
                  </td>
                    </tr>
                    	
                 </tbody>
              
                 
            </table>
            
	<input type="hidden" name="total_room" id="total_room" value="1">
	<input type="hidden" name="value_room" id="value_room" value="1">
            <div class="row m-1">
            <div class="col-md-2">
                <div class="form-group">
					 <label for="qty">Total Quantity</label>
					<input type="text" class="form-control" id="Quantity" tabindex="1" readonly placeholder="Total Quantity" name="total_qty" required  value="">
				</div>
			</div>
			<div class="col-md-2">
                <div class="form-group">
					 <label for="netamount_amt">Net Amount</label>
					<input type="text" class="form-control" id="net_amount" readonly tabindex="1" placeholder="Net Amount" name="net_amount"required>
				</div>
			</div>
			
          <!--  <div class="col-md-2">
                <div class="form-group">
                    <label for="pay">Pay Final</label>
					<input type="text" class="form-control" id="pay_amt" tabindex="1" placeholder="Pay Final" name="pay_amt" required>
                </div>
            </div>-->			
               <div class="col-md-12 text-center">
                <!-- <button  class='btn btn-primary' onclick="paymentArea()">Save and Print</button> -->
                <button type="submit" class="btn btn-primary btn-submit">{{ __('common.submit') }}</button><br><br>
               </div>
    </form>
        </div>
</div>
</div>
</div>
</section>
    
</div>

<!-- Modal -->
<div class="modal" id="saleInvantoryAmount" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Invantory Amount</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row mb-4">
          <div class="col-md-12 text-center">
            <label for="amount" class="form-label fw-bold">You Are Paying, Amount (₹)</label>
            <input type="tel" class="form-control text-center fw-bold fs-4" name="amount" id="amount" 
                   oninput="validateAmount(this)" placeholder="0.00" value="{{ $balances ?? '0' }}" required readonly>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-md-12 text-center">
            <label class="d-block mb-2 fw-bold">Choose Payment Method</label>
            <div class="d-flex justify-content-center gap-4">
              <div class="form-check">
                <input class="form-check-input paymentMode" type="radio" name="payment_mode_id" id="offline" value="4" required>
                <label class="form-check-label" for="offline">Offline</label>
              </div>
              <div class="form-check">
                <input class="form-check-input paymentMode" type="radio" name="payment_mode_id" id="online" value="6" required>
                <label class="form-check-label" for="online">Online</label>
              </div>
            </div>
          </div>
            
        </div>

        <!-- Offline fields -->
        <div class="row offlineInput d-none g-3">
          <div class="col-md-4">
            <label for="account_holder" class="form-label">Account Holder <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="account_holder" name="account_holder" placeholder="Account Holder">
          </div>
          <div class="col-md-4">
            <label for="transaction_id" class="form-label">UTR No./Transaction ID <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="transaction_id" name="transaction_id" placeholder="UTR No./Transaction ID">
          </div>
          <div class="col-md-4">
            <label for="payment_receipt" class="form-label">Payment Slip <span class="text-danger">*</span></label>
            <input type="file" class="form-control" id="payment_receipt" name="payment_receipt" accept="image/*,application/pdf">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center p-2">
            <button type="botton" onclick="printBill()" class=" pay-btn btn-submit">
            <i class="fa fa-money"></i>  Pay Now
            </button>
        </div>
      </div>
    </div>
  </div>
</div>

    <script>

    function printBill(){

        var $form = $(this);
        var btn = $form.find(".btn-submit");
        $('#loadingModal').modal('show');
        $('.collect_btn_hide').hide();
        var buttonValue = $('.collect_btn').val(); 
        var formData = new FormData($('#saleInvantoryForm')[0]); // Get all form data, including files

        let paymentModeId = $('input[name="payment_mode_id"]:checked').val();

        const actionUrl = $('#inventoryPayment').attr('action');
        //alert('Payment Done');
   
        $.ajax({
           headers: {
               'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
           },
           type: 'post',
           url: actionUrl,
           data: formData,
           processData: false,  // Important: Don't process the data
           contentType: false,  // Important: Set content type to false, letting jQuery assign it
           beforeSend: function () {
                btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> ' + btn.text()).addClass('d-none');
            },
           success: function(data) {
               if(data.status == true)
               {
                    
                    if(paymentModeId == 6){
                        let newTab = window.open("", "_blank"); // Open new blank tab
                        var name = "{{ Session::get('first_name') }}";
                        var email = "{{ Session::get('email') }}";
                        var requestAmount = $('#amount').val();
                        var invoiceId = data.invoiceId;
                        fetch("{{ url('payuPaymentInitiate') }}", { // Fetch Laravel route
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                "Content-Type": "application/json" // Ensures JSON format
                            },
                            method: "POST",
                            body: JSON.stringify({invoiceId:invoiceId, amount: requestAmount, name: name, email: email})
                        })
                        .then(response => response.text()) // Get response as text (HTML content)
                        .then(html => {
                            if (newTab) { // Check if newTab was successfully opened
                                newTab.document.open();
                                newTab.document.write(html); // Write content to new tab
                                newTab.document.close();

                                

                                 // Start monitoring if the tab is closed
                                let checkTab = setInterval(() => {
                                    if (newTab.closed) {
                                        clearInterval(checkTab);
                                                                                
                                        checkTransactionStatus(invoiceId, requestAmount);
                                        
                                        $('#loadingModal').modal('hide');
                                        btn.prop("disabled", false).text(btn.text()).removeClass('d-none');

                                    }
                                }, 500); // Check every 500ms

                                
                                //toastr.success('Fee History Ccreated');
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

                    }else{
                        $('#loadingModal').modal('hide');
                        btn.prop("disabled", false).text(btn.text()).removeClass('d-none');
                        toastr.success('Fee Collected Successfully');
                        window.location.href = 'fees_history';
                    }
                                    
               }
               else
               {
                btn.prop("disabled", false).text(btn.text());
                   $('#loadingModal').modal('hide');
                   toastr.error('Something Went Wrong');
                   btn.prop("disabled", false).text(btn.text()).removeClass('d-none');
               }
           },
           error: function (xhr) {
               
                    var errorMessage = xhr.responseJSON?.message || "An unexpected error occurred.";
                    toastr.error(errorMessage);

                btn.prop("disabled", false).text(btn.text()).removeClass('d-none');
            },
       });
    };


        $('#saleInvantoryForm').on('submit', function(e) {
            e.preventDefault();
            
            $('#saleInvantoryAmount').modal('show');
            let pendingValueTotal = $('#net_amount').val();
            $('#totAmt').text(pendingValueTotal);
            $('#amount').val(pendingValueTotal);
        });
        


        $('.paymentMode').change(function(){
        
            var paymentMethodVal = $(this).val();
            if(paymentMethodVal == 4){
                $('.offlineInput').removeClass('d-none');
                $('#account_holder,#transaction_id,#payment_receipt').attr('required', true);
            }else{
                //alert('Online Payment is Under Testing Phase till Avoid using Online Payment');
                $('.offlineInput').addClass('d-none');
                $('#account_holder,#transaction_id,#payment_receipt').attr('required', false);
            }
        });
      
       function addElement_room(){
	    var SITEURL  = "{{ url('/') }}";
		var div=document.getElementById('maindiv_room');
		
		var num=Number(document.getElementById('value_room').value)+Number(1);
		document.getElementById('value_room').value=num;
		var num1=Number(document.getElementById('total_room').value)+Number(1);
		document.getElementById('total_room').value=num1;
		var heightchange=Number(42)*(Number(num)-Number(1))+Number(110)+Number(15);
		//alert(heightchange);
		$("#main_room").css('height',heightchange);
		var newdiv = document.createElement('tbody');
	  	var divIdName = 'append_'+num;
	   	var contents ='';
		newdiv.setAttribute('id',divIdName); 
		contents='<tr class="tr_clone"><input  type="hidden" id="stock_'+num+'" class="form-control"><input  type="hidden" id="item_id1_'+num+'" name="item_id[]" class="form-control"><td><input id="item_name_'+num+'" required type="text" class="form-control item_name" name="item_name" value="" placeholder="Item Name"></td><td><input name="qty[]" id="qty_'+num+'" onblur="calcSum(this.value,'+num+'),getItemQtyCheck(this.value,'+num+')" placeholder="Quantity" style="width: 323px;"class="form-control quantity qty" maxlength="100" type="text"  value="{{ old('quantity') }}" onkeypress="javascript:return isNumber(event)"></td><td><input name="amount[]" onkeyup="calcSum(this.value,'+num+')"  id="amount_'+num+'" placeholder="Amount" class="form-control " style="width: 325px;" maxlength="100" type="text"  value=""  onkeypress="javascript:return isNumber(event)" {{ Session::get('role_id') == 3 ? 'readonly' : '' }}></td><td><input name="total_amount[]"  placeholder="Total Amount" class="form-control tolamount" maxlength="100" style="width: 327px;" type="text" id="total_amount_'+num+'" value="" onkeypress="javascript:return isNumber(event)" {{ Session::get('role_id') == 3 ? 'readonly' : '' }}></td><td id="add"><input type="button" onclick="addElement_room();" value="" title="Add More Product" class="addmoreprodtxtbx" id="button" name="button" ><input type="button" class="removeprodtxtbx" name=delrow_'+num+' id=delrow_'+num+'  value="" onclick="removeElement_room(\'append_'+num+'\','+num+')"></td></tr>';
		
		newdiv.innerHTML = contents;
	  	div.appendChild(newdiv);
	    $(document).ready(function(){
		$("#item_name_"+num).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
                    url: SITEURL+"/getAutoCompleteInvantoryItem",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#item_name_'+num).val(ui.item.label); // display the selected text
                $('#item_id1_'+num).val(ui.item.item_id); // save selected id to input
                $('#amount_'+num).val(ui.item.mrp); // save selected amount to input
                $('#stock_'+num).val(ui.item.stock);
                return false;
            },
            focus: function(event, ui){
               $('#item_name_'+num).val(ui.item.label); // display the selected text
               $('#item_id1_'+num).val(ui.item.item_id); // save selected id to input
               $('#amount_'+num).val(ui.item.mrp); // save selected amount to input
               return false;
            },
        }); 
	});
	}
    function removeElement_room(divNum, countNum){
		
		var d = document.getElementById('maindiv_room');
		d.removeChild(window.document.getElementById(divNum+""));
		var counterValue= Number(document.getElementById('value_room').value)-Number(1);
		document.getElementById('value_room').value=counterValue;
		var heightchange=Number(42)*(Number(counterValue)-Number(1))+Number(110)+Number(15);
		
		$("#main_room").css('height',heightchange);
  	
	}
	$(function() {
       var SITEURL  = "{{ url('/') }}";
	      $("#item_name_0").autocomplete({
            source: function( request, response ) {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
                    url: SITEURL+"/getAutoCompleteInvantoryItem",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#item_name_0').val(ui.item.label); // display the selected text
                $('#item_id1_0').val(ui.item.item_id); // save selected id to input
                $('#amount_0').val(ui.item.mrp); // save selected amount to input
                $('#stock_0').val(ui.item.stock);
                return false;
            },
            focus: function(event, ui){
               $('#item_name_0').val(ui.item.label); // display the selected text
               $('#item_id1_0').val(ui.item.item_id); // save selected id to input
               $('#amount_0').val(ui.item.mrp); // save selected amount to input
               return false;
            },
        });
          $("#student_name").autocomplete({
            source: function( request, response ) {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
                    url: SITEURL+"/getAutoCompleteStudent",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#student_name').val(ui.item.label); // display the selected text
                $('#admission_id').val(ui.item.id); // save selected id to input
                $('#mobile').val(ui.item.mobile); // save selected amount to input
                return false;
            },
           
        });
   });
   

    function getItemQtyCheck(qty, row_id) {
        var quantity = $('#qty_' + row_id).val(); // Renamed variable to 'quantity' to avoid shadowing
        var inventory_item_id = $('#item_id1_' + row_id).val();
        
        $.ajax({
            headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },
            type: 'post',
            url: '/getInvantoryItemQtyCheck',
            data: { qty: quantity, inventory_item_id: inventory_item_id },
            success: function (data) {
                if(data == 1){
                $('#qty_' + row_id).val('');  
                $('#item_id1_' + row_id).val('');  
                $('#amount_' + row_id).val('');  
            var Quantity =   $('#Quantity').val();
                $('#Quantity').val(Quantity-quantity);
                toastr.error('This item is out of stock');
                }
            }
        });
    }

   function calcSum(value,row_id) {
    var stock = parseInt($('#stock_'+row_id).val());
    var qty = parseInt($('#qty_'+row_id).val());

    if(stock < qty)
    {
        alert("Item's stock is only " + stock);
        $('#qty_'+row_id).val('');
        $('#amount_'+row_id).val('');
    }else{
        var amount = $('#amount_'+row_id).val();
        var total_amount = qty * amount;
        $('#total_amount_'+row_id).val(total_amount);
        calculateSum();
    }
        
};
function calculateSum() {
    var sum = 0;
    var qty = 0;
    $(".tolamount").each(function() {
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);
        }
    });
    $(".qty").each(function() {
            if (!isNaN(this.value) && this.value.length != 0) {
                qty += parseFloat(this.value);
              
            }
        });

        $("#net_amount").val(sum.toFixed(2));
        $("#pay_amt").val(sum.toFixed(2));
        $("#Quantity").val(qty);
   
};

    function studentList(value) {
        
        var selectedId = $(value).val();
        //alert(selectedId);
        $.ajax({
            headers: { 'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content') },
            type: 'post',
            url: '/get-student-data',
            data: {stdID: selectedId},
            success: function (data) {
                $('#student_name').val(data.first_name);  
                $('#mobile').val(data.mobile);  
                $('#father_name').val(data.father_name);  
            }
        });
    };
  </script> 


    <style>
    
    .form-control {
    height: 35px !important;
    }
    @media only screen and (min-width: 1220px) and (max-width:1300px)
    {
    .item-name{width: 119px !important;}
    .brand-name{width: 182px !important;}
    .quantity{width:196px !important;}
    .weightkg{width:193px !important;}
    .rate11{width:191px !important;}
    .amount123{width:196px !important;}
        
    }
    input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus, 
input:-webkit-autofill:active{
    -webkit-box-shadow: 0 0 0 30px white inset !important;
}
        .form-group {
  margin-bottom: 2px;
}
.left_b_none{
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    height: 40px;
    padding: 4px;
    line-height: 15px;
    font-size: 26px;
}
label {
  display: inline-block;
  margin-bottom: 0px;
  font-size: 14px;
}
.form-control {
  display: block;
  width: 100%;
  height: 28px;
  padding: 3px;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: .25rem;
  box-shadow: inset 0 0 0 transparent;
  transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.form-group {
  margin-bottom: 0px;
}
.table-bordered thead td, .table-bordered thead th {
  border-bottom-width: 2px;
  padding: 2px 0px 2px 10px;
}
.table td {
  border-bottom-width: 2px;
  padding: 2px 0px 2px 2px;
}
.border-radius{
    height:28px !important;
}
.addmoreprodtxtbx {
  background-color: #FFFFFF;
  background-image: url({{url('public/images/list_add.png')}});
  background-repeat: no-repeat;
  border: medium none;
  cursor: pointer;
  height: 16px;
  width: 16px;
  
}

.removeprodtxtbx {
  background-color: #FFFFFF;
  background-image: url({{url('public/images/delete2.png')}});
  background-repeat: no-repeat;
  border: medium none;
  cursor: pointer;
  height: 15px;
  margin-left: 5px;
  width: 16px;
}
.select2-container .select2-selection--single{
     height:27px !important;
}  


/*.ui-widget-content {
  border: 1px solid #aaaaaa ;
  background: #007bff !important;
  color: #fff !important;
}*/

    </style>
      <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endsection      




