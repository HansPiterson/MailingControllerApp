<?php
// ... (params)
return [
    // ...
    'components' => [
        // ...
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                'POST api/auth/login' => 'auth/login',
                'POST api/auth/refresh' => 'auth/refresh',
                'POST api/surat/<uuid>/upload-bukti' => 'foto/upload-bukti',
                'POST api/sync/download' => 'sync/download',
                'POST api/sync/upload' => 'sync/upload', // Tambahkan ini
                'GET api/divisi' => 'divisi/index',
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'surat',
                    'prefix' => 'api',
                ],
            ],
        ],
    ],
];
