<?php

namespace App\Traits;

trait Queryable
{
    /**
     * @var array
     */
    protected $queries = [];

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
            $this->queries[$key] = $value;
        }
    }

    /**
     * @param  array  $queries
     * @return void
     */
    protected function castQuery(array $queries)
    {
        $this->where = $queries['where'] ?? [];

        $this->with = $queries['with'] ? explode(',', $queries['with'] ?? '') : [];

        $this->paginate = $queries['paginate'] ?? 0;
    }
}
