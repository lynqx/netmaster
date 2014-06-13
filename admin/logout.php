<?php # Script 11.11 - logout.php #2
// This page lets the user logout.

 session_start(); // Access the existing session.

// If no session variable exists, redirect the user:
if (!isset($_SESSION['user_id'])) {

require_once ('includes/login_functions.inc.php');
$url = absolute_url();
header("Location: $url");
exit();

 } else { // Cancel the session.

$_SESSION = array(); // Clear the variables.
session_destroy(); // Destroy the session itself.
setcookie ('PHPSESSID', '', time()-8600, '/', '', 0, 0); // Destroy the cookie.


//redirect
header("Location: index.php");
exit();
}

// Set the page title and include the HTML header:
$page_title = 'Logged Out!';


 // Print a customized message:
echo '<h2>Logged Out!</h2>';
echo "<h3> You have been logged out!</h3>";
echo '<h3>You can click on the Login link to the right to login </h3>';

?>
