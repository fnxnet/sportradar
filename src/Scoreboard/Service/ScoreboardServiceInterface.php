<?php

namespace Sportradar\Scoreboard\Service;

use Sportradar\Scoreboard\Model\MatchInterface;
use Sportradar\Scoreboard\Repository\MatchRepositoryInterface;

interface ScoreboardServiceInterface
{
    function start(MatchInterface $match): void;

    function stop(MatchInterface $match): void;

    function update(MatchInterface $match): void;

    /**
     * @return MatchInterface[]
     */
    function getSummary(): array;
}
