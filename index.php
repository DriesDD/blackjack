<?php

declare(strict_types=1);
require 'Blackjack.php';
if (session_id() == '') {
    session_start();
    //echo('new id: ' . session_id());
}
$game = new Blackjack();

if (isset($_POST['Start'])) {
    $game->setActive(true);
    $game->gameStart();
    $game->printHands();
    $game->saveSession();
    }
if (isset($_POST['Hit'])) {
    $game->setActive(true);
    $game->getPlayer()->hit(1);
    $game->getDealer()->chooseMove();
        //issue: active changes to 'true' between choosemove and printhands
    var_dump($game->getActive());
    $game->printHands();
    $game->saveSession();
}
if (isset($_POST['Stand'])) {
    $game->setActive(true);
    $bothStand = false;
    if ($game->getDealer()->chooseMove() == false) {$bothStand = true;}
    $game->printHands();
    if ($bothStand = true) {$game->gameEnd();}
    $game->saveSession();
}
if (isset($_POST['Surrender'])) {
    $game->setActive(false);
    $game->printHands();
    $game->gameEnd();
    $game->saveSession();
}

?>

<form method="post">
    <input type="submit" name="Start" class="button" value="Start"
    <?php if ($game->getActive() == true){ ?> disabled <?php } ?> />

    <input type="submit" name="Hit" class="button" value="Hit"
    <?php if ($game->getActive() == false){ ?> disabled <?php } ?> />

    <input type="submit" name="Stand" class="button" value="Stand"
    <?php if ($game->getActive() == false){ ?> disabled <?php } ?> />

    <input type="submit" name="Surrender" class="button" value="Surrender"
    <?php if ($game->getActive() == false){ ?> disabled <?php } ?> />

</form>