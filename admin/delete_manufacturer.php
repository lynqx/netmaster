<?php 

  include ('../partials/functions.php');


// Check for a valid image ID, through GET or POST:
 if ( (isset($_GET['id'])) && (is_numeric ($_GET['id'])) ) { // From view_users.php
$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
$id = $_POST['id'];
} else { // No valid ID, kill the script.
echo '<p class="error">This page has been accessed in error.</p>';
exit();
}

require_once ('../init_connect.php');

// Make the query:

$q = "DELETE FROM manufacturer WHERE manufacture_id=$id LIMIT 1";
$r = @mysqli_query ($conn, $q);

// If it ran OK.
if (mysqli_affected_rows($conn) == 1) {
	
	// Do redirection.
$redirect = 'manufacturer.php';
header("Location: {$redirect}?success=yes");
	
	

} else { // If the query did not run OK.

// Do redirection.
	redirect_to("manufacturer.php?error=yes");
	//echo 'Not';
}

?>

<?php mysqli_close($dbc);?>