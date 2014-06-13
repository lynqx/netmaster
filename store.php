
	<?php	
	
	
	
		// Check for a valid image ID, through GET or POST:
 if ( (isset($_GET['cat'])) && (is_numeric ($_GET['cat'])) ) { // From view_users.php
$cat_id = $_GET['cat'];
} elseif ( (isset($_POST['cat'])) && (is_numeric($_POST['cat'])) ) { // Form submission.
$cat_id = $_POST['cat'];
								
	} else { // No valid ID, kill the script.
			// Redirect:
			$redirect = 'category.php';
			header("location: $redirect");
					exit();
	}
								// require db connection for page title
								
								require_once ('init_connect.php');
											
								$query = "SELECT * FROM  `category`
								WHERE category_id='$cat_id'";
								$result = mysqli_query ($conn, $query);
								$cat = mysqli_fetch_array($result, MYSQLI_ASSOC);
								
								// include header
								$page_title=$cat['category_name'];
								include ('partials/header.php'); 
			?>
		<!-- STORE UNIT -->
		<!-- START TOP CATEGORY LINK-->
							<div class="divide60"></div>
								<h2 class="text-center">
								<span class="bigintro">ALL CATEGORIES</span><br /><br />
								</h2>
					<div class="row">
						<div class="col-md-6 col-md-offset-3">
							<div id="" class="text-center btn-group">
								<div  class="hidden-xs">
	<?php 
								$q = "SELECT DISTINCT category_id, category_name, filter FROM `category`
								JOIN items ON items.category = category.category_id";
								$r = mysqli_query ($conn, $q); 
								while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	?>

								  	<a class="btn btn-lg btn-danger" href="store.php?cat=<?php echo $row['category_id']; ?>" style="color:#fff;">
								  	<?php echo $row['category_name']; ?>
								  	</a>
<?php } ?>
								  </div>						
							</div>
						</div>
					</div>
					
					<!-- END TOP CATEGORY LINK-->
		<section id="portfolio" class="color-light text-center">			
				<div class="divide40"></div>
					<div class="row">
						
						<div class="col-md-12">
								<h2 class="text-center">
								<?php
								$query = "SELECT * FROM  `category`
								WHERE category_id='$cat_id'";
								$result = mysqli_query ($conn, $query);
								$category = mysqli_fetch_array($result, MYSQLI_ASSOC);
								echo '<span class="bigintro">' . $category['category_name'] . '</span><br /><br />
								<h5 class="smallintro">' . $category['category_desc'] . '</h5></h2>';
								?>
						</div>
					</div>

				<div class="divide40"></div>
					<div class="container">
						<div id="filter-items" class="row">
				<?php 
								$q2 = "SELECT * FROM  `items`
								JOIN category ON category.category_id = items.category
								WHERE items.category = '$cat_id'";
								$r2 = mysqli_query ($conn, $q2); 
								while ($item= mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
				?>
							<div class="col xs-12 col-sm-4 <?php echo $item{'filter'};?> item">
								<div class="filter-content">
									<a href="img/product/<?php echo $item{'image'};?>" class="btn btn-sm btn-warning colorbox-button">
										<img src="img/product/<?php echo $item{'image'};?>" alt="" class="img-responsive" />
										</a>
									<div class="image-content">
										<h4><?php echo $item{'item_name'}; ?></h4>
										<p class="hidden-xs hidden-sm"> NGN
											<?php echo $item{'price'}; ?>
										</p>
										<a href="product.php?prod=<?php echo $item{'item_id'}; ?> " class="btn btn-sm btn-warning">
											Add to Cart</a>
									</div>
								</div>
							</div>
							
							<?php } ?>
							
						</div>
					</div>
					<div class="divide60"></div>
		</section>
		<!--/PORTFOLIO UNIT  -->
		
		
		<?php // include footer 
		include ('partials/footer.php'); 
		?>
