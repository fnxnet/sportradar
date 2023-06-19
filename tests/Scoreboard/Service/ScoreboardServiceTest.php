<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Sportradar\Scoreboard\Repository\MatchRepository;
use Sportradar\Scoreboard\Service\ScoreboardService;
use Sportradar\Scoreboard\Model\MatchInterface;

/**
 * Testing ScoreboardServiceTest
 */
final class ScoreboardServiceTest extends TestCase
{
    function testStartingMatch()
    {
        /** @var MockObject|MatchRepository */
        $repository = $this->createMock(MatchRepository::class);

        /** @var MockObject|MatchInterface */
        $match = $this->createMock(MatchInterface::class);

        $repository->expects($this->once())
            ->method('store');

        $service = new ScoreboardService($repository);
        $service->start($match);
    }

    function testUpdatingMatch()
    {
        /** @var MockObject|MatchRepository */
        $repository = $this->createMock(MatchRepository::class);

        /** @var MockObject|MatchInterface */
        $match = $this->createMock(MatchInterface::class);

        $repository->expects($this->once())
            ->method('update');

        $service = new ScoreboardService($repository);
        $service->update($match);
    }

    function testStoppingMatch()
    {
        /** @var MockObject|MatchRepository */
        $repository = $this->createMock(MatchRepository::class);

        /** @var MockObject|MatchInterface */
        $match = $this->createMock(MatchInterface::class);


        $repository->expects($this->once())
            ->method('remove');

        $service = new ScoreboardService($repository);
        $service->stop($match);
    }

    function testGettingSummary()
    {
        /** @var MockObject|MatchRepository */
        $repository = $this->createMock(MatchRepository::class);

        /** @var MockObject|MatchInterface */
        $match1 = $this->createMock(MatchInterface::class);
        $match1->expects($this->any())
            ->method('__toString')
            ->willReturn('Mexico 0 - Canada 5');
        $match1->expects($this->any())
            ->method('getTotalScore')
            ->willReturn(5);

        /** @var MockObject|MatchInterface */
        $match2 = $this->createMock(MatchInterface::class);
        $match2->expects($this->any())
            ->method('__toString')
            ->willReturn('Spain 10 - Brazil 2');
        $match2->expects($this->any())
            ->method('getTotalScore')
            ->willReturn(12);

        /** @var MockObject|MatchInterface */
        $match3 = $this->createMock(MatchInterface::class);
        $match3->expects($this->any())
            ->method('__toString')
            ->willReturn('Germany 2 - France 2');
        $match3->expects($this->any())
            ->method('getTotalScore')
            ->willReturn(4);

        /** @var MockObject|MatchInterface */
        $match4 = $this->createMock(MatchInterface::class);
        $match4->expects($this->any())
            ->method('__toString')
            ->willReturn('Uruguay 6 - Italy 6');
        $match4->expects($this->any())
            ->method('getTotalScore')
            ->willReturn(12);

        /** @var MockObject|MatchInterface */
        $match5 = $this->createMock(MatchInterface::class);
        $match5->expects($this->any())
            ->method('__toString')
            ->willReturn('Argentina 3 - Australia 1');
        $match5->expects($this->any())
            ->method('getTotalScore')
            ->willReturn(4);

        $repository->expects($this->once())
            ->method('getItems')
            ->willReturn([
                $match1,
                $match2,
                $match3,
                $match4,
                $match5
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
