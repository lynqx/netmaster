		<?php // include the header 
		$page_title = "My Cart";
		include ('partials/header.php'); 
		?>
	
	<?php	
	
	if (isset($_POST['submitted'])) {
	
		if (isset($_POST['item'])) {
$_SESSION['itemid'] = $_POST['item'];
	} else { $_POST['item'] = ""; }
	
		if (isset($_POST['price'])) {
$_SESSION['price'] = $_POST['price'];
		} else { $_POST['price'] = ""; }
			
		if (isset($_POST['qty'])) {
$_SESSION['quantity'] = $_POST['qty'];
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

// TODO: Check if the qty is lower than the qty in the item table
// check if item already exist in cart and add qty to qty selected
// to determine if qty selected + qy in cart is not greater than qty in store
				$q8 = "SELECT cart_id, item_id, quantity FROM cart 
				WHERE item_id='$itemid'
				AND customer_id='$user'";
				$r8 = mysqli_query ($conn, $q8) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
			if (mysqli_num_rows($r8) == 1) { // Available.
			// select quantity and update the quantity
			$row8 = mysqli_fetch_array($r8, MYSQLI_ASSOC);
			$cartqty = $row8['quantity'];
			} else {
			$cartqty = 0;			
			}
			
				$q2 = "SELECT quantity FROM items 
				WHERE item_id='$itemid'";
				$r2 = mysqli_query ($conn, $q2) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
				$itemqty = mysqli_fetch_row($r2);
				
				$val = $itemqty[0];
				$totalqty = $qty + $cartqty;
				if ($val >= $totalqty) {

// TODO: Check if the ID exist in the cart table
// if yes, then update the cart quantity instaed of adding a new field

// check if item id is availabe to customer id:
		$q = "SELECT cart_id, item_id, quantity FROM cart 
				WHERE item_id='$itemid'
				AND customer_id='$user'";
		$r = mysqli_query ($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		if (mysqli_num_rows($r) == 1) { // Available.

			// select quantity and update the quantity
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);
			$cartid = $row['cart_id'];
			$oldqty = $row['quantity'];
			$newqty = $oldqty + $qty;
			
			// Make the query:
$query = "UPDATE cart SET quantity='$newqty' WHERE cart_id=$cartid LIMIT 1";
$result = mysqli_query ($conn, $query);
if (mysqli_affected_rows($conn) == 1) {
	
	// Finish the page:
					 //Set display property and confirmation message of the message container to 'block'
					$success_display = 'block';
					$success_msg = '<h4 style="color: #008080"> SUCCESS! Product added successful.</h4>';
					
					} else { // db error.
						$err_msg = 'Product could not be added due to a system error. We apologize for any inconvenience</p>';
					}
					

		} else { // end if item exists, select qty

// continue from here tomorrow


// Add the order to the database:
if ($user && $itemid && $price) { // everything is set and OK!
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
		}
				} else {
					
				$err_msg = 'The quantity selected is more than the quantity in store. ' . $val . ' item(s) are available. Please try again</p>';
			
				}
						} // end of major if submitted statement


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
									$q = "SELECT cart.quantity, cart.cart_id, cart.price, items.item_name FROM `cart` 
									JOIN items ON items.item_id = cart.item_id
									WHERE cart.customer_id = '$user'"; 
									$r = @mysqli_query ($conn, $q);
									
									$sub_total = array();
									
									while ($cart = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
										$id = $cart['cart_id']; 
										$total =  $cart['quantity'] * $cart['price'];
										array_push($sub_total, $total);
									?>
												<tr class="gradeX">
													<td><?php echo $cart['item_name']; ?></td>
													<td> <?php echo ucwords($cart['price']); ?></td>
													<td> <?php echo ucwords($cart['quantity']); ?></td>
													<td> <?php echo $total; ?>.00</td>
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
													<th colspan="5">Delivery Charges</th>
												</tr>
												
												<tr>
													<th colspan="3">Total Estimated</th>
													<th colspan="2"> &#8358; <?php echo $amt; ?></th>
												</tr>
											</tfoot>
											
										</table>
									
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
