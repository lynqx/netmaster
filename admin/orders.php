<?php
/* VIEW INVENTORY */
/* Doubleakins*/
/* 08063777394*/
/* 02052014*/
/* view inventory */

$path = "../";
$inc_path = $path."includes";
$err_path = $path."errors/";
$fns_path = $path."fns";


$page_title = "Orders History";
include('partials/header.php');




// content goes here //
// Make the query to view table details:
						$q = "SELECT * FROM  `orders` 
						JOIN items ON items.item_id = orders.item_id
						JOIN customers ON customers.customer_id = orders.customer_id";
						$r = mysqli_query ($conn, $q); 
						?>
						<!-- EXPORT TABLES -->
						<div class="row">
							<div class="col-md-12">

								<!-- BOX -->
									<section id="product" class="color-light text-center">			
				<div class="divide40"></div>
					<div class="row">
						
						<div class="col-md-12">
								<h2 class="text-center"><span class="bigintro">Orders List </span> </h2>
												<div class="divide40"></div>

									<div class="box-body">
										<?php
																if (mysqli_num_rows($r) > 0) {
										?>
										<table id="datatable1" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<th>Item Name</th>
													<th class="hidden-xs">Barcode</th>
													<th>Quantity</th>
													<th>Cashier</th>
													<th>Supplier/Collector</th>
													<th>Status</th>
													<th class="hidden-xs">Date</th>
												</tr>
											</thead>
											<tbody>
									<?php 
									while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
										$id = $row['item_id']; 
										$qty = $row['qty'];
									?>
												<tr class="gradeX">
													<td>
														<a href="<?php echo $path; ?>inventory/view_inventory.php?id=<?php echo $id; ?>">
														<?php echo ucwords($row['item_name']); ?> </a></td>
													<td> <?php echo $row['barcode']; ?></td>
													<td> <?php
													if ((substr($qty, 0, 1) == '-' )) {
													 echo substr($qty, 1); 
													} else {
														echo $qty;
														
													}  ?></td>
													<td> <?php echo ucwords($row['firstname']) . '  ' . ucwords($row['lastname']); ?></td>
													<td> <?php if ($row['collector'] == NULL) {
														echo ucwords($row['supplier']);
														} else { echo ucwords($row['collector']); } ?></td>

													<td> <?php
													if (substr($qty, 0, 1) == '-' ) {
														echo '<button class="btn btn-danger">OUT</button>';
													} else {
														echo '<button class="btn btn-success">IN</button>';
													}
															?>
													</td>
													<td> <?php echo $row['date']; ?></td>
												   

													
												</tr>
									<?php } ?>
												
											</tbody>
											<tfoot>
												<tr>
													<th>Item Name</th>
													<th class="hidden-xs">Barcode</th>
													<th>Quantity</th>
													<th>Cashier</th>
													<th>Supplier/Collector</th>
													<th>Status</th>
													<th class="hidden-xs">Date</th>
												</tr>
											</tfoot>
										</table>

		<?php } else {
			
			echo 'No records found';
		}
		?>
								<!-- /BOX -->
							
						<!-- /End of view items table-->														</div>
													<!-- /item DETAILS -->
												  </div>
								</div>
						</div>
						
<?php

// content ends here //
include('partials/footer.php');
?>