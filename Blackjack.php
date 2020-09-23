<?php

declare(strict_types=1);

require 'Player.php';

class Blackjack
{
    private Player $player;
    private Player $dealer;
    private array $deck;
    private bool $active = false;

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getDealer(): Player
    {
        return $this->dealer;
    }

    public function __construct()
    {
        $this->deck =
            [
                0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12,
                13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25,
                26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38,
                39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51
            ];
        shuffle($this->deck);

        $this->loadSession();
    }

    public function gameStart()
    {
        $_SESSION = [];
        session_destroy();
        $this->loadSession();
        session_start();
        $this->dealer->hit(2);
        $this->player->hit(2);
    }

    public function gameEnd()
    {
       if (min(22,$this->player->getScore()) == min(22,$this->dealer->getScore()))
       {
           echo("It's a tie. </br>");
       }
       else
       {
        if (($this->player->getScore() < 22) && (($this->dealer->getScore() > 21) || ($this->player->getScore() > $this->dealer->getScore())))
        {
            echo("You win! </br>");
        }
        else
        {
            echo("Opponent wins! </br>");
        }
       }
       $this->active = false;
    }

    public function saveSession()
    {
        $_SESSION['playerData'] = $this->player;
        $_SESSION['dealerData'] = $this->dealer;
    }

    public function loadSession()
    {
        if (isset($_SESSION['playerData']) == 0) {
            $_SESSION['dealerData'] = new Player($this, 'opponent');
            $_SESSION['playerData'] = new Player($this, 'you');
        }

        $this->dealer = $_SESSION['dealerData'];
        $this->player = $_SESSION['playerData'];
    }

    public function drawCards(int $number): array
    {
        return array_splice($this->deck, 0, $number);
    }

    public function printHands()
    {
        foreach ([$this->player, $this->dealer] as $player) {
            $namedHand = array_map([$this, 'cardGetName'], $player->getHand());
            echo ($player->getRole() . ' drew ' . implode(' and ', $namedHand) . ' for a total score of ' . $player->getScore() . '</br>');
        }
    }

    private function cardGetName(int $index): string
    {
        $number = $index % 13;
        $number = ["Ace", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Jack", "Queen", "King"][$number];
        $suit = floor($index / 13);
        $suit = ["Spades", "Hearts", "Diamonds", "Clubs"][$suit];
        return ($number . " of " . $suit);
    }

    public function getActive() : bool
    {
        return $this->active;
    }

    public function setActive(bool $active)
    {
        $this->active = $active;
        return $this;
    }
}
