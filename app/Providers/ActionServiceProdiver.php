<?php

namespace App\Providers;

use App\Actions\GitAction;
use App\Actions\ResourceAction;
use App\Contracts\ResourceContract;
use Illuminate\Support\ServiceProvider;

class ActionServiceProdiver extends ServiceProvider
{
    public array $bindings = [
        ResourceContract::class => ResourceAction::class,
    ];
}
