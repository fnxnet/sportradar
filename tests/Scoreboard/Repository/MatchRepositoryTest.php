<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sportradar\Scoreboard\Repository\MatchRepository;
use Sportradar\Scoreboard\Model\FootballMatch;
use Sportradar\Scoreboard\Repository\DuplicateException;
use Sportradar\Scoreboard\Repository\NonFoundException;

/**
 * Testing MatchRepository
 */
final class MatchRepositoryTest extends TestCase
{

    function testInitiatingRepository(): void
    {
        $repository = new MatchRepository();
        $this->assertCount(0, $repository->getItems(), "expected empty collection");
    }

    function testStoringMatch(): void
    {
        $repository = new MatchRepository();
        $match = new FootballMatch('Team A', 'Team B');
        $repository->store($match);

        $items = $repository->getItems();
        $this->assertCount(1, $items, "expected collection with one entry");
    }

    function DuplicatedItemProvider()
    {
        return [
            [new FootballMatch('Team A', 'Team B')],
            [new FootballMatch('Team B', 'Team A')],
        ];
    }

    /** 
     * @dataProvider DuplicatedItemProvider
     */
    function testStoringDuplicate($duplicatedItem): void
    {
        $this->expectException(DuplicateException::class);

        $repository = new MatchRepository();
        $match = new FootballMatch('Team A', 'Team B');
        $repository->store($match);
        $repository->store($duplicatedItem);
    }

    function testGettingMatch(): void
    {
        $repository = new MatchRepository();
        $match = (new FootballMatch('Team A', 'Team B'))->updateScore(1, 3);
        $repository->store($match);

        $items = $repository->getItems();
        $this->assertCount(1, $items, "expected collection with one entry");

        $footballMatch = $repository->getMatch($match);
        $this->assertSame(1, $footballMatch->getHomeScore());
        $this->assertSame(3, $footballMatch->getAwayScore());
        $this->assertSame('Team A', $footballMatch->getHomeTeam());
        $this->assertSame('Team B', $footballMatch->getAwayTeam());
    }

    function testGettingNonExistingMatch(): void
    {
        $repository = new MatchRepository();
        $items = $repository->getItems();
        $this->assertCount(0, $items, "expected collection with one entry");

        $this->expectException(NonFoundException::class);
        $repository->getMatch(new FootballMatch('Team A', 'Team B'));
    }

    function testRemovingMatch(): void
    {
        $repository = new MatchRepository();
        $match = new FootballMatch('Team A', 'Team B');
        $repository->store($match);

        $this->assertCount(1, $repository->getItems(), "expected collection with one entry");

        $repository->remove($match);
        $this->assertCount(0, $repository->getItems(), "expected empty collection");
    }

    /** 
     * Should not throw any error 
     */
    function testRemovingNonExistingMatch(): void
    {
        $repository = new MatchRepository();
        $match = new FootballMatch('Team A', 'Team B');

        $repository->remove($match);
        $this->assertCount(0, $repository->getItems(), "expected empty collection");
    }

    function testUpdatingMatch(): void
    {
        $repository = new MatchRepository();
        $match = new FootballMatch('Team A', 'Team B');
        $repository->store($match);

        $this->assertCount(1, $repository->getItems(), "expected collection with one entry");

        $repository->update($match->updateScore(1, 3));
        $this->assertCount(1, $repository->getItems(), "expected empty collection");

        $matchFound = $repository->getMatch($match);
        $this->assertSame(1, $matchFound->getHomeScore());
        $this->assertSame(3, $matchFound->getAwayScore());
    }

    function testUpdatingNonExistingMatch(): void
    {
        $this->expectException(NonFoundException::class);

        $repository = new MatchRepository();
        $match = new FootballMatch('Team A', 'Team B');

        $repository->update($match);
    }
}
