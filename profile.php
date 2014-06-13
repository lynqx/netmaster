	<style>
		<!--
		#taskdiv
		{
			margin-left: auto;
			margin-right: auto;
			color: #808080;
			font-size: small;
			padding: 1% 10% 1% 10%;
			
		}
		
		#taskdiv a
		{
			color: blue;
		}
		
		#pview, #pedit, #ordview
		{
			margin: 10px;
		}
		
		.tasklnk
		{
			background-color: #ccf;
			padding: 5px;
			border: 2px solid #88c;
			margin: 5px;
			border-radius: 7px; 
		}
		
		.profval
		{
			padding: 5px 10px 5px 10px;
			color: #369;
		}
		
		.profval input
		{
			border: 1px solid #ccc;
			background-color: #fff;
			color: inherit;
		}
		
		.profkey
		{
			padding: 5px 10px 5px 10px;
			background-color: #369;
			color: #ddf;
			border: 1px solid #258;
		}
		
		
		//-->
	</style>
	
	<?php
		include ('partials/header.php');
		include ('partials/fns.php');
		
		//check if user is logged in
		if(!isset($_SESSION['customer_id']))
		{
			header('location: login.php');
			exit();
		}
		
		if(!empty($_GET['action']) && trim($_GET['action'])=='logout')
		{
			//destroy all session
			session_unset();
			session_destroy();
			$_GET['action'] = null;
			header('location: login.php');
			exit();
		}
		
		//obtain page url
		$thispage = $_SERVER['PHP_SELF'];
		
		
		//edit profile
		if(!empty($_POST['edit_profile']))
		{
			//set display
			$pview = 'none';
			$pedit = 'block';
			$ordview = 'none';
			
			
			//trim all data
			$post = array_map('trim', $_POST);
			
			//set each value
			$firstname = $post['firstname'];
			$lastname = $post['lastname'];
			$phone = $post['phone'];
			$address = $post['address'];
			$city = $post['city'];
			$state = $post['state'];
			$country = $post['country'];
			
			
			//submit to database
			$cust = $_SESSION['customer_id'];
			$insert_info = "UPDATE customers SET firstname='$firstname', lastname='$lastname', phone='$phone', address='$address', city='$city', state='$state', country='$country' WHERE customer_id='$cust'";
			mysqli_query($conn, $insert_info) or die(mysqli_error($conn).'<h4 style=\"color: red\">FATAL ERROR</h4>');
			
			$msg = "<span style=\"color: green;\">Profile Saved Successfully!</span>";
		}
		else
		{
			//set default display
			$pview = 'block';
			$pedit = 'none';
			$ordview = 'none';
		
		}
	
	
	?>
	<div id="taskdiv">
		<span class="tasklnk"><a id="pviewlnk" href="#">View Profile</a></span> 
		<span class="tasklnk"><a id="peditlnk" href="#">Edit Profile</a></span> 
		<span class="tasklnk"><a id="ordviewlnk" href="#">View Order History</a></span> 
	</div>
	
	<div style="margin-left: auto; margin-right: auto; padding: 0% 10% 0% 10%; ">
		
		<!-- view_profile -->
		<div id="pview" class="inpage" style="display: <?php echo $pview; ?>; ">
		
			<h4>My Profile</h4>
			<table class="viewtab">
				
				<?php
					//generate profile info
					$cust = $_SESSION['customer_id'];
					$viewsel = "SELECT email, firstname, lastname, phone, address, city, state, country, date_registered FROM customers WHERE customer_id='$cust'";
					$viewrslt = mysqli_query($conn, $viewsel) or die('<h4 style=\"color: red;\">FATAL ERROR!</h4>');
					
					$info = mysqli_fetch_assoc($viewrslt);
					foreach($info as $vk => $vv)
					{
						echo "<tr class=\"profrow\"><td class=\"profkey\">".ucwords($vk)."</td><td class=\"profval\">".$vv."</td></tr>";
					
					}
				?>
				
			</table>
		</div>
		
		
		<!-- edit_profile -->
		<div id="pedit" class="inpage" style="display: <?php echo $pedit; ?>; ">
			<h4>Edit Profile</h4>
			<div>
				<?php
					if(!empty($msg))
					echo $msg;				
				?>
			</div>
			<table class="viewtab">
				<form action="<?php echo $thispage; ?>" method="POST">
				<?php
					//generate profile info
					$cust = $_SESSION['customer_id'];
					$viewsel = "SELECT email, firstname, lastname, phone, address, city, state, country, date_registered FROM customers WHERE customer_id='$cust'";
					$viewrslt = mysqli_query($conn, $viewsel) or die('<h4 style=\"color: red;\">FATAL ERROR!</h4>');
					
					$info = mysqli_fetch_assoc($viewrslt);
					foreach($info as $vk => $vv)
					{
						if($vk != "date_registered")
						{
							if($vk == 'email')
							echo "<tr class=\"profrow\"><td class=\"profkey\">".ucwords($vk)."</td><td class=\"profval\"><input required name=\"$vk\" type=\"text\" disabled=\"disabled\" value=\"".$vv."\"></td></tr>";
							else
							echo "<tr class=\"profrow\"><td class=\"profkey\">".ucwords($vk)."</td><td class=\"profval\"><input required name=\"$vk\" type=\"text\" value=\"".$vv."\"></td></tr>";
						}
					}
				?>
					
					<tr><td></td><td style="text-align: right; "><button type="submit" class="btn btn-success" name="edit_profile" value="edit_profile">Edit Profile</button></td></tr>
					
				</form>
			</table>
			
			
		</div>
		
		
		<!-- view order history -->
		<div id="ordview" class="inpage" style="display: <?php echo $ordview; ?>; ">
			<h4>Order History</h4>
			<?php
				include('order_history.php');
			?>
		</div>
		
		
	
	</div>
	
	<?php // include footer 
		include ('partials/footer.php'); 
	?>
	
	<script>
		$(document).ready(function()
		{
			$("#pviewlnk").click(function()
			{
				$("#pedit").hide();
				$("#ordview").hide();
				$("#pview").slideDown("slow");
			});
			
			
			$("#peditlnk").click(function()
			{
				$("#pview").hide();
				$("#ordview").hide();
				$("#pedit").slideDown("slow");
			});
			
			$("#ordviewlnk").click(function()
			{
				$("#pview").hide();
				$("#pedit").hide();
				$("#ordview").slideDown("slow");
			});
			
			$("#lnkx").click(function()
			{
				$("#divx").slideToggle("fast");
			});
			
		});
		
		
		function showHide(k,m,n)
		{
			var c = document.getElementById(k);
			var d = document.getElementById(m);
			var e = document.getElementById(n);
			
			if(d.style.display=='block')
			{
				d.style.display = 'none';
				e.style.display = 'none';
			}
			else
			{
				d.style.display = 'block';
				e.style.display = 'block';
			}
		}	
		
		function doPrint(div, no, tot, date, inv_no)
		{
			var d = document.getElementById(div);
			var x = d.innerHTML;
			//alert(x);
			
			window.open('print_invoice.php?cont='+x+'&no='+no+'&tot='+tot+'&date='+date+'&inv='+inv_no,'_blank', 'height=600, width=600,left=10, location=no, menubar=no, resizable=yes, scrollbars=yes, status=no, titlebar=no, toolbar=no');
		}
	
	</script>