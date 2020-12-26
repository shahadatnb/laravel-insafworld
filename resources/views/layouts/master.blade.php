<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ config('app.name') }}</title>
	<meta name="description" content="Ela Admin - HTML5 Admin Template">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="{{url('/public/admin')}}/assets/css/cs-skin-elastic.css">
	<link rel="stylesheet" href="{{url('/public/admin')}}/assets/css/style.css"> 
	
	<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
	<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
	@yield('stylesheet')
	<style>
		*{font-weight: bold;}
		.dash-profile {
			padding: 10px;
			display: block;
			font-weight: bold;
		}

		.dash-profile img.user-avatar.rounded-circle {
			max-width: 60px;
		}
		.right-panel header.header {
			height: auto;
		}
	  .nav.navbar-nav.navbar-right li a {
		  color: #0e61e4;
	  }
	  .nav.navbar-nav.navbar-right li a:hover,.navbar .navbar-nav li > a:hover {
		  color: #1cc107;
	  }
	  .navbar .navbar-nav li > a {
			color: #000;
		  font-weight: bold;
		}
	  .navbar .navbar-nav li > a .menu-icon {
		color: #f70018;
		font-size:20px;
	  }
	  .navbar .menu-title {
		color: #749715;
	  }
	  .navbar .navbar-nav li.menu-item-has-children .sub-menu {
			padding: 0 0 0 10px;
			border: 2px solid #ddd;
		}
		.stat-widget-five .stat-content {
			margin-left: 75px !important;
		}
		a.navbar-brand {
		    color: #fff;
		    font-weight: bold;
		}
		.stat-widget-one .stat-content {
			margin-left: 5px;
		}
		.right-panel {
			background-image: url({{url('public/admin/images/bg.jpg')}});
		}
		.right-panel .breadcrumbs {
			margin-top: 0;
		}
		.bg-flat-color-1 {
			background: #30c200;
		}
		.bg-flat-color-2 {
			background: #71eabe;
		}
		.bg-flat-color-6 {
			background: #ffc107;
		}
		.bg-flat-color-4 {
			background: #ea0c0c;
		}

		.stat-widget-one .stat-digit {
			color: #f8f9fa;
			font-weight: bold;
		}
		.stat-widget-one .stat-text {
			font-size: 15px;
			color: #f8f9fa;
			font-weight: bold;
		}
		.content {
			background: rgba(0,0,0,1);
			content: "";
			width: 100%;
			height: 100%;
			display: block;
		}

		.form-control {
    background: transparent;
    /*border: 2px dotted;*/
    border: 0;
			border-bottom: 1px solid #f70018;
}

.btn-yellow, .bg-yellow {
  background: rgb(247, 255, 71);
  color: #000;
  font-weight: bold;
  -moz-box-shadow: none !important;
  -webkit-box-shadow: none !important;
  box-shadow: none !important;
}
.btn-yellow:hover, .btn-yellow:focus {
  background: rgb(205, 213, 32);
}
.btn-yellow:active {
  background: rgb(205, 213, 32);
}
	</style>
</head>

