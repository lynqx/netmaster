<?php

/* DELETE USERS */
/* Doubleakins*/
/* 08063777394*/
/* 24042014*/
/* delete users 


$path = "../";
$inc_path = $path."includes";
$err_path = $path."errors/"; 
 */
 
include ('fns/functions.php');


// Check for a valid image ID, through GET or POST:
 if ( (isset($_GET['id'])) && (is_numeric ($_GET['id'])) ) { // From view_users.php
$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
$id = $_POST['id'];
} else { // No valid ID, kill the script.
// Redirect:
$redirect = $err_path. 'error_503.php';
header("location: $redirect");
		exit();
}

require_once ('init_connect.php');

// Make the query:

$q = "DELETE FROM cart WHERE cart.cart_id=$id LIMIT 1";
$r = @mysqli_query ($conn, $q);

// If it ran OK.
if (mysqli_affected_rows($conn) == 1) {
	
	// Do redirection.
$redirect = 'mycart.php';
header("Location: {$redirect}?success=yes");
	
	

} else { // If the query did not run OK.

// Do redirection.
	redirect_to("mycart.php?error=yes");
	//echo 'Not';
}

?>

<?php mysqli_close($conn);?>