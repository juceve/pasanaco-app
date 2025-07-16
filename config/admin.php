<?php
return [
    // PARAMTROS DE LA APP
    'app' => [
        'name' => 'DevAPP',
        'logo' => '/images/logo.png',
        'favicon' => '/images/logo.png',
    ],


    // ENLACES PARA EL SIDEBAR DE LA APP
    'links' => [
        [
            'name' => 'Dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'route' => 'dashboard',
        ],
        [
            'header' => 'Administración',
        ],
        [
            'name' => 'Participantes',
            'icon' => 'fas fa-user-friends',
            'route' => 'participants',
        ],
        [
            'name' => 'Grupos',
            'icon' => 'fas fa-users',
            'route' => 'groups',
        ],
        // [
        //     'name' => 'Otros',
        //     'icon' => 'fas fa-user',
        //     'submenu' => [
        //         [
        //             'name' => 'Settings',
        //             'icon' => 'fas fa-user',
        //             'route' => 'profile.show',
        //             // 'can' => 'edit profile',
        //         ],
        //     ],
        // ],
    ]
];
