	<?php	
		// Check for a valid image ID, through GET or POST:
 if ( (isset($_GET['prod'])) && (is_numeric ($_GET['prod'])) ) { // From view_users.php
$prod_id = $_GET['prod'];
} elseif ( (isset($_POST['prod'])) && (is_numeric($_POST['prod'])) ) { // Form submission.
$prod_id = $_POST['prod'];
} else { // No valid ID, kill the script.
// Redirect:
$redirect = 'category.php';
header("location: $redirect");
		exit();
}


			// require db connection for page title
								
								require_once ('init_connect.php');
											
								$query = "SELECT * FROM  `items`
								WHERE item_id='$prod_id'";
								$result = mysqli_query ($conn, $query);
								$prod = mysqli_fetch_array($result, MYSQLI_ASSOC);
								
								// include header
								$page_title=$prod['item_name'];
								include ('partials/header.php'); 
								
?>
		<!-- STORE UNIT -->
		<section id="portfolio" class="color-light text-center">			
				<div class="divide40"></div>
					<div class="row">
						
						<div class="col-md-12">
								<h2 class="text-center">
								<?php
								$query = "SELECT * FROM  `items`
								WHERE item_id='$prod_id'";
								$result = mysqli_query ($conn, $query);
								$prod = mysqli_fetch_array($result, MYSQLI_ASSOC);
								echo '<span class="bigintro">' . $prod['item_name'] . '</span></h2>';
								?>
												<div class="divide20"></div>

								<div class="filter-content">
									<a href="img/product/<?php echo $prod{'image'};?>" class="btn btn-sm btn-warning colorbox-button">
										<img src="img/product/<?php echo $prod{'image'};?>" alt="" class="img-responsive" />
									</a>
								</div>
								
								<center>
								<div class="sidebar">
								<form action="mycart.php" method="post" >
                                <h4><span><b>Price: </b></span><b id="price_formatted">&#8358;<?php echo $prod['price']; ?>.00</b>
                                	<input type="hidden" name="item" value="<?php echo $prod['item_id']; ?>" />
                                	<input type="hidden" name="price" value="<?php echo $prod['price']; ?>" />
                                </h4>
                                    <a href="#" class="green-btn-small quantity-btn" onclick="quantity.value = (+quantity.value+1)||1;return false;">+</a>
                                    <input type="text" value="1" id="quantity" name="qty" class="quantity-input">
                                    <a href="#" class="green-btn-small quantity-btn" onclick="quantity.value = (quantity.value-1)||1;return false;">-</a>
                                    <input type="hidden" name="submitted" value="TRUE" />

								<input type="submit" class="btn btn-lg btn-primary" value="Add to cart" />
                                   
						</div>
						</center>
					</div>
					<div class="divide60"></div>
					</div>
		</section>
		<!--/PORTFOLIO UNIT  -->
		
		
		<?php // include footer 
		include ('partials/footer.php'); 
		?>
