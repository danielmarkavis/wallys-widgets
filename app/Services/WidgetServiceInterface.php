<?php

namespace App\Services;

use App\Repositories\ProviderInterface;

interface WidgetServiceInterface
{
    public function execute(int $quantity, bool $optimize = true): array;
}