<?php

namespace App\Actions;

use App\Contracts\ResourceContract;

class ResourceAction implements ResourceContract
{
    public function __invoke(): string
    {
        return "i am resource action";
    }
}
