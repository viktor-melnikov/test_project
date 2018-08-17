<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'patronymic',
        'account_number',
        'balance',
        'inn_id'
    ];

    protected $casts = [
        'balance' => 'float'
    ];

    public function inn()
    {
        return $this->belongsTo(Inn::class);
    }

}
