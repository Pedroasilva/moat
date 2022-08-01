<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user',
        'authenticity_token',
        'expire',
        'done'
    ];

    protected $hidden = [
        'done'
    ];

    public static function verifyPendingByUser($user)
    {
        $passwordRequest = new PasswordRequest();
        // $exists = $passwordRequest->where('user', $user)->where('done', 0)->latest()->first();
        $query = $passwordRequest->where('user', $user)->where('done', 0);
        $exists = $query->exists();
        $item = $query->latest()->first();
        return ($exists) ? $item : false;
    }

    public static function verifyPendingByToken($token)
    {
        $passwordRequest = new PasswordRequest();
        $exists = $passwordRequest->where('authenticity_token', $token)->where('done', 0)->first();
        return ($exists) ? $exists : false;
    }

    public static function createOrUpdate($body)
    {
        $passwordRequest = new PasswordRequest();
        $pending = $passwordRequest->verifyPendingByUser($body['user']);
        if ($pending)
        {
            $pending->update([
                'authenticity_token' => $body['authenticity_token'],
                'expire' => $body['expire']
            ]);
        }
            else
        {
            $pending = $passwordRequest->create($body);
        }
        return $pending;
    }

    public static function getIfIsValid($token)
    {
        $valid = false;
        $passwordRequest = new PasswordRequest();
        $pending = $passwordRequest->verifyPendingByToken($token);
        if ($pending)
        {
            $now = new \DateTime(date("Y-m-d H:i:s"));
            $expire = new \DateTime($pending->expire);
            if ($expire >= $now) {
                $valid = true;
            }
        }
        return ($valid === true) ? $pending : false;
    }

    public function user_data()
    {
        return $this->belongsTo('App\User', 'user');
    }
}
