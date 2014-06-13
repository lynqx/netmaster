<?php
$path = "";

?>
<!-- LOGIN -->
			<section id="login" class="visible">
				<div class="container">
					<div class="row">
						
						
															
						<div class="col-md-4 col-md-offset-4">
							<div class="login-box-plain">
								
								<!-- alert div -->
						
						<?php // reason for timeout
						
						if (isset($error)) {
						echo '<div class="alert alert-block alert-warning fade in">
											<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
												<p><h4><i class="fa fa-exclamation-circle"></i>' . $error . '</h4>';
						} 	
						elseif (isset($_GET['expired'])) 
						{
							echo '<div class="alert alert-block alert-warning fade in">
											<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>';
						echo "<p>No activity within '1440' seconds; your session has expired. Please log in again.</p></div>";
						}
						?>							
																	
									<?php
									// This page prints any errors associated with logging in
									// and it creates the entire login page, including the form.
									
									// Include the header:
									
									// Print any error messages, if they exist:
									if (!empty($errors)) {
										echo ' <div class="alert alert-block alert-danger fade in">
											<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
									<h4><i class="fa fa-times"></i> Error!</h4>
									<p>The following error(s) occurred:<br />';
									foreach ($errors as $msg) {
									echo " - $msg<br />\n";
									}
									echo '</p>
									<p>Please try again.</p></div>';
									}
									
									// Display the form:
									
									?>


							
								<h2 class="bigintro">Sign In</h2>
								<div class="divide-40"></div>
								<form role="form" action="index.php" method="post">
								  <div class="form-group">
									<label for="exampleInputEmail1">Username</label>
									<i class="fa fa-user"></i>
									<input type="text" name="username" class="form-control" id="exampleInputEmail1" required >
								  </div>
								  <div class="form-group"> 
									<label for="exampleInputPassword1">Password</label>
									<i class="fa fa-lock"></i>
									<input type="password" name="pass" class="form-control" id="exampleInputPassword1" required >
								  </div>
								 
								 

								  <div class="form-actions">
									<button type="submit" class="btn btn-danger">Submit</button>
									<input type="hidden" name="submitted" value="TRUE" />
								  </div>
								</form>
								
								<div class="login-helpers">
									<a href="#" onclick="swapScreen('forgot');return false;">Forgot Password?</a> <br>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!--/LOGIN -->
			
			
			
			<!-- FORGOT PASSWORD -->
			<section id="forgot">
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div class="login-box-plain">
								<h2 class="bigintro">Reset Password</h2>
								<div class="divide-40"></div>
								<form role="form" action="forgot_password.php" method="post">
								  <div class="form-group">
									<label for="exampleInputEmail1">Enter your Email address</label>
									<i class="fa fa-envelope"></i>
									<input type="email" name="email" class="form-control" id="exampleInputEmail1" required >
								  </div>
								  <div class="form-actions">
									<button type="submit" class="btn btn-info">Send Me Reset Instructions</button>
								  </div>
								</form>
								<div class="login-helpers">
									<a href="#" onclick="swapScreen('login');return false;">Back to Login</a> <br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- FORGOT PASSWORD -->
	</section>
	<!--/PAGE -->
	<!-- JAVASCRIPTS -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- JQUERY -->
	<script src="js/jquery/jquery-2.0.3.min.js"></script>
	<!-- JQUERY UI-->
	<script src="js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
	<!-- BOOTSTRAP -->
	<script src="bootstrap-dist/js/bootstrap.min.js"></script>
	
	
	<!-- UNIFORM -->
	<script type="text/javascript" src="js/uniform/jquery.uniform.min.js"></script>
	<!-- CUSTOM SCRIPT -->
	<script src="js/script.js"></script>
	<script>
		jQuery(document).ready(function() {		
			App.setPage("login");  //Set current page
			App.init(); //Initialise plugins and elements
		});
	</script>
	<script type="text/javascript">
		function swapScreen(id) {
			jQuery('.visible').removeClass('visible animated fadeInUp');
			jQuery('#'+id).addClass('visible animated fadeInUp');
		}
	</script>
	<!-- /JAVASCRIPTS -->
<!-- End of Content -->

 <?php // Flush the buffered output.
ob_end_flush();

?>
