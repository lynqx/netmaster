<!doctype html>
<html>
<head>
<style>
	<!--
	body
	{
		font: normal normal 12px Arial, Helvetica;
	}
	
	#header
	{
		text-align: center;
	}
	
	#prntdiv
	{
		width: 90%;
		font-size: 12px;
		border: 2px solid #eee;
		text-align: left;
		margin: 5px;
		padding: 5px;
		color: #333;
		background-color: #fefefe;
		margin-left: auto;
		margin-right: auto;
		border-radius: 10px;
	}
	
	.hist_hd
	{
		font-weight: bold;
		background-color: #9cf;
		padding: 3px;
		border: 2px solid #ccc;
		border-radius: 6px;
	}
	
	table
	{
		width: 100%;
		margin-left: auto;
		margin-right: auto;
		margin-top: 10px;
	}
	
	.total
	{
		text-align: right;
		padding-right: 20px;
	}
	
	td
	{
		padding-top: 6px;
	}
	
	button
	{
		margin-left: auto;
		margin-right: auto;
	}
	

	//-->
</style>

<?php
	$cont = $_GET['cont'];
	$no = $_GET['no'];
	$tot = $_GET['tot'];
	$date = $_GET['date'];
	$inv = $_GET['inv'];

?>
<title><?php echo "Order # $no || $date"; ?></title>

</head>
<body>
	<div id="header">
		<img src="" />header here....
	</div>
	<div id="prntdiv">
		<div class="hist_hd">
			<span class="order_no">Order#: <?php echo $no; ?></span> &nbsp; &nbsp; || &nbsp; &nbsp; <span class="order_tot">Total: N<?php echo $tot; ?></span> &nbsp; &nbsp; || &nbsp; &nbsp; <span class="order_date">Date: <?php echo $date; ?></span>&nbsp; &nbsp; || &nbsp; &nbsp; <span>Invoice #<?php echo $inv; ?></span>
		</div>
		<?php
			echo $cont;
		?>
		
	</div>
	<div style="text-align: center;">
	<button onclick="window.print()">Print Me!</button>
	</div>
</body>
</html>