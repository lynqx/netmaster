<?php # Script 9.3 - edit_manufacturer.php

// This page is for editing a user record.
// This page is accessed through view_users.php.
 $page_title = 'Edit Category';
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
$redirect = 'add_category.php';
header("location: $redirect");
		exit();
}

 // Check if the form has been submitted:
if (isset($_POST['submitted'])) {


// Trim all the incoming data:
$trimmed = array_map('trim', $_POST);

// Assume invalid values:
$cat_name = $cat_desc = $filter = FALSE;

$errors = array(); // Initialize error array.

// Check for a category:
if ($_POST['cat_name']) {
$cat_name = mysqli_real_escape_string ($conn, $trimmed['cat_name']);
} else {
$errors[] = 'Please enter the category';
}

// Check for the description:
$cat_desc = mysqli_real_escape_string ($conn, $trimmed['cat_desc']);

// Check for a price:
if ($_POST['filter']) {
$filter = mysqli_real_escape_string ($conn, $trimmed['filter']);
} else {
$errors[] = 'Please enter the filter!';
}


if ($cat_name && $cat_desc && $filter) { // If everything's OK...

// Make the query:
$q = "UPDATE category SET category_name='$cat_name', category_desc='$cat_desc', filter='$filter' WHERE category_id=$id LIMIT 1";
$r = mysqli_query ($conn, $q);
if (mysqli_affected_rows($conn) == 1)
{ // If it ran OK.

	// Do redirection.
$redirect = 'add_category.php';
header("Location: {$redirect}?edsuccess=yes");
	
} else { // If the query did not run OK.
	// Do redirection.
	redirect_to("add_category.php?ederror=yes");
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
$q = "SELECT * FROM category WHERE category_id=$id";
$r = @mysqli_query ($conn, $q);

// Get the user's information:
$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
?>
<!-- ADD CATEGORY UNIT -->
		<section id="category" class="color-light text-center">			
				<div class="divide40"></div>
					<div class="row">
						
						<div class="col-md-12">
								<h2 class="text-center"><span class="bigintro">Edit Category</span> </h2>
												<div class="divide20"></div>
												
<form method="post"  action="edit_category.php?id=<?php echo $id; ?>">			
							<div class="row">

							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="company" type="text" placeholder="Category Name" value="<?php echo $row['category_name']; ?>" name="cat_name"/>
							</div>
							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="title" type="text" placeholder="Description" value="<?php echo $row['category_desc']; ?>" name="cat_desc"/>
							</div>
							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="name" type="text" placeholder="Filter" value="<?php echo $row['filter']; ?>" name="filter"/>
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
