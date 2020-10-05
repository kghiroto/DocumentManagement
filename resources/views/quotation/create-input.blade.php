@extends('layouts.app')

@section('content')

<!-- コンテンツヘッダ -->

{{-- 見積りフォーム--}}


<h3 class="basic_info_tit">基本情報</h3>
<div class="basic_info">
  <div class="box basic_form">
    <form class="form-horizontal" id="quotation_form" action="{{route('quotation/save')}}" method="POST">
      {{ csrf_field() }}
      <div class="basic_form_in">


        <div class="basic_form_g">
          <label for="" class="form_tit">日付</label>
          <div class="bf_flex">

		        <p id="tag">令和</p>
		        <select name="quote_year" value="{{$quotationYear}}" class="form-control date_sele2" >
		          <option value="{{$quotationYear}}" name="quote_year">{{$quotationYear}}</option>
		          <option value="1" name="quote_year">1</option>
		          <option value="2" name="quote_year">2</option>
		          <option value="3" name="quote_year">3</option>
		          <option value="4" name="quote_year">4</option>
		          <option value="5" name="quote_year">5</option>
		          <option value="6" name="quote_year">6</option>
		          <option value="7" name="quote_year">7</option>
		          <option value="8" name="quote_year">8</option>
		          <option value="9" name="quote_year">9</option>
		          <option value="10" name="quote_year">10</option>
		        </select>
		        <p id="tag">年</p>
		        <select name="quote_month" value="{{$quotationMonth}}" class="form-control date_sele2" >
		          <option value="{{$quotationMonth}}" name="quote_month">{{$quotationMonth}}</option>
		          <option value="1" name="quote_month">1</option>
		          <option value="2" name="quote_month">2</option>
		          <option value="3" name="quote_month">3</option>
		          <option value="4" name="quote_month">4</option>
		          <option value="5" name="quote_month">5</option>
		          <option value="6" name="quote_month">6</option>
		          <option value="7" name="quote_month">7</option>
		          <option value="8" name="quote_month">8</option>
		          <option value="9" name="quote_month">9</option>
		          <option value="10" name="quote_month">10</option>
		          <option value="11" name="quote_month">11</option>
		          <option value="12" name="quote_month">12</option>
		        </select>
		        <p id="tag">月</p>
		        <select name="quote_day" value="{{$quotationDay}}" class="form-control date_sele2" >
		          <option value="{{$quotationDay}}" name="quote_day">{{$quotationDay}}</option>
							<option value="1" name="quote_day">1</option>
							<option value="2" name="quote_day">2</option>
							<option value="3" name="quote_day">3</option>
							<option value="4" name="quote_day">4</option>
							<option value="5" name="quote_day">5</option>
							<option value="6" name="quote_day">6</option>
							<option value="7" name="quote_day">7</option>
							<option value="8" name="quote_day">8</option>
							<option value="9" name="quote_day">9</option>
							<option value="10" name="quote_day">10</option>
							<option value="11" name="quote_day">11</option>
							<option value="12" name="quote_day">12</option>
							<option value="13" name="quote_day">13</option>
							<option value="14" name="quote_day">14</option>
							<option value="15" name="quote_day">15</option>
							<option value="16" name="quote_day">16</option>
							<option value="17" name="quote_day">17</option>
							<option value="18" name="quote_day">18</option>
							<option value="19" name="quote_day">19</option>
							<option value="20" name="quote_day">20</option>
							<option value="21" name="quote_day">21</option>
							<option value="22" name="quote_day">22</option>
							<option value="23" name="quote_day">23</option>
							<option value="24" name="quote_day">24</option>
							<option value="25" name="quote_day">25</option>
							<option value="26" name="quote_day">26</option>
							<option value="27" name="quote_day">27</option>
							<option value="28" name="quote_day">28</option>
							<option value="29" name="quote_day">29</option>
							<option value="30" name="quote_day">30</option>
							<option value="31" name="quote_day">31</option>
		        </select>
		        <p id="tag">日</p>
		      </div>
		    </div>


    <div class="basic_form_g">
      <label class="form_tit">担当者</label>
      <div class="bf_select">
        <select name="staffs" class="form-control" id="day" value="">
          @if(is_null($quotation->staffs))
          <option value="" name="staffs[]">選択してください</option>
          @endif
          <option value="{{$quotation->staffs}}" name="staffs[]">{{$quotation->staffs}}</option>
          <option value="今井道之"name="staffs[]">今井道之</option>
          <option value="今井英明"name="staffs[]">今井英明</option>
          <option value="石毛朝子"name="staffs[]">石毛朝子</option>
          <option value="今井裕敏"name="staffs[]">今井裕敏</option>
          <option value="藤井昌人"name="staffs[]">藤井昌人</option>
          <option value="太田草太郎"name="staffs[]">太田草太郎</option>
          <option value="木村文昭"name="staffs[]">木村文昭</option>
        </select>
      </div>
    </div>


    <div class="basic_form_g">
      <label class="form_tit">顧客名</label>
      <div class="bf_select2">
        <input type="text" name="customer-name" value="{{$customer_arr['name']}}" class="select_input form-control" id="customer_keyword" readonly>
        <input type="hidden" name="customer_id" value="{{$customer_arr['id']}}"class="form-control" id="customer_id">
      </div>
      <div class="basic_btn">
        <button data-target="modal02" class="js-modal-open btn" type="button" id="serch_customer" name="" value="">参照</button>
      </div>
    </div>


    <div class="basic_form_g">
      <label class="form_tit">工事名</label>
      <div class="">
        <input class="form-control basic_txt" name="quote-title" value="{{$quotation->title}}">
      </div>
    </div>

    <div class="basic_form_g">
      <label class="form_tit">工事場所</label>
      <div class="">
        <input class="form-control basic_txt" name="place" value="{{$quotation->place}}">
      </div>
    </div>

    <div class="basic_form_g">
      <label class="form_tit">御支払条件</label>
      <div class="">
        <input class="form-control basic_txt" name="payment_term" value="{{$quotation->payment_term}}">
      </div>
    </div>

    <div class="basic_form_g">
      <label class="form_tit">有効期限</label>
      <div class="">
        <input class="form-control basic_txt" name="expiration_date" value="{{$quotation->expiration_date}}">
      </div>
    </div>

    <div class="basic_form_g">
      <label for="" class="form_tit">工事期間</label>
      <div class="bf_flex">
    <p id="tag">令和</p>
    <select name="period_before_year" value="{{$period_before_year}}" class="form-control date_sele2" >
      <option value="{{$period_before_year}}" name="period_before_year">{{$period_before_year}}</option>
      <option value="1" name="period_before_year">1</option>
      <option value="2" name="period_before_year">2</option>
      <option value="3" name="period_before_year">3</option>
      <option value="4" name="period_before_year">4</option>
      <option value="5" name="period_before_year">5</option>
      <option value="6" name="period_before_year">6</option>
      <option value="7" name="period_before_year">7</option>
      <option value="8" name="period_before_year">8</option>
      <option value="9" name="period_before_year">9</option>
      <option value="10" name="period_before_year">10</option>
    </select>
    <p id="tag">年</p>
    <select name="period_before_month" value="{{$period_before_month}}" class="form-control date_sele2" >
      <option value="{{$period_before_month}}" name="period_before_month">{{$period_before_month}}</option>
			<option value="1" name="period_before_month">1</option>
			<option value="2" name="period_before_month">2</option>
			<option value="3" name="period_before_month">3</option>
			<option value="4" name="period_before_month">4</option>
			<option value="5" name="period_before_month">5</option>
			<option value="6" name="period_before_month">6</option>
			<option value="7" name="period_before_month">7</option>
			<option value="8" name="period_before_month">8</option>
			<option value="9" name="period_before_month">9</option>
			<option value="10" name="period_before_month">10</option>
			<option value="11" name="period_before_month">11</option>
			<option value="12" name="period_before_month">12</option>
    </select>
    <p id="tag">月</p>
    <select name="period_before_day" value="{{$period_before_day}}" class="form-control date_sele2" >
      <option value="{{$period_before_day}}" name="period_before_day">{{$period_before_day}}</option>
			<option value="1" name="period_before_day">1</option>
			<option value="2" name="period_before_day">2</option>
			<option value="3" name="period_before_day">3</option>
			<option value="4" name="period_before_day">4</option>
			<option value="5" name="period_before_day">5</option>
			<option value="6" name="period_before_day">6</option>
			<option value="7" name="period_before_day">7</option>
			<option value="8" name="period_before_day">8</option>
			<option value="9" name="period_before_day">9</option>
			<option value="10" name="period_before_day">10</option>
			<option value="11" name="period_before_day">11</option>
			<option value="12" name="period_before_day">12</option>
			<option value="13" name="period_before_day">13</option>
			<option value="14" name="period_before_day">14</option>
			<option value="15" name="period_before_day">15</option>
			<option value="16" name="period_before_day">16</option>
			<option value="17" name="period_before_day">17</option>
			<option value="18" name="period_before_day">18</option>
			<option value="19" name="period_before_day">19</option>
			<option value="20" name="period_before_day">20</option>
			<option value="21" name="period_before_day">21</option>
			<option value="22" name="period_before_day">22</option>
			<option value="23" name="period_before_day">23</option>
			<option value="24" name="period_before_day">24</option>
			<option value="25" name="period_before_day">25</option>
			<option value="26" name="period_before_day">26</option>
			<option value="27" name="period_before_day">27</option>
			<option value="28" name="period_before_day">28</option>
			<option value="29" name="period_before_day">29</option>
			<option value="30" name="period_before_day">30</option>
			<option value="31" name="period_before_day">31</option>
    </select>
    <p id="tag">日</p>
  </div>
  <div class="bf_flex">
    <p id="tag" class="bf_from">〜</p>
		<p id="tag">令和</p>
    <select name="period_after_year" value="{{$period_affter_year}}" class="form-control date_sele2" >
      <option value="{{$period_affter_year}}" name="period_after_year">{{$period_affter_day}}</option>
      <option value="1" name="period_after_year">1</option>
      <option value="2" name="period_after_year">2</option>
      <option value="3" name="period_after_year">3</option>
      <option value="4" name="period_after_year">4</option>
      <option value="5" name="period_after_year">5</option>
      <option value="6" name="period_after_year">6</option>
      <option value="7" name="period_after_year">7</option>
      <option value="8" name="period_after_year">8</option>
      <option value="9" name="period_after_year">9</option>
      <option value="10" name="period_after_year">10</option>
    </select>
		<p id="tag">年</p>
    <select name="period_after_month" value="{{$period_affter_month}}" class="form-control date_sele2" >
      <option value="{{$period_affter_month}}" name="period_after_month">{{$period_affter_month}}</option>
			<option value="1" name="period_after_month">1</option>
			<option value="2" name="period_after_month">2</option>
			<option value="3" name="period_after_month">3</option>
			<option value="4" name="period_after_month">4</option>
			<option value="5" name="period_after_month">5</option>
			<option value="6" name="period_after_month">6</option>
			<option value="7" name="period_after_month">7</option>
			<option value="8" name="period_after_month">8</option>
			<option value="9" name="period_after_month">9</option>
			<option value="10" name="period_after_month">10</option>
			<option value="11" name="period_after_month">11</option>
			<option value="12" name="period_after_month">12</option>
    </select>
		<p id="tag">月</p>
    <select name="period_after_day" value="{{$period_affter_day}}" class="form-control date_sele2" >
      <option value="{{$period_affter_day}}" name="period_after_day">{{$period_affter_day}}</option>
			<option value="1" name="period_after_day">1</option>
			<option value="2" name="period_after_day">2</option>
			<option value="3" name="period_after_day">3</option>
			<option value="4" name="period_after_day">4</option>
			<option value="5" name="period_after_day">5</option>
			<option value="6" name="period_after_day">6</option>
			<option value="7" name="period_after_day">7</option>
			<option value="8" name="period_after_day">8</option>
			<option value="9" name="period_after_day">9</option>
			<option value="10" name="period_after_day">10</option>
			<option value="11" name="period_after_day">11</option>
			<option value="12" name="period_after_day">12</option>
			<option value="13" name="period_after_day">13</option>
			<option value="14" name="period_after_day">14</option>
			<option value="15" name="period_after_day">15</option>
			<option value="16" name="period_after_day">16</option>
			<option value="17" name="period_after_day">17</option>
			<option value="18" name="period_after_day">18</option>
			<option value="19" name="period_after_day">19</option>
			<option value="20" name="period_after_day">20</option>
			<option value="21" name="period_after_day">21</option>
			<option value="22" name="period_after_day">22</option>
			<option value="23" name="period_after_day">23</option>
			<option value="24" name="period_after_day">24</option>
			<option value="25" name="period_after_day">25</option>
			<option value="26" name="period_after_day">26</option>
			<option value="27" name="period_after_day">27</option>
			<option value="28" name="period_after_day">28</option>
			<option value="29" name="period_after_day">29</option>
			<option value="30" name="period_after_day">30</option>
			<option value="31" name="period_after_day">31</option>
    </select>
		<p id="tag">日</p>
	</div>
