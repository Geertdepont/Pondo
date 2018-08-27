<?php

return [
    'logs' => [
        'instances' => [
            'logger.error' => [
                'name' => 'error',
                'handlers' => [
                    'logger.handler.error'
                ]
            ],
            'logger.system' => [
                'name' => 'system',
                'handlers' => [
                    'logger.handler.system'
                ]
            ],
            'logger.jobs' => [
                'name' => 'jobs',
                'handlers' => [
                    'logger.handler.jobs'
                ]
            ]
        ],
        'handlers' => [
            'logger.handler.error' => [
                'file' => __DIR__ . '/../../../logs/error.log',
                'formatter' => 'formatter.error.multi_line'
            ],
            'logger.handler.system' => [
                'file' => __DIR__ . '/../../../logs/system.log'
            ],
            'logger.handler.jobs' => [
                'file' => __DIR__ . '/../../../logs/jobs.log'
            ]
        ],
        'formatters' => [
            'formatter.error.multi_line' => []
        ]
    ]
];
