<?php
		//fetch phone nos from database
		$sel_shop = "SELECT set_value FROM settings where set_key LIKE 'shop_phone%'";
		
		$addr_result = mysqli_query($conn, $sel_shop) or die(mysqli_error($conn).'Failed to fetch shop phone numbers!');
		echo "<hr><div id=\"contacts\" style=\"background-color: #fff6e8; padding: 3px;\"><span class=\"less\">Contact Hotlines:</span><br>";
		$addr_cnt = 0;
		while($addr_rows = mysqli_fetch_row($addr_result))
		{
			if($addr_rows[0]!="")
			{
				$addr_cnt++;
				if($addr_cnt==1)
				echo $addr_rows[0];
				else
				echo " ; ".$addr_rows[0];
			}
		}
		echo "</div>";