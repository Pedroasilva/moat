<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Mail\SendgridEmail;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'telephone',
        'document_type',
        'document',
        'role',
        'establishment',
        'status',
        'verified',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function isAdministrator() {
        $roles = UserRole::where('name', 'administrator')->first();
        return $roles->role_id == $this->role;
    }

    public function userRole() {
        return $this->hasOne(UserRole::class, 'role_id', 'role');
    }

    public function companyData()
    {
        return $this->belongsTo(Establishment::class, 'establishment');
    }

    public function clientsCreated() {
        return $this->hasMany(Client::class, 'created_by');
    }

    public function campaignsCreated() {
        return $this->hasMany(Campaign::class, 'created_by');
    }

    public function templatesCreated() {
        return $this->hasMany(Template::class, 'created_by');
    }

    public function logs() {
        return $this->hasMany(UserLog::class, 'user');
    }

    /**
     * Send an email to new Password Request
     *
     * @param object $user
     * @return void
     */
    public static function sendPasswordRequestEmail($req)
    {
        $to = array(
            'name' => $req['name'],
            'email' => $req['email']
        );

        $data = array(
            'name' => $req['name'],
            'email' => $req['email'],
            'token' => $req['token'],
            'appUrl' => env("WEB_APP_URL"),
            'apiUrl' => env("APP_URL")
        );

        $subject = "Alteração de senha no ".env("APP_NAME");

        $email = new SendgridEmail('password-request', $to, $subject, $data);
        $email->send();
    }
}
