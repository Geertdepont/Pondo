<?php

header($_SERVER['SERVER_PROTOCOL'] . ' 503 Service Temporarily Unavailable');
header('Retry-After: 300'); // let the client try again after 5 minutes, in the future we should do this dynamically
header('Content-Type: application/json');

echo json_encode([
    'errors' => [
        'System down for maintenance'
    ]
]);
