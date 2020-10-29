<?php

return [
    '__name' => 'api-profile-login',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/api-profile-login.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'modules/api-profile-login' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'profile' => NULL
            ],
            [
                'profile-auth' => NULL
            ],
            [
                'lib-form' => NULL
            ],
            [
                'lib-app' => NULL
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'ApiProfileLogin\\Controller' => [
                'type' => 'file',
                'base' => 'modules/api-profile-login/controller'
            ]
        ],
        'files' => []
    ],
    'routes' => [
        'api' => [
            'apiProfileLogin' => [
                'path' => [
                    'value' => '/pme/login'
                ],
                'handler' => 'ApiProfileLogin\\Controller\\Auth::login',
                'method' => 'POST'
            ]
        ]
    ],
    'libForm' => [
        'forms' => [
            'api.profile.login' => [
                'name' => [
                    'label' => 'Name',
                    'type' => 'text',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'type' => 'password',
                    'rules' => [
                        'required' => TRUE,
                        'empty' => FALSE
                    ]
                ]
            ]
        ]
    ]
];