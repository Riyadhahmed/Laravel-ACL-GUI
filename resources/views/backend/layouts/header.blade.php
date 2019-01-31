<nav class="navbar navbar-static-top">
    <div class="navbar-header">
        <div class="col-md-3">
            <a href="{{ URL :: to('/home') }}" style="text-decoration: none; color: #fff;">
                <img class="gov_logo" src="{{ asset('/assets/images/laravel.png') }}"/>
            </a>
        </div>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse pull-left topnav" id="navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="treeview">
                <a href="{{ URL :: to('/home') }}">
                    <span> Dashboard </span>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Users <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li class="treeview">
                        <a href="{{ URL :: to('/admin/users') }}">
                            <span> Users </span>
                        </a>
                        <a href="{{ URL :: to('/admin/permissions') }}">
                            <span> Permissions </span>
                        </a>
                        <a href="{{ URL :: to('/admin/roles') }}">
                            <span> Roles </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="{{ URL :: to('/admin/divisions') }}">
                    <span> Divisions </span>
                </a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"> </i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a>{{ Auth::user()->name }}</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.navbar-custom-menu -->
</nav>
<script type="text/javascript">
    $(document).ready(function () {
        $('.nav li').each(function () {
            if (window.location.href.indexOf($(this).find('a:first').attr('href')) > -1) {
                $(this).find('a').addClass('active');
                $(this).siblings('li').find('a').removeClass('active');
            }
        });
        $('.dropdown .dropdown-menu li').each(function () {
            if (window.location.href.indexOf($(this).find('a:first').attr('href')) > -1) {
                $(this).closest('ul').closest('li').attr('class', 'active');
                $('.nav li a').removeClass('active');
                $(this).addClass('active').siblings().removeClass('active');
            }
        });
    });
</script>
