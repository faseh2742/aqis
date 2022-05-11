<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Passport password grant ID and Secret
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    'loginEndpoint' => env('PASSPORT_LOGIN_EDNPOINT', 'http://localhost/aqis/public/oauth/token'),
    'id' => env('PASSPORT_CLIENT_ID', '2'),
    'secret' => env('PASSPORT_CLIENT_SECRET', 'g1KeG4K6kf0jASASQgglzfkzJNhMsaZKBSLi8CVv'),

];
