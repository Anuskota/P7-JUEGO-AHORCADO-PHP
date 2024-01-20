<?php


session_start();

$letters = "ABCDEFGHIJQLMNOPQRSTUVWXYZ";

$guess = "HANGMAN";
$maxLetters = strlen($guess) - 1;
$responses = ["H", "G", "A"];


$bodyParts = ["cabeza", "cabeza_y_tronco", "tronco_y_mano", "tronco_y_2manos", "tronco_y_2manos_ypie", "tronco_y2_pies", "gorro", "ojos", "FIN"];
$words = ["FEMCODERS", "SEGOVIA", "LIBERTAD", "SUEÑO", "INTELIGENCIA", "CANSALIEBRES", "GAMBITERO", "ANIS"];





function getCurrentPicture($part)
{
    return "./img/hangman_" . $part . ".png";
}



function startGame()
{
}

function restartGame()
{
    session_destroy();
    session_start();
}

function getParts()
{
    global $bodyParts;
    return isset($_SESSION["parts"]) ? $_SESSION["parts"] : $bodyParts;
}

function getCurrentPart()
{
    $parts = getParts();
    return $parts[0];
}

// PALABRA 

function getCurrentWord()
{
    global $words;
    if (!isset($_SESSION["word"]) && empty($_SESSION["word"])) {
        $key = array_rand($words);
        $_SESSION["word"] = $words[$key];
    }
    return $_SESSION["word"];
}

function getcurrentResponses()
{
    return isset($_SESSION["responses"]) ? $_SERVER["responses"] : [];
}

function addResponse($letter)
{
    $responses = getCurrentResponses();
    array_push($responses, $letter);
    $_SESSION["responses"] = $responses;
}

function isLetterCorrect($letter)
{
    $word = getCurrentWord();
    $max = strlen($word) - 1;
    for ($i = 0; $i <= $max; $i++) {
        if ($letter == $word[$i]) {
            return true;
        }
    }
    return false;
}

function isWordCorrect()
{
    $guess = getCurrentWord();
    $responses = getCurrentResponses();
    $max = strlen($guess) - 1;
    for ($i = 0; $i <= $max; $i++) {
        if (!in_array($guess[$i],  $responses)) {
            return false;
        }
    }
    return true;
}
function isBodyComplete()
{
    $parts = getParts();
    // is the current parts less than or equal to one
    if (count($parts) <= 1) {
        return true;
    }
    return false;
}
function addPart()
{
    $parts = getParts();
    array_shift($parts);
    $_SESSION["parts"] = $parts;
}
// is game complete
function gameComplete()
{
    return isset($_SESSION["gamecomplete"]) ? $_SESSION["gamecomplete"] : false;
}


// set game as complete
function markGameAsComplete()
{
    $_SESSION["gamecomplete"] = true;
}

// start a new game
function markGameAsNew()
{
    $_SESSION["gamecomplete"] = false;
}







//Para saber que el juegp se reinicia

if (isset($_GET['start'])) {
}

//Para saber cuando se ha pulsado KeyPresset KP
if (isset($_GET['kp'])) {
    $currentPressedKey = isset($_GET['kp']) ? $_GET['kp'] : null;
    // if the key press is correct
    if (
        $currentPressedKey
        && isLetterCorrect($currentPressedKey)
        && !isBodyComplete()
        && !gameComplete()
    ) {

        addResponse($currentPressedKey);
        if (isWordCorrect()) {
            $WON = true; // game complete
            markGameAsComplete();
        }
    } else {
        // start hanging the man :)
        if (!isBodyComplete()) {
            addPart();
            if (isBodyComplete()) {
                markGameAsComplete(); // lost condition
            }
        } else {
            markGameAsComplete(); // lost condition
        }
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
            <img src="<?php echo getCurrentPicture(getCurrentPart()); ?> " alt=""
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
                    <br><br>

                    <button type="submit" name="start">RESTART GAME</button>
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