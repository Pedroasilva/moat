<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{

    protected $primaryKey = 'contact_message_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'name',
        'email',
        'message'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}