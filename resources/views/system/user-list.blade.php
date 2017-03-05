@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">用户筛选</div>

    <div class="panel-body">
        <form class="form-inline">
            <button type="submit" class="btn btn-default pull-right">搜索</button>
            <div class="form-group">
                <label>姓名</label>
                <input type="text" class="form-control" name="name" placeholder="Jane Doe" value="{{$params['name']}}">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" name="email" placeholder="jane.doe@example.com" value="{{$params['email']}}">
            </div>
        </form>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading text-right">
        <span>
            每页
            <span class="label label-{{$params['pageSize']==10?'default':'primary'}}">10</span>
            <span class="label label-{{$params['pageSize']==20?'default':'primary'}}">20</span>
            <span class="label label-{{$params['pageSize']==50?'default':'primary'}}">50</span>
            <span class="label label-{{$params['pageSize']==100?'default':'primary'}}">100</span>
            条
        </span>
    </div>
    <table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>姓名</th>
        <th>邮箱</th>
        <th>最后登录</th>
        <th>拥有角色</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
        @foreach($result as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->email}}</td>
            <td>{{$item->last_login}}</td>
            <td>{{$item->roles->implode('name')}}</td>
            <td><a href="{{route('system.user.show',[$item->id])}}">查看</a></td>
        </tr>
        @endforeach
    </tbody>
    </table>
    <div class="panel-footer">
        {!!$result->render()!!}
    </div>
</div>
@endsection
