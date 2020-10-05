@extends('layouts.app')

@section('content')

<!-- コンテンツヘッダ -->
<section class="content-header">
    <h1>レッスンURL登録確認</h1>
</section>


<!-- メインコンテンツ -->
<section class="content">

    <!-- /.box -->
    <!-- general form elements disabled -->
    <div class="box">
     {{--
      <div class="box-header">
        <h3 class="box-title">&nbsp;</h3>
      </div>
      --}}
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding">
        <table class="table table-bordered">
          <tr>
            <th class="col-md-2">レッスン名</th>
            <td class="col-md-10">{{$password['lesson_name']}}</td>
          </tr>
          <tr>
            <th>レッスン開始時間</th>
            <td>{{$password['lesson_start_date']}} {{$password['lesson_start_time']}}</td>
          </tr>
          <tr>
            <th>レッスンURL</th>
            <td>{{$password['lesson_password']}}</td>
          </tr>
        </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <div class="center-block">
          <form role="form" action="{{route('password/edit-confirm')}}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="from" value="confirm">
            <input type="hidden" name="id" value="{{$password['id']}}">
            <input type="hidden" name="lesson_name" value="{{$password['lesson_name']}}">
            <input type="hidden" name="lesson_start_date" value="{{$password['lesson_start_date']}}">
            <input type="hidden" name="lesson_start_time" value="{{$password['lesson_start_time']}}">
            <input type="hidden" name="lesson_password" value="{{$password['lesson_password']}}">
            <button type="button" class="btn btn-danger submit" data-action="{{route('password/edit-confirm')}}">戻る</button>
            <button type="button" class="btn btn-danger submit" data-action="{{route('password/edit-finish')}}">完了画面へ</button>
          </form>
        </div>
      </div>
    </div>
    <!-- /.box -->

</section>
@endsection
