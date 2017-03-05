<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Wayne\Guard\NamesConfigHelper;

class User extends Authenticatable
{
    protected $table = 'system_users';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getSelfNav()
    {
        $menus = NamesConfigHelper::getConfig();
        $navs  = [];
        foreach ($menus as $key => $node) {
            $navs[$node['index']] = $node['name'];
        }
        return $navs;
    }

    public function getCurrentMenu()
    {
        // app('route')->current();
        $name  = app('router')->currentRouteName();
        $menus = NamesConfigHelper::getConfig();
        foreach ($menus as $key => $group) {
            if (isset($group['routes'][$name])) {
                return $group;
            }
        }
        return [];
    }

    public function getCurrentNav()
    {
        $name  = app('router')->currentRouteName();
        $menus = NamesConfigHelper::getConfig();
        foreach ($menus as $key => $group) {
            if (isset($group['routes'][$name])) {
                return $group['index'];
            }
        }
    }

    public function currentMenuName()
    {
        $name  = app('router')->currentRouteName();
        $menus = NamesConfigHelper::getConfig();
        foreach ($menus as $key => $group) {
            if (isset($group['routes'][$name])) {
                if ($group['routes'][$name]['type'] == 'menu') {
                    return $name;
                } else {
                    return @$group['routes'][$name]['refer'];
                }
            }
        }
        return '';
    }
}
