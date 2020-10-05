@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                  <div class="panel-heading"><h2>レッスン名：{{$password->lesson_name}}</h2></div>
                  <div class="panel-body">
                      <h3>開始時間：{{$password->lesson_start_at}}</h3>
                      <h3>こちらをクリックして入室</h3>
                      @if(date("Y-m-d H:i:s",strtotime("+24 hour")) > $password->lesson_start_at)
                      <h3>入室用URL：<span class="text-danger"><b><a href="{{$password->lesson_password}}" target="_blank">{{$password->lesson_password}}</a></b></span></h3>
                      @else
                      <h3>入室用URL：<span class="text-danger"><b>レッスン開始1日前に公開されます。</b></span></h3>
                      @endif
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
