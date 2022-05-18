<?php

namespace App\Contracts;

interface ResourceContract {
    public function __invoke(): string;
}
