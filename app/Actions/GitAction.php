<?php

namespace App\Actions;

use App\Contracts\ResourceContract;

class GitAction implements ResourceContract
{
    public function __invoke(): string {
        return "i am git action";
    }
}
