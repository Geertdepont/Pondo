<?php

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    'host'     => '192.168.110.10',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => 'test',
                    'dbname'   => 'pondo',
                ]
            ]
        ]
    ],
];
