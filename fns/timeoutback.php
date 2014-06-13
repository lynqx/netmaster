<?php
/* LOGIN CHECK AND TIMEOUT */
/* check if user is logged in and implement idle timeout */

$baseurl = "http://localhost/fceobudustore/";


if (isset($_COOKIE['user_id'])) {

}else{
// Redirect:
$redirect = $baseurl . 'index.php';
header("location: $redirect");
		exit();
}




// set a time limit in seconds
$timelimit = 1440;
// get the current time
$now = time();
// where to redirect if rejected
$redirect = $baseurl . 'index.php';
// if session variable not set, redirect to login page
if (!isset($_SESSION['user_id'])) {
header("Location: $redirect");
exit;
}
// if timelimit has expired, destroy session and redirect
elseif ($now > $_SESSION['start'] + $timelimit) {
// empty the $_SESSION array
$_SESSION = array();
// invalidate the session cookie
if (isset($_COOKIE[session_name()])) {
setcookie(session_name(), '', time()-86400, '/');
}
// end session and redirect with query string
session_destroy();
header("Location: {$redirect}?expired=yes");
exit;
}
// if it's got this far, it's OK, so update start time
else {
$_SESSION['start'] = time();
}




 ?>