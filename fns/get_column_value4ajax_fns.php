<?php
//function returns search_column value from database
function getColumnValue($conn, $search_column, $table1, $table2, $join_column, $condition_column, $condition_value)
{
	
	$select = "SELECT 
			$search_column 
			FROM $table1 
			JOIN $table2
			ON $table1.$join_column=$table2.$join_column
			WHERE $condition_column='$condition_value'";
			
	//$select = "SELECT qty FROM inventory JOIN items ON inventory.item_id=items.item_id WHERE item_name='Ceiling Fan - HP87' AND qty>=0";
	$val = 0;
	
	if($result = mysqli_query($conn, $select))
	{
		while($row = mysqli_fetch_row($result))
		{
			$val += $row[0];
			
		}
	}
	else
	echo(mysqli_error($conn));
	
	mysqli_free_result($result);
	
	return($val);
}

//echo getColumnValue($conn, 'qty', 'inventory','items', 'item_id', 'item_name', 'Ceiling Fan - HP87');

