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

        $repository->expects($this->once())
            ->method('store');

        $service = new ScoreboardService($repository);
        $service->start($match);
    }

    function testUpdatingMatch()
    {
        /** @var MockObject|MatchRepository */
        $repository = $this->createMock(MatchRepository::class);
        $match = new FootballMatch('Team A', 'Team B');

        $repository->expects($this->once())
            ->method('update');

        $service = new ScoreboardService($repository);
        $service->update($match);
    }

    function testStoppingMatch()
    {
        /** @var MockObject|MatchRepository */
        $repository = $this->createMock(MatchRepository::class);
        $match = new FootballMatch('Team A', 'Team B');

        $repository->expects($this->once())
            ->method('remove');

        $service = new ScoreboardService($repository);
        $service->stop($match);
    }

    function testGettingSummary()
    {
        /** @var MockObject|MatchRepository */
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

        $this->assertSame('Uruguay 6 - Italy 6', (string)$summary[0]);
        $this->assertSame('Spain 10 - Brazil 2', (string)$summary[1]);
        $this->assertSame('Mexico 0 - Canada 5', (string)$summary[2]);
        $this->assertSame('Argentina 3 - Australia 1', (string)$summary[3]);
        $this->assertSame('Germany 2 - France 2', (string)$summary[4]);
    }
}
