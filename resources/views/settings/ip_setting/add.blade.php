
@extends('layout.app')
@section('content')


<div class="content-wrapper">

   <section class="content pt-3">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-outline card-orange">
                     <div class="card-header bg-primary">
                    <h3 class="card-title"><i class="fa fa-sliders"></i> &nbsp; {{__('setting.Add IP Setting') }}</h3>
                    <div class="card-tools">
                    <a href="{{url('view_ip_setting')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-eye"></i> {{__('common.View') }} </a>
                    <a href="{{url('master_dashboard')}}" class="btn btn-primary  btn-sm" title="View Users"><i class="fa fa-eye"></i> {{__('Back') }} </a>
                    </div>
                    
                    </div>        
                <form id="quickForm" action="{{ url('add_ip_setting') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row m-2">

                        <div class="col-md-6 p-0">
            
                            <table class="_table">
                            <thead>
                              <tr>
                                <th class="text-danger">{{__('setting.IP Address') }}*</th>
                                <th>{{__('setting.Remark') }}</th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody id="table_body">
                              <tr id="box2" >
                                <td>
                                    <input type="text" class="form-control" name="ip_address[]" id="ip_address" placeholder="{{__('setting.IP Address') }}" value="{{ old('ip_address') }}" autocomplete="off" required>
                                </td>
                                <td>
                                  <input type="text" class="form-control" placeholder="{{__('setting.Remark') }}" id="remark" name="remark[]"  value="{{ old('remark') }}">
                                </td>
                                <td>
                                  <div class="action_container">
                                        <button type="button" class="btn btn-primary btn-xs addmoreprodtxtbx" id="clonebtn"><i class="fa fa-plus"></i></button>
                                        <button type="button" class="btn btn-danger btn-xs removeprodtxtbx" id="removerow"><i class="fa fa-trash"></i></button>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                            </table>              
                            
                        </div>
            
                        <!--<div class="col-md-2">
                            <div class="form-group">
                                <label style="color:red;"> IP Address*</label>
                                <input type="text" class="form-control @error('ip_address') is-invalid @enderror" id="ip_address" name="ip_address" value="{{old('ip_address')}}" placeholder="IP Address">
                                @error('ip_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                           <div class="col-md-2">
                            <div class="form-group">
                                <label>Remark</label>
                                <input type="text" class="form-control @error('remark') is-invalid @enderror" id="remark" name="remark" value="{{old('remark')}}" placeholder="Remark">
                                @error('remark')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>-->

                    </div>
                    <div class="row m-2 pb-2">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary ">{{__('common.Submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
</div>
</div>
</div>
</section>
</div>


<style>
._table {
    width: 100%;
    border-collapse: collapse;
}

._table :is(th, td) {
    padding: 5px 10px;
}
.action_container>* {
    color: #fff;
    text-decoration: none;
    display: inline-block;
    padding: 4px 7px;
    cursor: pointer;
    transition: 0.3s ease-in-out;
}
</style>
<script>
    count=0;
      $( ".removeprodtxtbx" ).eq( 0 ).css( "display", "none" );
    $(document).on("click", "#clonebtn", function() {
       count++;
        //we select the box clone it and insert it after the box
        $('#box2').addClass('rowTr')
        $('#box2').clone().appendTo('#table_body')
       $('.rowTr').last().addClass('rowTr1')
       //  $('#box2').find('#removerow').addClass("buttondel")
          
   
        // $('.buttondel').css('visibility', 'visible')
      
         $( ".removeprodtxtbx" ).eq( count ).css( "display", "block" );
         $( ".addmoreprodtxtbx" ).eq( count ).css( "display", "none" );

    });
    
    $(document).on("click", "#removerow", function() {
        $(this).parents("#box2").remove();
        $('#removerow').focus();
        count--;
    });
</script>

@endsection