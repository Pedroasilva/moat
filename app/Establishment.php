<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mail\SendgridEmail;

class Establishment extends Model
{

    protected $primaryKey = 'establishment_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phonenumber',
        'picture',
        'email',
        'site_url',
        'city',
        'state',
        'country',
        'slug'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the users of this establishment.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'establishment');
    }

    /**
     * Get the clients of this establishment.
     */
    public function clients()
    {
        return $this->hasMany(Client::class, 'establishment');
    }

    /**
     * Get the campaigns of this establishment.
     */
    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'establishment');
    }

    /**
     * Get the templates of this establishment.
     */
    public function templates()
    {
        return $this->hasMany(Template::class, 'establishment');
    }

    /**
     * Get the exports of this establishment.
     */
    public function exports()
    {
        return $this->hasMany(Export::class, 'establishment');
    }

    /**
     * Send an email to new Signup Request
     *
     * @param object $user
     * @return void
     */
    public static function sendNewSignupEmail($data)
    {
        $to = array(
            'name' => $data['name'],
            'email' => $data['email']
        );
        
        $data['appUrl'] = env("WEB_APP_URL");
        $data['apiUrl'] = env("APP_URL");

        $subject = $data['name']." quer se cadastrar no ".env("APP_NAME");

        $email = new SendgridEmail('new-signup', $to, $subject, $data);
        $email->send();
    }

    /**
     * Get the Google integration refresh token
     */
    public function googleAdsIntegration() {
        return $this->hasOne(GoogleAdsIntegration::class, 'company', 'establishment_id');
    }
}