</div>

<div class="basic_form_g">
  <label class="form_tit">備考</label>
  <div class="form_tit">
    <textarea class="form-control basic_textarea" name="remark" cols="50" rows="5">{{$quotation->remark}}</textarea>
  </div>
</div>

@if($which['company'] == "今井設備工業")
<div class="basic_form_g create_radio">
  <input  type="radio" name="company" value="今井設備工業" class="cr_btn" checked　>今井設備工業
  <input type="radio" name="company" value="ジャストサポート" class="cr_txt">ジャストサポート
</div>
@elseif($which['company'] == "ジャストサポート")
<div class="basic_form_g create_radio">
  <input  type="radio" name="company" value="今井設備工業" class="cr_btn" >今井設備工業
  <input type="radio" name="company" value="ジャストサポート" class="cr_txt" checked>ジャストサポート
</div>
@else
<div class="basic_form_g create_radio">
  <input  type="radio" name="company" value="今井設備工業" class="cr_btn" >今井設備工業
  <input type="radio" name="company" value="ジャストサポート" class="cr_txt">ジャストサポート
</div>
@endif

@if($which['document'] == "見積")
<div class="basic_form_g create_radio">
  <input  type="radio" name="document" value="見積" class="cr_btn" checked>見積書
  <input type="radio" name="document" value="請求" class="cr_txt">請求書
