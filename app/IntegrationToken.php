<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntegrationToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'authenticity_token',
        'company'
    ];

    public function companyOwner()
    {
        return $this->belongsTo(Establishment::class, 'company');
    }


}
