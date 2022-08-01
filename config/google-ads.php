<?php
return [
    //Environment=> test/production
    'env' => 'test',
    //Google Ads
    'production' => [
        'developerToken' => env("GOOGLE_TOKEN"),
        'clientCustomerId' => env("GOOGLE_CUSTOMER_ID"),
        'userAgent' => env("GOOGLE_USER_AGENT"),
        'clientId' => env("GOOGLE_CLIENT_ID"),
        'clientSecret' => env("GOOGLE_CLIENT_SECRET"),
        'refreshToken' => "REFRESH-TOKEN"
    ],
    'test' => [
        'developerToken' => env("GOOGLE_TOKEN"),
        'clientCustomerId' => env("GOOGLE_CUSTOMER_ID"),
        'userAgent' => env("GOOGLE_USER_AGENT"),
        'clientId' => env("GOOGLE_CLIENT_ID"),
        'clientSecret' => env("GOOGLE_CLIENT_SECRET"),
        'refreshToken' => "REFRESH-TOKEN"
    ],
    'oAuth2' => [
        'authorizationUri' => 'https://accounts.google.com/o/oauth2/v2/auth',
        'redirectUri' => env("GOOGLE_REDIRECT_URI"),
        'tokenCredentialUri' => 'https://www.googleapis.com/oauth2/v4/token',
        'scope' => 'https://www.googleapis.com/auth/adwords'
    ]
];