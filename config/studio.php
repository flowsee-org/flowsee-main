<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Studio Superadmin Email
    |--------------------------------------------------------------------------
    |
    | The email address of the primary Studio superadmin. Studio management
    | endpoints only accept a session whose verified identity matches this
    | address. It is read from the environment so no address is hard-coded.
    |
    */

    'admin_email' => env('STUDIO_ADMIN_EMAIL', 'ceo@flowsee.local'),

    /*
    |--------------------------------------------------------------------------
    | Studio Base URL
    |--------------------------------------------------------------------------
    |
    | Base URL of the Studio application. Used to resolve the current Studio
    | session server-side. Override per environment (local, staging,
    | production) instead of editing the controllers.
    |
    */

    'base_url' => env('STUDIO_BASE_URL', 'https://studio.flowsee.ir'),

];
