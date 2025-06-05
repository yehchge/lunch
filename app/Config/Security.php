<?php

return [
    'csrf' => [
        'token_name' => 'csrf_token',
        'expire' => 7200, // 2 小時
        'methods' => ['POST', 'PUT', 'DELETE']
    ]
];
