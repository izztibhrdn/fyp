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

    <?php
        include('include/topheader.php');

    
    ?>



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

        <input hidden id="round_count" value="1">
        <input hidden id="correct_count" value="0">
        <input hidden id="wrong_count" value="0">

        <div class="container" id="round_page">
            <h4 class="bg-dark p-10"><b id="round_text">1</b>/5</h4>
        </div>
        <div class="container" id="main_game">

            <?php
        
                //print_r($_POST);

                //get insect data
                include('insect_data.php');

                //array for a b c d option
                $option_arr = array("A","B","C","D");

                //get data length
                $insect_length = count($insect);

                //echo "count " . $insect_length;

                $numbers = range (0,$insect_length-1); 
                //shuffle  Scramble the array order immediately  
                shuffle ($numbers); 
                //array_slice  Fetches a certain in the array 1 Segment  
                $num=6; 
                $result = array_slice($numbers,6,$num); 
                //print_r($result); 

                //get 1 number from random result array
                $value_rand = array_rand($result,1);

                //print($value_rand);

                $rand_insect = $result[$value_rand];

                //print($rand_insect);

                $title = $insect[$rand_insect][0];
                $image = $insect[$rand_insect][1];
                $audio = $insect[$rand_insect][2];


            ?>

            <input hidden id="answer_audio" value="<?php echo $audio; ?>">

            <div class="row vertical-gap">

                <div class="col-md-12">
                    <div class="nk-feature-2">
                        <h1 class="bg-dark p-10">Guess The Animal</h1>
                        <!-- <div class="nk-feature-icon">
                            <img src="images/<?php echo $image; ?>" width="400px">
                        </div> -->
                        <div class="nk-feature-cont text-center">
                            <div id="waveform"></div>
                            <div class="nk-gap-1"></div>
                            <button onclick="hear()" href="#"
                                class="nk-btn nk-btn-x4 nk-btn-rounded nk-btn-color-success">
                                <span class="icon ion-volume-high"></span>
                                Hear
                            </button>
                            <div class="nk-gap-1"></div>
                            <div class="row">
                                <?php 
                                    $cnt = 0;
                                    foreach($result as $key => $x){
                                        //echo "x -" .$x;
                                        //echo $insect[$x][0];

                                        if($insect[$x][0] == $title){

                                ?>
                                <input hidden id="answer_alph" value="<?php echo $option_arr[$cnt]; ?>">
                                <?php
                                
                                        }

                                ?>
                                <div id='<?php echo $option_arr[$cnt]; ?>' class="<?php if($title == $insect[$x][0]){echo 'correct_option';} ?> nk-feature-icon col-md-6 nk-btn-hover-color-info p-10" 
                                    onclick="check_answer('<?php echo $title; ?>','<?php echo $insect[$x][0]; ?>','<?php echo $option_arr[$cnt]; ?>')">
                                    <h3 class="bg-dark p-10"><?php echo $option_arr[$cnt]; ?></h3>
                                    <img src="images/<?php echo $insect[$x][1]; ?>" width="300px" height="300px">
                                </div>
                                <?php

                                        $cnt++;

                                    }
                                
                                ?>
                            </div>

                        </div>
                    </div>
                    <div class="nk-feature-2 text-center" hidden id="correct_answer">
                        <h1 class="bg-success p-10">Your Answer is Correct!</h1>
                    </div>
                    <div class="nk-feature-2 text-center" hidden id="wrong_answer">
                        <h1 class="bg-danger p-10" id="wrong_answer_text">Your Answer is Wrong!</h1>
                    </div>
                    <input hidden id="check_done" value="0">
                </div>

                <div class="col-md-12" hidden id="next_button">
                    <div class="nk-feature-cont text-right">
                        <button onclick="refresh_page()" class="nk-btn nk-btn-x4 nk-btn-rounded nk-btn-color-primary nk-btn-hover-color-info">
                            <span class="icon fa fa-arrow-right"></span>
                            Next
                        </button>
                    </div>
                </div>

            </div>
        </div>
        
        
        <div class="container" id="result_round" hidden>
        
            <?php include('result_round.php'); ?>

        </div>

    </div>

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


    $( document ).ready(function() {
        console.log( "ready!" );
        reload_audio();
    });

    function reload_audio(){
        audios = $('#answer_audio').val();
        this.wavesurfer.load('audio/'+audios);
        //console.log(audios);
    }

    function hear() {
        this.wavesurfer.playPause();
    }
 
    wavesurfer.on('finish', function() {
        wavesurfer.params.container.style.opacity = 0.9;
    });

    function check_answer(answer, choice, id) {
        console.log("answ "+ answer);
        console.log("choice " + choice);

        correct_count = parseInt($('#correct_count').val());
        wrong_count = parseInt($('#wrong_count').val());

        done = $("#check_done").val();
        ans_alph = $("#answer_alph").val();

        reload_audio();

        if(done == 0){

            $("#check_done").val(1);

            if (answer == choice) {

                console.log("bethol");
                $('#correct_answer').removeAttr('hidden');
                $('#next_button').removeAttr('hidden');
                $( ".correct_option" ). addClass( 'nk-btn-color-success');

                $('#correct_count').val(correct_count+1);

            }else{
                console.log("saloh");
                $( "#wrong_answer_text" ). html('Your Answer is Wrong! <br/> Correct answer is '+ans_alph);
                $('#wrong_answer').removeAttr('hidden');
                $('#next_button').removeAttr('hidden');
                $( "#"+id ). addClass( 'nk-btn-color-danger');
                $( ".correct_option" ). addClass( 'nk-btn-color-success');

                $('#wrong_count').val(wrong_count+1);

            }

        }

    }

    function refresh_page(){
        $("#main_game").load(location.href + " #main_game"); 
        round_count = parseInt($('#round_count').val());
        console.log("round count " + round_count);

        correct_count = parseInt($('#correct_count').val());
        wrong_count = parseInt($('#wrong_count').val());
        setTimeout(function(){
                //your code here
            reload_audio();
        }, 3000);

        if(round_count == 5){ 
            $('#result_correct').html(correct_count);
            $('#result_wrong').html(wrong_count);

            $("#round_page").hide(); 
            $("#main_game").hide(); 
            $("#result_round").removeAttr('hidden'); 
        }else{

            new_round_count = round_count + 1;
            $('#round_count').val(new_round_count);
            $('#round_text').html(new_round_count);
        }
    }

    </script>

</body>

</html>