</div>
@elseif($which['document'] == "請求")
<div class="basic_form_g create_radio">
  <input  type="radio" name="document" value="見積" class="cr_btn" >見積書
  <input type="radio" name="document" value="請求" class="cr_txt" checked>請求書
</div>
@else
<div class="basic_form_g create_radio">
  <input  type="radio" name="document" value="見積" class="cr_btn" >見積書
  <input type="radio" name="document" value="請求" class="cr_txt">請求書
</div>
@endif
</div>

<input type="hidden" id="quotation_details" name="quotation_details" value="">
<input type="hidden" name="quotation_id" value="{{$quotation->id}}">
</div>
</form>
</div>
</div>

<div class="container">
  <div class="content details_wrap">
    <div class="details_tit">
      <div>
        <h3 class="basic_info_tit">明細情報</h3>
      </div>
      <div class="details_btn">
        <button data-target="modal01" class="js-modal-open btn" type="button" id="copy_item" name="" value="">参照複写</button>
      </div>
      <div class="details_btn">
        <button type="button"id="sort">並び替え</button>
      </div>
    </div>
    <div id="modal02" class="modal js-modal">
      <div class="modal_bg js-modal-close"></div>
      <div class="modal_content">
        <a class="js-modal-close modal_close" href="">×</a>
        <div class="modal_in search_modal">
          <section class="">

            <div class="search_box_19 search_box_20">
              <div class="">
                <div class="search_19 search_box_20_tit">
                  <div>
                    <h4>顧客検索</h4>
                  </div>
                  <div class="input-group input-group-sm">
                    <input type="text" name="keyword" class="form-control" value="" id="modal-keyword" placeholder="キーワード入力">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default search_btn"id="in-modal-serch-customer">検索</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box -->
            <!-- general form elements disabled -->
            <div class="box box-danger search_modal_tbl">
              <div class="box-body table-responsive no-padding">
                <table class="table table-bordered" id="serch-customer-table">
                  <thead>
                    <tr class="">
                      <th></th>
                      <th>No.</th>
                      <th>顧客名</th>
                      <th>住所</th>
                      <th>電話番号</th>
                      <th>FAX</th>
                      <th>担当者</th>
                    </tr>
                  </thead>
                  <tbody>


                  </tbody>
                </table>
                <div class="box s_btn">
                  <div class="box-body text-center">
                    <button type="button" class="btn btn-warning btn-flat" id="ok-confirm">OK</button>
                    <button type="button" class="btn btn-danger btn-flat" id="ng-confirm">キャンセル</button>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->

          </section>
        </div>
      </div>
    </div>

    <div id="modal01" class="modal js-modal">
      <div class="modal_bg js-modal-close"></div>

      <div class="modal_content">
        <a class="js-modal-close modal_close" href="">×</a>
        <div class="modal_in search_modal">

          <section class="">

            <!-- /.box -->
            <!-- general form elements disabled -->
            <div class="search_box_19 search_box_20">
              <div class="">
                <div class="search_19 search_box_20_tit">
                  <div>
                    <h4>参照複写</h4>
                  </div>
                  <div class="input-group input-group-sm">
                    <input type="text" name="keyword" class="form-control" value="" id="modal-serch-quotaion" placeholder="キーワード入力" >
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-default search_btn"id="modal-serch-quotaion-btn"readonly>検索</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="box box-danger search_modal_tbl">
              <div class="box-body table-responsive no-padding overflow">
                <table class="refe_tbl table table-bordered" id="modal-quotation-table">
                  <thead>
                    <tr class="">
                      <th></th>
                      <th>No.</th>
                      <th>顧客名</th>
                      <th>工事名</th>
                      <th>担当者</th>
                      <th>S/M</th>
                      <th>I/J</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($quotations as $row)
                    <tr class="original-tr">
                      <td><input type="radio" name="select-quotation" class="select-quotation"></td>
                      <td>{{$row['id']}}</td>
                      <td>{{$customer_options[$row['customer_id']]}}</td>
                      <td>{{$row['title']}}</td>
                      <td>{{$row['staffs']}}</td>
                      <td>{{$row['which_document']}}</td>
                      <td>{{$row['which_company']}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="box box-danger overflow2">
                <div class="refe_tbl2 box-body table-responsive no-padding">
                  <table class="table table-bordered" id="modal-quotaion-detail-table">
                    <thead>
                      <tr class="">
                        <th>選択</th>
                        <th>名称</th>
                        <th>規格</th>
                        <th>数量</th>
                        <th>単位</th>
                        <th>原単価</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                  <div class="box s_btn">
                    <div class="box-body text-center">
                      <button type="button" class="btn btn-warning btn-flat" id="confirm">OK</button>
                      <button type="button" class="btn btn-danger btn-flat" id="ng-confirm-detail">キャンセル</button>
                    </div>
                  </div>
                </div>

                <!-- /.box-body -->
              </div>

            </section>

          </div>
        </div>
      </div>

      <div class="box details_table">
        <form class="form-horizontal"name="quotationDetails_form" id="quotationDetails_form" action="{{route('quotation/save')}}" method="POST">
          {{ csrf_field() }}
          <div class="box-body table-responsive no-padding">
            <table id="tree" class="table">

              <thead>
                <tr>
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
                <!-- Define a row template for all invariant markup: -->
                @foreach($result_Detail as $key => $value)
                <tr  class="clone_tr" >
                  <td class="alignRight">
	                  <input class="hier key_event" name="hier[]" value = "{{$value['hier']}}" type = "text">
                  </td>
                  <td class="alignRight">
	                  <input class="title" name="title[]" value = "{{$value['title']}}" type="text" >
                  </td>
                  <td class="alignRight">
	                  <input class="standard" name="standard[]" value = "{{$value['standard']}}" type="text" >
                  </td>
                  <td class="alignRight">
	                  <input class="a_right quantity" name="input_quantity[]" value = "{{$value['quantity']}}" type="text" >
                  </td>
                  <td class="alignRight">
	                  <input class="a_right unit" name="unit[]" type="text" value = "{{$value['unit']}}" >
                  </td>
                  <td class="alignRight">
	                  <input class="a_right price" name="input_price[]" value = "{{$value['price']}}" type="text" >
                  </td>
                  <td class="alignRight">
	                  <input class="a_right bugakari" name="input_bugakari[]" value = "{{$value['bugakari']}}" type="text">
                  </td>
                  <td class="alignRight" class = "unit-price"></td>
                  <td class="alignRight"class="total"></td>
                  <td class="alignRight"></td>
                  <td class="alignRight"></td>
                  <td class="alignRight"><input type="text" class="remark" rows="1" cols="30" value="{{$value['remark']}}" name="input_remark[]" ></td>
                  <input type="hidden" name="details_total[]" value="" class="details_total">
                  <input type="hidden" name="details_total_middle[]" value="" class="details_total_middle">

                </tr>
                @endforeach
              </tbody>

            </table>

            <!--modal edit-->
            <!--<a href="#inline_edit" class="inline_edit"></a>-->
            <button class="inline_edit" style="display:none;"></button>
            <div id="inline_edit" style="display:none;">
              <h4>
                名称を変更します
              </h4>
              <hr>
              <div><b>名称:</b>
                <input type="text" id="modal_edit_input" name="" value="">
              </div>
              <hr>
              <div>
                <button type="button" id="modal_edit_finish">決定</button>
              </div>
            </div>

            <!--modal new-->
            <!--<a href="#inline_new" class="inline_new"></a>-->
            <button class="inline_new" style="display:none;"></button>
            <div id="inline_new" style="display:none;">
              <h4>
                名称を追加します
              </h4>
              <hr>
              <div><b>追加位置:</b>
                <input type="radio" name="item_position" value="1" checked="checked">同列に追加
                <input type="radio" name="item_position" value="0">子供として追加
              </div>
              <hr>
              <div><b>カテゴリか項目か:</b>
                <input type="radio" name="item_type" value="1" checked="checked">カテゴリ
                <input type="radio" name="item_type" value="0">項目名
              </div>
              <hr>
              <div><b>名称:</b>
                <input type="text" id="modal_new_input" name="" value="">
              </div>
              <hr>
              <div>
                <button id="modal_new_finish">決定</button>
              </div>
            </div>

            <!--modal del comfirm-->
            <a href="#confirm_del" class="confirm_del"></a>

            <!--modal copy-->
            <button class="inline_copy" style="display:none;"></button>
            <div id="inline_copy" style="display:none;">
              <h4>
                参照複写
              </h4>
              <div><b>工事名:</b>
                <input type="text" id="modal_copy_input" name="" value="">
                <button type="button" id="modal_copy_search">検索</button>
              </div>
              <!-- <div style="height:100px; overflow-y:scroll;"> -->
              <div>
                <table id="quotation_list_table">
                  <thead style="display: block;">
                    <tr><th class="w50">No.</th><th class="w200">顧客名</th><th class="w200">工事名</th></tr>
                  </thead>
                  <tbody style="display: block;overflow-y:scroll;height: 200px">
                  </tbody>
                </table>
              </div>
              <hr>
              <div>
                <table id="quotation_detail_list_table">
                  <thead style="display: block;">
                    <tr><th class="w50">&nbsp;</th><th class="w200"><textarea></textarea></th><th class="w200">規格</th><th class="w50">数量</th>
                      <th class="w50">単位</th><th class="w50">原単価</th></tr>
                    </thead>
                    <tbody style="display: block;overflow-y:scroll;height: 200px">
                    </tbody>
                  </table>
                </div>
                <div>
                  <button type="button" id="modal_copy_finish">コピー</button>
                </div>
              </div>

            </div>
            <div class="box-footer">
              <div class="total_mny">
                <p class="text-right">小計 : ￥<span id="total_small"></span>-</p>
                <p class="text-right">消費税額 : ￥<span id="total_tax"></span>-</p>
                <p class="text-right">御見積金額 : ￥<span id="total"></span>-</p>
                <!--             <p class="text-right">利益率: <span id="profit_rate"></span>%</p> -->
              </div>
              <input type="hidden" name="sub_total" value="" id="sub_total_rq">
              <input type="hidden" name="total_tax" value="" id="total_tax_rq">
              <input type="hidden" name="total" value="" id="total_rq">
              <input type="hidden" name="profit_rate" value="" id="profit_rate_rq">
              <input type="hidden" name="profit" value="" id="profit">
              <input type="hidden"  id="quotation_data" name="detail_data">
              <button type="button" class="btn btn-block btn-lg  btn-danger btn-flat" id="save" onclick="send()" >保存する</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </section>
  @endsection
