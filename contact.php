		<?php // include header
		$page_title = "Contact Us";
		include ('partials/fns.php'); 
		include ('partials/header.php'); 
		?>
		
				<section id="parallax-3" data-type="background" data-speed="10" class="pages text-center">

<?php
if (isset($_POST['submitted'])) { // Handle the form.

// Trim all the incoming data:
$trimmed = array_map('trim', $_POST);

// Assume invalid values:
$name = $mobile = $email = $message = FALSE;

// Check for a category:
if ((isset($_POST['name'])) && ($_POST['name'] != "")) {
$name = mysqli_real_escape_string ($conn, $trimmed['name']);
} else {
echo '<p class="error">Please enter your name!</p>';
}

//check for a mobile no
if ( (isset($_POST['mobile'])) && (is_numeric($_POST['mobile'])) ) {
$mobile = mysqli_real_escape_string ($conn, $trimmed['mobile']);
} else {
echo '<p class="error">Please enter a valid mobile number.</p>';
}

// Check for an email address:
if (preg_match ('/^[\w.-]+@[\w.-]+\.[AZa-z]{2,6}$/', $trimmed['email'])) {
$email = mysqli_real_escape_string ($conn, $trimmed['email']);
} else {
echo '<p class="error">Please enter a valid email address!</p>';
}

// Check for the details:
if (isset($_POST['message'])) {
$msg= mysqli_real_escape_string ($conn, $trimmed['message']);
} else {
echo '<p class="error">Please enter your message!</p>';
}


if ($name && $mobile && $email && $msg) { // If everything's OK...


// Add the user to the database:

$q = "INSERT INTO  `shop`.`contact` (name, mobile, email, message, date) VALUES ('$name', '$mobile', '$email', '$msg', NOW())";

$r = mysqli_query ($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));

if (mysqli_affected_rows($conn) == 1)
{ // If it ran OK then add other details to biodata table.

	// send the mail and text message 
	// commented till when needed
/* $body = "TYou have been registered on the FCE Obudu Store portal";
$body .= "Below are you login details<br /><br />";
$body .= 'Username - ' . $un . '<br />';
$body .= 'Password - ' . $p . '<br /><br />';
$body .= "Please change your password to something familiar and secured on first login <br /><br /> Best Regards";

 mail($trimmed['email'],
'Registration on FCE Obudu Store', $body,
'From: FCE Obudu Store Portal');
	
 * 
 * 
 * 
 */
 
  // Send the message:
  // prepare phone number
/*$phone = $mobile;
$phonea=substr($phone, 0, 1);
	
	if ($phonea=='0'){
	$phon=substr($phone, 1, 15);
	$phona="234$phon";
	}else{
	$phona=$phone;
	}
 * *
 */

$q3 = "SELECT * FROM sms";
$r3 = mysqli_query ($conn, $q3) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
$a = mysqli_fetch_array($r3, MYSQLI_ASSOC); 
	
	$username=$a['username'];
	$password=$a['password'];
	$sender=$a['sender_id'];
	$destination='2348063777394';
	$longSms = 0;
	$message = "You have a message from a user of Netmaster Cart. Please attend appropriately and promptly";
	

//This code block can be customised. 
//The $data array contains data that must be modified as per the API documentation. 
//The array contains data that you will post to the server

$data = array(	
			'UN' => $user, 
			'p' => $password,
			'SA' => $sender,
			'DA' => $destination,
			'L' => $longSms, 
			'M' => $message
			);

	// send a request to the API url
	list($header, $content) = PostRequest("http://98.102.204.231/smsapi/Send.aspx?", $data);

	//Set display property and confirmation message of the message container to 'block'
					$success_display = 'block';
					$success_msg = '<h4 style="color: #008080"> SUCCESS! Message sent.</h4>';
					
					} else { // db error.
						$err_msg = 'Message was not sent due to a system error. We apologize for any inconvenience</p>';
					}

								} else { // If one of the data tests failed.
								echo '<p class="error">Please re-enter the details appropriately and try again.</p>';
								}

} // End of the main Submit conditional.
?>

<!-- form starts -->
		
		
		<!-- CONTACT-US -->

		
			<div class="parallax-overlay">
				<section id="contact">
					<section class="container">
										<div class="row">
							<div class="col-md-12">
								
								<div class="box-body">
																	<div class="divide20"></div>

												<?php // block to output success message	
											   	if(!empty($success_msg)) {
												echo '<div class="alert alert-block alert-success fade in">
														<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
														<p><h4><i class="fa fa-heart"></i> Successful!</h4>' . $success_msg . '</p></div>';
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
												
									<h2 class="text-center">
									<span class="bigintro-light">Contact Us</span>
									</h2>
							</div>
						</div>
						<div class="divide20"></div>
						<div class="row">
							
							<form method="post" action="contact.php">
								
							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="name" type="text" placeholder="Name" value="" name="name"/>
							</div>
							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="email" type="tel" placeholder="Mobile" value="" name="mobile"/>
							</div>
							
							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="email" type="email" placeholder="Email" value="" name="email"/>
							</div>
							
							<div class="col-md-6 col-md-offset-3 form-input">
								<textarea id="message"  placeholder="Message" name="message"></textarea>
							</div>
							<div class="col-md-6 col-md-offset-3 form-submit">
								<button id="submit" class="btn btn-warning btn-lg" type="submit">SEND</button>
							</div>
							<input type="hidden" name="submitted" value="TRUE" />
 						</form>
						</div>
						<div class="divide60"></div>
					</section>
				</section>
			</div>
		</section>
		<!--/CONTACT-US -->
		
		
		<?php // include footer 
		include ('partials/footer.php'); 
		?>