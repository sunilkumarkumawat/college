
@extends('layout.app') 
@section('content')

<div class="content-wrapper">
    <section class="pt-1">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-orange">
                        <div class="card-header bg-primary">
                            <h3 class="card-title" id="hello"><i class="fa fa-snapchat"></i> &nbsp; Chat Panel</h3>
                            <input type="hidden" id="sessionId" value="{{ Session::get('id') }}">
                            <div class="card-tools">
                                <svg class="" viewBox="0 0 24 24" height="24" width="24" ><path fill="currentColor" d="M12.072,1.761c-3.941-0.104-7.579,2.105-9.303,5.65c-0.236,0.486-0.034,1.07,0.452,1.305 c0.484,0.235,1.067,0.034,1.304-0.45c1.39-2.857,4.321-4.637,7.496-4.553c0.539,0.02,0.992-0.4,1.013-0.939s-0.4-0.992-0.939-1.013 C12.087,1.762,12.079,1.762,12.072,1.761z M1.926,13.64c0.718,3.876,3.635,6.975,7.461,7.925c0.523,0.13,1.053-0.189,1.183-0.712 c0.13-0.523-0.189-1.053-0.712-1.183c-3.083-0.765-5.434-3.262-6.012-6.386c-0.098-0.53-0.608-0.88-1.138-0.782 C2.178,12.6,1.828,13.11,1.926,13.64z M15.655,21.094c3.642-1.508,6.067-5.006,6.201-8.946c0.022-0.539-0.396-0.994-0.935-1.016 c-0.539-0.022-0.994,0.396-1.016,0.935c0,0.005,0,0.009,0,0.014c-0.107,3.175-2.061,5.994-4.997,7.209 c-0.501,0.201-0.743,0.769-0.543,1.27c0.201,0.501,0.769,0.743,1.27,0.543C15.642,21.1,15.648,21.097,15.655,21.094z"></path><path fill="#009588" d="M19,1.5c1.657,0,3,1.343,3,3s-1.343,3-3,3s-3-1.343-3-3S17.343,1.5,19,1.5z"></path></svg>
                                <svg class="ml-3" id="NewChat" viewBox="0 0 24 24" height="24" width="24" ><path fill="currentColor" d="M19.005,3.175H4.674C3.642,3.175,3,3.789,3,4.821V21.02 l3.544-3.514h12.461c1.033,0,2.064-1.06,2.064-2.093V4.821C21.068,3.789,20.037,3.175,19.005,3.175z M14.016,13.044H7.041V11.1 h6.975V13.044z M17.016,9.044H7.041V7.1h9.975V9.044z"></path></svg>
                                <svg class="ml-2" viewBox="0 0 24 24" height="24" width="24" ><path fill="currentColor" d="M12,7c1.104,0,2-0.896,2-2c0-1.105-0.895-2-2-2c-1.104,0-2,0.894-2,2 C10,6.105,10.895,7,12,7z M12,9c-1.104,0-2,0.894-2,2c0,1.104,0.895,2,2,2c1.104,0,2-0.896,2-2C13.999,9.895,13.104,9,12,9z M12,15 c-1.104,0-2,0.894-2,2c0,1.104,0.895,2,2,2c1.104,0,2-0.896,2-2C13.999,15.894,13.104,15,12,15z"></path></svg>
                            </div>
                        </div>        

                        <div class="row m-5">
     
                            <div class="col-md-12 p-b-5 mt-3">

                                        	<button id="recordButton">Start Recording</button>
                                        	<button id="stopButton" >Stop</button>

                                        		<audio src="" controls id="audio-playback"></audio>

                                    		<a href="" download="" id="downloadButton">Download Audio</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// audio recorder
let recorder, audio_stream;
const recordButton = document.getElementById("recordButton");
recordButton.addEventListener("click", startRecording);

// stop recording
const stopButton = document.getElementById("stopButton");
stopButton.addEventListener("click", stopRecording);

// set preview
const preview = document.getElementById("audio-playback");

// set download button event
const downloadAudio = document.getElementById("downloadButton");
downloadAudio.addEventListener("click", downloadRecording);

function startRecording() {

    navigator.mediaDevices.getUserMedia({ audio: true })
        .then(function (stream) {
            audio_stream = stream;
            recorder = new MediaRecorder(stream);

            // when there is data, compile into object for preview src
            recorder.ondataavailable = function (e) {
                const url = URL.createObjectURL(e.data);
                preview.src = url;

                // set link href as blob url, replaced instantly if re-recorded
                downloadAudio.href = url;
            };
            recorder.start();

            timeout_status = setTimeout(function () {
                console.log("5 min timeout");
                stopRecording();
            }, 300000);
        });
}

function stopRecording() {
    recorder.stop();
    audio_stream.getAudioTracks()[0].stop();
}

function downloadRecording(){
    var name = new Date();
    var res = name.toISOString().slice(0,10)
    downloadAudio.download = res + '.wav';
}
</script>

<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>    
<script>
$(document).ready(function(){

      const firebaseConfig = {
        apiKey: "AIzaSyCFj9hBIa221TJdXFhWl8wHnRYDz9PMipE",
        authDomain: "callback-d7ec3.firebaseapp.com",
        projectId: "callback-d7ec3",
        storageBucket: "callback-d7ec3.appspot.com",
        messagingSenderId: "254423862976",
        appId: "1:254423862976:web:e6b3270802eb4cf98c2725",
        measurementId: "G-FQBVLJTWB4"
      };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (response) {
                //alert(response);
                $(".mt-3").html(response);
            })
    
        messaging.onMessage(function(payload) {
            alert(JSON.stringify(payload.notification));
            
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(noteTitle, noteOptions);
        
        });
})
</script>

<script src="https://rukmanisoftware.com/public/school/v1/validation.js"></script>
@endsection      