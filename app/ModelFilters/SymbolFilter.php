<?php

namespace App\ModelFilters;

class SymbolFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function search($query)
    {
        return $this->orWhere('title', 'LIKE', '%' . $query . '%')
            ->orWhere('symbol', 'LIKE', '%' . $query . '%')
            ->orWhere('coingecko_id', 'LIKE', '%' . $query . '%');
    }
}
