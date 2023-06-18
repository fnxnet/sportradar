<?php

namespace Sportradar\Scoreboard\Model;

class FootballMatch
{

    private string $homeTeam = '';
    private string $awayTeam = '';
    private int $homeScore = 0;
    private int $awayScore = 0;

    function __construct(string $homeTeam, string $awayTeam)
    {
        if ($homeTeam == $awayTeam) {
            throw new \RuntimeException("Away team can not be the same as home one");
        }

        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
    }

    function getHomeTeam(): string
    {
        return $this->homeTeam;
    }

    function getAwayTeam(): string
    {
        return $this->awayTeam;
    }

    function getHomeScore(): int
    {
        return $this->homeScore;
    }

    function getAwayScore(): int
    {
        return $this->awayScore;
    }

    function getTotalScore(): int
    {
        return $this->homeScore + $this->awayScore;
    }

    function updateScore(int $homeScore, int $awayScore): FootballMatch
    {
        if ($homeScore < 0 || $awayScore < 0) {
            throw new \RuntimeException("Score can not be negative");
        }

        $updatedMatch = clone ($this);

        $updatedMatch->homeScore = $homeScore;
        $updatedMatch->awayScore = $awayScore;
        return $updatedMatch;
    }

    function __toString(): string
    {
        return "{$this->homeTeam} {$this->homeScore} - {$this->awayTeam} {$this->awayScore}";
    }
}
