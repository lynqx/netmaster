		 <script src="jquery-1.8.0.min.js"></script>

			<script>
		 $(document).ready(function () {
			 //by default this initialises when the pagee is fully loaded
               // 	alert('am ready');
                	$('#add').hide();
                });
                
		 $(document).on('click','#show2',function(){
			 //this performs the hide and show and you can add transitions using either slide,blind,fast,slow and many more
			 $('#add').show("slide");
        	$('#view').hide("fast");
		 });
		 
		 $(document).on('click','#show1',function(){
			 $('#view').show("blind");
        	$('#add').hide("slide");
		 });
		 
		 
         </script>
        <!-- end show or hide link -->
        
        <?php // include footer 
		$page_title = 'Basic Shop Settings';
		include ('partials/header.php'); 
		?>
		
		<?php # Script 10.3 - settings.php

// Check if the form has been submitted:
// Check if the form has been submitted:
if (isset($_POST['submitted'])) {


// Trim all the incoming data:
$trimmed = array_map('trim', $_POST);

$errors = array(); // Initialize error array.

// Check for the address and phone number:

if ($_POST['addy1']) {
$addy1 = mysqli_real_escape_string ($conn, $trimmed['addy1']);
} else {
$errors[] = 'Please enter at least one shop address';
}

$addy2 = mysqli_real_escape_string ($conn, $trimmed['addy2']);

$addy3 = mysqli_real_escape_string ($conn, $trimmed['addy3']);


if ($_POST['phone1']) {
$phone1 = mysqli_real_escape_string ($conn, $trimmed['phone1']);
} else {
$errors[] = 'Please enter at least one shop phone number';
}

$phone2 = mysqli_real_escape_string ($conn, $trimmed['phone2']);

$phone3 = mysqli_real_escape_string ($conn, $trimmed['phone3']);



if ($addy1 && $phone1) { // If everything's OK...

// Add the user to the database:
$q = "INSERT INTO settings (key, value) 
		VALUES 
		('shop_address1', '$addy1'),
		('shop_address2', '$addy2'),
		('shop_address3', '$addy3'),
		('shop_phone1', '$phone1'),
		('shop_phone2', '$phone2'),
		('shop_phone3', '$phone3')";
		
$r = mysqli_query ($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));

if (mysqli_affected_rows($conn) == 1)
{ // If it ran OK.

	$success[] = 'Thank You! The manufacturer has been added successfully!</p>';

} else {
	$errors[] = 'The manufacturer could not be added due to some errors.';

}

}

}// End of the submitted conditional.

?>

										<?php
// Print any error messages, if they exist:
if (!empty($success)) {
echo '<h1>Success!</h1>';
foreach ($success as $msg) {
echo " $msg<br />\n";
}
}


if (!empty($errors)) {
echo '<h1>Error!</h1>
<p class="error">The following error(s) occurred:<br />';
foreach ($errors as $msg) {
echo " - $msg<br />\n";
}
echo '</p><p class="errortry">Please try again.</p>';
}

