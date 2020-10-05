@extends('layouts.app')

@section('content')

<!-- コンテンツヘッダ -->
<section class="content-header">
    <h1>レッスンURL登録完了</h1>
</section>


<!-- メインコンテンツ -->
<section class="content">
    <div class="box box-default">
      <div class="box-header with-border">
        <i class="fa fa-bullhorn"></i>
        <h3 class="box-title">お疲れ様でした</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
          <p><a href="{{route('password/list')}}">レッスンURL一覧画面</a>より登録したレッスンURLと公開用URLを確認できます。</p>
      </div>
      <!-- /.box-body -->
    </div>
     <!-- /.box -->
</section>

@endsection
