<?php

namespace Sportradar\Scoreboard\Repository;

use Sportradar\Scoreboard\Model\MatchInterface;

interface MatchRepositoryInterface
{
    function getItems(): array;

    function getMatch(MatchInterface $match): MatchInterface;

    function store(MatchInterface $match): void;

    function remove(MatchInterface $match): void;

    function update(MatchInterface $match): void;
}
