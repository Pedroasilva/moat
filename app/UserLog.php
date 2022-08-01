<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'establishment',
        'user',
        'log'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the establishment
     */
    public function establishmentOwner()
    {
        return $this->belongsTo(Establishment::class, 'establishment');
    }

    /**
     * Get the user
     */
    public function userOwner()
    {
        return $this->belongsTo(User::class, 'user');
    }
}