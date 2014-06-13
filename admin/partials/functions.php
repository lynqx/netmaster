<?php
//Contains all reusable fnctions

function mysqli_prep($value) {
	$magic_quotes_active = get_magic_quotes_gpc();
	$new_enough_php = function_exists("mysqli_real_escape_string"); //PHP > v4.3.0
	
	if ($new_enough_php) { //php v4.3.0 or higher
	//undo any magic quote effects so mysqli_real_escape_string can do the work
	
	if ($magic_quotes_active) { $value = stripslashes ($value);}
	$value = mysqli_real_escape_string ($value);
		} else { // before PHP v4.3.0
		//if magic quotes \ren't already on then add slashes manually
		if (!$magic_quotes_active) {$value = addslashes( $value );}
		// if magic quotes are active, then the slashes already exists
		}
		return $value;
	}
	

	
	
function redirect_to($location = NULL) {
	if ($location != NULL) {
		header("location: {$location}");
		exit();
	}
}


?>
