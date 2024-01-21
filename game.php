<?php


session_start();

$letters = "ABCDEFGHIJQLMNOPQRSTUVWXYZ";
$WON = false;

$guess = "SEGOVIA";
$maxLetters = strlen($guess) - 1;
$responses = ["H", "G", "A"];


$bodyParts = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"];
$words = ["MADRID", "SEGOVIA", "OVIEDO", "BILBAO", "SANTANDER", "MALAGA", "JAEN", "GUADALAJARA", "SALAMANCA", "CACERES", "ORENSE", "PONTEVEDRA", "BARCELONA"];





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
    // return "SEGOVIA";
    global $words;
    if (!isset($_SESSION["word"]) && empty($_SESSION["word"])) {
        $key = array_rand($words);
        $_SESSION["word"] = $words[$key];
    }
    return $_SESSION["word"];
}

function getcurrentResponses()
{
    return isset($_SESSION["responses"]) ? $_SESSION["responses"] : [];
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
    restartGame();
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
    <link rel="stylesheet" href="style.css">
    <title>Juego del Payasu</title>
</head>

<body>
    <div class="container">

        <div class="picture">
            <img src=" <?php echo getCurrentPicture(getCurrentPart()); ?> " alt="imagen">

            <!--Indicar el estado del juego-->
            <?Php if (gameComplete()) : ?>
            <h1>GAME COMPLETE</h1>
            <?php endif; ?>
            <?php if ($WON  && gameComplete()) : ?>
            <p class="win">HAS GANADO! VIVA!! :)</p>
            <?php elseif (!$WON  && gameComplete()) : ?>
            <p class="loss"> OH NO! HAS PERDIDO :(</p>
            <?php endif; ?>

        </div>

        <div class="letters">
            <h1>Juego del Payasu</h1>
            <div class="form">
                <form method=" get">

                    <?php
                    $max = strlen($letters) - 1;
                    for ($i = 0; $i <= $max; $i++) {
                        echo "<button type='submit' name='kp' value='" . $letters[$i] . "'>" . $letters[$i] . "</button>";
                        if ($i %  10 == 0 && $i > 0) {
                            echo '<br>';
                        }
                    }




                    ?>
                    <br><br>

                    <button type="submit" name="start">RESTART GAME</button>
                </form>
            </div>
        </div>

        <div class="hidden-letters">

            <?php
            $guess = getCurrentWord();
            $maxLetters = strlen($guess) - 1;
            for ($j = 0; $j <= $maxLetters; $j++) : $l = getCurrentWord()[$j]; ?>
            <?php if (in_array($l, getCurrentResponses())) : ?>
            <span><?php echo $l; ?></span>
            <?php else : ?>
            <span>&nbsp;&nbsp;&nbsp;</span>
            <?php endif; ?>
            <?php endfor; ?>
        </div>



</body>

</html>