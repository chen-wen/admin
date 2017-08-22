<?php

return [
    'name'       => '系统管理',
    'index'      => 'system.user.index', // 导航页链接地址，routes 节点的键名
    'prefix'     => '', // 路由前缀
    'namespace'  => 'App\Http\Controllers',
    'middleware' => [
        'web', 'guard.auth', 'guard.permission',
        'guard.throttle', 'guard.logger',
    ],
    'groups'     => [
        '权限管理' => [
            'system.user.index',
            'system.role.index',
        ],
    ],
    'routes'     => [

        // 权限管理
        'system.user.index' => [
            'uri'    => 'user/index',
            'uses'   => 'SystemController@getUserList',
            'method' => 'get',
            'name'   => '用户管理',
            'group'  => '70',
            'type'   => 'menu',
        ],
        'system.user.show'  => [
            'uri'    => 'user/{id}',
            'uses'   => 'SystemController@getUserDetail',
            'method' => 'get',
            'name'   => '用户权限详情',
            'group'  => '70',
            'type'   => 'page',
            'refer'  => 'system.user.index', // 非菜单页的从哪个菜单页过来的key
        ],
        'system.user.save'  => [
            'uri'    => 'user/{id}',
            'uses'   => 'SystemController@saveUser',
            'method' => 'put',
            'name'   => '保存用户权限',
            'group'  => '70',
            'type'   => 'page',
            'refer'  => 'system.user.index', // 非菜单页的从哪个菜单页过来的key
            'log.file' => '【{{user.name}}】保存了【{{model.name}}】的权限',
        ],
        'system.role.index' => [
            'uri'    => 'role/index',
            'uses'   => 'SystemController@getRoleList',
            'method' => 'get',
            'name'   => '角色管理',
            'group'  => '70',
            'type'   => 'menu',
        ],
        'system.role.show'  => [
            'uri'    => 'role/{id}',
            'uses'   => 'SystemController@getRoleDetail',
            'method' => 'get',
            'name'   => '角色权限详情',
            'group'  => '70',
            'type'   => 'page',
            'refer'  => 'system.role.index', // 非菜单页的从哪个菜单页过来的key
        ],
        'system.role.users' => [
            'uri'    => 'role/{id}/users',
            'uses'   => 'SystemController@getRoleUsers',
            'method' => 'get',
            'name'   => '角色用户列表',
            'group'  => '70',
            'type'   => 'page',
            'refer'  => 'system.role.index', // 非菜单页的从哪个菜单页过来的key
        ],
        'system.role.save'  => [
            'uri'    => 'role/{id}',
            'uses'   => 'SystemController@saveRole',
            'method' => 'put',
            'name'   => '保存角色权限',
            'group'  => '70',
            'type'   => 'page',
            'refer'  => 'system.role.index', // 非菜单页的从哪个菜单页过来的key
        ],
        'system.role.store' => [
            'uri'    => 'role',
            'uses'   => 'SystemController@storeRole',
            'method' => 'post',
            'name'   => '创建角色',
            'group'  => '70',
            'type'   => 'page',
            'refer'  => 'system.role.index', // 非菜单页的从哪个菜单页过来的key
        ],
    ],
];
