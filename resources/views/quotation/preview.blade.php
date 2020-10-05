@if ($format == "今井設備工業見積" || $format == "今井設備工業請求")

<!DOCTYPE html>
	<html lang="ja">
		<head>
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
			<meta name="format-detection" content="telephone=no">
			
			<meta charset="utf-8">
			<title>{{config('app.name')}}</title>
			<!-- for responsive -->
			<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

			<!-- Font Awesome -->
			<link rel="stylesheet" href="{{asset("AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.min.css")}}">
			<!--jquery UI-->
			<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
			<!-- jQuery -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
				
			<!-- CSS -->
			<link rel="stylesheet" href="{{asset("css/template/reset.css")}}">
			<link rel="stylesheet" href="{{asset("css/template/style_t.css")}}">
		</head>
		<body>
			<div class="wrapper">
				<div class="contain">
					<div class="temp_info">
						<h1>御{{$result["M_S"]}}書</h1><!-- 御見積書or御請求書 -->
						<div class="number">
							<p>令和<span>{{$result["quotation_day_year"]}}</span>年<span>{{$result["quotation_day_month"]}}</span>月<span>{{$result["quotation_day_day"]}}</span>日</p><!-- spanの中に数字取得 -->
							<p>No.：<span>{{$result["id"]}}</span></p><!-- spanの中に数字取得 -->
						</div>
						<div class="info_con">
							<div class="info_con_l">
								<div class="name">
									<h2>{{$result["customer"]}}</h2><!-- 顧客名取得 -->
									<h3>{{$result["O_S_D"]}}</h3><!-- 御中or様or殿 -->
								</div>
								<div class="note">
									<p>下記の通り、<span>御{{$result["M_S"]}}</span>申し上げます。</p><!-- spanに御見積or御請求 -->
									<p>ご検討の上、何卒ご用命の程お願い申し上げます。</p><!-- ご請求書の場合消す？ -->
								</div>
								<div class="info_data">
									<div class="info_data_l">
										<p>工事名</p>
									</div>
									<div class="info_data_r">
										<h4>{{$result["title"]}}</h4><!-- 取得 -->
									</div>
								</div>
								<div class="info_data">
									<div class="info_data_l">
										<p>工事場所</p>
									</div>
									<div class="info_data_r">
										<h4>{{$result["place"]}}</h4><!-- 取得 -->
									</div>
								</div>
								<div class="info_data">
									<div class="info_data_l">
										<p>工事期間</p>
									</div>
									<div class="info_data_r">
										<h4>令和{{$result["period_before_year"]}}年{{$result["period_before_month"]}}月{{$result["period_before_day"]}}日 ~ 令和{{$result["period_after_year"]}}年{{$result["period_after_month"]}}月{{$result["period_after_day"]}}日</h4><!-- 取得 -->
									</div>
								</div>
								<div class="info_data">
									<div class="info_data_l">
										<p>支払条件</p>
									</div>
									<div class="info_data_r">
										<h4>{{$result["payment_term"]}}</h4><!-- 取得 -->
									</div>
								</div>
								<div class="info_data">
									<div class="info_data_l">
										<p>有効期限</p>
									</div>
									<div class="info_data_r">
										<h4>{{$result["expiration_date"]}}</h4><!-- 取得 -->
									</div>
								</div>
							</div>
							<div class="info_con_r">
								<h3>有限会社 今井設備工業</h3>
								<h4>代表取締役　今井 道之</h4>
								<div class="comp_data">
									<p>〒297-0078 千葉県茂原市高師台3-6-16</p>
									<p>TEL：0475-20-1233　FAX：0475-258400</p>
									<p>E-mail：info@imai-s.co.jp</p>
									<p>URL： http://www.imai-s.co.jp</p>
									<div class="transfer">
										@if ($result["M_S"] == "見積")
											<p>お振込先：千葉銀行　茂原支店　普通　2259982</p>
										@else
											<p></p>
										@endif
									</div>
								</div>
							</div>
						</div>
						<div class="money">
							<div class="tax_in">
								<h5>御{{$result["M_S"]}}金額</h5>
								<p>¥<span>{{$result["total"]}}</span>-</p><!-- spanの中に数字取得 -->
							</div>
							<div class="tax">
								<h5>消費税額</h5>
								<p>¥<span>{{$result["total_tax"]}}</span>-</p><!-- spanの中に数字取得 -->
							</div>
						</div>
					</div>
					<div class="temp_details">
						<table style="table-layout: fixed;">
							<thead>
								<tr>
									<th style="width:10%;"></th>
									<td style="font-size:1px; width:29%;">名　称</td>
									<td style="font-size:1px; width:7%;">数 量</td>
									<td style="font-size:1px; width:7%;">単 位</td>
									<td style="font-size:1px; width:10%;">単 価</td>
									<td style="font-size:1px; width:10%;">金 額</td>
									<td style="font-size:1px; width:28%;">備　考</td>
								</tr>
							</thead>
							<tbody>
								@foreach($result_Detail as $row)
								<tr>
									<th>{{$row["hier"]}}</th>
									<td style="font-size:10px;">{{$row["title"]}}<br>　{{$row["standard"]}}</td>
									<td class="a_right" >{{$row["quantity"]}}</td>
									<td class="a_right">{{$row["unit"]}}</td>
									<td class="a_right">{{$row["unit_price"]}}</td>
									<td class="a_right">{{$row["price"]}}</td>
									<td>{{$row["remark"]}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<div class="moment">
							<div class="moment_con subtotal">
								<h5>小　計</h5>
								<p>¥<span>{{$result["total_small"]}}</span>-</p><!-- spanの中に数字取得 -->
							</div>
							<!-- <div class="moment_con total">
								<h5>合　計</h5>
								<p>¥<span>{{$result["total_small"]}}</span>-</p>
							</div> -->
							<div class="moment_con tax">
								<h5>消費税等</h5>
								<p>¥<span>{{$result["total_tax"]}}</span>-</p><!-- spanの中に数字取得 -->
							</div>
							<div class="moment_con taxin">
								<h5>見積合計</h5>
								<p>¥<span>{{$result["total"]}}</span>-</p><!-- spanの中に数字取得 -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</body>
	</html>


@elseif ($format == "ジャストサポート見積")


<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="format-detection" content="telephone=no">
		
		<meta charset="utf-8">
		<title>{{config('app.name')}}</title>
		<!-- for responsive -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{asset("AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.min.css")}}">
		<!--jquery UI-->
		<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			
		<!-- CSS -->
		<link rel="stylesheet" href="{{asset("css/template/reset.css")}}">
		<link rel="stylesheet" href="{{asset("css/template/style_j.css")}}">
	</head>
	<body>
		<div class="wrapper">
			<div class="contain">
				<div class="temp_info">
					<h1>御見積書</h1>
					<div class="number">
						<p>No.<span>{{$result["id"]}}</span></p><!-- spanの中に数字取得 -->
					</div>
					<div class="info_con">
						<div class="info_con_l">
							<div class="name">
								<h2>{{$result["customer"]}}</h2><!-- 顧客名取得 -->
								<h3>{{$result["O_S_D"]}}</h3><!-- 御中or様or殿 -->
							</div>
							<div class="note">
								<p>令和<span>{{$result["quotation_day_year"]}}</span>年<span>{{$result["quotation_day_month"]}}</span>月<span>{{$result["quotation_day_day"]}}</span>日</p><!-- spanの中に数字取得 -->
								<p>下記の通り、御見積申し上げます。何卒御用命賜ります様お願い申し上げます。</p>
							</div>
							<div class="money">
								<div class="money_name">
									<h4>御見積金額</h4>
								</div>
								<div class="money_txt">
									<p>¥<span>{{$result["total"]}}</span></p><!-- spanの中に数字取得 -->
								</div>
							</div>
							<div class="breakdown">
								<div class="taxin">
									<div class="taxin_tit">
										<p>● うち 工事価格 （取引に係る消費税等を除く額）</p>
									</div>
									<div class="taxin_txt">
										<p>¥<span>{{$result["total_small"]}}</span></p><!-- spanの中に数字取得 -->
									</div>
								</div>
								<div class="taxin">
									<div class="taxin_tit">
										<p>● 取引に係る消費税等 （税率10.0%）</p>
									</div>
									<div class="taxin_txt">
										<p>¥<span>{{$result["total_tax"]}}</span></p><!-- spanの中に数字取得 -->
									</div>
								</div>
							</div>
							<div class="note2">
								<p>下記の通り、御見積申し上げます。何卒御用命賜ります様お願い申し上げます。</p>
							</div>
							<div class="temp_details">
								<table>
									<tbody>
										<tr>
											<th>工事名称</th>
											<td>{{$result["title"]}}</td><!-- 取得 -->
										</tr>
										<tr>
											<th>工事場所</th>
											<td>{{$result["place"]}}</td><!-- 取得 -->
										</tr>
										<tr>
											<th>工事期間</th>
											<td>令和{{$result["period_before_year"]}}年{{$result["period_before_month"]}}月{{$result["period_before_day"]}}日 ~ 令和{{$result["period_after_year"]}}年{{$result["period_after_month"]}}月{{$result["period_after_day"]}}日</td><!-- 取得 -->
										</tr>
										<tr>
											<th>御支払条件</th>
											<td>{{$result["payment_term"]}}</td><!-- 取得 -->
										</tr>
										<tr>
											<th>摘要</th>
											<td>{{$result["remark"]}}</td><!-- 取得 -->
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="info_con_r">
							<h3>ジャストサポートホーム （株）</h3>
							<div class="comp_data">
								<p>〒297-0078</p>
								<p>千葉県茂原市高師台3−6−16</p>
								<p>（TEL）0475-25-6580</p>
								<p>（FAX）0475-23-4077</p>
							</div>
							<h4>代表取締役　今井 英明</h4>
							<div class="mark">
								<table>
									<tbody>
										<tr>
											<th>検印</th>
											<td></td>
											<th>検印</th>
											<td></td>
											<th>担当印</th>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="footer">
					<div class="partners">
						<img src="{{asset("image/partners.jpg")}}">
					</div>
				</div>
			</div>
			<div class="contain">
				<div class="breakdown_info">
					<h2>■見積内訳　<span>{{$result["title"]}}</span></h2><!-- spanの中に工事名称 -->
					<div class="number">
						<p>No.<span>{{$result["id"]}}</span></p><!-- spanの中に数字取得 -->
					</div>
					<div class="bd_details">
						<table style="table-layout: fixed;">
							<thead>
								<tr>
									<td style="width:26%; font-size:11px;">名　称</td>
									<td style="width: 18%; font-size:11px;">仕　様</td>
									<td style="width: 7%; font-size:11px;">数 量</td>
									<td style="width: 7%; font-size:11px;">単 位</td>
									<td style="width: 10%; font-size:11px;">単 価</td>
									<td style="width: 10%; font-size:11px;">金 額</td>
									<td style="width: 22%; font-size:11px;">備 考</td>
								</tr>
							</thead>
							<tbody>
							@foreach($result_bigs as $row)
								<tr>
									<td>{{$row["title"]}}</td>
									<td>{{$row["standard"]}}</td>
									<td class="a_right">{{$row["quantity"]}}</td>
									<td class="a_right">{{$row["unit"]}}</td>
									<td class="a_right">{{$row["unit_price"]}}</td>
									<td class="a_right">{{$row["price"]}}</td>
									<td>{{$row["remark"]}}</td>
								</tr>
								@endforeach
								<tr class="in_total">
									<td>※　小 計　※</td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right">{{$result["total_small"]}}</td>
									<td></td>
								</tr>
								<tr>
									<td>消費税額（税率10.0%）</td>
									<td></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right">{{$result["total_tax"]}}</td>
									<td></td>
								</tr>
								<tr class="in_total">
									<td>※　合 計　※</td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right">{{$result["total"]}}</td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p class="page_num">1</p>
					</div>
				</div>
				<div class="footer">
					<div class="partners">
						<img src="{{asset("image/partners.jpg")}}">
					</div>
				</div>
			</div>
			<div class="contain">
				<div class="breakdown_info">
					<h2>■工事明細　<span>{{$result["title"]}}</span></h2><!-- spanの中に工事名称 -->
					<div class="number">
						<p>No.<span>{{$result["id"]}}</span></p><!-- spanの中に数字取得 -->
					</div>
					<div class="bd_details">
						<table style="table-layout: fixed;">
							<thead>
								<tr>
									<td style="width:26%; font-size:11px;">名　称</td>
									<td style="width: 18%; font-size:11px;">仕　様</td>
									<td style="width: 7%; font-size:11px;">数 量</td>
									<td style="width: 7%; font-size:11px;">単 位</td>
									<td style="width: 10%; font-size:11px;">単 価</td>
									<td style="width: 10%; font-size:11px;">金 額</td>
									<td style="width: 22%; font-size:11px;">備 考</td>
								</tr>
							</thead>
							<tbody>
							@foreach($result_Detail as $row)
							<tr>
									<td>{{$row["title"]}}</td>
									<td>{{$row["standard"]}}</td>
									<td class="a_right">{{$row["quantity"]}}</td>
									<td class="a_right">{{$row["unit"]}}</td>
									<td class="a_right">{{$row["unit_price"]}}</td>
									<td class="a_right">{{$row["price"]}}</td>
									<td>{{$row["remark"]}}</td>
								</tr>
								@endforeach
								<tr>
									<td></td>
									<td></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p class="page_num">2</p>
					</div>
				</div>
				<div class="footer">
					<div class="partners">
						<img src="{{asset("image/partners.jpg")}}">
					</div>
				</div>
			</div>
		</div>
	</body>
