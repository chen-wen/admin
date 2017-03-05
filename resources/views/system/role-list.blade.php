@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">创建角色</div>

    <div class="panel-body">
        <form class="form-inline" method="post" action="{{route('system.role.store')}}">
            <button type="submit" class="btn btn-default pull-right">创建</button>
            <div class="form-group">
                <label>名称</label>
                {!! csrf_field() !!}
                <input type="text" class="form-control" name="name" placeholder="Jane Doe" value="">
            </div>
        </form>
    </div>
</div>






<div class="panel panel-default">
    <div class="panel-heading text-right">
        <span>
            每页
            <span class="label label-pagesize label-{{$params['pageSize']==10?'default':'primary'}}" 
            data-size="{{$params['pageSize']}}">10</span>
            <span class="label label-pagesize label-{{$params['pageSize']==20?'default':'primary'}}" 
            data-size="{{$params['pageSize']}}">20</span>
            <span class="label label-pagesize label-{{$params['pageSize']==50?'default':'primary'}}" 
            data-size="{{$params['pageSize']}}">50</span>
            <span class="label label-pagesize  label-{{$params['pageSize']==100?'default':'primary'}}" 
            data-size="{{$params['pageSize']}}">100</span>
            条
        </span>
    </div>
    <table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>角色名称</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
        @foreach($result as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->name}}</td>
            <td>
                <a href="{{route('system.role.show',[$item->id])}}">查看权限</a>
                <a href="{{route('system.role.users',[$item->id])}}">查看用户</a>
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>
    <div class="panel-footer">
        {!!$result->render()!!}
    </div>
</div>

<script>
$(function(){
    $('.label-pagesize').click(function(){

    });
});
</script>
@endsection

