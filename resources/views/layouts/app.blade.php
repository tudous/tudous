<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'TudousClub') - {{ setting('site_name', 'tudous club') }}</title>
    <meta name="description" content="@yield('description', setting('seo_description', 'tudous'))" />
    <meta name="keyword" content="@yield('keyword', setting('seo_keyword', 'tudous,'))" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
   

   
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{url('/')}}">
                        <strong>TudousClub</strong>
                    </a>
                    
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="{{ active_class(if_route('topics.index')) }}"><a href="{{ route('topics.index') }}">话题</a></li>
                        <li class="{{ active_class((if_route('categories.show')&&if_route_param('category','1'))) }}"><a href="{{ route('categories.show', 1) }}">分享</a></li>
                        <li class="{{ active_class((if_route('categories.show')&&if_route_param('category','2'))) }}"><a href="{{ route('categories.show', 2) }}">随笔</a></li>
                        <li class="{{ active_class((if_route('categories.show')&&if_route_param('category','3'))) }}"><a href="{{ route('categories.show', 3) }}">搬砖</a></li>
                        <li class="{{ active_class((if_route('categories.show')&&if_route_param('category','4'))) }}"><a href="{{ route('categories.show', 4) }}">公告</a></li>
                    </ul>
                    
                    <ul class="nav navbar-nav" style="margin:7px 0px 0px 200px;">
                        <form class="form-inline"  role="form" action="{{route('search')}}" method="get">
                        <input style="width:200px;height:35px;" class="b-search-text" type="text" name="wd">
                        <span onclick="parentNode.submit()" class="glyphicon glyphicon-search" aria-hidden="true">
                        <!-- <input class="glyphicon glyphicon-search" type="submit" value=""> -->
                        </form>
                    </ul>
                    


                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">登陆</a></li>
                            <li><a href="{{ route('register') }}">注册</a></li>
                        @else
                        <li>
                        <a href="{{ route('topics.create') }}">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </a>
                        </li>

                         {{-- 消息通知标记 --}}
                        <li>
                            <a href="{{ route('notifications.index') }}" class="notifications-badge" style="margin-top: -2px;">
                                <span class="badge badge-{{ Auth::user()->notification_count > 0 ? 'hint' : 'fade' }} " title="消息提醒">
                                    {{ Auth::user()->notification_count }}
                                </span>
                            </a>
                        </li>

                            <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="user-avatar pull-left" style="margin-right:8px; margin-top:-5px;">
                                    <img src="{{Auth::user()->avatar}}" class="img-responsive img-circle" width="30px" height="30px">
                                </span>
                                {{ Auth::user()->name }} <span class="caret"></span>
                             </a>
                               <!--  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a> -->

                                <ul class="dropdown-menu">
                                @can('manage_contents')
                                <li>
                                    <a href="{{ url(config('administrator.uri')) }}">
                                        管理后台
                                    </a>
                                </li>
                                @endcan
                                    <li>
                                    <a href="{{ route('users.show',Auth::id()) }}">个人中心</a>
                                    </li>
                                     <li>
                                    <a href="{{ route('users.edit',Auth::id()) }}">编辑资料</a>
                                    </li>
                                        
                                   <li>
                                   <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    退出登录
                                     </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            @include('layouts._message')
            @yield('content')

        </div>
        

       
    </div>

     <footer class="footer">
        <div class="container">
            <p class="pull-left">
                <a href="" target="_blank">tusous</a>  <span style="color: #e27575;font-size: 14px;">❤</span>
            </p>

            <p class="pull-right"><a href="mailto:{{ setting('contact_email') }}">联系我</a></p>
        </div>
        </footer>
    @if (app()->isLocal())
        @include('sudosu::user-selector')
    @endif
    <!-- Scripts -->
   <!--  <script src="{{ asset('js/app.js') }}"></script> -->
    <script src="http://code.jquery.com/jquery.js"></script>
   <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
   @yield('scripts')
  
</body>
</html>
