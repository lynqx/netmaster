		<?php // include the header 
		$page_title = "My Cart";
		include ('partials/header.php'); 
		?>
	
	<?php	
		if (isset($_POST['item'])) {
$_SESSION['itemid'] = $_POST['item'];
	} else { $_POST['item'] = ""; }
	
		if (isset($_POST['price'])) {
$_SESSION['price'] = $_POST['price'];
		} else { $_POST['price'] = ""; }
			
		if (isset($_POST['quantity'])) {
$_SESSION['quantity'] = $_POST['quantity'];
	} else { $_POST['item'] = ""; }

$_SESSION['redirect'] = 'mycart.php';

if (isset($_SESSION['customer_id'])){

}else{
// Redirect:
$redirect = 'login.php';
header("location: $redirect");
		exit();
}

$user = $_SESSION['customer_id'];

if (isset($_SESSION['itemid'])) {
$itemid = $_SESSION['itemid'];
} else {$itemid =""; }

if (isset($_SESSION['quantity'])) {
$qty = $_SESSION['quantity'];
} else { $qty =""; }

if (isset($_SESSION['price'])) {
$price = $_SESSION['price'];
} else { $price = ""; }

// Add the order to the database:
if ($user && $itemid && $qty && $price) { // everything is set and OK!
$q = "INSERT INTO cart (customer_id, item_id, quantity, price, date) VALUES ('$user', '$itemid', '$qty', '$price', NOW())";
$r = mysqli_query ($conn, $q);

if (mysqli_affected_rows($conn) == 1) {
	
	// unset session
	$_SESSION['itemid'] ="";
	$_SESSION['quantity'] ="";
	$_SESSION['price'] = "";
	// Finish the page:
					 //Set display property and confirmation message of the message container to 'block'
					$success_display = 'block';
					$success_msg = '<h4 style="color: #008080"> SUCCESS! Product added successful.</h4>';
					
					} else { // db error.
						$err_msg = 'Product could not be added due to a system error. We apologize for any inconvenience</p>';
					}
}

?>
		<!-- STORE UNIT -->
		<!-- START TOP CATEGORY LINK-->
							<div class="divide60"></div>
							<div class="row">
						<div class="col-md-6 col-md-offset-3">
								<h2 class="text-center">
								<span class="bigintro">CART DETAIL</span><br /><br />
								</h2>
								
								<div class="box-body">
									
									<?php // block to output success message	
								if (isset($_GET['success'])) 
									{
										$success_msg = 'Item removed successfully';
									}
						
								if (isset($_GET['error'])) 
									{
										$err_msg = 'Ooops: The item was not removed';
									}
									
									 // block to output success message	
											   	if(!empty($success_msg)) {
												echo '<div class="alert alert-block alert-success fade in">
														<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
														<p><h4><i class="fa fa-check"></i> Successful!</h4>' . $success_msg . '</p></div>';
													}
												?>
												
												<?php // block to output success message	
											   	if(!empty($err_msg)) {
												echo '<div class="alert alert-block alert-danger fade in">
														<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
														<p><h4><i class="fa fa-asterisk"></i> Error!</h4>' . $err_msg . '</p></div>';
													}
												?>
												</div>
												

					<!-- END TOP CATEGORY LINK-->
		<section id="portfolio" class="color-light text-center">			
				<div class="divide40"></div>
					<div class="row">
												<div class="col-md-12">

						<!-- BOX -->
								<div class="box border purple">
									
									<div class="box-body">
										<table id="datatable2" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<th>Item Name</th>
													<th class="hidden-xs">Price</th>
													<th>Quantity</th>
													<th class="hidden-xs">Total</th>
													<th class="hidden-xs">Remove</th>

												</tr>
											</thead>
											<tbody>
									<?php 
									$q = "SELECT * FROM  `cart` 
									JOIN items ON items.item_id = cart.item_id
									WHERE cart.customer_id = '$user'"; 
									$r = @mysqli_query ($conn, $q);
									
									$sub_total = array();
									$cartid = "";		//string containing the concatenated cart ids.
									
									while ($cart = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
										$id = $cart['cart_id']; 
										$total =  $cart['quantity'] * $cart['price'];
										array_push($sub_total, $total);
										$cartid .= $cart['cart_id'].",";	//comma-separated values
									?>
												<tr class="gradeX">
													<td><?php echo $cart['item_name']; ?></td>
													<td> <?php echo ucwords($cart['price']); ?>.00</td>
													<td> <?php echo ucwords($cart['quantity']); ?></td>
													<td> <?php echo $total; ?></td>
												   <td align="center"> 
												
													<a href="delete_cart.php?id=<?php echo urlencode($id); ?>" onclick="return confirm('Are you sure you want to remove this item ?')">
														<button class="btn btn-danger" title="DELETE">
														<i class="fa fa-times"></i></button></a>
												</td>

													
												</tr>
									<?php } 
									
									$amt = array_sum($sub_total);
									
									?>
												
											</tbody>
											
											<tfoot>										
												<tr>
													<th colspan="3">Total Estimated</th>
													<th colspan="2"> &#8358; <?php echo $amt; ?></th>
												</tr>
											</tfoot>
											
										</table>
										<form action="checkout.php" method="POST">
											<button type="submit" name="proceed2checkout" value="<?php echo $cartid; ?>" class="btn btn-success" >Set My Delivery Preference &raquo;</button>
										</form>
										
							
								<!-- /BOX -->
								</div>
								</div>
								</div>
								</div>
						</div>
					</div>
					<div class="divide60"></div>
		</section>
		<!--/PORTFOLIO UNIT  -->
		
		
		<?php // include footer 
		include ('partials/footer.php'); 
		?>
