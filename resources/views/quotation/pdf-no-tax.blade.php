<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>{{$quotation->title}}</title>
<style type="text/css">
body {
  font-family: ipag;
  font-size: 0.75em;
}
.header {
}

.header-left, .header-center, .header-right {
  float: left;
  width: 33.3333%; // 3分割
  //border: solid 2px blue;
}
.header-center {
  text-align: center;
  vertical-align: top;
  margin-bottom: 50px;
  font-size: 28px;
}
.header-right {
  text-align: right;
}
.quotation-info {
}
.quotation-info-left{
  float: left;
  width: 60%;
  //border: solid 2px yellow;
  margin-bottom: 15px;
}
.quotation-info-right {
  float: left;
  width: 40%;
  //border: solid 2px black;
  margin-bottom: 15px;
}
.sign-box {
    margin-top: 10px;
    width: 60px;
    height: 60px;
    line-height: 40px;
    border: solid 1px #222;
    text-align: center;
}
.quotation-total, .quotation-total-small, .quotation-tax {
  float: left;
  width: 33%;
  //border: solid 1px pink;
  padding: 0 5px;
  margin-bottom: 15px;
}
div.right {
  text-align: right;
}

div.left {
  text-align: left;
}
.clear {
  clear: both;
}
table {
width: 100%; /* ボックス外側余白を指定する */
margin-left: auto; /* 左側の余白を自動に指定する */
margin-right: auto; /* 右側の余白を自動に指定する */
border-collapse: collapse; /* 隣接するセルの罫線を重ねて表示する */
}
table th{
padding: 3px; /* 見出しの余白を指定する(上下左右) */
background-color: #CEF9DC; /* 見出しの背景色を指定する */
color: #222222; /* フォントの色を指定する */
font-weight: normal; /* フォントの太さを指定する */
text-align: center; /* テキストの位置を指定する */
vertical-align: top; /* 見出しテキストの位置を指定する */
border: 1px solid #666666;/* 罫線を実線で指定する */
}
table td{
padding: 6px; /* セルの余白を指定する(上下左右) */
background-color: #fff; /* ボックスの背景色を指定する */
border: 1px solid #666666; /* 罫線を実線で指定する */
}
table td.right {
  text-align: right;
}
table td.center {
  text-align: center;
}
span.big {
  font-size: 1.5em;
}
</style>
</head>
<body>

<div class="container">
  <div class="header">
    <div class="header-left">
      &nbsp;
    </div>
    <div class="header-center">
      <u>御&nbsp;見&nbsp;積&nbsp;書</u>
    </div>
    <div class="header-right">
      <div>{{date("Y年m月d日")}}</div>
      <div>御見積No.：{{$quotation->adjustId($quotation->id)}}</div>
    </div>
  </div>
  <div class="clear"></div>


  <div class="quotation-info">
    <div class="quotation-info-left">
      <div><span class="big">{{$customer_options[$quotation->customer_id]}}&nbsp;様</span></div>
      <div><p>下記の通り、御見積申し上げます。<br />ご検討の上、何卒ご用命のほどお願い申し上げます。</p></div>
      <div>工&nbsp;事&nbsp;名: {{$quotation->title}}</div>
      <div>工事場所: {{$quotation->place}}</div>
      <div>工事期間: {{$quotation->period}}</div>
      <div>支払条件: {{$quotation->payment_term}}</div>
      <div>有効期限: {{$quotation->validity}}</div>
    </div>
    <div class="quotation-info-right">
      <div><span class="big">有限会社今井設備工業</span></div>
      <div>代表取締役 今井道之</div>
      <div>&#12306;297-0078 千葉県茂原市高師台3-6-16</div>
      <div>Email: info@imai-s.co.jp</div>
      <div>URL: http://www.imai-s.co.jp</div>
      <div>備考:<br> {!!nl2br(e($quotation->remark))!!}</div>
    </div>
  </div>
  <div class="clear"></div>

  <div class="quotation-amount">
    <div class="quotation-total"><u><span class="big">御見積金額: ￥{{number_format($quotation->total_small)}}-</span></u></div>
  </div>
  <div class="clear"></div>

  <div class="quotation-detail">
    <table>
    <thead>
        <tr>
            <th width="50">&nbsp;</th>
            <th width="150">名称</th>
            <th width="30">数量</th>
            <th width="30">単位</th>
            <th width="40">単価</th>
            <th width="40">金額</th>
            <th>備考</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($quotation->quotationDetails as $value)
        <tr>
          @if ($value->folder == false)
            <td class="right">{{ $value->hier }}</td>
            <td>
              {!!str_repeat("&nbsp;&nbsp;", $value->indent)!!}{{ $value->title }}
              @if ($value->standard != '')
              <br />
              {!!str_repeat("&nbsp;&nbsp;", $value->indent)!!}{{ $value->standard }}
              @endif
            </td>
            <td class="right">{{ $value->quantity}}</td>
            <td class="center">{{ $value->unit}}</td>
            <td class="right">{{ number_format($value->price_estimate)}}</td>
            <td class="right">{{ number_format($value->sum_estimate)}}</td>
            <td>{{ $value->remark}}</td>
          @else
            <td class="right">{{ $value->hier }}</td>
            <td>{!!str_repeat("&nbsp;&nbsp;", $value->indent)!!}{{ $value->title }}</td>
            <td class="right">&nbsp;</td>
            <td class="center">&nbsp;</td>
            <td class="right">&nbsp;</td>
            <td class="right">{{ number_format($value->sum_estimate)}}</td>
            <td>{{ $value->remark}}</td>
          @endif
        </tr>
        @endforeach
    </tbody>
    </table>
  </div>
  <script type="text/php">
      if ( isset($pdf) ) {
        $x = 36;
        $y = 760;
        $text = "{PAGE_NUM} / {PAGE_COUNT}";
        $font = $fontMetrics->get_font("ipag", "normal");
        $size = 14;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
      }
 </script>
</div>
</body>
</html>
