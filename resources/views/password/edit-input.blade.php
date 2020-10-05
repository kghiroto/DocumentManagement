@extends('layouts.app')

@section('content')

<!-- コンテンツヘッダ -->
<section class="content-header">
    <h1>レッスンURL編集</h1>
</section>

<!-- メインコンテンツ -->
<section class="content">

<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">レッスン情報入力</h3>
  </div>
  <!-- /.box-header -->
  <form role="form" action="{{route('password/edit-confirm')}}" method="POST">
    {{ csrf_field() }}
    <div class="box-body">
      <input type="hidden" name="id" value="{{$password->id}}">
      <!-- text input -->
      <div class="form-group @if($errors->has('lesson_name')) has-error @endif">
        <label>レッスン名</label>&nbsp;<i class="fa fa-commenting-o"></i>&nbsp;<label class="h6 text-green">レッスン名を入力</label> <input type="text" name="lesson_name" class="form-control" placeholder="レッスン名" value="{{old('lesson_name', $password->lesson_name)}}">
        @if($errors->has('lesson_name')) <span class="help-block">{{$errors->first('lesson_name')}}</span> @endif
      </div>
      <div class="form-group @if($errors->has('lesson_start_date') or $errors->has('lesson_start_time')) has-error @endif">
        <label>レッスン開始時間</label>&nbsp;<i class="fa fa-commenting-o"></i>&nbsp;<label class="h6 text-green">Zoomに設定したレッスン開始時間</label>
        <div class="row">
          <div class="col-xs-2">
            <div class="input-group date">
              <input type="text" name="lesson_start_date" class="form-control"  value="{{old('lesson_start_date', $password->lesson_start_date)}}" id="datepicker">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
            </div>
            @if($errors->has('lesson_start_date')) <span class="help-block">{{$errors->first('lesson_start_date')}}</span> @endif
          </div>
          <div class="col-xs-2">
          <select name="lesson_start_time" class="form-control">
            <option value="">選択してください</option>
            <option value="0:00" @if(old('lesson_start_time', $password->lesson_start_time)=="00:00") selected @endif>0:00</option>
            <option value="0:30" @if(old('lesson_start_time', $password->lesson_start_time)=="00:30") selected @endif>0:30</option>
            <option value="1:00" @if(old('lesson_start_time', $password->lesson_start_time)=="01:00") selected @endif>1:00</option>
            <option value="1:30" @if(old('lesson_start_time', $password->lesson_start_time)=="01:30") selected @endif>1:30</option>
            <option value="2:00" @if(old('lesson_start_time', $password->lesson_start_time)=="02:00") selected @endif>2:00</option>
            <option value="2:30" @if(old('lesson_start_time', $password->lesson_start_time)=="02:30") selected @endif>2:30</option>
            <option value="3:00" @if(old('lesson_start_time', $password->lesson_start_time)=="03:00") selected @endif>3:00</option>
            <option value="3:30" @if(old('lesson_start_time', $password->lesson_start_time)=="03:30") selected @endif>3:30</option>
            <option value="4:00" @if(old('lesson_start_time', $password->lesson_start_time)=="04:00") selected @endif>4:00</option>
            <option value="4:30" @if(old('lesson_start_time', $password->lesson_start_time)=="04:30") selected @endif>4:30</option>
            <option value="5:00" @if(old('lesson_start_time', $password->lesson_start_time)=="05:00") selected @endif>5:00</option>
            <option value="5:30" @if(old('lesson_start_time', $password->lesson_start_time)=="05:30") selected @endif>5:30</option>
            <option value="6:00" @if(old('lesson_start_time', $password->lesson_start_time)=="06:00") selected @endif>6:00</option>
            <option value="6:30" @if(old('lesson_start_time', $password->lesson_start_time)=="06:30") selected @endif>6:30</option>
            <option value="7:00" @if(old('lesson_start_time', $password->lesson_start_time)=="07:00") selected @endif>7:00</option>
            <option value="7:30" @if(old('lesson_start_time', $password->lesson_start_time)=="07:30") selected @endif>7:30</option>
            <option value="8:00" @if(old('lesson_start_time', $password->lesson_start_time)=="08:00") selected @endif>8:00</option>
            <option value="8:30" @if(old('lesson_start_time', $password->lesson_start_time)=="08:30") selected @endif>8:30</option>
            <option value="9:00" @if(old('lesson_start_time', $password->lesson_start_time)=="09:00") selected @endif>9:00</option>
            <option value="9:30" @if(old('lesson_start_time', $password->lesson_start_time)=="09:30") selected @endif>9:30</option>
            <option value="10:00" @if(old('lesson_start_time', $password->lesson_start_time)=="10:00") selected @endif>10:00</option>
            <option value="10:30" @if(old('lesson_start_time', $password->lesson_start_time)=="10:30") selected @endif>10:30</option>
            <option value="11:00" @if(old('lesson_start_time', $password->lesson_start_time)=="11:00") selected @endif>11:00</option>
            <option value="11:30" @if(old('lesson_start_time', $password->lesson_start_time)=="11:30") selected @endif>11:30</option>
            <option value="12:00" @if(old('lesson_start_time', $password->lesson_start_time)=="12:00") selected @endif>12:00</option>
            <option value="12:30" @if(old('lesson_start_time', $password->lesson_start_time)=="12:30") selected @endif>12:30</option>
            <option value="13:00" @if(old('lesson_start_time', $password->lesson_start_time)=="13:00") selected @endif>13:00</option>
            <option value="13:30" @if(old('lesson_start_time', $password->lesson_start_time)=="13:30") selected @endif>13:30</option>
            <option value="14:00" @if(old('lesson_start_time', $password->lesson_start_time)=="14:00") selected @endif>14:00</option>
            <option value="14:30" @if(old('lesson_start_time', $password->lesson_start_time)=="14:30") selected @endif>14:30</option>
            <option value="15:00" @if(old('lesson_start_time', $password->lesson_start_time)=="15:00") selected @endif>15:00</option>
            <option value="15:30" @if(old('lesson_start_time', $password->lesson_start_time)=="15:30") selected @endif>15:30</option>
            <option value="16:00" @if(old('lesson_start_time', $password->lesson_start_time)=="16:00") selected @endif>16:00</option>
            <option value="16:30" @if(old('lesson_start_time', $password->lesson_start_time)=="16:30") selected @endif>16:30</option>
            <option value="17:00" @if(old('lesson_start_time', $password->lesson_start_time)=="17:00") selected @endif>17:00</option>
            <option value="17:30" @if(old('lesson_start_time', $password->lesson_start_time)=="17:30") selected @endif>17:30</option>
            <option value="18:00" @if(old('lesson_start_time', $password->lesson_start_time)=="18:00") selected @endif>18:00</option>
            <option value="18:30" @if(old('lesson_start_time', $password->lesson_start_time)=="18:30") selected @endif>18:30</option>
            <option value="19:00" @if(old('lesson_start_time', $password->lesson_start_time)=="19:00") selected @endif>19:00</option>
            <option value="19:30" @if(old('lesson_start_time', $password->lesson_start_time)=="19:30") selected @endif>19:30</option>
            <option value="20:00" @if(old('lesson_start_time', $password->lesson_start_time)=="20:00") selected @endif>20:00</option>
            <option value="20:30" @if(old('lesson_start_time', $password->lesson_start_time)=="20:30") selected @endif>20:30</option>
            <option value="21:00" @if(old('lesson_start_time', $password->lesson_start_time)=="21:00") selected @endif>21:00</option>
            <option value="21:30" @if(old('lesson_start_time', $password->lesson_start_time)=="21:30") selected @endif>21:30</option>
            <option value="22:00" @if(old('lesson_start_time', $password->lesson_start_time)=="22:00") selected @endif>22:00</option>
            <option value="22:30" @if(old('lesson_start_time', $password->lesson_start_time)=="22:30") selected @endif>22:30</option>
            <option value="23:00" @if(old('lesson_start_time', $password->lesson_start_time)=="23:00") selected @endif>23:00</option>
            <option value="23:30" @if(old('lesson_start_time', $password->lesson_start_time)=="23:30") selected @endif>23:30</option>
          </select>
          @if($errors->has('lesson_start_time')) <span class="help-block">{{$errors->first('lesson_start_time')}}</span> @endif
          </div>
        </div>
      </div>
	  <div class="form-group @if($errors->has('lesson_password')) has-error @endif">
        <label>レッスンURL</label>&nbsp;<i class="fa fa-commenting-o"></i>&nbsp;<label class="h6 text-green">Zoomに表示されたレッスンURLを入力</label>
        <input type="text" name="lesson_password" class="form-control" placeholder="" value="{{old('lesson_password', $password->lesson_password)}}">
        @if($errors->has('lesson_password')) <span class="help-block">{{$errors->first('lesson_password')}}</span> @endif
      </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      <button type="submit" class="btn btn-danger center-block">確認画面へ</button>
    </div>
  </form>
</div>
<!-- /.box -->

</section>

@endsection
