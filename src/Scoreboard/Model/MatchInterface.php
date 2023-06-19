<?php

namespace Sportradar\Scoreboard\Model;

interface MatchInterface
{
    function getHomeTeam(): string;

    function getAwayTeam(): string;

    function getHomeScore(): int;

    function getAwayScore(): int;

    function getTotalScore(): int;

    function updateScore(int $homeScore, int $awayScore): self;
    function __toString(): string;
}
