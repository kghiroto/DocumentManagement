@extends('layouts.app')

@section('content')

<!-- コンテンツヘッダ -->
<section class="content-header">

		<h1>顧客一覧</h1>

  <div class="box-body search_box_19">
    <form role="form" action="{{route('customer/list')}}" method="GET">
      <div class="row">
        <div class="search_19 search_20">
          <div class="input-group input-group-sm">
            <input type="text" name="keyword" class="form-control" value="{{$conditions['keyword']}}" placeholder="キーワード入力">
            <div class="input-group-btn">
              <button type="submit" class="btn btn-default search_btn">検索開始</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>

<!-- メインコンテンツ -->
<section class="content c_list_wrap">
  <!-- general form elements disabled -->
  <div class="box">
    {{--
      <div class="box-header">
      </div>
      --}}
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding c_list">
        <table class="table table-bordered">
          <thead>
            <tr class="table_tit">
              <th class="no_th">顧客No.</th>
              <th>顧客名</th>
              <th>住所</th>
              <th>電話番号</th>
              <th>FAX</th>
              <th>担当者</th>
              <th>備考</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($customers as $row)
            <tr class="table_txt">
              <td class="no_th">{{$row->id}}</td>
              <td>{{$row->name}}</td>
              <td>
                @if(!is_null($row->zip))
                〒{{$row->zip}}
                @endif
                <br>
                {{$row->address}}
              </td>
              <td>{{$row->tel}}</td>
              <td>{{$row->FAX}}</td>
              <td>{{$row->staffs}}</td>
							<td>{{$row->remark}}</td>
              <td>
                <a href="{{route('customer/edit-input', $row->id)}}"><button type="button" class="edit_btn btn btn-danger btn-flat">編集</button></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
      <div class="clearfix">
        {{$customers->appends($conditions)->links()}}
      </div>
    </div>
    <!-- /.box -->

  </section>

  @endsection