</html>



@elseif ($format == "ジャストサポート請求")


<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="format-detection" content="telephone=no">
		
		<meta charset="utf-8">
		<title>{{config('app.name')}}</title>
		<!-- for responsive -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{asset("AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.min.css")}}">
		<!--jquery UI-->
		<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			
		<!-- CSS -->
		<link rel="stylesheet" href="{{asset("css/template/reset.css")}}">
		<link rel="stylesheet" href="{{asset("css/template/style_j.css")}}">
	</head>
	<body>
		<div class="wrapper">
			<div class="contain contain_s">
				<div class="temp_info">
					<h1>御請求書</h1>
					<div class="number">
						<p>No.<span>{{$result["id"]}}</span></p><!-- spanの中に数字取得 -->
					</div>
					<div class="info_con info_con_s">
						<div class="info_con_l">
							<div class="name">
								<h2>{{$result["customer"]}}</h2><!-- 顧客名取得 -->
								<h3>{{$result["O_S_D"]}}</h3><!-- 御中or様or殿 -->
							</div>
							<div class="note3">
								<p>御請求日　令和<span>{{$result["quotation_day_year"]}}</span>年<span>{{$result["quotation_day_month"]}}</span>月<span>{{$result["quotation_day_day"]}}</span>日</p><!-- spanの中に見積日数取得 -->
								<p>下記の通りご請求申し上げます。</p>
							</div>
							<div class="money_details">
								<table>
									<tbody>
										<tr>
											<th>御請求金額</th>
											<td>¥{{$result["total"]}}</td><!-- 取得 -->
										</tr>
										<tr>
											<th>御請求金額（税別）</th>
											<td>¥{{$result["tax_subtraction"]}}</td><!-- 取得 -->
										</tr>
										<tr>
											<th>消費税等</th>
											<td>¥{{$result["total_tax"]}}</td><!-- 取得 -->
										</tr>
									</tbody>
								</table>
							</div>
							<div class="remarks">
								<div class="taxin">
									<div class="taxin_tit">
										<p>備考  </p>
									</div>
								</div>
								<div class="taxin">
									<div class="taxin_tit">
										<p>請負金額（税込）</p>
									</div>
									<div class="taxin_txt">
										<p>¥<span></span></p><!-- 出力後手入力 -->
									</div>
								</div>
								<div class="taxin">
									<div class="taxin_tit">
										<p>前回までの領収済金額（税込）</p>
									</div>
									<div class="taxin_txt">
										<p>¥<span></span></p><!-- 出力後手入力 -->
									</div>
								</div>
								<div class="taxin">
									<div class="taxin_tit">
										<p>今回の請求金額（税込）</p>
									</div>
									<div class="taxin_txt">
										<p>¥<span>{{$result["total"]}}</span></p><!-- spanの中に数字取得 -->
									</div>
								</div>
								<div class="taxin">
									<div class="taxin_tit">
										<p>差引残高（税込）</p>
									</div>
									<div class="taxin_txt">
										<p>¥<span></span></p><!-- spanの中に数字取得 -->
									</div>
								</div>
							</div>
							<div class="destination">
								<h4>■お振込先</h4>
								<p>　千葉銀行　茂原支店　普通　3961260　ジャストサポートホーム（株）</p>
								<div class="description">
									<h5>摘要</h5>
									<div class="descri_box">
										<p>{{$result["remark"]}}</p><!-- 備考を取得 -->
									</div>
								</div>
							</div>
						</div>
						<div class="info_con_r">
							<div class="construction">
								<table>
									<tbody>
										<tr>
											<th>工事名称</th>
											<td>{{$result["title"]}}</td><!-- 取得 -->
										</tr>
										<tr>
											<th>工事場所</th>
											<td>{{$result["place"]}}</td><!-- 取得 -->
										</tr>
										<tr>
											<th>工事期間</th>
											<td>令和{{$result["period_before_year"]}}年{{$result["period_before_month"]}}月{{$result["period_before_day"]}}日 ~ 令和{{$result["period_after_year"]}}年{{$result["period_after_month"]}}月{{$result["period_after_day"]}}日</td><!-- 取得 -->
										</tr>
									</tbody>
								</table>
							</div>
							<div class="comp_data2">
								<table>
									<tbody>
										<tr>
											<th>( 会社名 )</th>
											<td>ジャストサポートホーム（株）<br>代表取締役　今井 英明</td>
										</tr>
										<tr>
											<th>( 住所 )</th>
											<td>〒297-0078<br>千葉県茂原市高師台3−6−16</td>
										</tr>
										<tr>
											<th>( TEL / FAX )</th>
											<td>0475-25-6580　/　0475-23-4077</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="mark2">
								<table>
									<tbody>
										<tr>
											<th>検　印</th>
											<th>検　印</th>
										</tr>
										<tr>
											<td></td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="footer">
					<div class="partners">
						<img src="{{asset("image/partners.jpg")}}">
					</div>
				</div>
			</div>
			<div class="contain">
				<div class="breakdown_info">
					<h2>■見積内訳　<span>{{$result["title"]}}</span></h2><!-- spanの中に工事名称 -->
					<div class="number">
						<p>No.<span>{{$result["id"]}}</span></p><!-- spanの中に数字取得 -->
					</div>
					<div class="bd_details">
							<table style="table-layout: fixed;">
							<thead>
								<tr>
									<td style="width:26%; font-size:11px;">名　称</td>
									<td style="width: 18%; font-size:11px;">規　格</td>
									<td style="width: 7%; font-size:11px;">数 量</td>
									<td style="width: 7%; font-size:11px;">単 位</td>
									<td style="width: 10%; font-size:11px;">単 価</td>
									<td style="width: 10%; font-size:11px;">金 額</td>
									<td style="width: 22%; font-size:11px;">備 考</td>
								</tr>
							</thead>
							<tbody>
							@foreach($result_bigs as $row)
								<tr>
									<td>{{$row["title"]}}</td>
									<td>{{$row["standard"]}}</td>
									<td class="a_right">{{$row["quantity"]}}</td>
									<td class="a_right">{{$row["unit"]}}</td>
									<td class="a_right">{{$row["unit_price"]}}</td>
									<td class="a_right">{{$row["price"]}}</td>
									<td>{{$row["remark"]}}</td>
								</tr>
								@endforeach
								<tr class="in_total">
									<td>※　小 計　※</td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right">{{$result["tax_subtraction"]}}</td>
									<td></td>
								</tr>
								<tr>
									<td>消費税額（税率10.0%）</td>
									<td></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right">{{$result["total_tax"]}}</td>
									<td></td>
								</tr>
								<tr class="in_total">
									<td>※　合 計　※</td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right">{{$result["total"]}}</td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p class="page_num">1</p>
					</div>
				</div>
				<div class="footer">
					<div class="partners">
						<img src="{{asset("image/partners.jpg")}}">
					</div>
				</div>
			</div>
			<div class="contain">
				<div class="breakdown_info">
					<h2>■工事明細　<span>{{$result["title"]}}</span></h2><!-- spanの中に工事名称 -->
					<div class="number">
						<p>No.<span>{{$result["id"]}}</span></p><!-- spanの中に数字取得 -->
					</div>
					<div class="bd_details">
							<table style="table-layout: fixed;">
							<thead>
								<tr>
									<td style="width:26%; font-size:11px;">名　称</td>
									<td style="width: 18%; font-size:11px;">規　格</td>
									<td style="width: 7%; font-size:11px;">数 量</td>
									<td style="width: 7%; font-size:11px;">単 位</td>
									<td style="width: 10%; font-size:11px;">単 価</td>
									<td style="width: 10%; font-size:11px;">金 額</td>
									<td style="width: 22%; font-size:11px;">備 考</td>
								</tr>
							</thead>
							<tbody>
							@foreach($result_Detail as $row)
								<tr>
									<td>{{$row["title"]}}</td>
									<td>{{$row["standard"]}}</td>
									<td class="a_right">{{$row["quantity"]}}</td>
									<td class="a_right">{{$row["unit"]}}</td>
									<td class="a_right">{{$row["unit_price"]}}</td>
									<td class="a_right">{{$row["price"]}}</td>
									<td>{{$row["remark"]}}</td>
								</tr>
								@endforeach
								<tr>
									<td></td>
									<td></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td class="a_right"></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p class="page_num">2</p>
					</div>
				</div>
				<div class="footer">
					<div class="partners">
						<img src="{{asset("image/partners.jpg")}}">
					</div>
				</div>
			</div>
		</div>
	</body>
</html>


@endif