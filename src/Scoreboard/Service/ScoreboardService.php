<?php

namespace Sportradar\Scoreboard\Service;

use Sportradar\Scoreboard\Model\MatchInterface;
use Sportradar\Scoreboard\Repository\MatchRepositoryInterface;

class ScoreboardService implements ScoreboardServiceInterface
{
    private MatchRepositoryInterface $repository;

    function __construct(MatchRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    function start(MatchInterface $match): void
    {
        $this->repository->store($match);
    }

    function stop(MatchInterface $match): void
    {
        $this->repository->remove($match);
    }

    function update(MatchInterface $match): void
    {
        $this->repository->update($match);
    }

    /**
     * @return MatchInterface[]
     */
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
