		 <script src="jquery-1.8.0.min.js"></script>

			<script>
		 $(document).ready(function () {
			 //by default this initialises when the pagee is fully loaded
               // 	alert('am ready');
                	$('#add').hide();
                });
                
		 $(document).on('click','#show2',function(){
			 //this performs the hide and show and you can add transitions using either slide,blind,fast,slow and many more
			 $('#add').show("slide");
        	$('#view').hide("fast");
		 });
		 
		 $(document).on('click','#show1',function(){
			 $('#view').show("blind");
        	$('#add').hide("slide");
		 });
		 
		 
         </script>
        <!-- end show or hide link -->
        
        <?php // include the header 
		$page_title = 'Add Products';
		include ('partials/header.php'); 
		?>
		
		
					

		<section id="category" class="color-light text-center">
			<div class="row" id="view">			
				<div class="divide40"></div>
						
						<div class="col-md-12">
								<h2 class="text-center"><span class="bigintro">View Products</span> </h2>
												<div class="divide20"></div>
												
												<div class="col-md-12">
												<div class="box-body">
									
									<?php // block to output success message	
								if (isset($_GET['success'])) 
									{
										$success_msg = 'Product removed successfully';
									}
						
								if (isset($_GET['error'])) 
									{
										$err_msg = 'Ooops: The product was not removed';
									}
								
								if (isset($_GET['edsuccess'])) 
									{
										$success_msg = 'Product updated successfully';
									}
						
								if (isset($_GET['ederror'])) 
									{
										$err_msg = 'Ooops: The product was not updated';
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
		
		
		<div class="col-md-12">									
<p>Click on the underlined header to sort the records</p> <br />
</div>

<?php	
 // Number of records to show per page:
$display = 10;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET ['p'])) { // Already been determined.

$pages = $_GET['p'];

} else { // Need to determine.

// Count the number of records:
$q = "SELECT COUNT(item_id) FROM items";
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
$sort = (isset($_GET['sort'])) ? $_GET ['sort'] : 'ud';

// Determine the sorting order:
switch ($sort) { 

case 'c': $order_by = 'item_name ASC';
break;

case 'p': $order_by = 'price ASC';
break;

case 'q': $order_by = 'quantity ASC';
break;

case 'ud': $order_by = 'date ASC';
break;

default:
$order_by = 'date DESC';
$sort = 'ud';
break;
}

 // Make the query:
$q = "SELECT * FROM items ORDER BY $order_by LIMIT $start, $display";

$r = @mysqli_query ($conn, $q);

// Table header:
 echo '<table align="center" cellspacing= "0" cellpadding="5" width="960px" border="0">
 <tr style=" background-color:#000; height:40px; color:#fff;" class="edit">
<td align="left" color:#fff;"><b>Edit</b></td>
<td align="left" color:#fff;"><b>Delete</b></td>
<td align="left" color:#fff;"><b><a href="add_product.php?sort=c" class="edit" style="color:#fff">Item Name</a></b></td>
<td align="left" color:#fff;"><b><a class="edit" style="color:#fff">Item Description</a></b></td>
<td align="left" color:#fff;"><b><a href="add_product.php?sort=q" class="edit" style="color:#fff">Quantity</a></b></td>
<td align="left" color:#fff;"><b><a href="add_product.php?sort=p" class="edit" style="color:#fff">Price</a></b></td>
<td align="left" color:#fff;"><b><a href="add_product.php?sort=ud" class="edit" style="color:#fff">Date Posted</a></b></td></tr>';


// Fetch and print all the records....

$bg = ''; // Set the initial background color.
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) 
{

$bg = ($bg=='#FF8B17' ? '#6b0707' : '#FF8B17');  // Switch the background color.

echo '<tr bgcolor="' . $bg . '" style="height:30px; color:#fff"> 

<td align="left"><a href="edit_product.php?id=' . $row['item_id'] . '" class="edit2" style="color:#fff">Edit </a></td>';
?>
<td align="left"><a style="color:#fff" class="edit2" href="delete_product.php?id= <?php echo $row['item_id']; ?>"
	 onclick="return confirm('Are you sure you want to delete this item?');">Delete </a></td>

<?php
echo '<td align="left" class="view">' . $row['item_name'] . '</td>
<td align="left" class="view">' . $row['item_desc'] . '</td>
<td align="left" class="view">' . $row['quantity'] . '</td>
<td align="left" class="view">' . $row['price'] . '</td>
<td align="left" class="view">' . $row['date'] . '</td> </tr> ';

} // End of WHILE loop.

