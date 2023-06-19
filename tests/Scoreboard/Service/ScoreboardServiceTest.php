<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Sportradar\Scoreboard\Repository\MatchRepository;
use Sportradar\Scoreboard\Service\ScoreboardService;
use Sportradar\Scoreboard\Model\FootballMatch;

/**
 * Testing ScoreboardServiceTest
 */
final class ScoreboardServiceTest extends TestCase
{
    function testStartingMatch()
    {
        /** @var MockObject|MatchRepository */
        $repository = $this->createMock(MatchRepository::class);
        $match = new FootballMatch('Team A', 'Team B');

        $service = new ScoreboardService($repository);
        $service->start($match);

        $repository->expects($this->once())
            ->method('store');
    }

    function testUpdatingMatch()
    {
        $repository = $this->createMock(MatchRepository::class);
        $match = new FootballMatch('Team A', 'Team B');

        $service = new ScoreboardService($repository);
        $service->update($match);

        $repository->expects($this->once())
            ->method('update');
    }

    function testStoppingMatch()
    {
        $repository = $this->createMock(MatchRepository::class);
        $match = new FootballMatch('Team A', 'Team B');

        $service = new ScoreboardService($repository);
        $service->stop($match);

        $repository->expects($this->once())
            ->method('remove');
    }

    function testGettingSummary()
    {
        $repository = $this->createMock(MatchRepository::class);
        $match1 = new FootballMatch('Mexico', 'Canada');
        $match2 = new FootballMatch('Spain', 'Brasil');
        $match3 = new FootballMatch('Germany', 'France');
        $match4 = new FootballMatch('Uruguay', 'Italy');
        $match5 = new FootballMatch('Argentina', 'Australia');

        $repository->expects($this->once())
            ->method('getItems')
            ->willReturn([
                $match1->updateScore(0, 5),
                $match2->updateScore(10, 2),
                $match3->updateScore(2, 2),
                $match4->updateScore(6, 6),
                $match5->updateScore(3, 1),
            ]);

        $service = new ScoreboardService($repository);
        $summary = $service->getSummary();

        $this->assertSame('Uruguay 6 - Italy 6', $summary[0]);
        $this->assertSame('Spain 10 - Brazil 2', $summary[1]);
        $this->assertSame('Mexico 0 - Canada 5', $summary[2]);
        $this->assertSame('Argentina 3 - Australia 1', $summary[3]);
        $this->assertSame('Germany 2 - France 2', $summary[4]);
    }
}
