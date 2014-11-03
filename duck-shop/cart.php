<?php
	if(!session_is_registered("login"))
		header( 'Location: index.php' );

	$uid = $_SESSION['uid'];
	
	
	if (isset($_POST['confirm']) ) {               

        $sql = "DELETE FROM `cart` WHERE uid='$uid';";
        $result = $rm->mysql_query($sql);        
    }

	if($_GET['a']=='add' && $_GET['pid']) {
		
		$pid = $_GET['pid'];
		
		$sql = "INSERT INTO `cart` (`pid`, `uid`, `quantity`) 
				VALUES ('$pid','$uid' , 1) ;";
				
		$result = $rm->mysql_query($sql);
		
	} 
	else if($_GET['a']=='remove' && $_GET['cid']) {
		
		$cid = $_GET['cid'];
		
		$sql = "DELETE FROM `cart` WHERE `id` = $cid ";
		
		$result = $rm->mysql_query($sql);
	}
	?>
	<h2> cart list :</h2>
	<?php	
		$sql = "SELECT cart.id AS cid, products.title
		  FROM `cart` 
			JOIN products ON cart.pid = products.id 
			WHERE cart.uid= $uid ;";
		$result = $rm->mysql_query($sql);
		
		echo "<ul>";
		while ( $row = mysql_fetch_array($result) ) {
			
			echo "<li>" ;
			echo "<b> " . $row['title'] . "</b> ";
			echo "<a href=\"index.php?p=cart.php&a=remove&cid=" . $row['cid'] ." \">remove</a>" ;
			echo "</li>" ;
		
		}
		echo "</ul>";


?>

<form method="POST" >
	<input hidden="hidden" type="text" name="confirm"/>	
	<input type="submit" value="Buy">
</form>

