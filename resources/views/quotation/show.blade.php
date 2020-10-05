@extends('layouts.app')

@section('content')

<!-- コンテンツヘッダ -->
<section class="content-header">
  <h1>確認画面</h1>
  {{--<div class="callout bg-gray" style="margin-bottom: 0px">--}}

  @if(Session::has('message'))
     <div class="alert alert-success">{{ session('message') }}</div>
  @endif
</section>

<!-- メインコンテンツ -->
<section class="content">
    <h3>書き出し形式</h3>
    <div class="box">
    <form class="form-horizontal" id="quotation_preview_form" action="{{route('quotaion/preview')}}" method="POST">
      {{ csrf_field() }}
      <input type="hidden" value='{{$quotation->id}}' name="id">
      <input type="hidden" value='{{number_format($quotation->total_tax)}}' name="total_tax">
      <input type="hidden" value='{{number_format($quotation->total)}}' name="total">
      <input type="hidden" value='{{number_format($quotation->sub_total)}}' name="total_small">

      <div class="box-body center-kj">
        <div class="">
          <input  type="radio" name="O_S_D" value="御中" class="mg1-kj"  checked>御中
          <input type="radio" name="O_S_D" value="様" class="mg1-kj">様
          <input type="radio" name="O_S_D" value="殿" class="mg1-kj">殿
        </div>
      </div>
    </div>
    <div class="box">
      <div class="box-body text-center">
      <button type="submit" class="btn btn-warning btn-flat mg2-kj" formaction="{{route('quotaion/preview')}}" onclick="this.form.target='_blank'">プレビュー</button>
      <button type="submit" class="btn btn-danger btn-flat mg2-kj" formaction="{{route('quotaion/excel')}}" >excelで書き出し</button>
      <td> <a href="{{route('quotation/edit-input', $quotation->id)}}"><button type="button" class="btn btn-success btn-flat mg2-kj">再編集</button></a></td>
      </form>
      </div>
    </div>

      <h3>基本情報</h3>
        <div class="box">
          <div class="box-body c_show2">
            <table class="table table-bordered">
              <tr>
               <th style="width: 100px;">No.</th>
               <td>{{$quotation->id}}</td>
              </tr>
              <tr>
               <th style="width: 100px;">日付</th>
               <td>{{$quotationdate}}</td>
              </tr>
              <tr>
               <th style="width: 100px;">担当者</th>
               <td>{{$quotation->staffs}}</td>
              </tr>
              <tr>
               <th style="width: 100px;">顧客名</th>
               <td>{{$customer_options[$quotation->customer_id]}}</td>
              </tr>
              <tr>
               <th style="width: 100px;">工事名</th>
               <td>{{$quotation->title}}</td>
              </tr>
              <tr>
               <th style="width: 100px;">工事場所</th>
               <td>{{$quotation->place}}</td>
              </tr>
            </table>
          </div>
        </div>

    <!-- /.box -->
    <!-- general form elements disabled -->
    <h3>明細情報</h3>
    <div class="box">
<!--
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
--}}
      </div>
-->
      <!-- /.box-header -->
      <div class="box-body table-responsive no-padding confirm_table">
        <table class="table table-bordered" id="show">
          <thead>
	          <tr class="">
	            <th>#</th>
	            <th>名称</th>
	            <th>規格</th>
	            <th>数量</th>
	            <th>単位</th>
	            <th>原単価</th>
	            <th>歩掛り</th>
	            <th>単価</th>
	            <th>御見積</th>
	            <th>原価</th>
	            <th>利益</th>
	            <th>備考</th>
	          </tr>
          </thead>
          <tbody>
          @foreach($quotationDetails as $row)
          <tr class="clone_tr">
          @if ($row->folder == false)
            <td class="alignLeft" class="hier">{{$row->hier}}</td>
            <td>{!!str_repeat("&nbsp;&nbsp;", $row->indent)!!}{{$row->title}}</td>
            <td>{{$row->standard}}</td>
            <td class="alignRight">{{$row->quantity}}</td>
            <td>{!!$row->unit!!}</td>
            <td class="alignRight">{{$row->price}}</td>
            <td class="alignRight">{{$row->bugakari}}</td>
            <td class="alignRight">{{$row->price_estimate}}</td>
            <td class="alignRight"class="total">{{$row->sum_estimate}}</td>
            <td class="alignRight">{{$row->sum}}</td>
            <td class="alignRight">{{$row->profit}}</td>
            <td>{{$row->remark}}</td>
          @else
            <td class="alignRight">{{$row->hier}}</td>
            <td colspan="7">{!!str_repeat("&nbsp;&nbsp;", $row->indent)!!}<i class="fa fa-fw fa-folder-open-o" style="color: #fecb81"></i>{{$row->title}}</td>
            <td class="alignRight" id="show_total_small">{{number_format($row->sum)}}</td>
            <td class="alignRight"id="show_total_tax">{{number_format($row->sum_estimate)}}</td>
            <td class="alignRight"id="show_total">{{number_format($row->profit)}}</td>
            <td>{{$row->remark}}</td>
          @endif
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer clearfix">
      <div class="confirm_total">
	      <p class="text-right"id="show_total_small">小計: ￥{{number_format($quotation->sub_total)}}-</p>
	      <p class="text-right"id="show_total_tax">消費税額: ￥{{number_format($quotation->total_tax)}}-</p>
	      <p class="text-right"id="show_total">御見積金額: ￥{{number_format($quotation->total)}}-</p>
	      <p class="text-right" id="show_profit_rate">利益率: {{number_format($quotation->profit_rate, 1)}}</span>%</p>
      </div>
      </div>
    </div>

</section>

@endsection
