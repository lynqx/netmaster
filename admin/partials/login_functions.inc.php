<?php # Script 11.2 - login_functions.inc.php

// This page defines two functions used by the login/logout process.

 /* This function determines and returns an absolute URL.
* It takes one argument: the page that concludes the URL.
* The argument defaults to index.php.
*/
function absolute_url ($page = 'index.php') {

// Start defining the URL...
// URL is http:// plus the host name



$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

// Remove any trailing slashes:
$url = rtrim($url, '/\\');

 // Add the page:
$url .= '/' . $page;

// Return the URL:
return $url;

} // End of absolute_url() function.

/* This function validates the form data (the email address and password).
* If both are present, the database is queried.
* The function requires a database connection.
* The function returns an array of information, including:
* - a TRUE/FALSE variable indicating success
* - an array of either errors or the database result
*/

function check_login($conn, $user = '', $pass = '') {

$errors = array(); // Initialize error array.

// Validate the email address:
if (empty($user)) {
$errors[] = 'You forgot to enter your username.';
} else {
 $user = mysqli_real_escape_string($conn, trim($user));
}

// Validate the password:
 if (empty($pass)) {
$errors[] = 'You forgot to enter your password.';
} else {
$pass = mysqli_real_escape_string($conn, trim($pass));
}

if (empty($errors)) { // If everything's OK.

//$q = "SELECT * FROM users WHERE username='$user' AND pwd='$pass'";

$q = "SELECT * 
FROM  `users` 
WHERE users.username='$user' AND users.pwd=SHA1('$pass')";

$r = mysqli_query ($conn, $q); // Run the query.

// Check the result:
if (mysqli_num_rows($r) == 1) {

// Register the values & redirect:
	session_regenerate_id();
			$data = mysql_fetch_assoc($r);
			$_SESSION['SESS_USER_ID'] = $data['users.user_id'];
			$_SESSION['SESS_USER_LEVEL'] = $data['users.user_level'];
						session_write_close();

// Fetch the record:
$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);


 // Return true and the record:
return array(true, $row);

} else { // Not a match!
$errors[] = 'The username and password entered do not match those on file.';
}

} // End of empty($errors) IF.

 // Return false and the errors:
return array(false, $errors);

 } // End of check_login() function.

?>