<?php
//function returns TRUE if model or barcode already exists in database

function itemExists($conn, $table, $search_column, $search_value)
{
	$select = mysqli_query($conn, "SELECT * FROM $table WHERE $search_column='$search_value'");
	$row = mysqli_num_rows($select);
	
	if($row>0)
	return true;
	else
	return false;
	
	//free result set
    mysqli_free_result($select);
}