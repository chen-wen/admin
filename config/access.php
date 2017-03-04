<?php 

return [
    'logger' => [
        // 'handle' => 'access.handle', 
        // 上述需用 类似以下形式将处理器绑定到 app 容器上
        // app()->instance('access.handle', function($router, $key, $log){
        //    logger("$router $key $log");
        // })
        'handle' => function($router, $key, $log){
            logger("$router $key $log");
        }
    ],
    'throttle' => [
        'total' => 800,
        'decay' => 60 * 24,
        'message' => '您的访问已超过最大限制！',
        'trigger' => 'throttle.handle',
    ]
];