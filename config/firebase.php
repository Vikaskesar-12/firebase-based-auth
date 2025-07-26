<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Firebase Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials and project ID for Firestore
    | Make sure the 'firebase_credentials.json' file exists in storage folder.
    |
    */

    'project_id' => env('FIREBASE_PROJECT_ID'),

    'keyFilePath' => base_path('storage/firebase_credentials.json'), // ✅ ensure this file exists

];
