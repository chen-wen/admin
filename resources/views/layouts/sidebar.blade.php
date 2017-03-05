<div class="panel-group" id="accordion" role="tablist"
                    aria-multiselectable="true">
    @foreach($MENU['groups'] as $name => $groups)
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading-{{$name}}">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$name}}" aria-expanded="true" aria-controls="collapseOne">
              {{$name}}
            </a>
          </h4>
        </div>
        <div id="collapse-{{$name}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-{{$name}}">
            <div class="list-group">
              @foreach($groups as $key)
                @if(isset($MENU['routes'][$key]))
                  <!-- <span class="badge">14</span> -->
                  <a href="{{route($key)}}" class="list-group-item {{$key==$CURRENT_ROUTE?'active':''}}">{{$MENU['routes'][$key]['name']}}</a>
                @endif
              @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>
