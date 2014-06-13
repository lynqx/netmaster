<?php
ob_start();
session_start();
if (isset($_SESSION['user_id'])) {

}else{
// Redirect:
$redirect = 'index.php';
header("location: $redirect");
		exit();
}

require_once ('../init_connect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title><?php if (!isset($page_title)) {$page_title = 'Administrator'; }
		echo $page_title . " || Shopping Cart"; 
		?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
		<!-- STYLESHEETS --><!--[if lt IE 9]><script src="../js/flot/excanvas.min.js"></script><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
			
		</script><script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script><![endif]-->
	<link rel="stylesheet" type="text/css" href="../css/cloud-admin-frontend.css" >
	<link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- ANIMATE -->
    <link href="../css/amimatecss/animate.min.css" rel="stylesheet">
	<!-- COLORBOX -->
	<link rel="stylesheet" type="text/css" href="../js/colorbox/colorbox.min.css" />
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
							<a href="index.html"><img src="../img/logo/logo.png" height="40" alt="logo name"/></a>
						</div>
					</div>
					<div class="col-sm-9 col-md-8">
						<nav id="fixed-top-navigation">
							<ul class="list-inline pull-right">
								<li><a href="dashboard.php" class="external">Dashboard</a></li>
								<li><a href="add_category.php" class="external">Category</a></li>
								<li><a href="add_product.php" class="external" onclick="show_notification();"> 
									Products
																		
									<?php
									$q = "SELECT item_id, item_name, quantity FROM `items`
									WHERE quantity < 10";
									$r = mysqli_query ($conn, $q);
									$county = mysqli_num_rows($r);
									echo '<span class="badge">' . $county . '</span>';
									
									?>
									</a>
									
									<?php 
									echo '<div id="hidden_div" style="display:none"><ul>';
									while ($not = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
										echo '<li>' . $not['item_name'] . '&nbsp;<span class="badge">' . $not['quantity'] . '</span></li>';
										}
										echo '</ul></div>';
									?>
								</li>
								<li><a href="manufacturer.php" class="external">Manufacturer</a></li>
								<li><a href="orders.php" class="external">Sales</a></li>
								<li><a href="order_report.php" class="external">Report</a></li>
								<li><a href="../index.php" class="external">Store Front</a></li>
								<li><a href="logout.php" class="external">Logout</a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
		<!--/NAV-BAR -->
	<script type="text/javascript">
	
		function show_notification() {
			
			var elem = document.getElementById('hidden_div');

			if(elem.style.display=='none')
			{
				elem.style.display = 'block';
			}
			else
			{
				elem.style.display = 'none';
			}
</script>