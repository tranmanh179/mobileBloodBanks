<!doctype html>
<html class="fixed">

<head>
	<title>Login System</title>
	<!-- Basic -->
	<meta charset="UTF-8">
	<link rel="shortcut icon" href="http://bloodbanks.live/app/Plugin/bloodbanks/view/images/logo-Live-Blood-Bank.png" type="image/x-icon">
	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Web Fonts  -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/css/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/css/font-awesome.css" />
	<link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/css/magnific-popup.css" />
	<link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/css/datepicker3.css" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/css/theme.css" />

	<!-- Skin CSS -->
    <link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/css/default.css" />
    <link href="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/css/menu.css " rel="stylesheet"/>

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/css/theme-custom.css">

	<!-- Head Libs -->
	<script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/modernizr.js"></script>

	<meta name="description" content="Log in to the hospital blood inventory management system" />
	<meta name="keywords" content="" />  
	<meta property="og:title" content="Log in to the hospital blood inventory management system"/>
	<meta property="og:type" content="website"/>
	<meta property="og:description" content="Log in to the hospital blood inventory management system"/>
	<meta property="og:url" content="<?php echo $urlHomes;?>"/>
	<meta property="og:site_name" content="Log in to the hospital blood inventory management system"/>
	<meta property="og:image" content="http://www.hoanmydanang.com/upload/hoanmydanang.com/Hinh%20anh/Tin%20tuc/Tin%20Hoan%20My/Nh%C3%A2n%20vi%C3%AAn%20B%E1%BB%87nh%20Vi%E1%BB%87n%20Ho%C3%A0n%20M%E1%BB%B9%20%C4%90%C3%A0%20N%E1%BA%B5ng%20Hi%E1%BA%BFn%20M%C3%A1u%20Nh%C3%A2n%20%C4%90%E1%BA%A1o/nhan-vien-benh-vien-hoan-my-da-nang-hien-mau-nhan-dao.jpg" />
	<meta property="fb:admins" content="" />
	<meta property="fb:app_id" content="1695746487308818" /> 
	<meta property="og:image:width" content="900" />
	<meta property="og:image:height" content="603" />
</head>
<body>
	<style type="text/css" media="screen">
	.center-sign h3{
		color: #B02721;
		text-transform: uppercase;
		text-align: center;
		margin-bottom: 50px;
		text-shadow: 0 1px 0 rgba(255, 255, 255, 0.4);
		text-shadow: 
		1px 0px 1px #ccc, 0px 1px 1px #eee, 
		2px 1px 1px #ccc, 1px 2px 1px #eee,
		3px 2px 1px #ccc, 2px 3px 1px #eee,
		4px 3px 1px #ccc, 3px 4px 1px #eee,
		5px 4px 1px #ccc, 4px 5px 1px #eee,
		6px 5px 1px #ccc, 5px 6px 1px #eee,
		7px 6px 1px #ccc;
	}
	.body-sign .panel-sign{
		position: relative;
	}
	.logo_viettel {
		position: absolute;
		width: 150px;
	}
	@media screen and (max-width: 768px){

		.body-sign {
			height: 70vh;
			max-width: 600px;
		}
	}
	@media screen and (max-width: 600px){

		.body-sign {
			height: 100vh;
			max-width: 500px;
		}
	}
</style>
<!-- start: page -->
<section class="body-sign">
	<div class="center-sign">
		<h3 class="text-center">Mobile Blood Bank</h3>
		<div class="panel panel-sign">
			<div class="logo_viettel">
				<img src="http://bloodbanks.live/app/Plugin/bloodbanks/view/images/logo-Live-Blood-Bank.png" class="img-responsive" alt="" style="max-width: 65px;margin-top: -55px;">
			</div>
			<div class="panel-title-sign mt-xl text-right">
				<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Login</h2>
			</div>
			<div class="panel-body">
				<form action="" method="post">
					<?php
						if (isset($_GET['status']))
						switch ($_GET['status']) {
							case -1: echo '<p style="color: red;"><b>Wrong login information</b></p>';
							break;
							case -2: echo '<p style="color: red;"><b>Account is locked</b></p>';
							break;
						}
					?>
						
					<div class="form-group mb-lg">
						<label>Account</label>
						<div class="input-group input-group-icon">
							<input name="user" type="text" class="form-control input-lg" />
							<span class="input-group-addon">
								<span class="icon icon-lg">
									<i class="fa fa-user"></i>
								</span>
							</span>
						</div>
					</div>

					<div class="form-group mb-lg">
						<label class="pull-left">Password</label>
						<div class="input-group input-group-icon">
							<input name="password" type="password" class="form-control input-lg" />
							<span class="input-group-addon">
								<span class="icon icon-lg">
									<i class="fa fa-lock"></i>
								</span>
							</span>
						</div>                                
					</div>

					<div class="row form-group">
						<div class="col-sm-12 ">
							<div class=" text-left">                                    
								<a href="/forgetPassword" class="">Forgot password?</a>
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-sm-6">
							<button type="submit" class="btn btn-primary hidden-xs">Login</button>
							<button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Login</button>
						</div>
						
					</div>
					<br/>

                </form>
            </div>
        </div>

        <p class="text-center text-muted mt-md mb-md">Lao Cai High School for the Gifted</p>
    </div>
</section>
<!-- end: page -->

<!-- Vendor -->
<script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/jquery.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/jquery.browser.mobile.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/bootstrap.js"></script>
<!-- <script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/nanoscroller.js"></script> -->
<script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/magnific-popup.js"></script>
<script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/jquery.placeholder.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/theme.js"></script>

<!-- Theme Custom -->
<script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/theme.custom.js"></script>

<!-- Theme Initialization Files -->
<script src="<?php echo $urlHomes . 'app/Plugin/bloodbanks/view'; ?>/js/theme.init.js"></script>



</body>
</html>