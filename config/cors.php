<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Sesuaikan path API Anda

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'], 

    'allowed_headers' => ['*'],
    
    'supports_credentials' => true,
];

