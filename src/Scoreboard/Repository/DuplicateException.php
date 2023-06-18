<?php

namespace Sportradar\Scoreboard\Repository;

use Throwable;

class DuplicateException extends \Exception
{
    function __construct($message = "Item duplicated", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message);
    }
}
