
<style>
	<!--
	.hist_hd
	{
		padding: 5px 10px 5px 10px;
		background-color: #369;
		color: #ddf;
		border: 1px solid #258;
		border-radius: 10px 10px 0px 0px;
	}
	
	.viewlnk
	{
		font-size: small;
		float: right;
		border: 2px solid #069;
		background-color: #36c;
		padding:3px;
		border-radius: 8px;
	}
	
	.viewlnk a
	{
		color: inherit;
	}
	
	.details_div
	{
		display: none;
		width:100%;
		background-color: #dee7ef;
		padding: 0px 3px 3px 3px;
		
	}
	
	.details_div table
	{
		font-size: small;
		width: 99%;
	}
	
	.total
	{
		text-align: right;
		padding-right: 5px;
	}
	
	.inv_prnt_lnk
	{
		font-size: small;
		display: none;
		color: #3cc;
	}
	
	
	
	
	//-->
</style>


<?php

?>
<div id="order_hist_cont">
	<div class="ordercont">
	
	<?php
	$cus = $_SESSION['customer_id'];
	/*--- obtain data for customer_id from orders table ---*/
	//order id
	$oid_arr = getColumnValueByLimit($conn, 'order_id', 'orders', 'customer_id', $cus,0 , 30, 'order_id','DESC');
	$totalprice_arr = getColumnValueByLimit($conn, 'total_price', 'orders', 'customer_id', $cus,0 , 30, 'order_id','DESC');
	$date_arr = getColumnValueByLimit($conn, 'date', 'orders', 'customer_id', $cus,0 , 30, 'order_id','DESC');
	$invoice_arr = getColumnValueByLimit($conn, 'invoice_no', 'orders', 'customer_id', $cus,0 , 30, 'order_id','DESC');
	
		
	foreach($oid_arr as $index => $oid)
	{
		$o_no = $oid_arr[$index];
		$o_total = $totalprice_arr[$index];
		$o_date = $date_arr[$index];
		$o_invoice = $invoice_arr[$index];
		
		$out1 = 	"<div class=\"hist_hd\">";
		$out1 .= "	<span class=\"order_no\">Order#: ".$o_no."</span> &nbsp; &nbsp; || &nbsp; &nbsp; <span class=\"order_tot\">Total: N".$o_total."</span>
		 &nbsp; &nbsp; || &nbsp; &nbsp; <span class=\"order_date\">Date: ".$o_date."</span>&nbsp; &nbsp; || &nbsp; &nbsp; <span>
		 Invoice #".$o_invoice."</span>&nbsp; &nbsp;<span id=\"lnk".$o_no."\" class=\"viewlnk\">
		 <a href=\"#\" onclick=\"showHide(this.id,'div".$o_no."', 'prnt".$o_no."')\">Show/Hide details</a></span> 
		 <a id=\"prnt".$o_no."\" class=\"inv_prnt_lnk\" href=\"javascript:void()\" title=\"Click to print invoice no ".$o_no."\" onclick=\"doPrint('div$o_no', '$o_no', '$o_total', '$o_date', '$o_invoice')\">Print this invoice</a> 
					
					<div style=\"clear: both;\"></div>
					</div>";
		$out1 .= "<div id=\"div".$o_no."\" class=\"details_div\">";
		$out1 .= "	<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><thead>
					<tr><th>S/N</th><th>Item</th><th>Quantity</th><th>Unit Price</th><th>Sub-Total</th><th>Tax</th><th>Total</th></tr></thead><tbody>";
		echo $out1;
		
		//obtain order details for specific order id
		$item_name_arr = getColumnJoinValueByLimit($conn, 'item_name', 'order_details', 'items', 'item_id', 'order_id', $oid, 0, 10000, 'order_id','DESC');
		$qty_arr = getColumnValueByLimit($conn, 'quantity', 'order_details', 'order_id', $oid, 0, 10000, 'order_id','DESC');
		$unitprice_arr = getColumnValueByLimit($conn, 'price', 'order_details', 'order_id', $oid, 0, 10000, 'order_id','DESC');
		$tax_arr = getColumnValueByLimit($conn, 'tax', 'order_details', 'order_id', $oid, 0, 10000, 'order_id','DESC');
		
		foreach($item_name_arr as $ind => $nm)
		{
			$ind_no = $ind+1;
			$subtotal = findSubTotal($qty_arr[$ind], $unitprice_arr[$ind]);
			$agg_total = findTotalAmount($qty_arr[$ind], $unitprice_arr[$ind], $tax_arr[$ind]);
			
			$out2 = "<tr><td>".$ind_no."</td><td>".$item_name_arr[$ind]."</td><td>".$qty_arr[$ind]."</td><td>".$unitprice_arr[$ind]."</td><td>".$subtotal."</td><td>".$tax_arr[$ind]."</td><td>".$agg_total."</td></tr>";
			
			echo $out2;
		}
		
		$out3 = "<tr><th class=\"total\" colspan=\"7\">N".$o_total."</th></tr>
				</tbody></table>
				</div>";
		echo $out3;
	}
	
	?>
	
	</div>
</div>