// Display the form:
?>	

		
		<section id="category" class="color-light text-center">		
		
		<div class="divide40"></div>

		<h2 class="text-center"><span class="bigintro"> BASIC SETTINGS </span> </h2>
	
					<div class="row" id="view">
						
						<div class="col-md-12">
												<div class="divide20"></div>
												
												<div class="col-md-12">
												<div class="box-body">
									
									<?php // block to output success message	
								if (isset($_GET['success'])) 
									{
										$success_msg = 'Manufacturer removed successfully';
									}
						
								if (isset($_GET['error'])) 
									{
										$err_msg = 'Ooops: The manufacturer was not removed';
									}
									
									if (isset($_GET['edsuccess'])) 
									{
										$success_msg = 'Manufacturer updated successfully';
									}
						
								if (isset($_GET['ederror'])) 
									{
										$err_msg = 'Ooops: The manufacturer was not updated';
									}
									
									 // block to output success message	
											   	if(!empty($success_msg)) {
												echo '<div class="alert alert-block alert-success fade in">
														<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
														<p><h4><i class="fa fa-check"></i> Successful!</h4>' . $success_msg . '</p></div>';
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
												</div>
		
		
		<div class="col-md-12">									
		<h3>Shop Address</h3> <br />
		</div>

							<form method="post"  action="settings.php">			
							<div class="row">

							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="addy1" type="text" placeholder="Shop Address 1" value="<?php echo $row[0]; ?>" name="addy1"/>
							</div>
							
							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="addy2" type="text" placeholder="Shop Address 2" value="<?php echo $row[1]; ?>" name="addy2"/>
							</div>
							
							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="addy3" type="text" placeholder="Shop Address 3" value="<?php echo $row[2]; ?>" name="addy3"/>
							</div>
													
							<div class="col-md-6 col-md-offset-3 form-submit">
								<input id="submit" class="btn btn-warning btn-lg" type="submit" value="Send" />
							</div>
							<input type="hidden" name="submitted" value="TRUE" />

						</div>


					<div class="divide40"></div>
					
					

		<a id="show2" class="btn btn-lg btn-info"> Phone Settings </a>

<div class="divide40"></div>
</div>
</div>
				
				
						

		<!-- ADD CATEGORY UNIT -->
		<section id="category" class="color-light text-center">			
				<div class="divide40"></div>
				
				<?php # Script 10.3 - settings.php

// Check if the form has been submitted:
// Check if the form has been submitted:
if (isset($_POST['submitted'])) {


// Trim all the incoming data:
$trimmed = array_map('trim', $_POST);

$errors = array(); // Initialize error array.

// Check for the address and phone number:

if ($_POST['addy1']) {
$addy1 = mysqli_real_escape_string ($conn, $trimmed['addy1']);
} else {
$errors[] = 'Please enter at least one shop address';
}

$addy2 = mysqli_real_escape_string ($conn, $trimmed['addy2']);

$addy3 = mysqli_real_escape_string ($conn, $trimmed['addy3']);


if ($_POST['phone1']) {
$phone1 = mysqli_real_escape_string ($conn, $trimmed['phone1']);
} else {
$errors[] = 'Please enter at least one shop phone number';
}

$phone2 = mysqli_real_escape_string ($conn, $trimmed['phone2']);

$phone3 = mysqli_real_escape_string ($conn, $trimmed['phone3']);



if ($addy1 && $phone1) { // If everything's OK...

// Add the user to the database:
$q = "INSERT INTO settings (key, value) 
		VALUES 		
		('shop_phone1', '$phone1'),
		('shop_phone2', '$phone2'),
		('shop_phone3', '$phone3')";
		
$r = mysqli_query ($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));

if (mysqli_affected_rows($conn) == 1)
{ // If it ran OK.

	$success[] = 'Thank You! The manufacturer has been added successfully!</p>';

} else {
	$errors[] = 'The manufacturer could not be added due to some errors.';

}

}

}// End of the submitted conditional.

?>

					<div class="row" id="add">
									<a id="show1" class="btn btn-lg btn-default"> Address Settings</a>
						
						<div class="col-md-12">
								<h3> Phone Settings </span> </h3>
												<div class="divide20"></div>
												
												<div class="col-md-6 col-md-offset-3 form-input">
								<input id="addy1" type="text" placeholder="Shop Address 1" value="<?php echo $row[0]; ?>" name="addy1"/>
							</div>
							
							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="addy2" type="text" placeholder="Shop Address 2" value="<?php echo $row[1]; ?>" name="addy2"/>
							</div>
							
							<div class="col-md-6 col-md-offset-3 form-input">
								<input id="addy3" type="text" placeholder="Shop Address 3" value="<?php echo $row[2]; ?>" name="addy3"/>
							</div>
													
							<div class="col-md-6 col-md-offset-3 form-submit">
								<input id="submit" class="btn btn-warning btn-lg" type="submit" value="Send" />
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
