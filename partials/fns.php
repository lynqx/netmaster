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
	
	$result = mysqli_query($conn, $select) or die(mysqli_error($conn).'Cannot fetch data!');
	
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



// Sms functions start here

function PostRequest($url, $_data) 
{
	//sms processor
	 
    // convert variables array to string:
    $data = array();    
    while(list($n,$v) = each($_data)){
        $data[] = "$n=$v";
    }    
    $data = implode('&', $data);
    // format --> test1=a&test2=b etc.
 
    // parse the given URL
    $url = parse_url($url);
    if ($url['scheme'] != 'http') { 
        die('Only HTTP request are supported !');
    }
 
    // extract host and path:
    $host = $url['host'];
    $path = $url['path'];
 
    // open a socket connection on port 80
    $fp = fsockopen($host, 80);
 
    // send the request headers:
    fputs($fp, "POST $path HTTP/1.1\r\n");
    fputs($fp, "Host: $host\r\n");
    fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
    fputs($fp, "Content-length: ". strlen($data) ."\r\n");
    fputs($fp, "Connection: close\r\n\r\n");
    fputs($fp, $data);
 
    $result = ''; 
    while(!feof($fp)) {
        // receive the results of the request
        $result .= fgets($fp, 128);
    }
 
    // close the socket connection:
    fclose($fp);
 
    // split the result header from the content
    $result = explode("\r\n\r\n", $result, 2);
 
    $header = isset($result[0]) ? $result[0] : '';
    $content = isset($result[1]) ? $result[1] : '';
 
    // return as array:
    return array($header, $content);
	
}

?>