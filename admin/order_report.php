		<style>
	<!--


	
	//-->
</style>

 <script src="jquery-1.8.0.min.js"></script>

			<script>
		 $(document).ready(function () {
			 //by default this initialises when the pagee is fully loaded
               // 	alert('am ready');
                	$('#hidden8').hide();
                });
                
		 $(document).on('click','#showme',function(){
			 //this performs the hide and show and you can add transitions using either slide,blind,fast,slow and many more
			 $('#hidden').show("slide");
		 });
		 
		 $(document).on('click','#show1',function(){
			 $('#view').show("blind");
        	$('#add').hide("slide");
		 });
		 
		 
         </script>
        <!-- end show or hide link -->
        
        <?php // include footer 
		$page_title = 'Order Reports';
		include ('partials/header.php'); 
		?>
		
		
		<section id="category" class="color-light text-center">			
				<div class="divide40"></div>
					<div class="row" id="view">
						
						<div class="col-md-12">
								<h2 class="text-center"><span class="bigintro">View Order List </span> </h2>
												<div class="divide20"></div>
												
												<div class="col-md-12">
												<div class="box-body">
									
									<?php // block to output success message	
								if (isset($_GET['success'])) 
									{
										$success_msg = 'Manufacturer removed successfully';
									}
						
								if (isset($_GET['error'])) 
									{
										$err_msg = 'Ooops: The manufacturer was not removed';
									}
									
									if (isset($_GET['edsuccess'])) 
									{
										$success_msg = 'Manufacturer updated successfully';
									}
						
								if (isset($_GET['ederror'])) 
									{
										$err_msg = 'Ooops: The manufacturer was not updated';
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
												</div>
		
		
		<div class="col-sm-10">									
<p>Click on the underlined header to sort the records</p> <br />

	<div class="col-md-12">
	<div id="order_hist_cont">
	<div class="ordercont">
<?php	
 // Number of records to show per page:
$display = 10;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET ['p'])) { // Already been determined.

$pages = $_GET['p'];

} else { // Need to determine.

// Count the number of records:
$q = "SELECT COUNT(order_id) FROM orders";
$r = mysqli_query ($conn, $q);
$row = mysqli_fetch_array ($r, MYSQLI_NUM);
$records = $row[0];

// Calculate the number of pages...
if ($records > $display) { // More than 1 page.
$pages = ceil ($records/$display);
} else {
$pages = 1;
}

 } // End of p IF.

 // Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric ($_GET['s'])) {  $start = $_GET['s'];
} else {

$start = 0;
}

// Determine the sort...
// Default is by registration date.
$sort = (isset($_GET['sort'])) ? $_GET ['sort'] : 'rd';

// Determine the sorting order:
switch ($sort) { 

case 'c': $order_by = 'orders.order_id DESC';
break;

case 'p': $order_by = 'orders.customer_id ASC';
break;

default:
$order_by = 'orders.order_id DESC';
$sort = 'c';
break;
}

 // Make the query:
$q = "SELECT * FROM orders 
	JOIN invoice ON invoice.order_id=orders.order_id 
	JOIN customers ON customers.customer_id=orders.customer_id 
	ORDER BY $order_by LIMIT $start, $display";

$r = @mysqli_query ($conn, $q);
?>

<table id="datatable2" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered table-hover">
<thead>
 <th width="200"> Order No</th>
 <th width="300"> Customer Name </th>
 <th width="200"> Total Amount</th>
 <th width="150"> Invoice Details</th>
 <th width="10" > Status</th>
 <th width="10" > Operations</th>
 
 </tr></thead>

<?php 
// Fetch and print all the records....

