<?php

namespace App\Services;

use App\Repositories\ProviderInterface;

interface WidgetServiceInterface
{
    public function execute(int $quantity): array;
}