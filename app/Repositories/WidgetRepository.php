<?php

namespace App\Repositories;

use App\Models\Widget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;

class WidgetRepository implements ProviderInterface
{
    public function getQuery(): Builder|QueryBuilder|Relation
    {
        return Widget::select([
            'widgets.size',
        ]);
    }
}
