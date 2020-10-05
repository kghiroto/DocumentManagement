<!doctype html>
<html>
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}" charset="utf-8">
  <title>{{config('app.name')}}</title>
  <!-- for responsive -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset("AdminLTE-2.4.2/bower_components/bootstrap/dist/css/bootstrap.min.css")}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset("AdminLTE-2.4.2/bower_components/font-awesome/css/font-awesome.min.css")}}">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{asset("AdminLTE-2.4.2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset("AdminLTE-2.4.2/bower_components/Ionicons/css/ionicons.min.css")}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset("AdminLTE-2.4.2/dist/css/AdminLTE.min.css")}}">
  <link rel="stylesheet" href="{{asset("AdminLTE-2.4.2/dist/css/skins/skin-red-light.min.css")}}">

  <!--jquery UI-->
  <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
  <!--fancytree-->
  <link href="{{asset("fancytree/dist/skin-win8/ui.fancytree.css")}}" rel="stylesheet">
  <!--Modaal-->
  <link href="{{asset("Modaal/dist/css/modaal.min.css")}}" rel="stylesheet">

  <style type="text/css">
  .ui-menu {
    width: 180px;
    font-size: 63%;
  }
  .ui-menu kbd { /* Keyboard shortcuts for ui-contextmenu titles */
    float: right;
  }
  .ui-front {z-index: 10000}
  /* custom alignment (set by 'renderColumns'' event) */
  td.alignRight {
    text-align: right;
  }
  td.alignCenter {
    text-align: center;
  }
  td input[type=input].quantity {
    width: 30px;
  }
  td input[type=input].unit {
    width: 40px;
  }
  td input[type=input].price {
    width: 70px;
  }
  td input[type=input].bugakari {
    width: 50px;
  }
  th {
    background-color: #eee;
  }
  tr.selected {
    background-color: yellow;
  }

  table#quotation_list_table th,td {
    border: 1px solid #666666;
  }
  table#quotation_detail_list_table th,td{
    border: 1px solid #666666;
  }
  th.w50, td.w50 {
    width: 50px;
  }
  th.w200, td.w200 {
    width: 200px;
  }

  /* 追記 */

.mg1-kj{
  margin:0 5px 0 20px !important;
}

.center-kj{
  text-align:center;
}

.mg2-kj{
  margin:0 10px;
}

/* .fontsize-kj{
  font-size: 2px !important;
} */
  /*
  td.title {
  cursor: pointer;
}
*/
</style>
<!--Original_css-->
<link href="{{asset("css/style.css")}}" rel="stylesheet">
<!--Original_css-->
<link href="{{asset("css/style_c.css")}}" rel="stylesheet">
</head>
<body class="hold-transition skin-red-light layout-top-nav">
  <div class="wrapper">
    <!-- ヘッダー -->
    @include('header')

    <!-- サイドバー -->
    {{--@include('sidebar')--}}

    <!-- content -->
    <div class="content-wrapper">
      <div class="container">
        <!-- コンテンツ -->
        @yield('content')
      </div>
    </div><!-- end content -->

    <!-- フッター -->
    @include('footer')

  </div><!-- end wrapper -->
  <!-- JS -->
  <!-- jQuery 3 -->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js" integrity="sha512-qzgd5cYSZcosqpzpn7zF2ZId8f/8CHmFKZ8j7mU4OUXTNRd5g+ZHBPsgKEwoqxCtdQvExE5LprwwPAgoicguNg==" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/css/theme.default.min.css">

  <!-- jQuery UI-->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <!-- fancytree -->
  <script src="{{asset("fancytree/dist/jquery.fancytree-all.min.js")}}"></script>
  <!-- Modaal -->
  <script src="{{asset("Modaal/dist/js/modaal.min.js")}}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{asset("AdminLTE-2.4.2/bower_components/bootstrap/dist/js/bootstrap.min.js")}}"></script>
  <!-- bootstrap datepicker -->
  <script src="{{asset("AdminLTE-2.4.2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset("AdminLTE-2.4.2/dist/js/adminlte.min.js")}}"></script>
  <!-- for Quotation  -->
  @if(Request::is('quotation/*'))
  <script src="{{asset("js/quotation.js") . "?" . date("YmdHis")}}"></script>
  @endif
  <script>
  var site_url = "{{config('app.url')}}";
  var shouhizei = {{config('const.tax_rate')}};
  var mode = 'create';
  var jsonData = [];
  var unit_options = [];
  @if(Request::is('quotation/edit-input/*'))
  jsonData = {!!$json!!};
  mode = 'edit';
  unit_options = {!!$unit_options!!};
  @endif
  @if(Request::is('quotation/create-input'))
  jsonData = [
    {title: "名称", standard:"", folder: false, expanded: true, quantity:0, unit: "", price:0, bugakari:0, children: []}
  ];
  unit_options = {!!$unit_options!!};
  mode = 'create';
  @endif
  @if(Request::is('quotation/copy-input/*'))
  jsonData = {!!$json!!};
  unit_options = {!!$unit_options!!};
  mode = 'create';
  @endif
  // IE用の関数定義
  if (!String.prototype.startsWith) {
    Object.defineProperty(String.prototype, 'startsWith', {
      value: function(search, pos) {
        pos = !pos || pos < 0 ? 0 : +pos;
        return this.substring(pos, pos + search.length) === search;
      }
    });
  }
  </script>
  <!-- モーダル -->
  <script>
  $(function(){
    var winScrollTop;
    $('.js-modal-open').each(function(){
      $(this).on('click',function(i){
        //スクロール位置を取得
        winScrollTop = $(window).scrollTop();

        var target = $(this).data('target');
        var modal = document.getElementById(target);
        $(modal).fadeIn();
        return false;
      });
    });
    $('.js-modal-close').on('click',function(){
      $('.js-modal').fadeOut();
      $('body,html').stop().animate({scrollTop:winScrollTop}, 100);
      return false;
    });
  });
  </script>
</body>
</html>
