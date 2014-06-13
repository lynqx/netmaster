<style>
	<!--
	#contdiv
	{
		margin-left: 7%;
		
		
	}
	
	h3
	{
		color: #006;
	}
	/*
	form
	{
		margin-left: auto;
		margin-right: auto;
		padding: 1% 10% 1% 10%;
	}
	*/
	#default_addr
	{
		text-align: left;
	}
	
	#defaultaddress, #newaddress, #ouraddress, #defaultpayment, #orderdetails
	{
		padding: 5px;
		border: 1px dashed #cecece;
		box-shadow: 1px 1px 2px #ccc;
		background-color: #fff;
		width: 70%;
		font: normal bold 100% Verdana;
		color: #006;
	}
	
	.checkdiv
	{
		width: 70%;
		color: #008000;
		padding: 5px;
		margin: 2px;
		background-color: #ccc;
		border: 3px solid #9cf;
		font-weight: bold;
	}
	
	.checkdiv select
	{
		background-color: #ccc;
		border: 0px;
		color: #c30;
	}
	
	.check
	{
		position: relative;
		left: -49%;
		float: left;
	}
	
	.alert
	{
		color: red;
		font-weight: bold;
		font-size: 80%;
		text-decoration: blink;
	}
	
	.less
	{
		color: #808080;
		font-weight: normal;
		font-style: italic;
	}
	
	#confirm_payment, #preview_order, #default_addr_block, #addrcheck_info, #new_addr_out, #office_addr_out, #bank_details_out, #paymentcheck_info
	{
		display: none;
	}
	
	#orderdetails
	{
		font: normal normal 100% Verdana;
	}
	
	.outtag
	{
		color: #666;
		padding: 1px;
		//border: 1px solid #ececec;
		border-radius: 3px;
	}
	
	.bu
	{
		font-weight: bold;
		text-decoration: underline;
	}
	
	.response_out
	{
		font-weight: bold;
		color: green;
	}
	
	input
	{
		color: #669;
	}
	
	.comp_table
	{
		border 1px dashed #efefef;
		border-radius: 5px;
		//background-color: #f0f0f0;
		font-size: small;
		width: 90%;
		color: #666;
	}
	
	.comp_table tfoot tr
	{
		font-weight: bold;
	}
	
	
	//-->
</style>

<?php
$page_title = "Checkout";
include ('partials/header.php');
include ('partials/fns.php');

//check if checkout is authentic
if(empty($_POST['proceed2checkout']))
{
	header('location: login.php');
	exit();
}
else
$proceed = $_POST['proceed2checkout'];

//obtain item ids
$itemids = array_map('trim', explode(',', $proceed));

//obtain customer's default shipping address
$cust_address = getColumnValue($conn, 'address', 'customers', 'customer_id', $_SESSION['customer_id']);
$cust_city = getColumnValue($conn, 'city', 'customers', 'customer_id', $_SESSION['customer_id']);
$cust_state = getColumnValue($conn, 'state', 'customers', 'customer_id', $_SESSION['customer_id']);
$cust_country = getColumnValue($conn, 'country', 'customers', 'customer_id', $_SESSION['customer_id']);

$default_address = $cust_address."\n<br>".$cust_city."\n<br>".$cust_state."\n<br>".$cust_country;


?>



