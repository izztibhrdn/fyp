<!DOCTYPE html>

    
<html lang="en">
<head>

    <title>Start Game - Kids-Learning</title>
    
    <?php include('include/head.php'); ?>
    <script src="https://unpkg.com/wavesurfer.js"></script>

</head>


<!--
    Additional Classes:
        .nk-page-boxed
-->
<body>
    
    <?php include('include/topheader.php'); ?>

    

    <div class="nk-main">
        
        <!-- START: Breadcrumbs -->
        <div class="nk-gap-1"></div>
        <div class="container">
            <ul class="nk-breadcrumbs">


                <li><a href="index.php">Home</a></li>


                <li><span class="fa fa-angle-right"></span></li>

                <li><span>Guess the Insect!</span></li>

            </ul>
        </div>
        <div class="nk-gap-1"></div>
        <!-- END: Breadcrumbs -->

        <div class="container">

            <?php

                //get insect data
                include('insect_data.php');

                //get data length
                $insect_length = count($insect);

                //get random insect number
                $rand_insect = rand(0,$insect_length-1);

                //get insect data by random number
                //print_r($insect[$rand_insect]);

                $title = $insect[$rand_insect][0];
                $image = $insect[$rand_insect][1];
                $audio = $insect[$rand_insect][2];


            ?>

            <div class="row vertical-gap">

                <div class="col-md-12">
                    <div class="nk-feature-2">
                        <h1 class="bg-dark p-10"><?php echo $title; ?></h1>
                        <div class="nk-feature-icon">
                            <img src="images/<?php echo $image; ?>" width="400px">
                        </div>
                        <div class="nk-feature-cont text-center">
                            <div id="waveform"></div>
                            <div class="nk-gap-1"></div>
                            <button onclick="hear('<?php echo $audio; ?>')" href="#" class="nk-btn nk-btn-x4 nk-btn-rounded nk-btn-color-success">
                                <span class="icon ion-volume-high"></span>
                                Hear
                            </button>
                            <button onclick="speak('<?php echo $title; ?>')" class="nk-btn nk-btn-x4 nk-btn-rounded nk-btn-color-success">
                                <span class="icon fa fa-microphone"></span>
                                Speak
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="nk-feature-cont text-right">
                        <a href="game_on.php" class="nk-btn nk-btn-x4 nk-btn-rounded nk-btn-color-primary nk-btn-hover-color-info">
                            <span class="icon fa fa-arrow-right"></span>
                            Next
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
    
    <a hidden href="#" data-toggle="modal" data-target="#modalsuccess" id="modalpopup">success</a>
    
    <!-- START: Success Modal -->
    <div class="nk-modal modal fade" id="modalsuccess" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="ion-android-close"></span>
                    </button>
  
                    <h2 class="mb-0 text-success"><span class="fa fa-check-circle"></span> Correct!</h2>
                                    
                    <div class="nk-gap-2"></div>
                    <h3>You have pronounced the correct way!</h3>
                    <button class="nk-btn nk-btn-color-danger nk-btn-rounded " data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- END: success Modal -->
    
    <a hidden href="#" data-toggle="modal" data-target="#modalspik" id="speakmodal">speak</a>
    
    <!-- START: Success Modal -->
    <div class="nk-modal modal fade" id="modalspik" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="ion-android-close"></span>
                    </button>
  
                    <h2 class="mb-0 text-info">Let us hear you.</h2>
                                    
                    <div class="nk-gap-2"></div>
                    <h3>Please speak to the microphone......</h3>
                    <button id="close-speakmodal" hidden class="nk-btn nk-btn-color-danger nk-btn-rounded" data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- END: success Modal -->
    
    <a hidden href="#" data-toggle="modal" data-target="#modalerror" id="errormodal">error</a>
    
    <!-- START: Success Modal -->
    <div class="nk-modal modal fade" id="modalerror" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="ion-android-close"></span>
                    </button>
  
                    <h2 class="mb-0 text-danger"><span class="fa fa-times-circle"></span> Wrong!</h2>
                                    
                    <div class="nk-gap-2"></div>
                    <h3>You have pronounced the wrong way! Please try speak again.</h3>
                    <button class="nk-btn nk-btn-color-danger nk-btn-rounded " data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- END: success Modal -->

    <div class="nk-gap-1"></div>

    <?php include('include/script.php'); ?>
    <script>

        var wavesurfer = WaveSurfer.create({
            container: '#waveform',
            waveColor: 'white',
            progressColor: 'grey',
            barWidth: 4,
            height: 90,
            responsive: true,
            hideScrollbar: true,
            barRadius: 4
        });


        wavesurfer.load('audio/<?php echo $audio; ?>');

        function hear(){
            this.wavesurfer.playPause();
        }

        wavesurfer.on('finish', function () {
            wavesurfer.params.container.style.opacity = 0.9;
        });
        
        function speech(textspeech){
            //window.speechSynthesis.speak(new SpeechSynthesisUtterance('Hello World'));
            // new SpeechSynthesisUtterance object
            let utter = new SpeechSynthesisUtterance();
            utter.lang = 'ms-MY-Standard-A';
            utter.text = textspeech;
            utter.volume = 1;
            utter.rate = 0.5; // From 0.1 to 10
            utter.pitch = 6; // From 0 to 2

            var voices = window.speechSynthesis.getVoices();
            console.log(voices);

            // event after text has been spoken
            utter.onend = function() {
            	//alert('Speech has finished');
            }

            // speak
            window.speechSynthesis.speak(utter);
        }

        
        function speak(insectname) {
            
            // new speech recognition object
            var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
            var recognition = new SpeechRecognition();
        
            // This runs when the speech recognition service starts
            recognition.onstart = function() {
                //action.innerHTML = "<small>listening, please speak...</small>";
                $('#speakmodal').click();
            };

            recognition.onspeechend = function() {
                //action.innerHTML = "<small>stopped listening, hope you are done...</small>";
                $('#close-speakmodal').click();
                recognition.stop();
            }
        
            // This runs when the speech recognition service returns result
            recognition.onresult = function(event) {
                var transcript = event.results[0][0].transcript;
                var confidence = event.results[0][0].confidence;
                //output.innerHTML = "<b>Text:</b> " + transcript + "<br/> <b>Confidence:</b> " + confidence*100+"%";
                console.log("speak - " + transcript.toLowerCase());
                console.log("insek - " + insectname.toLowerCase());


                //if( transcript.toLowerCase() ==  insectname.toLowerCase()){
                if( transcript.includes(insectname)){
                    $('#modalpopup').click();
                    console.log("same");
                }else{
                    $('#errormodal').click();
                    console.log("text " + insectname);
                    console.log("speak " + transcript);
                }

            };
        
             // start recognition
             recognition.start();
	    }
        

    </script>
    
</body>
</html>
