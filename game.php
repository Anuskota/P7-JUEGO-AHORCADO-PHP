<?php


session_start();

$letters = "ABCDEFGHIJQLMNOPQRSTUVWXYZ";

$guess = "HANGMAN";
$maxLetters = strlen($guess) - 1;
$responses = ["H", "G", "A"];

function getCurrentPicture($part)
{
    return "./img/hangman_" . $part. ".png";
}
$bodyParts = ["cabeza","cabeza_y_tronco","tronco_y_mano", "tronco_y_2manos", "tronco_y_2manos_ypie" ,"tronco_y2_pies","gorro", "ojos", "FIN"];

function startGame(){
    
}

function restartGame(){

    
}

function getParts() {
    global $bodyParts;
    return isset($_SESSION["parts"]) ? $_SESSION["parts"] : $bodyParts;    
}

function getCurrentPart(){
        $parts = getParts();
        return $parts[0];
    
}

//Para saber que el juegp se reinicia

if(isser($_GET['start'])){

    
}

//Para saber cuando se ha pulsado KeyPresset KP
if (isser($_GET['kp'])) {

    $currentPressedKey = isset($_GET['kp']) ? $_GET['kp'] : null;

    if($currentPressedKey){
        
    }
}






?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego del Ahorcado</title>
</head>

<body style="background: deepskyblue;">
    <div style=" margin :0 auto; background: #dddddd; width:900px; height:900px; padding:5px; border-radius:3px ">

        <div style="width:500px; display:inline-block; background:#fff1;">
            <img src="<?php echo getCurrentPicture(getCurrentPart());?> " alt=""
                style=" width :80%; display:inline-block;">
        </div>

        <div style="float:right; display:inline; vertical-align:top">
            <h1>Juego del Ahorcado</h1>
            <div style="display:inline-block;">
                <form method="get">

                    <?php
                    $max = strlen($letters) - 1;
                    for ($i = 0; $i <= $max; $i++) {
                        echo "<button type='submit' name='kp' value='" . $letters[$i] . "'>" . $letters[$i] . "</button>";
                        if ($i % 7 == 0 && $i > 0) {
                            echo '<br>';
                        }
                    }




                    ?>

                </form>
            </div>
        </div>

        <div style=" margin-top:20px; padding:15px; background:lightseagreen ;color:#fcf8e3">
            <?php for ($j = 0; $j <= $maxLetters; $j++) : ?>

            <span style="font-size:35px; border-bottom: 3px solid #000; margin-right:5px;"> A</span>
            < <?php endfor; ?> </div>

        </div>



</body>

</html>