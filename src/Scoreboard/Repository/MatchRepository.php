<?php

namespace Sportradar\Scoreboard\Repository;

use Sportradar\Scoreboard\Model\FootballMatch;

class MatchRepository
{

    private array $items = [];

    function getItems(): array
    {
        return $this->items;
    }

    function getMatch(FootballMatch $match): FootballMatch
    {
        foreach ($this->items as $item) {
            if ($item->getHomeTeam() == $match->getHomeTeam() && $item->getAwayTeam() == $match->getAwayTeam()) {
                return $item;
            }
        }

        throw new NonFoundException();
    }

    /**
     * @throws DuplicateException
     */
    function store(FootballMatch $match): void
    {
        $homeTeam = $match->getHomeTeam();
        $awayTeam = $match->getAwayTeam();

        foreach ($this->items as $item) {
            if (
                //     ($item->getHomeTeam() == $homeTeam && $item->getAwayTeam() == $awayTeam) ||
                //     ($item->getHomeTeam() == $awayTeam && $item->getAwayTeam() == $homeTeam)
                true
            ) {
                throw new DuplicateException();
            }
        }

        array_push($this->items, $match);
    }

    function remove(FootballMatch $match): void
    {
        foreach ($this->items as $key => $item) {
            if ($match->getHomeTeam() == $item->getHomeTeam() && $match->getAwayTeam() == $item->getAwayTeam()) {
                unset($this->items[$key]);
            }
        }
    }

    function update(FootballMatch $match): void
    {
        // will throw NonFoundException if not found
        $this->getMatch($match);

        foreach ($this->items as $key => $item) {
            if ($match->getHomeTeam() == $item->getHomeTeam() && $match->getAwayTeam() == $item->getAwayTeam()) {
                $this->items[$key] = $match;
            }
        }
    }
}
