@extends('layouts.app')

@section('content')

<!-- コンテンツヘッダ -->
<section class="content-header">
    <h1>ダッシュボード</h1>
</section>


<!-- メインコンテンツ -->
<section class="content">

  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>{{$quotation->countAll()}}</h3>
          <p>案件数</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{url('quotation/list')}}" class="small-box-footer">案件一覧 <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3>{{$customer->countAll()}}</h3>
          <p>顧客数</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="{{url('customer/list')}}" class="small-box-footer">見積一覧 <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
{{--
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>1000</h3>
          <p>顧客数</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
--}}
  </div>
  <!-- コンテンツ1 -->
  {{--
  <div class="box">
      <div class="box-header with-border">
          <h3 class="box-title">お知らせ</h3>
      </div>
      <div class="box-body">
          <p>特にありません。（ダッシュボードの表示例です）</p>
      </div>
  </div>
  <!-- /.row -->
  --}}
  {{--
  @foreach (config('my.bg_styles') as $class)
    <div style="height:50px;width:150px;float:left;" class="{{$class}}">{{$class}}</div>
  @endforeach
  <div style="clear:both;"></div>
  --}}
</section>

@endsection
