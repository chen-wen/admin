<?php

return [
	'name'=>'首页',
	'index'=>'welcome',
	'groups' => [
		'Dashboard'=>[
			'welcome',
			'home',
		]
	],
	'namespaces' => ['guard.auth', 'web', 'guard.throttle', 'guard.log'],
	'routes' => [
		'welcome'=>[
            'name'    =>'Welcome',
            'uri'     =>'/',  
            'method'  =>'get',
            'uses'    =>'HomeController@welcome',
            'limit-on'=>true,// 权限开关，值为false 则登陆后不限制该功能,默认为 true
            'throttle'=>100, // 限制单用户最大访问次数，
            'log.file'=> '【{{user.name}}】访问了操作 Welcome',
        ],
        'home' => [
            'name'    => 'Home',
            'uri'     => '/home',  
            'method'  => 'get',
            'uses'    => 'HomeController@home',
            'log.file'=> '【{{user.name}}】访问了操作日志页',
        ],
	]
];