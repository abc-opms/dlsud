<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'administrator' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'Property' => [
            'users' => 'c,r,u,',
            'profile' => 'c,r,u'
        ],
        'Custodian' => [
            'users' => 'c,r,u,',
            'profile' => 'c,r,u'
        ],
        'Warehouse' => [
            'users' => 'c,r,u,',
            'profile' => 'c,r,u'
        ],
        'ICTC' => [
            'users' => 'c,r,u,',
            'profile' => 'c,r,u'
        ],
        'Finance' => [
            'users' => 'c,r,u,',
            'profile' => 'c,r,u'
        ],
        'BFMO' => [
            'users' => 'c,r,u,',
            'profile' => 'c,r,u'
        ],
        'ERMAC' => [
            'users' => 'c,r,u,',
            'profile' => 'c,r,u'
        ],
        'Museo' => [
            'users' => 'c,r,u,',
            'profile' => 'c,r,u'
        ]
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
