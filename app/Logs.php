<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logs';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the user that the comment belongs to.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
