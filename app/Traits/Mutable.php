<?php

namespace App\Traits;

trait Mutable
{
    /**
     * @var array
     */
    protected $mutations = [];

    /**
     * @var array
     */
    protected $create;

    /**
     * @var array
     */
    protected $attach;

    /**
     * @param  array  $mutations
     * @return void
     */
    protected function setMutation(array $mutations)
    {
        foreach($mutations as $key => $value) {
            $this->mutations[$key] = $value;
        }
    }

    /**
     * @param  array  $mutations
     * @return void
     */
    protected function castMutation(array $mutations)
    {
        $this->create = $mutations['create'] ?? [];

        $this->attach = $mutations['attach'] ?? [];
    }
}