echo '</table>';

// Make the links to other pages, if necessary.
if ($pages > 1) {

// Add some spacing and start a paragraph:

// Determine what page the script is on:
$current_page = ($start/$display) + 1;
// If it's not the first page, make a Previous button:
echo '<div class="divide40"></div>';

if ($current_page != 1) {
echo '<a class="btn btn-sm btn-primary links" href="add_product.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '"><<</a> ';
}

// Make all the numbered pages:
 for ($i = 1; $i <= $pages; $i++) {
if ($i != $current_page) {
echo '<a class="btn btn-sm btn-primary links" href="add_product.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
} else {
 echo '<span class="btn btn-sm btn-danger links" >' . $i . '</span>';
}
} // End of FOR loop.

// If it's not the last page, make a Next button:
if ($current_page != $pages) {
 echo '<a class="btn btn-sm btn-primary links" href="add_product.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">>></a>';
}

echo '</p>'; // Close the paragraph.

 
}// End of links section.

?>

					<div class="divide40"></div>


	<a id="show2" class="btn btn-sm btn-info"> Add Products </a>

</div>
	</div>



<!-- end of view products div -->

	
						<?php # Script 10.3 - upload_image.php

// Check if the form has been submitted:
if (isset($_POST['submitted'])) {

// Check for an uploaded file:
if (isset($_FILES['upload'])) {
define('UPLOAD_DIR', 'temp/');
	
//define('UPLOAD_DIR', '../img/product/');

// Validate the type. Should be JPEG or PNG.
$allowed = array ('image/pjpeg', 'image/JPEG', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');
if (in_array($_FILES['upload'] ['type'], $allowed)) {

// Move the file over.
$file = str_replace(' ', '_', $_FILES['upload']['name']);
$kaboom = explode(".", $file);
$fileExt = $kaboom[1];
if (move_uploaded_file ($_FILES['upload']['tmp_name'], UPLOAD_DIR.$file)); {
	
// include universal image resizing function
include_once("partials/img_lib.php");
$target_file = "temp/$file";
$resized_file = "../img/product//$file";
$wmax = 300;
$hmax = 200;
ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);

// Post details to db.
//require_once ('mysqli_connect.php');

// Trim all the incoming data:
$trimmed = array_map('trim', $_POST);

// Assume invalid values:
$category = $item_name = $price = $item_desc = $quantity = $file = $tag = FALSE;

$errors = array(); // Initialize error array.

// Check for a category:
$category = mysqli_real_escape_string ($conn, $trimmed['category']);

// Check for a manufacturer:
$manufacturer = mysqli_real_escape_string ($conn, $trimmed['manufacturer']);

// Check for the item name:
if ($_POST['item_name']) {
$item_name = mysqli_real_escape_string ($conn, $trimmed['item_name']);
} else {
$errors[] = 'Please enter the item name';
}

// Check for the item price:
if ($_POST['price']) {
$price = mysqli_real_escape_string ($conn, $trimmed['price']);
} else {
$errors[] = 'Please enter the price';
}

// Check for the item quantity:
if ($_POST['quantity']) {
$quantity = mysqli_real_escape_string ($conn, $trimmed['quantity']);
} else {
$errors[] = 'Please enter the quantity';
}

// Check for the description:
$item_desc = mysqli_real_escape_string ($conn, $trimmed['item_desc']);

$file = str_replace(' ', '_', $_FILES['upload']['name']);

// Check for the item price:
if ($_POST['tag']) {
$tag = mysqli_real_escape_string ($conn, $trimmed['tag']);
} else {
$errors[] = 'Please select a tag';
}


if ($category && $item_name && $price && $item_desc && $quantity && $tag && $file) { // If everything's OK...

// Add the user to the database:
$q = "INSERT INTO items (category, item_name, price, item_desc, quantity, manufacturer, image, tag, date) 
		VALUES ('$category', '$item_name', '$price', '$item_desc', '$quantity', '$manufacturer', '$file', '$tag', NOW() )";
$r = mysqli_query ($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));

if (mysqli_affected_rows($conn) == 1)
{ // If it ran OK.

echo '<p class="yes">Thank You! The Item has been added successfully!</p>';

} else {
	$errors[] = 'The Itam could not be added due to some errors.';

}

} else { // Invalid type.
$errors[] = 'Please upload a jpeg or png image format.';

}
}
}
} // End of isset($_FILES['upload']) IF.

