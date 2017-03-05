@extends('layouts.app')

@section('content')
<form class="form-inline" method="post" action="{{route('system.user.save',[$model->id])}}">
  @if(session('error'))
    <div class="alert alert-danger" role="alert">{{session('error')}}</div>
  @endif
  @if(session('success'))
    <div class="alert alert-success" role="alert">{{session('success')}}</div>
  @endif

  <input type="hidden" name="_token" value="{{ csrf_token() }}">

  <div class="panel panel-default">
    <div class="panel-heading">拥有角色</div>
    <div class="panel-body">
      <ul style="list-style-type:none;padding-left:1em;">
      @foreach($roles as $role)
          <li class="item" style="width:24%;display:inline-block;">
              <label>
                <input type="checkbox" name="gids[]" class="gid" value="{{$role['id']}}" 
                  {{$rids->contains($role['id'])?'checked':''}}>
                {{ $role['name'] }}
              </label>
          </li>
      @endforeach
      </ul>
    </div>
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
                {{$isSuper||(isset($merged[$key])&&$merged[$key])?'checked':''}} disabled>
                <label for="{{$key}}" style="color:{{isset($self[$key])?$typeColor[$self[$key]]:''}}">{{ $menu['name'] }}</label>
            </li>
            @endif

            @foreach($group['routes'] as $ck=>$cm)
            @if(isset($cm['refer']) && $cm['refer']==$key)
            <li style="text-indent:1em;" class="item-child">
                <input type="checkbox" name="permissions[{{$ck}}]" value="1" id="{{$ck}}"
                  {{$isSuper||(isset($merged[$ck])&&$merged[$ck])?'checked':''}} disabled>
                <label  for="{{$ck}}" style="color:{{isset($self[$ck])?$typeColor[$self[$ck]]:''}}">{{ $cm['name'] }}</label>
            </li>
            @endif
            @endforeach
        @endforeach
        </ul>
      </div>
    </div>

  @endforeach
  
  <input name="action" type="hidden" value="user" />
  <input name="_method" type="hidden" value="put" />
  <!-- <div class="text-center">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="submit" class="btn btn-sm btn-primary">保存</button>
    </div> -->
</form>
@endsection


@section('footer')
    @parent
    <script>
    $(function(){
        $('input.gid').change(function(e){
          e.preventDefault();
          $('input[name=action]').val('group');
          $(this).parents('form').submit();
        });
    });
    </script>
@endsection
