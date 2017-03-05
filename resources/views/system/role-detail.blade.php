@extends('layouts.app')

@section('content')
<form class="form-inline" method="post" action="{{route('system.role.save',[$model->id])}}">
  @if(session('error'))
    <div class="alert alert-danger" role="alert">{{session('error')}}</div>
  @endif
  @if(session('success'))
    <div class="alert alert-success" role="alert">{{session('success')}}</div>
  @endif
  <div class="form-group">
    <label for="">角色名称</label>
    <input name="_method" type="hidden" value="put" />
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input name="id" type="hidden" value="{{ $model->id }}" />
    <input type="text" class="form-control" name="name" value="{{$model->name}}">
  </div>

  @foreach($permissions as $group)
    <div class="panel panel-default">
      <div class="panel-heading">{{$group['name']}}</div>
      <div class="panel-body">
        <ul style="list-style-type:none;padding-left:1em;">
        @foreach($group['routes'] as $key=>$menu)
            @if(!isset($menu['refer']))
            <li class="item">
                <input type="checkbox" name="permissions[{{$key}}]" id="{{$key}}" value="1"
                    {{isset($self[$key])||$isSuper?'checked':''}}>
                <label for="{{$key}}">{{ $menu['name'] }}</label>
            </li>
            @endif

            @foreach($group['routes'] as $ck=>$cm)
            @if(isset($cm['refer']) && $cm['refer']==$key)
            <li style="text-indent:1em;" class="item-child">
                <input type="checkbox" name="permissions[{{$ck}}]" value="1" id="{{$ck}}"
                    {{isset($self[$ck])||$isSuper?'checked':''}}>
                <label  for="{{$ck}}">{{ $cm['name'] }}</label>
            </li>
            @endif
            @endforeach
        @endforeach
        </ul>
      </div>
    </div>

  @endforeach
  <div class="text-center">
        <button type="submit" class="btn btn-sm btn-primary">保存</button>
    </div>
</form>
@endsection


@section('foot')
    @parent
    <script>
      require(['jquery'],function($){
        $('.item').click(function(){
           var checked = $(this).find(':checkbox').get(0).checked;
           $(this).nextUntil('.item','li').each(function(i,o){
               $(o).find(':checkbox').get(0).checked = checked;
           });
        });
      });
    </script>
@stop