<!--------------------------------------// DELIVERY PREFERENCE //------------------------------------------->
<div id="contdiv">

	<div id="both_prev">
	
	<div id="confirm_addr">
		<h3>Set Delivery Preference</h3>
		<div id="default_addr">
			<div class="checkdiv">
				<select id="addrcheck" name="addrcheck" onchange="changePreference()">
					<option value="0">Please ship my items to my address shown below. </option> 
					<option value="1">Ship my items to a different address I'll provide below. </option> 
					<option value="2">Do not ship! I'll come to your office for my items. </option> 
				</select> &nbsp; <span class="alert">&#8672; IMPORTANT!</span>
			</div>
			<div id="defaultaddress">
				<?php
				echo "<span id=\"def_addr\">".$default_address."</span>";
				
				//show hotlines
				include('show_hotlines.php');
				?>
			</div>
			<div id="newaddress" style="display: none;">
				<label>Street</label>
				<input id="street_in" type="text" name="n_address" required>
				<label>City/District</label>
				<input id="city_in" type="text" name="n_city" required>
				<label>State/region</label>
				<input id="state_in" type="text" name="n_state" required>
				<label>Country</label>
				<input id="country_in" type="text" name="n_country" required>
				
				<?php
					//show hotlines
					include('show_hotlines.php');
				?>
			</div>
			
			<div id="ouraddress" style="display: none;">
				<span style="font-weight: normal;">See our location(s) for picking up your items:</span><br>
				<br>
				
				<?php
					echo "<div id=\"office_addr_in\">";
					
					//fetch shop address from database
					$sel_shop = "SELECT set_value FROM settings where set_key LIKE 'shop_address%'";
					
					$addr_result = mysqli_query($conn, $sel_shop) or die(mysqli_error($conn).'Failed to fetch shop address!');
					
					$addr_cnt = 0;
					while($addr_rows = mysqli_fetch_row($addr_result))
					{
						$addr_cnt++;
						
						echo "<p><span class=\"less\">Location ".$addr_cnt.":</span><br>".$addr_rows[0]."</p>";
					}
					
					echo "</div>";
					//show hotlines
					include('show_hotlines.php');
				?>
				
				
			</div>
			
			<br>
			<button type="" class="btn btn-success" style="background-color: #808080; border-color: #737373" onclick="window.history.back(-1)">&laquo; Back</button> &nbsp;<button id="to_payment" class="btn btn-success" onclick="goNext('confirm_addr', 'confirm_payment')">Proceed to Payment &raquo;</button>
			
			
		</div>
	</div>
	
	<!--------------------------------------// PAYMENT PREFERENCE //------------------------------------------->
	<div id="confirm_payment">
		<h3>Set Payment Preference</h3>
		<div id="payment">
			<div class="checkdiv">
				<select id="paymentcheck" name="paymentcheck" >	
					<option value="0">Direct Bank Deposit</option> 
					
				</select> &nbsp; <span class="alert">&#8630; See details below!</span>
			</div>
			<div id="defaultpayment">
				<?php
					//fetch shop address from database
					$sel_pay = "SELECT set_value FROM settings where set_key LIKE 'bank_details%'";
					
					$pay_result = mysqli_query($conn, $sel_pay) or die(mysqli_error($conn).'Failed to fetch bank details!');
					
					$pay_cnt = 0;
					
					echo "<div id=\"bank_details_in\">";
					while($pay_rows = mysqli_fetch_row($pay_result))
					{
						if($pay_rows[0]!="")
						{
							echo $pay_rows[0]."<br>";
						}
					}
					echo "</div>";
				
				//show payment instruction
				$inst_sel = mysqli_query($conn, "SELECT set_value FROM settings WHERE set_key='payment_instruction'") or die('Failed loading payment instructions');
				$inst_row = mysqli_fetch_row($inst_sel);
				if($inst_row[0]!="")
				{
					echo "<span class=\"less\">Payment Instruction</span><br>";
					echo "<span style=\"font-size: 70%; font-weight: normal; color: #699; \">".$inst_row[0]."</span>";
				}
				
				//show hotlines
				include('show_hotlines.php');
				?>
			</div>
		
			<br>
			<button class="btn btn-success" style="background-color: #808080; border-color: #737373" onclick="goNext('confirm_payment', 'confirm_addr')">&laquo; Back</button> &nbsp;<button onclick="goNext('both_prev', 'preview_order'); lift_prefs(); " id="to_preview" class="btn btn-success">Preview Order Details &raquo;</button>
		
		
		</div>
	</div>
	
	</div>

	
	
	<!--------------------------------------// PREVIEW ORDER //------------------------------------------->
	<div id="preview_order">
		<h3>Order Preview</h3>
		<form action="checkout_success.php" method="GET">
			<div id="preview">
				<div class="checkdiv">
					&nbsp;<span class="alert">&#8630; Please verify your order details and CHECHOUT.</span>
				</div>
				
				<div id="orderdetails">
					<div id="items">
						<span class="outtag bu">Your Items</span><br>
						<?php echo composeOrderTable($conn, $proceed); ?>
					</div>
					<br>
					<div id="delivery">
						<span class="outtag bu">Your Delivery Preference</span><br>
						<span id="addrcheck_info" class="response_out"></span>
						<div id="default_addr_block"></div>
						
						<div id="new_addr_out">
							<span class="outtag">Street:</span> &nbsp;<span id="street_info" class="outinfo"></span><br>
							<span class="outtag">City/District:</span> &nbsp;<span id="city_info" class="outinfo"></span><br>
							<span class="outtag">State/Region:</span> &nbsp;<span id="state_info" class="outinfo"></span><br>
							<span class="outtag">Country:</span> &nbsp;<span id="country_info" class="outinfo"></span><br>
							
						</div>
						
						<div id="office_addr_out"></div>
					
					</div>
					<br>
					<div id="payment">
						<span class="outtag bu">Your Payment Preference</span><br>
						<span id="paymentcheck_info" class="response_out"></span>
						<div id="bank_details_out"></div>
						
					</div>
					
					<div id="hid_fields">
						<input type="hidden" id="hid_addrcheck_info" name="hid_addrcheck_info" value="">
						<input type="hidden" id="hid_paymentcheck_info" name="hid_paymentcheck_info" value="">
						<input type="hidden" id="hid_itemids" name="hid_itemids" value="<?php echo $proceed; ?>">
						<input type="hidden" id="hid_street" name="hid_street" value="">
						<input type="hidden" id="hid_city" name="hid_city" value="">
						<input type="hidden" id="hid_state" name="hid_state" value="">
						<input type="hidden" id="hid_country" name="hid_country" value="">
					</div>
				</div>
				<br>
				<button type="button" class="btn btn-success" style="background-color: #808080; border-color: #737373" onclick="goNext('preview_order', 'both_prev'); goNext('preview_order', 'confirm_payment');">&laquo; Change My Preference</button> &nbsp;<button type="submit" name="gocheckout" value="gocheckout" id="checkoutbtn" class="btn btn-success" style="border: 2px solid #008000; width: 30%; color: #0f0; font-weight: bold; ">CHECKOUT</button>
				
			</div>
		</form>
	</div>

