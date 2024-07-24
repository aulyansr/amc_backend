<?php

return
[
	'views_style_directory'=> 'saas-theme',
	'separate_style_according_to_actions' =>
    [
        'index'=>
        [
            'extends'=>'layouts.admin',
            'section'=>'content'
        ],
        'create'=>
        [
            'extends'=>'layouts.admin',
            'section'=>'content'
        ],
        'edit'=>
        [
            'extends'=>'layouts.admin',
            'section'=>'content'
        ],
        'show'=>
        [
            'extends'=>'layouts.admin',
            'section'=>'content'
        ],
    ],
    'paths' =>
    [
        'service' =>
        [
            'path' => app_path('Services'),
            'namespace' => 'App\Services'
        ]
    ]

];
