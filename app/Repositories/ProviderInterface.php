<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;

interface ProviderInterface
{
    public function getQuery(): Builder|QueryBuilder|Relation;
}