// Check for an error:

if ($_FILES['upload']['error'] > 0) {
echo '<p class="error">The file could not be uploaded because: <strong>';

// Print a message based upon the error.
switch ($_FILES['upload']['error']) {
case 1:
 print 'The file exceeds the upload_max_filesize setting in php.ini.';
break;
case 2:
print 'The file exceeds the MAX_FILE_SIZE setting in the HTML form.';
break;
case 3:
print 'The file was only partially uploaded.';
break;
case 4:
print 'No file was selected.';
 break;
case 6:
print 'No temporary folder was available.';
break;
case 7:
print 'Unable to write to the disk.';
break;
case 8:
print 'File upload stopped.';
break;
default:
print 'A system error occurred.';
break;
} // End of switch.

 print '</strong></p>';

} // End of error IF.

// Delete the file if it still exists:
if (file_exists ($_FILES['upload']['tmp_name']) && is_file($_FILES['upload']['tmp_name']) ) {
unlink ($_FILES['upload']['tmp_name']);
unlink ($_FILES['upload']['temp']);


// Finish the page:

}// End of the submitted conditional.
}

?>

		<!-- ADD CATEGORY UNIT -->					
		<div class="row" id="add">
			<div class="divide40"></div>
	
						<div class="col-md-12">
								<h2 class="text-center"><span class="bigintro">Add Products </span> </h2>
												<div class="divide20"></div>
										<?php
// Print any error messages, if they exist:
if (!empty($errors)) {
echo '<h1>Error!</h1>
<p class="error">The following error(s) occurred:<br />';
foreach ($errors as $msg) {
echo " - $msg<br />\n";
}
echo '</p><p class="errortry">Please try again.</p>';
}

// Display the form:
?>		
							<form enctype="multipart/form-data" method="post"  action="add_product.php">			
							<div class="row">
								<input type="hidden" name="MAX_FILE_SIZE" value="524288">

							<div class="col-md-6 col-md-offset-3 form-input">
							<select name="category">
								<option value="">Select a Category</option>
								<?php
							
								if($selcat = mysqli_query($conn, "SELECT * FROM category"))
								{
									while($category = mysqli_fetch_row($selcat))
									{
										$catname = ucwords($category[1]);
										echo
										"<option value=\"$category[0]\" >$catname</option>";
									}
								}
								mysqli_free_result($category);
								
								?>
								
							</select>							
							</div>
							
							<div class="col-md-6 col-md-offset-3 form-input">
							<select name="manufacturer">
								<option value="">Select a Manufacturer</option>
								<?php
							
								if($selman = mysqli_query($conn, "SELECT * FROM manufacturer"))
								{
									while($manufacture = mysqli_fetch_row($selman))
									{
										$manufacturer = ucwords($manufacture[1]);
										echo
										"<option value=\"$manufacture[0]\" >$manufacturer</option>";
									}
								}
								mysqli_free_result($category);
								
								?>
								
							</select>							
							</div>
							
							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="title" type="text" placeholder="Product Name" value="" name="item_name"/>
							</div>
							
							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="title" type="text" placeholder="Description" value="" name="item_desc"/>
							</div>
							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="name" type="number" placeholder="Price" value="" name="price"  step="0.01"/>
							</div>
							
							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="name" type="number" placeholder="Quantity" value="" name="quantity"/>
							</div>
							
							<div class="col-md-6 col-md-offset-3 form-input">
								<select name="tag">
									<option value="">Select a Tag</option>
									<option value = 1> Best Selling </option>
									<option value = 2> Exclusive </option>
									<option value = 3> Out of Stock </option>
									</select>
							</div>
							
							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="avatar" type="file" name="upload"/>
							</div>
							<div class="col-md-6 col-md-offset-3 form-submit">
								<input id="submit" class="btn btn-warning btn-lg" type="submit" value="Send" />
							</div>
							<input type="hidden" name="submitted" value="TRUE" />

						</div>
						</form>
						
						<div class="divide20"></div>
								<a id="show1" class="btn btn-sm btn-default"> View Products </a>

						</div>

								</div>
								</section>

		<!--/ADD CATEGORY UNIT  -->
		
		
		<?php // include footer 
		include ('partials/footer.php'); 
		?>
		
		
