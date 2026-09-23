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
                            <h3 class="card-title"><i class="fa fa-credit-card"></i> &nbsp;{{ __('expense.Edit Expense') }} </h3>
                            <div class="card-tools">
                                <a href="{{url('expenseView')}}" class="btn btn-primary  btn-sm"><i class="fa fa-eye"></i> {{ __('common.View') }} </a>
                                <!--<a href="{{url('hostel_dashboard')}}" class="btn btn-primary  btn-sm"><i class="fa fa-arrow-left"></i> Back </a>-->
                            </div>

                        </div>
                        <form id="quickForm" action="{{ url('expenseEdit') }}/{{ $data['id'] ?? '' }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row m-2">
                                <table class="_table" id="tableId">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th  colspan='2' style="color:red;">{{ __('Expense Head') }}*</th>
                                            <th colspan='2' style="color:red;">{{ __('Staff/User') }}*</th>
                                            <th style="color:red;">{{ __('common.Date') }}*</th>
                                            <th style="color:red;">{{ __('expense.Quantity') }}*</th>
                                            <th style="color:red;">{{ __('expense.Rate') }}*</th>
                                            <th style="color:red;">{{ __('Payment Mode') }}*</th>
                                            <!--<th style="color:red;">{{ __('expense.Attachocument') }}*</th>-->
                                            <th style="color:red;">{{ __('expense.Description') }}*</th>
                                            <th style="color:red;">{{ __('expense.Total') }}*</th>

                                            <th width="50px"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body">
                                        <tr id="appendRow_0">
                                            <td colspan="2">
                                                
                                                 <input type="text" class="form-control" id="name" name="name" value="{{$data['name'] ?? ''}}" required>
                                    
                                            </td>
                                            <td colspan='2'>
                                                
                                               
                                                <select id="role" name="role" required>
                                                @if(!empty($getRole))
                                                 
                                                 <option value=''>Select</option>
                                                @foreach($getRole as $item)
                                               
                                                <option value='{{$item->id}}'{{$item->id == $data["user_id"]  ? "selected" : ""}}>{{$item->first_name ?? ''}} {{$item->last_name ?? ''}}</option>
                                                @endforeach
                                                
                                                @endif
                                                
                                                
                                            </select>
                                            </td>
                                            <td>
                                                <input type="date" class="form-control" id="date" name="date" value="{{ $data->date ?? '' }}" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" onkeyup="calculateAmount(this.value,0);" placeholder="{{ __('expense.Quantity') }}" id="quantity_0" name="quantity" onkeypress="javascript:return isNumber(event)" value="{{ $data->quantity ?? '' }}" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" onkeyup="calculateAmount(this.value,0);" placeholder="{{ __('expense.Rate') }}" id="rate_0" name="rate" onkeypress="javascript:return isNumber(event)" value="{{ $data->rate ?? '' }}" required>
                                            </td>
                                             <td>
                                             <select class="form-control" id="payment_mode_id" name="payment_mode_id" required>
                                    @if(!empty($getPaymentMode))
                                        @foreach($getPaymentMode as $value)
                                        <option value="{{ $value->id }}" {{$value->id == ($data->payment_mode_id ?? '') ? 'selected' : ''}}>{{ $value->name ?? ''}}</option>
                                        @endforeach
                                    @endif  
                                </select>
                                        </td>
                                           
                                                
                                                
                                               
									
                                          
                                            <td>
                                                <textarea type="text" id="description" name="description" class="form-control" placeholder="{{ __('expense.Description') }}">{{ $data->description ?? '' }}</textarea>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control amount" onkeyup="calculateSum()" placeholder="{{ __('expense.Total') }}" id="amount_0" name="amount" value="{{ $data->amount ?? '' }}" readonly required>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                                	<div class="ml-2 form-group">
				<label style='color:red'class='font-weight-bold'>{{ __('Attachment *') }} </label><br>             
                <img width='100px' height='100px' class='mt-2 mb-2 doc_img profileImg pointer'src ='{{env("IMAGE_SHOW_PATH").($data->attachment == '' ? "default/Icon_images/noImage.png" : "expense/".$data->attachment ?? '')}}'  data-img="@if(!empty($data->attachment)) {{ env('IMAGE_SHOW_PATH').'expense/'.$data->attachment }} @endif"/>
			
			 <input type="file" class="form-control"  id="attachment" name="attachment" value="{{ $data->attachment ?? '' }}" accept="image/png, image/jpg, image/jpeg">
		    </div>
                            </div>

                            <div class="row m-2">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">{{ __('common.submit') }} </button>
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
    #image_error{
        font-weight: bold;
    font-size: 14px;
    }
    </style>


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

<div id="profileImgModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <img id="profileImg" src="" width="100%" height="100%">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>  

<script>
    $('.profileImg').click(function(){
        var profileImgUrl = $(this).data('img');
        if(profileImgUrl != ''){
            $('#profileImgModal').modal('toggle');
            $('#profileImg').attr('src',profileImgUrl);
        }
    });
</script>

@endsection