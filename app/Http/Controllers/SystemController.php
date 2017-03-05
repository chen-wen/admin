<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Wayne\Guard\NamesConfigHelper;

class SystemController extends Controller
{
    public function getUserInfo()
    {
        $user = Auth::user();
        return [
            'code' => 0,
            'data' => [
                'id'    => $user->id,
                'email' => $user->email,
                'name'  => $user->name,
                'role'  => $user->roles->implode('name'),
            ],
        ];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserList(Request $request)
    {
        $model   = new User;
        $handles = $model->getSearchHandles();
        $params  = $request->all();
        $query   = $model->search($params, $handles);
        $params  = $model->params($params, $handles);
        $result  = $query->with('roles')
            ->paginate($params['pageSize'] ?: 20)
            ->appends($params);

        $this->data['result'] = $result;
        $this->data['params'] = $params;
        return view('system.user-list', $this->data);
    }

    public function getUserDetail(Request $request, $id)
    {
        $model                     = User::find($id);
        $this->data['model']       = $model;
        $this->data['self']        = $model->getSelfPermissions();
        $this->data['merged']      = $model->getMergedPermissions();
        $this->data['permissions'] = NamesConfigHelper::getConfig();
        $this->data['typeColor']   = ['red', 'green'];

        $this->data['roles']  = Role::all();
        $this->data['rids']    = $model->roles->pluck('id');
        $this->data['isSuper'] = $model->isSuper();
        return view('system.user-detail', $this->data);
    }

    public function saveUser(Request $request, $id)
    {
        $model = User::find($id);
        app()->instance('model', $model);
        if ($request->get('action') == 'group') {
            $model->roles()->detach();
            $model->roles()->attach($request->get('gids'));
            $model->save();
            return redirect()->back();
        }

        $permissions     = $request->get('permissions') ?: [];
        $groupPermission = $model->getRolePermissions() ?: [];
        $diff1           = array_diff_key($permissions, $groupPermission);
        $diff0           = array_diff_key($groupPermission, $permissions);
        $diff0           = array_map(function ($item) use ($groupPermission) {
            return $item = 0;
        }, $diff0);
        unset($diff0['super']);
        
        $model->permissions = array_merge($diff0, $diff1);
        $model->save();

        return redirect()->back()->with('success', '保存成功');
    }

    public function getRoleList(Request $request)
    {
        $model   = new Role;
        $handles = $model->getSearchHandles();
        $params  = $request->all();
        $query   = $model->search($params, $handles);
        $params  = $model->params($params, $handles);
        $query->where('name', '!=', 'super');
        $result = $query->paginate($params['pageSize'] ?: 20)
            ->appends($params);
        $this->data['result'] = $result;
        $this->data['params'] = $params;
        return view('system.role-list', $this->data);
    }

    public function getRoleDetail(Request $request, $id)
    {
        $model                     = Role::find($id);
        $this->data['model']       = $model;
        $this->data['self']        = $model->permissions;
        $this->data['permissions'] = NamesConfigHelper::getConfig();
        $this->data['isSuper']     = isset($this->data['self']['super']);
        return view('system.role-detail', $this->data);
    }

    public function saveRole(Request $request, $id)
    {
        $model       = Role::find($id);
        $permissions = $request->get('permissions');
        $name        = $request->get('name');

        $model->name        = $name;
        $model->permissions = $permissions;
        $model->save();
        // $model->update($request->only('name', 'permissions'));
        return redirect()->back()->with('success', '保存成功');
    }

    public function storeRole(Request $request)
    {
        if (!$request->get('name')) {
            return redirect()->back()->with('error', ' 角色名称不能为空');
        }
        $model = Role::create(['name' => $request->get('name')]);
        return redirect()->route('system.role.show', [$model->id])
            ->with('success', '角色创建成功');
    }

    public function getUserPermissions()
    {
        $nodes = config('permissions.home');
        $user  = Auth::user();
        $menus = [];
        foreach ($nodes['roles'] as $key => $group) {
            $menus[$key] = [
                'id'   => $key,
                'name' => $group,
            ];
            foreach ($nodes['routes'] as $r => $route) {
                if ($key == $route['group']) {
                    $cur = [
                        'id'    => $r,
                        'name'  => $route['name'],
                        'group' => $route['group'],
                        'type'  => $route['type'],
                    ];
                    if (isset($route['refer'])) {
                        $cur['refer'] = $route['refer'];
                    }
                    if ($route['type'] != 'function') {
                        $cur['path'] = $route['uri'];
                    }

                    $menus[$key]['menu'][$r] = $cur;
                }
            }
        }
        if (!$user->isSuper()) {
            $permissions = $user->getMergedPermission();
            // collect($permissions)->where();
            foreach ($menus as &$group) {
                $group['menu'] = array_intersect_key($group['menu'], $permissions);
            }
        }

        foreach ($menus as &$group) {
            $group['menu'] = array_values($group['menu']);
        }

        return collect($menus)->filter(function ($item) {
            return !empty($item['menu']);
        })->values();
    }
}
