<!DOCTYPE html>
<html>
  <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dark Bootstrap Admin </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="admin/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="admin/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="admin/css/font.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="admin/css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="admin/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="admin/img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <header class="header">   
  <nav class="navbar navbar-expand-lg">
    <div class="search-panel">
      <div class="search-inner d-flex align-items-center justify-content-center">
        <div class="close-btn">Close <i class="fa fa-close"></i></div>
        <form id="searchForm" action="#">
          <div class="form-group">
            <input type="search" name="search" placeholder="What are you searching for...">
            <button type="submit" class="submit">Search</button>
          </div>
        </form>
      </div>
    </div>

    <div class="container-fluid d-flex align-items-center justify-content-between">
      <div class="navbar-header">
        <a href="{{ url('admin/dashboard') }}" class="navbar-brand">
          <div class="brand-text brand-big visible text-uppercase">
            <strong class="text-primary">Dark</strong><strong>Admin</strong>
          </div>
          <div class="brand-text brand-sm">
            <strong class="text-primary">D</strong><strong>A</strong>
          </div>
        </a>
        <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
      </div>

      <div class="right-menu list-inline no-margin-bottom">    
        <div class="list-inline-item">
            <a href="#" class="search-open nav-link"><i class="icon-magnifying-glass-browser"></i></a>
        </div>

        <div class="list-inline-item dropdown">
            <a id="navbarDropdownMenuLink1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link messages-toggle">
                <i class="icon-email"></i>
                <span class="badge dashbg-1">{{ $messageCount }}</span>
            </a>

            <div aria-labelledby="navbarDropdownMenuLink1" class="dropdown-menu messages dropdown-menu-right">
                @forelse($recentMessages as $msg)
                    <a href="{{ route('admin.messages') }}" class="dropdown-item message d-flex align-items-center">
                        <div class="profile">
                            <img src="{{ asset('admin/img/avatar-3.jpg') }}" alt="..." class="img-fluid">
                            <div class="status online"></div>
                        </div>
                        <div class="content">   
                            <strong class="d-block">{{ $msg->name }}</strong>
                            <span class="d-block text-muted small">{{ Str::limit($msg->message, 30) }}</span>
                            <small class="date d-block">{{ $msg->created_at->diffForHumans() }}</small>
                        </div>
                    </a>
                @empty
                    <div class="dropdown-item text-center small text-gray-500">No new messages</div>
                @endforelse

                <a href="{{ route('admin.messages') }}" class="dropdown-item text-center message"> 
                    <strong>See All Messages <i class="fa fa-angle-right"></i></strong>
                </a>
            </div>
        </div>

        <div class="list-inline-item logout">
            <a id="logout" href="#" class="nav-link"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                 Logout <i class="icon-logout"></i>
            </a>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                @csrf
            </form>
        </div>
      </div>
    </div>
  </nav>
</header>
    <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      <nav id="sidebar">
        <!-- Sidebar Header-->
        <!-- Sidebar Header -->
@auth
<div class="sidebar-header d-flex align-items-center">
    <div class="avatar">
        <img src="{{ asset(auth()->user()->avatar_path ?? 'admin/img/avatar-6.jpg') }}" 
             alt="{{ auth()->user()->name }}" 
             class="img-fluid rounded-circle">
    </div>
    
    <div class="title">
        <h1 class="h5">{{ auth()->user()->name }}</h1>
        <p>{{ auth()->user()->role ?? 'Admin' }}</p>
    </div>
</div>
@endauth
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
                <li class="active"><a href="{{ route('admin.dashboard') }}"> <i class="icon-home"></i>Home </a></li>
                <li><a href="{{ route('admin.category') }}"> <i class="icon-grid"></i>Category </a></li>
                 <li><a href="{{ route('admin.Viewcategory') }}"> <i class="icon-grid"></i>View Categories </a></li>
                
                
                <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Products</a>
                  <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                    <li><a href="{{ route('admin.addproduct') }}">Add product</a></li>
                    <li><a href="{{ route('admin.viewproduct') }}">View product</a></li>
                    <li><a href="{{ route('admin.vieworders')}}">View orders</a></li>
                  </ul>
                </li>
                
    
      </nav>
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Dashboard</h2>
          </div>
        </div>
        <section class="no-padding-top no-padding-bottom">
          @yield('content')
          
        </section>
                     
          <div class="container-fluid">
            <div class="row">
           
              
        <footer class="footer">
          <div class="footer__block block no-margin-bottom">
            <div class="container-fluid text-center">
              <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
               <p class="no-margin-bottom">2026 &copy; Sunivil de hero. Download From <a target="_blank" href="https://templateshub.net">Templates Hub</a>.</p>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="admin/vendor/jquery/jquery.min.js"></script>
    <script src="admin/vendor/popper.js/umd/popper.min.js"> </script>
    <script src="admin/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="admin/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="admin/vendor/chart.js/Chart.min.js"></script>
    <script src="admin/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="admin/js/charts-home.js"></script>
    <script src="admin/js/front.js"></script>
  </body>
</html>