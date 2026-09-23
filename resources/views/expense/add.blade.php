@php
    $getHostel = Helper::getHostel();
   $getPaymentMode = Helper::getPaymentMode();
   $getRole = Helper::getUsers();
   
   
 
@endphp
@extends('layout.app') 
@section('content')

<div class="content-wrapper">

   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-outline card-orange">
                     <div class="card-header bg-primary">
                    <h3 class="card-title"><i class="fa fa-credit-card"></i> &nbsp;{{ __('expense.Add Expense') }} </h3>
                    <div class="card-tools">
                    <!--<a class="btn btn-primary  btn-sm" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> {{ __('Add Head') }} </a>-->
                    <a href="{{url('expenseView')}}" class="btn btn-primary  btn-sm"><i class="fa fa-eye"></i> {{ __('common.View') }} </a>
                    <!--<a href="{{url('hostel_dashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> Back </a>-->
                    </div>
                    
                    </div>        
                            <form id="quickForm" action="{{ url('expenseAdd') }}" method="post"enctype="multipart/form-data">
                                @csrf
        
                                <div class="row m-2">
                                    <table class="_table" id="tableId">
                                    <thead>
                                      <tr>
                                        <th style="color:red;">{{ __('Expense Head') }}*</th>
                                        <th style="color:red;">{{ __('Staff/User') }}*</th>
                                        <th style="color:red;">{{ __('common.Date') }}*</th>
                                        <th style="color:red;">{{ __('expense.Quantity') }}*</th>
                                        <th style="color:red;">{{ __('expense.Rate') }}*</th>
                                        <th style="color:red;">{{ __('expense.Total') }}*</th>
                                        <th style="color:red;">{{ __('Payment Mode') }}*</th>
                                        <th>{{ __('Attachment') }}</th>
                                        <th>{{ __('expense.Description') }}</th>
                                        <th width="50px"></th>
                                
                                      </tr>
                                    </thead>
                                    <tbody id="table_body">
                                      <tr id="appendRow_0" >
                                        <td >
                                             <input type="text" class="form-control" id="name" name="name[]" placeholder='Expense Name'value="" required>     
                                        </td>
                                        <td >
                                            <select class="select2" id="role" name="role[]" required>
                                                @if(!empty($getRole))
                                                 <option value=''>Select</option>
                                                @foreach($getRole as $item)
                                                
                                                <option value='{{$item->id}}'>{{$item->first_name ?? ''}} {{$item->last_name ?? ''}}</option>
                                                @endforeach
                                                
                                                @endif
                                                
                                                
                                            </select>
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" id="date" name="date[]" value="{{ date('Y-m-d') }}" required>         
                                        </td>   
                                        <td>
                                            <input type="text" class="form-control" onKeyup="calculateAmount(this.value,0);" placeholder="Quantity" id="quantity_0" name="quantity[]" onkeypress="javascript:return isNumber(event)" value="{{ old('quantity') }}" required>         
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" onKeyup="calculateAmount(this.value,0);" placeholder="Rate" id="rate_0" name="rate[]" onkeypress="javascript:return isNumber(event)" value="{{ old('rate') }}" required>         
                                        </td>                                         
                                        <td>
                                          <input type="text" class="form-control amount" onKeyup="calculateSum()" placeholder="Amount" id="amount_0" name="amount[]" value="{{ old('amount') }}" readonly required>
                                        </td>
                                        <td>
                                             <select class="form-control select2" id="payment_mode_id" name="payment_mode_id[]" required>
                                    @if(!empty($getPaymentMode))
                                        @foreach($getPaymentMode as $value)
                                        <option value="{{ $value->id }}">{{ $value->name ?? ''}}</option>
                                        @endforeach
                                    @endif  
                                </select>
                                        </td>
                                        <td>
                                            <input type="file" class="form-control"  id="attachment" name="attachment[]" value="{{ old('attachment') }}" accept="image/png, image/jpg, image/jpeg">
										 <p class="text-danger" id="image_error"></p>         
                                        </td>    
                                          
                                      <td>
                                          
                                            <textarea type="text" id="description" name="description[]" class="form-control" placeholder="If have any description write here...">{{ old('description') }}</textarea>
                                      </td>
                                        <!--<td style="width: 92px;">-->
                                        <!--  <div class="action_container">-->
                                        <!--        <button type="button" class="btn btn-primary btn-xs addmoreprodtxtbx" id="clonebtn"><i class="fa fa-plus"></i></button>-->
                                        <!--        <button type="button" class="btn btn-danger btn-xs removeprodtxtbx" id="removerow"><i class="fa fa-trash"></i></button>-->
                                        <!--  </div>-->
                                        <!--</td>-->
                                      </tr>
                                    </tbody>
                                    
                                    <tr>
                                        <td>
                                           <label style="color:red;"><b>{{ __('expense.Total Amount') }}*</b></label>
                                            <input type="text" class="form-control" placeholder="{{ __('expense.Total Amount') }}" id="total_amt" name="total_amt" value="" value="{{ old('total_amt') }}" readonly>
                                      </td>  
                                    </tr>
                                  
                                </table>
                            </div>        

                            <div class="row m-2">
                                <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">{{ __('common.Submit') }} </button>
                                </div>
                            </div>
                        </form>
            </div>
