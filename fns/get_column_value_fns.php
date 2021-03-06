<?php


//function returns search_column value from database
function getColumnValue($conn, $search_column, $table, $condition_column, $condition_value)
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



//function returns balance for quantity of item in the database
function getQtyBal($conn, $condition_column, $condition_value)
{
	$val = 0;
	
	$select = "SELECT qty FROM inventory WHERE $condition_column='$condition_value'";
	if($result = mysqli_query($conn, $select))
	{
		
		while($row = mysqli_fetch_row($result))
		{
			$val += $row[0];
		}
	}
	
	//mysqli_free_result($result);
	
	return($val);
}

