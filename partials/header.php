<?php
ob_start();
session_start();
require_once ('init_connect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>
		<?php if (!isset($page_title)) {$page_title = 'Administrator'; }
		echo $page_title . " || Shopping Cart"; 
		?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
		<!-- STYLESHEETS --><!--[if lt IE 9]><script src="../js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
	<link rel="stylesheet" type="text/css" href="css/cloud-admin-frontend.css" >
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- ANIMATE -->
    <link href="css/amimatecss/animate.min.css" rel="stylesheet">
	<!-- COLORBOX -->
	<link rel="stylesheet" type="text/css" href="js/colorbox/colorbox.min.css" />
	<!-- CAROUSEL -->
    <link href="css/carousel.css" rel="stylesheet">
	<!-- FONTS -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/flexslider.css" type="text/css" />
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
</head>
<body>
	
<!-- PAGE -->
	<div id="page">
	
		<!-- NAV-BAR -->
		<div id="nav-bar">
			<div class="container">
				<div class="row">
					<div class="col-sm-3 col-md-4">
						<div class="logo" >
							<a href="index.html"><img src="img/logo/logo.png" height="40" alt="logo name"/></a>
						</div>
					</div>
					<div class="col-sm-9 col-md-8">
						<nav id="fixed-top-navigation">
							<ul class="list-inline pull-right">
								<li><a href="index.php" class="external">Home</a></li>
								<li><a href="category.php" class="external">Products</a></li>
								<li><a href="about.php" class="external">About</a></li>
								<li><a href="contact.php" class="external">Contact</a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
		<!--/NAV-BAR -->
		<div id ="user-bar">
			<div class="container">
				<div class="row">
					<div class="col-sm-3 col-md-4">
						<div class="logo" >
							<ul class="list-inline pull-left">
							<?php
							//confirm if customer is NOT logged in
							if(!isset($_SESSION['customer_id'])) 
							{ 								
							?>
								<li><a href="login.php"><i class="fa fa-unlock"></i> &nbsp;Login</a></li>
								<li><a href="login.php?action=register"><i class="fa fa-user"></i> &nbsp;Register</a></li>
							
							<?php 
							} 
							else 
							{ 
								//show 'logout' link
							?>
								
								<span style="color: #efefef; ">You are logged in as <b><?php echo $_SESSION['email']; ?></b></span>
								<li><a href="profile.php?action=logout"><i class="fa fa-unlock"></i> &nbsp;Logout</a></li>
							<?php
							} 
							?>
							</ul>
						</div>
					</div>
					
					
					<div class="col-sm-9 col-md-8">
						<nav id="fixed-top-navigation">
							<ul class="list-inline pull-right">
<li><a href="mycart.php" class="external"> <i class="fa fa-shopping-cart"></i> &nbsp;Cart &nbsp;
									<span class="badge badge-orange">
										<?php 
										if(isset($_SESSION['customer_id']))
										$user = $_SESSION['customer_id'];
										else
										$user = "";
									$q = "SELECT * FROM  `cart` 
											WHERE customer_id = '$user'"; 
									$r = @mysqli_query ($conn, $q);
									$numberOfRows = MYSQLI_NUM_ROWS($r);
									echo $numberOfRows;
									?>
									</span></a></li>								
								<li><a href="profile.php" class="external"> <i class="fa fa-wrench"></i> &nbsp;My Account</a></li>
							</ul>
						</nav>
					</div>
					
					
				</div>
				</div>
			</div>