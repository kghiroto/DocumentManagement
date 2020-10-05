<aside class="main-sidebar">
  <section class="sidebar">
    {{--
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="https://placehold.jp/160x160.png?text=X" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{Auth::user()->name}}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form>
    <!-- /.search form -->
    --}}
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li><a href="{{route('/')}}"><i class="fa fa-dashboard"></i><span>ダッシュボード</span></a></li>

      {{--
      <li><a href="{{route('password/create-input')}}"><i class="fa fa-circle-o"></i>パスワード登録</a></li>
      <li><a href="{{route('password/list')}}"><i class="fa fa-circle-o"></i>パスワード一覧</a></li>
      --}}

      <li><a href="{{route('quotation/create-input')}}"><i class="fa fa-circle-o"></i>見積り作成</a></li>

      {{--
      <li class="header">LABELS</li>
      <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
      --}}
    </ul>
  </section>
</aside><!-- end sidebar -->
