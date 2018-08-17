<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inn extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inn',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
