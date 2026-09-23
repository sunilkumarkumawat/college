<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Print</title>
    <link rel="stylesheet" href="{{ asset('public/assets/school/css/adminlte.min.css') }}"> 
    <script src="{{URL::asset('public/assets/school/js/jquery.min.js')}}"></script>
</head>
<body class="m-5">
@php
$getSetting = Helper::getSetting();
@endphp
@if(!empty($data))

    <!-- Your page content goes here -->
    <header class="">

        <div class="row m-2">
            <div class="col-md-1 text-center col-1">
                <img src="{{ env('IMAGE_SHOW_PATH').'setting/left_logo/'.$getSetting->left_logo }}" width="150px" onerror="this.src='{{ env('IMAGE_SHOW_PATH').'default/rukmanisoft_logo.png' }}'">
            </div>
            <div class="col-md-11 col-11">
                <h1 class="text-center"><b>{{ $getSetting->name ?? '' }}</b></h1>
                <p class="text-center"><b>Address : </b>{{ $getSetting->address ?? '' }}</p>
                <p class="text-center"><b>Phone : </b> {{ $getSetting->mobile ?? '' }} <b>Email : </b> {{ $getSetting->gmail ?? '' }}</p>
            </div>
        </div>
        <hr class="header_bottom_border">
        <h3 class="text-center"><b>{{ $data->name ?? '' }}</b></h3>
        <div class="row m-2">
            <div class="col-md-6">
                <b>Exam Date : </b>{{ date('d-m-Y, h:i A', strtotime($data->exam_date)) ?? '' }}
            </div>
            <div class="col-md-6 text-right">
                <b>TEST ID : </b>{{ $data->exam_code ?? '' }}
            </div>
            <div class="col-md-6">
                <b>Duration : </b>{{ $data->duration ?? '' }}H : {{ $data->duration_minute ?? '' }}M
            </div>
            <div class="col-md-6">
                
            </div>
            <div class="col-md-6">
                <b>Total Marks : </b>{{ $data->totalQuesMark ?? '' }}
            </div>
            
        </div>
        
    </header>
    <hr class="header_bottom_border">
    <main>
        <section>
            <h2 class="text-center"><u>CHEMISTRY</u></h2>
        </section>

        <section class="p-2">
                <table>
                    <tbody>
                        @if(!empty($question))
                            @php
                                $i = 1;
                            @endphp
                        @foreach($question as $ques)
                        <tr>
                            <td>{{ $i++ }}.</td>
                            <td colspan="4">{!! $ques->name ?? '' !!} <br> {!! $ques->hi_name ?? '' !!}</td>
                        </tr>
                            @if($ques->question_type_id == 1)
                            <tr>
                                <td></td>
                                <td class="p-1">a) {!! $ques->ans_a ?? '' !!} <br> {!! $ques->hi_ans_a ?? '' !!}</td>
                                <td class="p-1">b) {!! $ques->ans_b ?? '' !!} <br> {!! $ques->hi_ans_b ?? '' !!}</td>
                                <td class="p-1">c) {!! $ques->ans_c ?? '' !!} <br> {!! $ques->hi_ans_c ?? '' !!}</td>
                                <td class="p-1">d) {!! $ques->ans_d ?? '' !!} <br> {!! $ques->hi_ans_d ?? '' !!}</td>
                            </tr>
                            @else
                            <tr>
                                <td></td>
                                <td class="p-1">a) {!! $ques->ans_a ?? '' !!} <br> </td>
                                <td class="p-1"></td>
                                <td class="p-1"></td>
                                <td class="p-1"></td>
                            </tr>                            
                            @endif
                        @endforeach
                        @endif
                    </tbody>
                </table>
            
        </section>
        <!-- Add more sections or content as needed -->
    </main>

    <footer class="pt-5">
        <center><p class="text-center">&copy; 2024 {{ $getSetting->name ?? '' }}</p></center>
        <!-- Add footer content or links as needed -->
    </footer>
@endif

<script>
$(document).ready(function(){
    window.print();
    
    $('table p').attr('style', '');
    $('table p').replaceWith(function()
    {
      return '<span>' + $(this).html() + '</span>';
    });
});
</script>
<style>
    body {
        background-image: url('https://tciexam.rusoft.in/schoolimage//setting/left_logo/170410264665928af61fffelogo%20new(1).jpg');
        
        background-position: center;
        background-repeat: no-repeat;

    }
    
    *{
        font-family: auto;
    }
    .header_bottom_border{
        border-bottom: 2px solid;
    }
    body{
        border: 2px solid;
    }
    tr{
        vertical-align: baseline;
    }
</style>
</body>
</html>
