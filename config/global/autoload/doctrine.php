<?php

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'proxy_dir' => realpath(__DIR__ . '/../../../data/doctrine/proxies'),
                'proxy_namespace' => 'Pondo\\Proxy',
                'metadata_cache' => 'redis',
                'query_cache' => 'redis',
                'result_cache' => 'array',
                'driver' => 'orm_default'
            ],
        ],

        'driver' => [
            'orm_default' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'paths' => [
                    realpath(__DIR__ . '/../../../module/Pondo/src/Domain/Entity')
                ],
                'cache' => 'redis'
            ],
        ],

        'event_manager' => [
            'orm_default' => [
                'subscribers' => [
                ]
            ]
        ],

        'entity_listeners' => [
        ],
    ],
];
