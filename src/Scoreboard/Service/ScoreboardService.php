<?php

namespace Sportradar\Scoreboard\Service;

use Sportradar\Scoreboard\Model\FootballMatch;
use Sportradar\Scoreboard\Repository\MatchRepository;

class ScoreboardService
{
    private MatchRepository $repository;

    function __construct(MatchRepository $repository)
    {
        $this->repository = $repository;
    }

    function start(FootballMatch $match): void
    {
        $this->repository->store($match);
    }

    function stop(FootballMatch $match): void
    {
        $this->repository->remove($match);
    }

    function update(FootballMatch $match): void
    {
        $this->repository->update($match);
    }

    function getSummary(): array
    {
        $items = $this->repository->getItems();

        usort($items, function ($a, $b) {
            if ($a->getTotalScore() == $b->getTotalScore()) {
                return 1;
            }
            return $a->getTotalScore() < $b->getTotalScore() ? 1 : -1;
        });

        return $items;
    }
}
