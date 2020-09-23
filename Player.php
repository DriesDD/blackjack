<?php

declare(strict_types=1);

class Player
{

    private array $hand = [];
    private bool $lost = false;
    private BlackJack $game;
    private $role;

    public function __construct($game, $role)
    {
        $this->game = $game;
        $this->role = $role;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getHand(): array
    {
        return $this->hand;
    }

    public function hit(int $number)
    {
        $drawnCards = $this->game->drawCards($number);
        $this->hand = array_merge($this->hand, $drawnCards);
        if ($this->getScore() > 20) {
            $this->game->gameEnd();
        }
    }

    public function chooseMove()
    {var_dump($this->game->getActive());

        if ($this->getScore() < 16) {
            $this->hit(1);
            return true;
        } else {
            var_dump($this->game->getActive());
            return false;
        }
    }

    public function surrender()
    {
        $this->lost = true;
    }

    public function getScore(): int
    {
        $score = 0;
        foreach ($this->hand as $value) {
            $score += min(10, $value % 13);
        }
        return $score;
    }

    public function hasLost(): bool
    {
        return $lost;
    }
}
