<?php

namespace App;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the users that belong to the project.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_project')->withTimestamps();
    }
    
    /**
     * Get the route key for the model.
     * 
     * @return string
     */
    public function getRouteKeyName()
    {
        return App::environment('local') ? 'id' : 'name';
    }

    /**
     * Get the environments for the project.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function environments()
    {
        return $this->hasMany(Environment::class);
    }
}