<body>
	<!-- Left Panel -->
	<aside id="left-panel" class="left-panel">
		<nav class="navbar navbar-expand-sm">{{-- navbar-default --}}
				<a href="{{ url('/profile')}}" class="dash-profile text-center">
					@if(Auth::user()->photo != null )
						<img src="{{ url('/')}}/public/upload/member/{{ Auth::user()->photo }}" class="user-avatar rounded-circle" alt="">
					@else
						<img class="user-avatar rounded-circle" src="{{ url('/')}}/public/admin/images/avatar.png">
					@endif
					&nbsp; {{Auth::user()->name}}
				</a>
			<div id="main-menu" class="main-menu collapse navbar-collapse">
				<ul class="nav navbar-nav">
				@if(Auth::user()->admin==1)
					<li class="menu-title">Admin</li><!-- /.menu-title -->
					<li>
						<a href="{{url('/admin-panel')}}"><i class="menu-icon fa fa-laptop"></i>Admin Dashboard </a>
					</li>
					<li>
						<a href="{{url('/sendMoney')}}"><i class="menu-icon fa fa-money"></i>Send Money </a>
					</li>
					<li>
						<a href="{{url('/withdrawWetting')}}"><i class="menu-icon fa fa-money"></i>Withdraw Money </a>
					</li>
					<li>
						<a href="{{url('/packs')}}"><i class="menu-icon fa fa-user"></i>Packege List </a>
					</li>
					<li>
						<a href="{{url('/allMemberList')}}"><i class="menu-icon fa fa-user"></i>Member List </a>
					</li>
					<li class="menu-item-has-children dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>VIP Info</a>
						<ul class="sub-menu children dropdown-menu bg-transparent">
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/products')}}">All List</a></li>
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/products/create')}}">Add New</a></li>
						</ul>
					</li>
					{{-- <li>
						<a href="{{url('/youtubeLinks')}}"><i class="menu-icon fa fa-youtube"></i>Youtube </a>
					</li> --}}                    
					<li class="menu-title">Member</li>
					@endif
					<li><a href="{{ url('/home')}}"><i class="menu-icon fa fa-laptop"></i> Dashboard</a></li>
					<li class="menu-item-has-children dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users"></i>General</a>
						<ul class="sub-menu children dropdown-menu bg-transparent">
							<li><i class="menu-icon fa fa-user"></i><a href="{{url('/newMember')}}">New Member </a></li>							
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/rankList')}}"> Rank Info</a></li>
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/vipInfoList')}}"> Global Info</a></li>
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/level')}}"> Generation Chart</a></li>
							{{-- <li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/matchinList')}}"> Matching Info</a></li> --}}
						</ul>
					</li>
					<li class="menu-item-has-children dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Transactions</a>
						<ul class="sub-menu children dropdown-menu bg-transparent">
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/withdrawWallet')}}">Main Wallet</a></li>
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/myWallet/registerWallet')}}">Balance Transfer</a></li>
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/myWallet/referralWallet')}}">Referral Income Report</a></li>
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/myWallet/generationWallet')}}">Generation Income Report</a></li>
							{{-- <li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/myWallet/matchingWallet')}}">Matching Income Report</a></li> --}}
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/myWallet/dailyWallet')}}">Daily Income Report</a></li>
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/myWallet/globalIncome')}}"> Global Income Report</a></li>
							
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/myWallet/rankWallet')}}"> Rank Income Report</a></li>
						</ul>
					</li>
					<li class="menu-item-has-children dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-users"></i>Profile</a>
						<ul class="sub-menu children dropdown-menu bg-transparent">
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/changePass')}}">Change Password</a></li>
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/editProfile')}}">Change Image</a></li>
							{{-- <li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/editProfile')}}">Change TRX-PIN</a></li> --}}
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/profile')}}">My Profile</a></li>
						</ul>
					</li>
					<li class="menu-item-has-children dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Network</a>
						<ul class="sub-menu children dropdown-menu bg-transparent">
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/levelTree')}}">Downline Network</a></li>
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/mySponsor')}}">My Sponsored Records</a></li>
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/vipMembers')}}">VIP Member</a></li>
						</ul>
					</li>
					{{-- <li class="menu-item-has-children dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Wallat</a>
						<ul class="sub-menu children dropdown-menu bg-transparent">
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/myWallet/withdrawWallet')}}">Withdraw wallet</a></li>
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/myWallet/registerWallet')}}">Register wallet</a></li>
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/myWallet/sponsorWallet')}}">Sponsor wallet</a></li>
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/myWallet/selfWallet')}}">Generation income wallet</a></li>
							<li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ url('/youtubeWallet')}}">Youtube wallet</a></li>
						</ul>
					</li> --}}
					{{-- <li>
						<a href="{{ url('/youtubeClick') }}"> <i class="menu-icon ti-youtube"></i>Youtube Click</a>
					</li> --}}
					<li>
						<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="menu-icon ti-power-off"></i>Log out </a>
					</li>
					
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>
	</aside>
	<!-- /#left-panel -->
	<!-- Right Panel -->
	<div id="right-panel" class="right-panel bg-dark">
		<!-- Header-->
		<header id="header" class="header bg-primary">
			<div class="top-left bg-primary">
				<div class="navbar-header bg-primary">
					<a class="navbar-brand" href="{{url('/home')}}">{{ config('app.name') }}</a>
					<a class="navbar-brand hidden" href="{{url('/home')}}">{{ config('app.name') }}</a>
					<a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
				</div>
			</div>
			<div class="top-right d-none d-sm-block">
				<div class="header-menu">
					<div class="header-left">
					</div>

					<div class="user-area dropdown float-right">
						<a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							@if(Auth::user()->photo != null )
							  <img src="{{ url('/')}}/public/upload/member/{{ Auth::user()->photo }}" class="user-avatar rounded-circle" alt="">
							@else
							  <img class="user-avatar rounded-circle" src="{{ url('/')}}/public/admin/images/avatar.png">
							@endif
							&nbsp; {{Auth::user()->name}}
						</a>

						<div class="user-menu dropdown-menu">
							<a class="nav-link" href="{{ url('/profile')}}"><i class="fa fa- user"></i>My Profile</a>

							<a class="nav-link" href="#"><i class="fa fa- user"></i>{{Auth::user()->username}}</a>

							<a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" ><i class="fa fa-power -off"></i>Logout</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					  {{ csrf_field() }}
				  </form>
						</div>
					</div>

				</div>
			</div>
		</header>
		<!-- /#header -->
		<!-- Breadcrumbs-->
		@if(View::hasSection('title'))
		<div class="breadcrumbs">
			<div class="breadcrumbs-inner">
				<div class="row m-0">
					<div class="col-sm-4">
						<div class="page-header float-left">
							<div class="page-title">
								<h1>@yield('title')</h1>
							</div>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="page-header float-right">
							<div class="page-title">
								<ol class="breadcrumb text-right">
									<li><a href="{{url('/home')}}">Home</a></li>
									<li class="active">@yield('title')</li>
								</ol>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif
		<!-- /.breadcrumbs-->
		<!-- Content -->
		<div class="content">
			<!-- Animated -->
			<div class="animated fadeIn">
				@yield('content')
			</div>
			<!-- .animated -->
		</div>
		<!-- /.content -->
		<div class="clearfix"></div>
		<!-- Footer -->
		{{-- <footer class="site-footer">
			<div class="footer-inner bg-white">
				<div class="row">
					<div class="col-sm-6">
						Copyright &copy; 2020 {{ config('app.name', 'Laravel') }}
					</div>
				</div>
			</div>
		</footer> --}}
		<!-- /.site-footer -->
	</div>
	<!-- /#right-panel -->

	<!-- Scripts -->
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<script src="{{url('/public/admin')}}/assets/js/main.js"></script>
	<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
	@yield('scripts')
</body>
</html>
