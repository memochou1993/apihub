<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'private',
    ];

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
     * Get the environments for the project.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function environments()
    {
        return $this->hasMany(Environment::class);
    }

    /**
     * Get the endpoints for the project.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function endpoints()
    {
        return $this->hasMany(Endpoint::class);
    }
}
