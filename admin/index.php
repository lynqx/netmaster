<?php # Script 16.5 - index.php
// This is the main page for the site.
// Set the page title and include the HTML header:

$path = '';
 $page_title = 'Login || iSTORE';
include ('partials/header_login.php');


// you need to login again if you enter this page
if (isset($_SESSION['user_id'])) {

$_SESSION = array(); // Clear the variables.
session_destroy(); // Destroy the session itself.
setcookie ('PHPSESSID', '', time()-8600, '/', '', 0, 0); // Destroy the cookie.
}

 ?>

                	<?php
				
/* where to redirect if rejected
$redirect = 'dashboard.php';	
// if session variable not set, redirect to login page
if (isset($_COOKIE['user_id'])) {
header("Location: {$redirect}?loggedin=yes");
exit;
}

 * */

?>

<?php # Script 11.3 - login.php

// This page processes the login form submission.
// Upon successful login, the user is redirected.
// Two included files are necessary.
// Send NOTHING to the Web browser prior to the setcookie() lines!

// Check if the form has been submitted:
if (isset($_POST['submitted'])) {


// For processing the login:
require_once ('partials/login_functions.inc.php');

// Need the database connection:
require_once ('../init_connect.php');

// Check the login:
list ($check, $data) = check_login($conn, $_POST['username'], $_POST['pass']);
if ($check) { // OK!


// Set the session data:.
session_start();
$_SESSION['user_id'] = $data ['user_id'];
$_SESSION['username'] = $data ['username'];
$_SESSION['firstname'] = $data ['firstname'];
$_SESSION['lastname'] = $data ['lastname'];
$_SESSION['email'] = $data ['email'];
$_SESSION['mobile'] = $data ['mobile'];
$_SESSION['bio'] = $data ['bio'];
$_SESSION['user_level'] = $data ['user_level'];

// Set the cookies:
setcookie ('user_id', $data['user_id'], time()+1440, '/', '', 0, 0);
setcookie ('firstname', $data['firstname'], time()+1440, '/', '', 0, 0);
setcookie ('lastname', $data['lastname'], time()+1440, '/', '', 0, 0);

if (isset ($_SESSION['user_id'])){
	 
	 $user = $_SESSION['user_id'];
	 $datetime = strtotime(date("Y-m-d H:i:s"));
// update the last login time	
$q4 = "UPDATE users SET last_login='$datetime' WHERE user_id='$user' LIMIT 1";
$r4 = mysqli_query ($conn, $q4) or trigger_error("Query: $q4\n<br />MySQL Error: " . mysqli_error($dbc));
	
$_SESSION['start'] = time();

// Store the HTTP_USER_AGENT:
$_SESSION['agent'] = md5($_SERVER ['HTTP_USER_AGENT']);

//if ($_SESSION['user_level'] == 1) {
// Redirect:
$url = absolute_url ('dashboard.php');
header("Location: $url");
exit();

} 

} else { // Unsuccessful!

// Assign $data to $errors for error reporting
// in the login_page.inc.php file.
$errors = $data;

 }


} // End of the main submit conditional.

// Create the page:
include ('partials/login_page.inc.php');
?>

				
		            
        <?php 

// Include the HTML footer file:
 include ('partials/footer.php');
 ?>