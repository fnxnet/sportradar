<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Sportradar\Scoreboard\Model\FootballMatch;

/**
 * Testing FootballMatch
 */
final class FootballMatchTest extends TestCase
{

    function testInitiatingFootballMatch(): void
    {
        $footballMatch = new FootballMatch("Team A", "Team B");

        $this->assertSame("Team A", $footballMatch->getHomeTeam());
        $this->assertSame("Team B", $footballMatch->getAwayTeam());
        $this->assertSame(0, $footballMatch->getHomeScore());
        $this->assertSame(0, $footballMatch->getAwayScore());
        $this->assertSame(0, $footballMatch->getTotalScore());
        $this->assertSame('Team A 0 - Team B 0', (string) $footballMatch);
    }

    function invalidTeamNamesProvider()
    {
        return [
            ['Away team can not be the same as home one', 'Team A', 'Team A'],
            ['Team name can not be empty', 'Team A', ''],
            ['Team name can not be empty', '', 'Team A'],
        ];
    }

    /**
     * @dataProvider invalidTeamNamesProvider
     */
    function testInitiatingFootballMatchWithInvalidData($message, $homeTeam, $awayTeam): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage($message);
        $footballMatch = new FootballMatch($homeTeam, $awayTeam);
    }

    function testUpdatingScoreWithValidData(): void
    {
        $footballMatch = new FootballMatch("Team A", "Team B");
        $updatedMatch = $footballMatch->updateScore(1, 3);

        // make sure original match is immutable
        $this->assertSame(0, $footballMatch->getHomeScore());
        $this->assertSame(0, $footballMatch->getAwayScore());

        // checking cloned object
        $this->assertSame(1, $updatedMatch->getHomeScore());
        $this->assertSame(3, $updatedMatch->getAwayScore());
        $this->assertSame(4, $updatedMatch->getTotalScore());
        $this->assertSame("Team A", $updatedMatch->getHomeTeam());
        $this->assertSame("Team B", $updatedMatch->getAwayTeam());
        $this->assertSame('Team A 1 - Team B 3', (string) $updatedMatch);
    }

    public function InvalidScoreDataProvider()
    {
        return [
            [\RuntimeException::class, -1, 3],
            [\RuntimeException::class, 3, -3],
            [\TypeError::class, null, null],
            [\TypeError::class, 'A', 'B'],
        ];
    }

    /**
     * @dataProvider InvalidScoreDataProvider
     */
    function testUpdatingScoreWithInvalidData($exceptionType, $homeScore, $awayScore): void
    {
        $this->expectException($exceptionType);

        $footballMatch = new FootballMatch("Team A", "Team B");

        $updatedMatch = $footballMatch->updateScore($homeScore, $awayScore);
    }
}
