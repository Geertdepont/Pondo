<?php

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'result_cache' => 'array',
                'auto_generate_proxy_classes' => \Doctrine\ORM\Proxy\ProxyFactory::AUTOGENERATE_EVAL
            ],
        ],

        'driver' => [
            'orm_default' => [
                'cache' => 'array'
            ]
        ]
    ],
];
