<?php


session_start();
include ("functions.php");

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