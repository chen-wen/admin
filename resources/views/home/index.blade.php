@extends('layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">Dashboard</div>

    <div class="panel-body">
        <h1 class="text-center">欢迎使用Laravel来开发您的系统</h1>
        @can('welcome')<h3>has `welcome` permission</h3> @endcan
        @can('home')<p>has `home` permission</p> @endcan
    </div>
</div>
@endsection
