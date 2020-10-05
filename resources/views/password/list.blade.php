@extends('layouts.app')

@section('content')

<!-- コンテンツヘッダ -->
<section class="content-header">
  <h1>レッスンURL一覧</h1>
  <br />
  <div class="callout bg-gray">
    <p>背景<b>赤</b>: レッスンURLが公開</p>
    <p>背景<b>グレー</b>: 過去のレッスン</p>
  </div>
</section>

<!-- メインコンテンツ -->
<section class="content">

    <!-- /.box -->
    <!-- general form elements disabled -->
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">&nbsp;</h3>
{{--
        <div class="box-tools">
          <div class="input-group input-group-sm" style="width: 200px;">
            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

            <div class="input-group-btn">
              <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </div>
          </div>
        </div>
      </div>
--}}
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table class="table table-bordered">
          <thead>
          <tr class="">
            <th>No.</th>
            <th>レッスン名前</th>
            <th>レッスン開始時間</th>
            <th>レッスンURL</th>
            <th>公開用URL</th>
            <th>-</th>
          </tr>
          </thead>
          <tbody>
          @foreach($passwords as $row)
          <tr 
          @if(date("Y-m-d H:i:s") > $row->lesson_start_at)
            class="bg-gray-active"
          @elseif(date("Y-m-d H:i:s",strtotime("+24 hour")) > $row->lesson_start_at) 
            class="danger"
          @endif
          >
            <td>{{$row->id}}</td>
            <td>{{$row->lesson_name}}</td>
            <td>{{substr($row->lesson_start_at, 0, strlen($row->lesson_start_at) - 3)}}</td>
            <td>{{$row->lesson_password}}</td>
            <td>{{route('password/show', $row->url_key)}}</td>
            <td><a href="{{route('password/edit-input', $row->id)}}"><button type="button" class="btn btn-danger btn-flat">編集する</button></a></td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix">
      {{$passwords->links()}}
      </div>
    </div>
    <!-- /.box -->

</section>

@endsection


