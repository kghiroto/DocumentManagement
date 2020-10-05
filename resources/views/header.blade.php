<!-- トップメニュー -->
<header class="main-header">
  <nav class="navbar navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <a href="{{route('dashboard')}}" class="navbar-brand"><b>{{config("app.name")}}</b></a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
          <i class="fa fa-bars"></i>
        </button>
      </div>
      <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a href="{{route('dashboard')}}">ダッシュボード <span class="sr-only">(current)</span></a></li>
          <li><a href="{{route('quotation/create-input')}}">新規作成 <span class="sr-only">(current)</span></a></li>
          {{--
          <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
          <li><a href="#">Link</a></li>
          --}}
          <li><a href="{{route('quotation/list')}}">案件一覧</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">顧客 <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="{{route('customer/list')}}">顧客一覧</a></li>
              <li class="divider"></li>
              <li><a href="{{route('customer/create-input')}}">顧客登録</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('image/icon_admin.jpeg') }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('image/icon_admin.jpeg') }}" class="img-circle" alt="User Image">
                <p>
                  {{ Auth::user()->name }}
                  <small></small>
                </p>
              </li>
              <!-- Menu Body -->
              {{--
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              --}}
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  {{--<a href="#" class="btn btn-default btn-flat">Profile</a>--}}
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Logout</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>

{{--
<header class="main-header">

    <!-- ロゴ -->
    <a href="" class="logo">{{config("app.name")}}</a>

    <!-- トップメニュー -->
    <nav class="navbar navbar-static-top" role="navigation">

        <ul class="nav navbar-nav">
            <li><a href="">XXXXXXX</a></li>
        </ul>
		<!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @if (Auth::guest())
                <li><a href="{{ route('login') }}">Login</a></li>
            @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>

</header><!-- end header -->
--}}
