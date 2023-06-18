<?php

namespace Sportradar\Scoreboard\Repository;

use Throwable;

class NonFoundException extends \Exception
{
    function __construct($message = "Item not found", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message);
    }
}
