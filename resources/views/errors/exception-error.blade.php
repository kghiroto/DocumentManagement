@extends('layouts.app')

@section('content')

<!-- コンテンツヘッダ -->
<section class="content-header">
    <h1>エラー発生</h1>
    <ol class="breadcrumb">
       <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
       <li class="active">Index</li>
    </ol>
</section>


<!-- メインコンテンツ -->
<section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
        <i class="fa fa-bullhorn"></i>
        <h3 class="box-title">大きな問題はございません。メニューより移動をお願いします。</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <h4>エラーとなった理由</h4>
          <p>ログイン後、長時間放置していた</p>
          <p>登録完了ページへ再アクセスを行った</p>
      </div>
      <!-- /.box-body -->
    </div>
     <!-- /.box -->
</section>
@endsection