</div>
</div>
</div>
</section>
</div>


 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#attachment').change(function(e){
            $('#image_error').html("");
            var fileName = $(this).val();
        var extension = fileName.split(".").pop();
        if (
          extension.toLowerCase() === "png" ||
          extension.toLowerCase() === "jpg" ||
          extension.toLowerCase() === "jpeg"
        ) {
            if (e.target.files[0].size > Img_Size) {
                $('#image_error').html("please select Image Size under 2MB");
                $(this).val('');
            }else{
                $('#image_error').html("");
            }
        }else{
            $('#image_error').html("Image Size File");
            $(this).val('');
        }
        });
    });
    </script>
    
    <style>
    #image_error{
        font-weight: bold;
    font-size: 14px;
    }
    </style> 
<script>
$(document).ready(function() {
    
    var modes = @json($getPaymentMode);
      var row;
     
    
      modes.forEach(function(item,index) {
                    row +='<option value='+item.id+ '>'+item.name+'</option>';
      });
      
      var select_box = '<select class="form-control" name="payment_mode_id[]">'+ row+ '</select>'
    
    count=0;
        $( ".removeprodtxtbx" ).eq( 0 ).css( "display", "none" );
        $(document).on("click", "#clonebtn", function() {
    count++;
        $('#table_body').append('<tr id="appendRow_'+count+'" ><td colspan="2"><input type="text" onkeydown="return /[a-zA-Z ]/i.test(event.key)" class="form-control" placeholder="Expanse Name" id="name" name="name[]" required></td><td><input type="date" class="form-control" id="date" name="date[]" value="{{ date('Y-m-d') }}" required></td><td><input type="text" class="form-control" onKeyup="calculateAmount(this.value,'+count+');" placeholder="Quantity" id="quantity_'+count+'" name="quantity[]" onkeypress="javascript:return isNumber(event)" required></td><td><input type="text" class="form-control" onKeyup="calculateAmount(this.value,'+count+');" placeholder="Rate" id="rate_'+count+'" name="rate[]" onkeypress="javascript:return isNumber(event)" required></td>        <td><input type="text" class="form-control amount"  placeholder="Amount" id="amount_'+count+'" name="amount[]" readonly required></td><td>'+select_box+'</td><td><input type="file" class="form-control"  id="attachment" name="attachment[]"></td><td><textarea type="text" id="description" name="description[]" class="form-control" placeholder="If have any description write here..."></textarea></td><td style="width: 92px;"><div class="action_container"><button type="button" class="btn btn-primary btn-xs addmoreprodtxtbx" id="clonebtn"><i class="fa fa-plus"></i></button><button type="button" class="btn btn-danger btn-xs removeprodtxtbx" id="removerow"><i class="fa fa-trash"></i></button></div></td> </tr>');
            

        $( ".removeprodtxtbx" ).eq( count ).css( "display", "block" );
        $( ".addmoreprodtxtbx" ).eq( count ).css( "display", "none" );

        });
    
        $(document).on("click", "#removerow", function() {
            $(this).parents('tr').remove();
            count--;
            window.calculateSum()
        });

});
</script>
<script>
   
    function calculateAmount(value,row_id) {
       
        var quantity = $('#quantity_'+row_id).val();
        var rate = $('#rate_'+row_id).val();
    
        var amount = quantity * rate;
    
        $('#amount_'+row_id).val(amount);
        calculateSum();
    };    
 function calculateSum() {
        var sum = 0;
        $(".amount").each(function() {
            if (!isNaN(this.value) && this.value.length != 0) {
                sum += parseFloat(this.value);
            }
        });
    
        $("#total_amt").val(sum.toFixed(2));
    }
        
</script>

<style>
._table {
    width: 100%;
    border-collapse: collapse;
}

._table :is(th, td) {
    padding: 5px 10px;
}
.success {
    background-color: #24b96f !important;
}
.danger {
    background-color: #ff5722 !important;
}
.action_container>* {
    color: #fff;
    text-decoration: none;
    display: inline-block;
    padding: 4px 7px;
    cursor: pointer;
    transition: 0.3s ease-in-out;
}
textarea {
    height: calc(2.25rem) !important;
}
</style>

@endsection      