<?php # Script 9.3 - edit_manufacturer.php

// This page is for editing a user record.
// This page is accessed through view_users.php.
 $page_title = 'Edit Manufacturer';
include ('partials/header.php');
include ('../partials/functions.php');


// Check for a valid product ID, through GET or POST:

 if ( (isset($_GET['id'])) && (is_numeric
($_GET['id'])) ) { // From view_users.php
$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) &&
(is_numeric($_POST['id'])) ) { // Form submission.
$id = $_POST['id'];
} else { // No valid ID, kill the script.
// Redirect:
$redirect = 'manufacturer.php';
header("location: $redirect");
		exit();
}

 // Check if the form has been submitted:
if (isset($_POST['submitted'])) {

$errors = array();

// Check for a manufacture:
if (empty($_POST['manufacturer'])) {
$errors[] = 'You forgot to enter the manufacturer name.';

} else {
$manufacturer = mysqli_real_escape_string($conn, trim($_POST['manufacturer']));
}

if (empty($errors)) { // If everything's OK.

// Make the query:
$q = "UPDATE manufacturer SET manufacturer='$manufacturer' WHERE manufacture_id=$id LIMIT 1";
$r = mysqli_query ($conn, $q);
if (mysqli_affected_rows($conn) == 1)
{ // If it ran OK.

	// Do redirection.
$redirect = 'manufacturer.php';
header("Location: {$redirect}?edsuccess=yes");
	
} else { // If the query did not run OK.
	// Do redirection.
	redirect_to("manufacturer.php?ederror=yes");
	//echo 'Not';
}

} else { // Report the errors.

echo '<p class="error">The following error(s) occurred:<br />';
foreach ($errors as $msg) { // Print each error.
echo " - $msg<br />\n";
}
 echo '</p><p>Please try again.</p>';

}// End of if (empty($errors)) IF.

 } // End of submit conditional.

// Always show the form...

// Retrieve the user's information:
$q = "SELECT * FROM manufacturer WHERE manufacture_id=$id";
$r = @mysqli_query ($conn, $q);

// Get the user's information:
$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
?>
<!-- ADD CATEGORY UNIT -->
		<section id="category" class="color-light text-center">			
				<div class="divide40"></div>
					<div class="row">
						
						<div class="col-md-12">
								<h2 class="text-center"><span class="bigintro">Edit Manucaturer </span> </h2>
												<div class="divide20"></div>
												
<form method="post"  action="edit_manufacture.php?id=<?php echo $id; ?>">			
							<div class="row">

							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="manufacturer" type="text" placeholder="Manufacturer" 
								value="<?php echo $row['manufacturer']  ?>" name="manufacturer"/>
							</div>
							
							<div class="col-md-6 col-md-offset-3 form-submit">
								<input id="submit" class="btn btn-warning btn-lg" type="submit" value="Update" />
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
