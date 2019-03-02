<?php

namespace App\Traits;

trait Queryable
{
    /**
     * @var array
     */
    protected $query = [];

    /**
     * @var array
     */
    protected $with;

    /**
     * @var array
     */
    protected $where;

    /**
     * @var int
     */
    protected $paginate;

    /**
     * @param  array  $queries
     * @return void
     */
    protected function setQuery(array $queries)
    {
        foreach($queries as $key => $value) {
            $this->query[$key] = $value;
        }
    }

    /**
     * @param  array  $query
     * @return void
     */
    protected function castQuery(array $query)
    {
        $this->where = $query['where'] ?? [];

        $this->with = $query['with'] ? explode(',', $query['with'] ?? '') : [];

        $this->paginate = $query['paginate'] ?? 0;
    }
}