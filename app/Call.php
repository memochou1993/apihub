<?php

namespace App;

use App\Endpoint;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request', 'response',
    ];

    /**
     * Determine if the model should be searchable.
     *
     * @return bool
     */
    public function shouldBeSearchable()
    {
        return false;
    }

    /**
     * Get the endpoint that the call belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function endpoint()
    {
        return $this->belongsTo(Endpoint::class);
    }
}