</div>




<?php // include footer 
		include ('partials/footer.php'); 
?>

<script>
<!--
	function clearInputs()
	{
		var inp = document.getElementsByTagName('input');
		
		for(var i=0; i<inp.length; i++)
		{
			inp[i].value = "";
		}
	}


	function changePreference()
	{
		var da = document.getElementById('defaultaddress');
		var na = document.getElementById('newaddress');
		var oa = document.getElementById('ouraddress');
		var pref = document.getElementById('addrcheck');
	
		switch(pref.value)
		{
			case "0":
			da.style.display = 'block';
			na.style.display = 'none';
			oa.style.display = 'none';
			clearInputs();
			break;
			
			case "1":
			da.style.display = 'none';
			na.style.display = 'block';
			oa.style.display = 'none';
			break;
			
			case "2":
			da.style.display = 'none';
			na.style.display = 'none';
			oa.style.display = 'block';
			clearInputs();
			break;
		
			default:
			da.style.display = 'block';
			na.style.display = 'none';
			oa.style.display = 'none';
			clearInputs();
		}
	}
	
	function goNext(current, next)
	{
		//function closes current div and open the next
		var cur = document.getElementById(current);
		var nxt = document.getElementById(next);
		
		cur.style.display = 'none';
		nxt.style.display = 'block';
	}
	
	function copyHtml(from, to)
	{
		var fromcont = document.getElementById(from);
		var tocont = document.getElementById(to);
		
		tocont.innerHTML = fromcont.innerHTML;
	}
	
	
	function lift_deliv_pref()
	{
		var pref_val = document.getElementById('addrcheck').value;
		var deliv_choice="";
		
		switch(pref_val)
		{
			case '0':
			deliv_choice = "Delivery to my default Address<br>";
			document.getElementById('addrcheck_info').style.display='block';
			document.getElementById('default_addr_block').style.display='block';
			document.getElementById('addrcheck_info').innerHTML=deliv_choice;
			document.getElementById('default_addr_block').innerHTML=document.getElementById('def_addr').textContent;
			break;
			
			case '1':
			deliv_choice = "Delivery to a new Address<br>";
			document.getElementById('addrcheck_info').innerHTML=deliv_choice;
			document.getElementById('default_addr_block').style.display='none';
			document.getElementById('new_addr_out').style.display='block';
			
			document.getElementById('street_info').innerHTML=document.getElementById('street_in').value.trim();
			document.getElementById('city_info').innerHTML=document.getElementById('city_in').value.trim();
			document.getElementById('state_info').innerHTML=document.getElementById('state_in').value.trim();
			document.getElementById('country_info').innerHTML=document.getElementById('country_in').value.trim();
			
			document.getElementById('hid_street').value=document.getElementById('street_in').value.trim();
			document.getElementById('hid_city').value=document.getElementById('city_in').value.trim();
			document.getElementById('hid_state').value=document.getElementById('state_in').value.trim();
			document.getElementById('hid_country').value=document.getElementById('country_in').value.trim();
			break;
			
			case '2':
			deliv_choice = "I'll pick up my items at your location<br>";
			document.getElementById('addrcheck_info').innerHTML=deliv_choice;
			document.getElementById('default_addr_block').style.display='none';
			document.getElementById('office_addr_out').style.display='block';
			document.getElementById('office_addr_out').innerHTML=document.getElementById('office_addr_in').innerHTML;
			break;
			
			default:
		}
		
		document.getElementById('hid_addrcheck_info').value=pref_val;
	}
	
	
	function lift_payment_pref()
	{
		var pay_pref_val = document.getElementById('paymentcheck').value;
		var pay_choice="";
		
		switch(pay_pref_val)
		{
			case '0':
			pay_choice = "Direct Deposit to Bank<br>";
			document.getElementById('paymentcheck_info').style.display='block';
			document.getElementById('bank_details_out').style.display='block';
			document.getElementById('paymentcheck_info').innerHTML=pay_choice;
			document.getElementById('bank_details_out').innerHTML=document.getElementById('bank_details_in').innerHTML;
			break;
			
			default:
		}
		
		document.getElementById('hid_paymentcheck_info').value=pay_pref_val;
	}
	
	function lift_prefs()
	{
		lift_deliv_pref();
		lift_payment_pref();
	}
	
	/*
	$(document).ready(function()
	{
		$( ".comp_table tbody tr:odd" ).css( "background-color", "#f5f5f8" );
	});
	*/
	

//-->
</script>
