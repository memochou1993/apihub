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
     * 
     *
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
     * 
     * 
     * @param  array  $query
     * @return void
     */
    protected function castQuery(array $query)
    {
        $where = $query['where'] ?? [];

        $this->where = $where;

        $with = explode(',', $query['with'] ?? '');

        $this->with = $with[0] ? $with : [];
    }
}
