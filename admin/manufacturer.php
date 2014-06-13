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
        
        <?php // include footer 
		$page_title = 'Add Manufacturer';
		include ('partials/header.php'); 
		?>
		
		
		<section id="category" class="color-light text-center">			
				<div class="divide40"></div>
					<div class="row" id="view">
						
						<div class="col-md-12">
								<h2 class="text-center"><span class="bigintro">View Manufacturers </span> </h2>
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
$q = "SELECT COUNT(manufacture_id) FROM manufacturer";
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

case 'c': $order_by = 'manufacture_id DESC';
break;

case 'p': $order_by = 'manufacturer ASC';
break;

default:
$order_by = 'manufacture_id DESC';
$sort = 'c';
break;
}

 // Make the query:
$q = "SELECT * FROM manufacturer ORDER BY $order_by LIMIT $start, $display";

$r = @mysqli_query ($conn, $q);

// Table header:
 echo '<table align="center" cellspacing= "0" cellpadding="5" width="700px" border="0">
 <tr style=" background-color:#000; height:40px; color:#fff;" class="edit">
<td align="left" color:#fff;"><b>Edit</b></td>
<td align="left" color:#fff;"><b>Delete</b></td>
<td align="left" color:#fff;"><b><a href="upload_products.php?sort=c" class="edit" style="color:#fff">Manufacturer</a></b></td>
<td align="left" color:#fff;"><b><a href="upload_products.php?sort=ud" class="edit" style="color:#fff">Date Posted</a></b></td></tr>';


// Fetch and print all the records....

$bg = ''; // Set the initial background color.
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) 
{

$bg = ($bg=='#FF8B17' ? '#6b0707' : '#FF8B17');  // Switch the background color.

echo '<tr bgcolor="' . $bg . '" style="height:30px; color:#fff"> 

<td align="left"><a href="edit_manufacture.php?id=' . $row['manufacture_id'] . '" class="edit2" style="color:#fff">Edit </a></td>';
?>
<td align="left"><a style="color:#fff" class="edit2" href="delete_manufacturer.php?id= <?php echo $row['manufacture_id']; ?>" onclick="return confirm('Are you sure you want to delete this manufacturer?');">Delete </a></td>

<?php
echo '<td align="left" class="view">' . $row['manufacturer'] . '</td>
<td align="left" class="view">' . $row['date'] . '</td> </tr> ';

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

		<a id="show2" class="btn btn-lg btn-info"> Add Manufacturer </a>

<div class="divide40"></div>
</div>
</div>
				
				
						<?php # Script 10.3 - upload_image.php

// Check if the form has been submitted:
// Check if the form has been submitted:
if (isset($_POST['submitted'])) {


// Trim all the incoming data:
$trimmed = array_map('trim', $_POST);

// Assume invalid values:
$manufacturer = FALSE;

$errors = array(); // Initialize error array.

// Check for the manufacturers name:

if ($_POST['manufacturer']) {
$manufacturer = mysqli_real_escape_string ($conn, $trimmed['manufacturer']);
} else {
$errors[] = 'Please enter the manufacturer name';
}

if ($manufacturer) { // If everything's OK...

// Add the user to the database:
$q = "INSERT INTO manufacturer (manufacturer, date) VALUES ('$manufacturer', NOW() )";
$r = mysqli_query ($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));

if (mysqli_affected_rows($conn) == 1)
{ // If it ran OK.

	$success[] = 'Thank You! The manufacturer has been added successfully!</p>';

} else {
	$errors[] = 'The manufacturer could not be added due to some errors.';

}

}

}// End of the submitted conditional.

?>

		<!-- ADD CATEGORY UNIT -->
		<section id="category" class="color-light text-center">			
				<div class="divide40"></div>
					<div class="row" id="add">
									<a id="show1" class="btn btn-lg btn-default"> View Manufacturer </a>
						
						<div class="col-md-12">
								<h2 class="text-center"><span class="bigintro">Add Manucaturer </span> </h2>
												<div class="divide20"></div>
										<?php
// Print any error messages, if they exist:
if (!empty($success)) {
echo '<h1>Success!</h1>';
foreach ($success as $msg) {
echo " $msg<br />\n";
}
}


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
							<form method="post"  action="manufacturer.php">			
							<div class="row">

							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="manufacturer" type="text" placeholder="Manufacturer" value="" name="manufacturer"/>
							</div>
							
							<div class="col-md-6 col-md-offset-3 form-submit">
								<input id="submit" class="btn btn-warning btn-lg" type="submit" value="Send" />
							</div>
							<input type="hidden" name="submitted" value="TRUE" />

						</div>
						</form>
						</div>
						

					</div>
					<div class="divide20"></div>
					</div>
		</section>
		</section>
		<!--/ADD CATEGORY UNIT  -->
		
		
		<?php // include footer 
		include ('partials/footer.php'); 
		?>
