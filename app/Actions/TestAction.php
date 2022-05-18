<?php

namespace App\Actions;

use App\Contracts\ResourceContract;

class TestAction
{
    static $count = 0;

    function __construct()
    {
        $count = 1;
    }

    /**
     * @return int
     */
    public static function getCount(): int
    {
        return self::$count;
    }

}
