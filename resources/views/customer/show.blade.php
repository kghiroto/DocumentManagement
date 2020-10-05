@extends('layouts.app')

@section('content')

<!-- コンテンツヘッダ -->
<section class="content-header">
  <h1>顧客登録</h1>
  @if(Session::has('message'))
     <div class="alert alert-success">{{ session('message') }}</div>
  @endif
</section>

<!-- メインコンテンツ -->
<section class="content">
    <div class="box c_show">
      <table class="table table-bordered">
        <tr>
         <th style="width: 100px;">顧客No.</th>
         <td>{{$customer->id}}</td>
        </tr>
        <tr>
         <th style="width: 100px;">顧客名</th>
         <td>{{$customer->name}}</td>
        </tr>
        <tr>
         <th style="width: 100px;">郵便番号</th>
         <td>{{$customer->zip}}</td>
        </tr>
        <tr>
         <th style="width: 100px;">住所</th>
         <td>{{$customer->address}}</td>
        </tr>
        <tr>
         <th style="width: 100px;">電話番号</th>
         <td>{{$customer->tel}}</td>
        </tr>
        <tr>
         <th style="width: 100px;">FAX</th>
         <td>{{$customer->FAX}}</td>
        </tr>
        <tr>
         <th style="width: 100px;">担当者</th>
         <td>{{$customer->staffs}}</td>
        </tr>
        <tr>
         <th style="width: 100px;">備考</th>
         <td>{{$customer->remark}}</td>
        </tr>
      </table>
    </div>
    <!-- /.box -->
    <div class="c_show_btn">
      <a href="{{url('customer/list')}}">
        <button type="button" class="btn btn-danger btn-flat">一覧</button>
      </a>
      <a href='{{url("customer/edit-input/$customer->id")}}'>
        <button type="button" class="btn btn-danger btn-flat">編集</button>
      </a>
    </div>
</section>

@endsection


