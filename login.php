	<style>
	<!--
		form
		{
			background-color: #ddd;
			border: 1px dashed #ccc;
			padding: 5px;
			border-radius: 10px;
		}
		
		form input, textarea
		{
			border: 1px solid #ccc;
		}
		
		button
		{
			margin: 8px 0px 3px 0px;
		}
		
		.hint
		{
			font-style: italic;
			color: #f8f8f8;
			text-shadow: 1px 1px #ccc;
			font-size: small;
		}
			
		
	//-->
	</style>
	
	<?php // include footer 
		include ('partials/header.php');
		
		//obtain page url
		$thispage = $_SERVER['PHP_SELF'];
		
		
		//if registration data submmitted, then send to database
		if(!empty($_POST['reg']))
		{
			//toggle display
			$rdis = 'block';
			$ldis = 'none';
			
			
			//trim all data
			$post = array_map('trim', $_POST);
			//obtain email and check if user already exists
			$email = $post['email'];
			include('partials/get_column_value_fns.php');
			$check = getColumnValue($conn, 'firstname', 'customers', 'email', $email);
			
			if(!empty($check))
			{
				//terminate process and output message
				$msg = "<div style=\"margin-left: 20px; padding: 10px; text-align: center; color: #f33;\"><h4>But it appears you're already registered here!</h4><span>Please <a class=\"loginlnk\" href=\"javascript:\">click here</a> to login</span></div>";
				
			}
			else
			{
				//continue processing form
				$password = md5($post['password']);
				$firstname = ucwords($post['firstname']);
				$lastname = ucwords($post['lastname']);
				$address = $post['address'];
				$phone = $post['phone'];
				$city = ucwords($post['city']);
				$state = ucwords($post['state']);
				$country = ucwords($post['country']);
				$date_registered = $post['date_registered'];
				$terms = $post['terms'];
				
				//post to database
				mysqli_query($conn, "INSERT INTO customers (email, password, firstname, lastname, address, phone, city, state, country, date_registered, terms) VALUES ('$email', '$password', '$firstname', '$lastname', '$address', '$phone', '$city', '$state', '$country', '$date_registered', '$terms')") or die('Sorry! Cannot submit data at this time!');
				
				$msg = "<div style=\"margin-left: 20px; padding: 10px; text-align: center; color: #008000;\"><h4>Signup Successful!</h4><span>Please <a class=\"loginlnk\" href=\"javascript:\">click here</a> to login</span></div>";
				
			}
		}
		elseif(!empty($_POST['login']))
		{
			//toggle display
			$rdis = 'none';
			$ldis = 'block';
			
			//trim all data
			$post = array_map('trim', $_POST);
			
			//check if data are correct
			$email = $post['email'];
			$password = md5($post['password']);
			
			include('partials/get_column_value_fns.php');
			$checkemail = getColumnValue($conn, 'email', 'customers', 'email', $email);
			$checkpass = getColumnValue($conn, 'password', 'customers', 'email', $email);
			
			
			//confirm correct login details
			if($checkpass!="" && $checkemail!="" && $checkpass==$password && $checkemail==$email)
			{
				//LOGIN IS CORRECT!
				//set user sessions
				$_SESSION['customer_id'] = getColumnValue($conn, 'customer_id', 'customers', 'email', $email);
				$_SESSION['firstname'] = getColumnValue($conn, 'firstname', 'customers', 'email', $email);
				$_SESSION['lastname'] = getColumnValue($conn, 'lastname', 'customers', 'email', $email);
				$_SESSION['email'] = $email;
							
				//redirect user
				if(isset($_SESSION['redirect']))
				{
					header('location:'.$_SESSION['redirect']);
					exit();
				}
				else
				{
					header('location: index.php');
					exit();
				}
			}
			else
			{
				//output login error msg
				$login_err = "<span style=\"color: red;\">Wrong email or password!</span>";
			}
		}
		else
		{
			$rdis = 'none';
			$ldis = 'block';
		}
		
		//'action' query
		if(!empty($_GET['action']))
		{
		$action = trim($_GET['action']);
			if($action == 'register')
			{
				$rdis = 'block';
				$ldis = 'none';
			}
			elseif($action == 'login')
			{
				$rdis = 'none';
				$ldis = 'block';
			}
		}
	?>
	
	
	
	<div style="margin-left: auto; margin-right: auto; padding: 0% 10% 0% 10%; ">
	
		<div id="logindiv" style="margin-left: auto margin-right: auto; text-align: center; display: <?php echo $ldis; ?>; ">
			<h4>LOGIN</h4>
			<label>Enter your login details</label>
			<div>
				<?php
					if(!empty($login_err))
					echo $login_err;
				?>
			</div>
			<form id="loginform" action="<?php echo $thispage; ?>" method="POST" style="text-align: left; margin: 1% 5% 1% 5%;" onsubmit="return validateLogin('loginemail')">
				<label>Email</label>
				<input id="loginemail" type="email" name="email" placeholder="email" required >
				
				<label>Password</label>
				<input type="password" name="password" placeholder="password" required >
				
				<div style="text-align: center;">
					<br>
					<button type="submit" name="login" class="btn btn-success" value="Login">Login</button>
				</div>
			</form>
			
			<div style="text-align: right; padding-right: 60px;">
				<h4><a id="reglnk" href="javascript:">REGISTER&raquo;</a></h4>
			</div>
		</div>
		
		
		
		
		<div id="regdiv" style="margin-left: auto margin-right: auto; text-align: center; font-size: small; display: <?php echo $rdis; ?>; ">
			<?php
				if(!empty($msg))
				echo $msg;
			?>
			<h4>REGISTER</h4>
			<label>Please Enter Your Details Below to Register</label>
			<form action="<?php echo $thispage; ?>" method="POST" style="text-align: left; margin: 1% 5% 1% 5%; " onsubmit="return validateReg()">
				
				<label>Email</label>
				<input id="regemail" type="email" name="email" placeholder="email" required >
				
				<label>Password <span class="hint">mininum of 6 characters</span></label>
				<input id="password" type="password" name="password" placeholder="password" required >
				
				<label>Confirm password</label>
				<input id="password2" type="password" name="password2" placeholder="confirm" required >
			
			
				<label>First Name</label>
				<input type="text" name="firstname" placeholder="Firstname" required >
				
				<label>Last Name</label>
				<input type="text" name="lastname" placeholder="Lastname" required >
				
				<label>Address <span class="hint">(Physical)</span></label>
				<textarea name="address" placeholder="Address" required ></textarea>
				
				<label>Tel/Mobile</label>
				<input type="tel" name="phone" placeholder="Phone" required >
				
				<label>City</label>
				<input type="text" name="city" placeholder="City" required >
				
				<label>State</label>
				<input type="text" name="state" placeholder="State" required >
				
				<label>Country</label>
				<input type="text" name="country" placeholder="Country" required >
				
				<input id="terms" type="checkbox" name="terms" >
				
				<input type="hidden" name="date_registered" value="<?php echo date('Y-m-d H:i'); ?>">
				<div style="text-align: center;">
					I Accept <a href="">Terms and Conditions</a><br>
					<br>
					<button type="submit" name="reg" class="btn btn-success" value="Register">Register</button>
				</div>
			
			</form>
			
			<div style="text-align: right; padding-right: 60px;">
				<h4><a class="loginlnk" href="javascript:">LOGIN&raquo;</a></h4>
			</div>
			
		</div>
		
	</div>
	<div style="clear: both;"></div>
	
	<?php // include footer 
		include ('partials/footer.php'); 
	?>
	<script>
		$(document).ready(function()
		{
			$("#reglnk").click(function()
			{
				$("#logindiv").hide();
				$("#regdiv").slideDown("slow");
			});
			
			$(".loginlnk").click(function()
			{
				$("#regdiv").hide();
				$("#logindiv").slideDown("slow");
			});
		});
		
		function validateReg()
		{
			//function validates email address
			var er = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
			var e = document.getElementById('regemail');
			var p1 = document.getElementById('password');
			var p2 = document.getElementById('password2');
			var t = document.getElementById('terms');
			
			var trm_p = p1.value.trim();
			
			if(e.value=="" || e.value==null || !er.test(e.value))
			{
				alert('You must provide a valid email address!');
				e.focus();
				return false;
			}
			else if(trm_p.length<6)
			{
				alert('Password must be 6 or more characters long!');
				p1.value="";
				p2.value="";
				p1.focus();
				return false;
			}
			else if(p1.value!=p2.value)
			{
				alert('Password mismatch!');
				p1.value="";
				p2.value="";
				p1.focus();
				return false;
			}
			else if(t.checked==false)
			{
				alert('You must accept Terms And Conditions!');
				t.focus();
				return false;
			}
			else
			return true;
		}
		
		
		function validateLogin(x)
		{
			//function validates email address
			var er = /[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/igm;
			var e = document.getElementById(x);
			
			if(e.value=="" || e.value==null || !er.test(e.value))
			{
				alert('You must provide a valid email address!');
				e.focus();
				return false;
			}
			else
			return true;
		}
	</script>