$bg = '';// Set the initial background color.
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) 
{
$order = $row['order_id'];
$customer = $row['customer_id'];
echo '<tr class="hist_hd">';
echo '<td>Order #:'. $row['order_id']. ' </td>'; ?>

<td><a href="#" id="showme" onclick="show_me('hidden<?php echo $customer; ?>')"> <?php echo $row['firstname'] . '  ' . $row['lastname']; ?> </a></td>
	
<td> <?php 
$q2 = "SELECT SUM(amount) AS total FROM order_details WHERE order_id=$order";
$result = mysqli_query($conn, $q2);
$row2 = mysqli_fetch_row($result);
echo $val = $row2[0];
//echo $sum['total'];
	?></td>
	
<td><a href="view_invoice.php?invoice=<?php echo $row['invoice_id'];?>"><?php echo $row['invoice_id']; ?> </td>
	
<td><?php echo $row['status'];?></td>
	
<td> <input type="submit" class="btn btn-danger btn-sm" id="butt<?php echo $order; ?>" 
	value="Show Details" onclick="show_details('div<?php echo $order; ?>', 'butt<?php echo $order; ?>')" />
	<?php
	if ($row['status'] == 'unpaid') { ?>
		<a href="payment.php?id=<?php echo $order; ?>" class="btn btn-info btn-sm">Mark as Paid </a>
	<?php } ?>
	 </td>
</tr>

<tr>
<td colspan="5" id="hidden<?php echo $customer; ?>" style="display:none">
	<?php echo 'SHIPPING ADDRESS<br />'; ?> 
	<?php echo 'Street:' . $row['address'] . '<br />'; ?> 
	<?php echo 'City:' . $row['city'] . '<br />'; ?> 
	<?php echo 'State:' . $row['state'] . '<br />'; ?> 
	<?php echo 'Country:' . $row['country'] . '<br />'; ?> 
</td>
</tr>

<tr>
 <td colspan="5" id="div<?php echo $order; ?>" style="display:none"> 
 	
 	<?php
		 // Make the query:
$q4 = "SELECT *, order_details.quantity AS qty FROM order_details
	JOIN items ON items.item_id=order_details.item_id
	WHERE order_details.order_id = '$order'";

$r4 = mysqli_query ($conn, $q4) or trigger_error("Query: $q4\n<br />MySQL Error: " . mysqli_error($conn));

		echo '<table id="datatable2" cellpadding="0" cellspacing="0" border="0" 
		class="datatable table table-striped table-bordered table-hover">
<thead>
<tr>
 <th>Item Name </th>
 <th>Quantity</th>
 <th> Unit Price</th>
 <th> Sub-Total</th>
 </tr><thead>';
			while ($row4 = mysqli_fetch_array($r4, MYSQLI_ASSOC)) {
?>
			<tbody>
				<tr> 
				<td> <?php echo $row4['item_name']; ?> </td>
				<td> <?php echo $row4['qty']; ?> </td>
				<td> <?php echo $row4['price']; ?> </td>
				<td> <?php echo $row4['amount']; ?> </td>
			</tr>
			</tbody>
		<?php }  // end of inner while loop
		?>
		
		</table>
 	
 	</td>

 
 </tr>

<?php
} // End of WHILE loop.

echo '</table>';

// Make the links to other pages, if necessary.
if ($pages > 1) {

// Add some spacing and start a paragraph:

// Determine what page the script is on:
$current_page = ($start/$display) + 1;
// If it's not the first page, make a Previous button:
echo '<div id="links">';

if ($current_page != 1) {
echo '<a class="event" href="manufacturer.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
}

// Make all the numbered pages:
 for ($i = 1; $i <= $pages; $i++) {
if ($i != $current_page) {
echo '<a class="event" href="manufacturer.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
} else {
 echo '<span>' . $i . '</span>';
}
} // End of FOR loop.

// If it's not the last page, make a Next button:
if ($current_page != $pages) {
 echo '<a class="event" href="manufacturer.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
}

echo '</p>'; // Close the paragraph.

 
}// End of links section.

?>
					<div class="divide40"></div>

					</div>
		</section>
		</section>
		<!--/ADD CATEGORY UNIT  -->
		
		
		<?php // include footer 
		include ('partials/footer.php'); 
		?>

<script type="text/javascript">
function show_details(m, k){

	var b = document.getElementById(m);
	var a = document.getElementById(k);
	
	if(b.style.display=='none')
			{
				b.style.display = 'block';
				a.value="Hide Details";
			}
			else
			{
				b.style.display = 'none';
				a.value="Show Details";

			}
	
}

function show_me(y){

	var x = document.getElementById(y);
	
	if(x.style.display=='none')
			{
				x.style.display = 'block';

			}
			else
			{
				x.style.display = 'none';

			}
	
}
</script>