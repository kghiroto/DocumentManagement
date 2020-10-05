@extends('layouts.app')

@section('content')

<!-- コンテンツヘッダ -->
<section class="content-header_tng">
	<div class="content-header_tit">
		<h1>案件一覧</h1>
	</div>
	<div class="reference_wrap">
		<a class="reference js-modal-open" href="" data-target="modal01">
			検索
		</a>
	</div>

	<div id="modal01" class="modal js-modal">
		<div class="modal_bg js-modal-close"></div>

		<div class="modal_content">
			<div class="modal_in">
				<div class="container refe_form">
					<form method="POST" action="{{ route('quotation/list') }}">
						{{ csrf_field() }}
						<div class="refe_form_in">

							<div class="form-group refe_form_g">
								<label for="responsible" class="form_tit">担当者</label>
								<select id="staffs" name="staffs" class="form-control">
									<option value="">選択してください</option>
									<option value="今井道之">今井道之</option>
									<option value="今井英明">今井英明</option>
									<option value="石毛朝子">石毛朝子</option>
									<option value="今井裕敏">今井裕敏</option>
									<option value="藤井昌人">藤井昌人</option>
									<option value="太田草太郎">太田草太郎</option>
									<option value="木村文昭">木村文昭</option>
								</select>
							</div>

							<div class="form-group refe_form_r refe_form_g">
								<label for="date" class="form_tit">形式</label>
								<label class="radio-inline">
									<input type="radio" name="radio_1" value="見積" required>見積書
								</label>
								<label class="radio-inline">
									<input type="radio" name="radio_1" value="請求" required>請求書
								</label>
								<label class="radio-inline">
									<input type="radio" name="radio_1" value="" checked="checked" required>全件
								</label>
							</div>

							<div class="form-group refe_form_r refe_form_g">
								<label for="date" class="form_tit">会社名</label>
								<label class="radio-inline">
									<input type="radio" name="radio_2" value="今井設備工業" required>今井設備工業
								</label>

								<label class="radio-inline">
									<input type="radio" name="radio_2" value="ジャストサポート" required>ジャストサポート
								</label>

								<label class="radio-inline">
									<input type="radio" name="radio_2" value="" checked="checked" required>全件
								</label>
							</div>

							<div class="form-group refe_form_g ">
									<label for="date" class="form_tit">日付</label>

									<p id="tag">令和</p>
									<select name="year_before" value="" class="form-control date_sele2 day_form" >
										<option value="" name="quote_year"></option>
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
									<select name="month_before" value="" class="form-control date_sele2 day_form" >
										<option value="" name="quote_month"></option>
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
									<select name="day_before" value="" class="form-control date_sele2 day_form" >
										<option value="" name="quote_day"></option>
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
									<p id="tag">日  〜 </p>

									<p id="tag">令和</p>
									<select name="year_after" value="" class="form-control date_sele2 day_form" >
										<option value="" name="quote_year"></option>
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
									<select name="month_after" value="" class="form-control date_sele2 day_form" >
										<option value="" name="quote_month"></option>
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
									<select name="day_after" value="" class="form-control date_sele2 day_form" >
										<option value="" name="quote_day"></option>
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
							
							<div class="form-group refe_form_g">
								<label for="name" class="form_tit">顧客検索</label>
								<input type="text" id="name" name="name" class="form-control formtxt">
							</div>

							<div class="form-group refe_form_g">
								<label for="name" class="form_tit">フリーワード</label>
								<input type="text" id="freeword" name="freeword" class="form-control formtxt">
							</div>


							<button type="submit" class="btn start_s">検索開始</button>
						</div>
					</form>
				</div>
			</div>
			<a class="js-modal-close modal_close" href="">×</a>
		</div>
	</div>

</section>

<!-- メインコンテンツ -->
<section class="content">

	<!-- /.box -->
	<!-- general form elements disabled -->
	<div class="box box-danger">
		<div class="box-body table-responsive no-padding p_list">
			<table class="table table-bordered">
				<thead>
					<tr class="">
						<th class="a_center">No.</th>
						<th>更新日</th>
						<th>顧客名</th>
						<th>工事名</th>
						<th>提出金額</th>
						<th>請負金額</th>
						<th>利益</th>
						<th>利益率</th>
						<th>担当者</th>
						<th>S/M</th>
						<th>I/J</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="a_right b_total">￥{{number_format($cost)}}</td>
					<td class="a_right b_total">￥{{number_format($unitPrice)}}</td>
					<td class="a_right b_total">￥{{number_format($totalProfit)}}</td>
					@if($totalProfitRate !=0)
					<td class="a_right b_total">{{number_format($totalProfitRate,1)}}%</td>
					@else
					<td>{{$totalProfitRate}}%</td>
					@endif
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					@foreach($quotations as $row)
					<tr>
						<td class="a_center">{{$row->id}}</td>
						<td>令和{{(int)$row->updated_at->format('Y')-2018}}年{{(int)$row->updated_at->format('m')}}月{{(int)$row->updated_at->format('d')}}日</td>
						<td>{{$customer_options[$row->customer_id]}}</td>
						<td>{{$row->title}}</td>
						<td class="a_right">￥{{number_format($row->sub_total)}}</td>
						<td class="a_right">￥{{number_format($row->total)}}</td>
						<td class="a_right">￥{{number_format($row->profit)}}</td>
						@if($row->profit_rate != 0 && $row->profit_rate != "")
						<td class="a_right">{{number_format($row->profit_rate,1)}}%</td>
						@else
						<td class="a_right">{{$row->profit_rate}}%</td>
						@endif
						<td>{{$row->staffs}}</td>
						<td>{{$row->which_document}}</td>
						<td>{{$row->which_company}}</td>
						<td>
							<a href="{{route('quotation/edit-input', $row->id)}}">
								<button type="button" class="btn btn-danger btn-flat">編集</button>
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<!-- /.box-body -->
		<div class="clearfix">
			{{$quotations->appends($conditions)->links()}}
		</div>
	</div>
	<!-- /.box -->

</section>


@endsection
