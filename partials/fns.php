<?php
//include('../init_connect.php');



/*-------------------------------------- function returns search_column value from database */
function getColumnValue(
						$conn, 
						$search_column, 
						$table, 
						$condition_column, 
						$condition_value
						)
{
	$select = "SELECT $search_column FROM $table WHERE $condition_column='$condition_value'";
	if($result = mysqli_query($conn, $select))
	{
		$row = mysqli_fetch_row($result);
		$val = $row[0];
	}
	
	mysqli_free_result($result);
	
	return($val);
}
//echo $myval = getColumnValue($conn, 'total_price', 'orders','customer_id', '8');



/*----------------------------------------- function returns search_column value from two JOINed tables */
function getColumnJoinValue(
							$conn, 
							$search_column, 
							$table1, 
							$table2, 
							$join_column, 
							$condition_column, 
							$condition_value
							)
{
	
	$select = "SELECT 
			$search_column 
			FROM $table1 
			JOIN $table2
			ON $table1.$join_column=$table2.$join_column
			WHERE $condition_column='$condition_value'";
	
	$result = mysqli_query($conn, $select) or die(mysqli_error($conn).'Cannot fetch data!');
	
	$row = mysqli_fetch_row($result);
	
	mysqli_free_result($result);
	
	return($row[0]);
}
//echo $myval = getColumnJoinValue($conn, 'total_price', 'orders','customers', 'customer_id', 'firstname', 'Aderohunmu');


/*----------------------------------------- function returns search_column value from two JOINed tables by limit */
function getColumnJoinValueByLimit(
									$conn, 
									$search_column, 
									$table1, $table2, 
									$join_column, 
									$condition_column, 
									$condition_value, 
									$start, 
									$stop,
									$ORD,
									$ASC_DESC
									)
{
	if(!empty($ASC_DESC))
	$ordering = $ASC_DESC;
	else
	$ordering = "";
	
	if(!empty($ORD))
	$ordby = "ORDER BY ".$ORD;
	else
	$ordby = "";
	
	$select = "SELECT 
			$search_column 
			FROM $table1 
			JOIN $table2
			ON $table1.$join_column=$table2.$join_column
			WHERE $condition_column='$condition_value' $ordby $ordering LIMIT $start , $stop";
	
	$rows = array();
	
	$result = mysqli_query ($conn, $select);
	
	//$result = mysqli_query($conn, $select) or die(mysqli_error($conn).'Cannot fetch data!');
	
	while($row = mysqli_fetch_row($result))
	{
		array_push($rows, $row[0]);
	}
	
	mysqli_free_result($result);
	
	return($rows);
}

//$myval = getColumnJoinValueByLimit($conn, 'total_price', 'orders','customers', 'customer_id', 'firstname', 'Aderohunmu', 0, 10,'total_price','DESC');
//print_r($myval);



/*------------------------------- function returns search_column value from database by limit */
function getColumnValueByLimit(
								$conn, 
								$search_column, 
								$table, 
								$condition_column, 
								$condition_value, 
								$start, 
								$stop,
								$ORD,
								$ASC_DESC
								)
{
	if(!empty($ASC_DESC))
	$ordering = $ASC_DESC;
	else
	$ordering = "";
	
	if(!empty($ORD))
	$ordby = "ORDER BY ".$ORD;
	else
	$ordby = "";
	
	$select = "SELECT $search_column FROM $table WHERE $condition_column='$condition_value' $ordby $ordering LIMIT $start , $stop";
	
	$rows = array();
	$result = mysqli_query($conn, $select) or die(mysqli_error($conn).'Cannot fetch data!');
	
	
	while($row = mysqli_fetch_row($result))
	{
		array_push($rows, $row[0]);
	}
	
	
	mysqli_free_result($result);
	
	return($rows);
}
//$myval = getColumnValueByLimit($conn, 'total_price', 'orders','customer_id', 8, 0, 10,'order_id','DESC');
//print_r($myval);


/*------------------------------- function returns subtotal price for an order item */
function findSubTotal($qty, $unitprice)
{
	$qp = round($qty*$unitprice, 2);
	return $qp;
}


/*------------------------------- function returns total amount paid inclusive of tax for an order item */
function findTotalAmount($qty, $unitprice, $tax)
{
	$qpt = round($qty*$unitprice+$tax, 2);
	return $qpt;
}


/*------------------------------- function returns tabulated view of item being ordered */

function composeOrderTable($conn, $id_string)
{
	//given the $concartid
	$cartid = $id_string;
	
	//explode
	$ctid = array_map('trim', explode(',', $cartid));

	//define table header
	$tbl = "<table class=\"comp_table\"><thead><tr><th>Item Name</th><th>Price</th><th>Quantity</th><th>Vat</th><th>Total</th></tr></thead><tbody>";
	
	//define total
	$totals=0;
	
	//for each find 'item_name', 'price', 'quantity', 'vat', 'total'
	foreach($ctid as $vid)
	{
		if($vid>0)
		{
			$ct_itnm = getColumnJoinValue($conn, 'item_name', 'cart', 'items', 'item_id', 'cart_id', $vid);
			$ct_price = getColumnValue($conn, 'price', 'cart', 'cart_id', $vid);
			$ct_qty = getColumnValue($conn, 'quantity', 'cart', 'cart_id', $vid);
			$ct_vat = getColumnValue($conn, 'vat', 'cart', 'cart_id', $vid);
			$ct_tot = $ct_price*$ct_qty+$ct_vat;
		
		
			//define trows
			$tbl .= "<tr><td>$ct_itnm</td><td>$ct_price</td><td>$ct_qty</td><td>$ct_vat</td><td>$ct_tot</td></tr>";
			$totals += $ct_tot;
		}
	}
	//define table footer
	$tbl .= "</tbody><tfoot><tr><td colspan=\"4\">Total</td><td>&#8358; $totals</td></tr></tfoot></table>";
	
	return $tbl;
}

