<?php
	if(!session_is_registered("login"))
		header( 'Location: index.php' );

	$rm->title("showing user cart");
	$uid = $_SESSION['uid'];
	
	
	if ($_GET['a']=='buy') {            

		$rm->title("Checkout");
		$sql = "INSERT INTO `orders` (pid,uid) SELECT pid,uid FROM `cart` WHERE uid='$uid'";
		$rm->mysql_query($sql);
        $sql = "DELETE FROM `cart` WHERE uid='$uid';";
        $rm->mysql_query($sql);
    }
	else if($_GET['a']=='add' && isset($_GET['pid']) ){
		$rm->title("adding product to cart");
		$pid = $_GET['pid'];
		
		$sql = "INSERT INTO `cart` (`pid`, `uid`, `quantity`) 
				VALUES ( $pid, $uid , 1) ;";
				
		$result = $rm->mysql_query($sql);
		$rm->hl_sql($pid);
	} 
	else if($_GET['a']=='remove' && isset($_GET['cid']) ){
		$rm->title("removing product from cart");
		$cid = $_GET['cid'];
		
		$sql = "DELETE FROM `cart` WHERE `id` = $cid AND `uid` = $uid ";		
		$result = $rm->mysql_query($sql);
		$rm->hl_sql($cid);
	}
	?>
	<h2>Cart list :</h2>
	<?php	
	
	$sql = "SELECT cart.id AS cid, products.title
		  FROM `cart` 
			JOIN products ON cart.pid = products.id 
			WHERE cart.uid= $uid ;";
	$result = $rm->mysql_query($sql);
	
	if( mysql_num_rows($result) > 0) {
		
				
		echo "<ul>";
		
		while ( $row = mysql_fetch_array($result) ) {
			
			echo "<li>" ;
			echo "<b> " . $row['title'] . "</b> ";
			echo "<a href=\"index.php?p=cart.php&a=remove&cid=" . $row['cid'] ." \">remove</a>" ;
			echo "</li>" ;
		}
		echo "</ul>";
		echo '<a href="index.php?p=cart.php&a=buy">Buy</a>';
		
	} 
	else {
		echo "cart is empty";
	}
		
	?>
	
	<h2>Purchased items:</h2>
	<?php	
		
			
		$sql = "SELECT products.id AS pid, products.title, orders.uid
		  FROM `orders` 
			JOIN products ON orders.pid = products.id 
			WHERE orders.uid= $uid ;";
		$result = $rm->mysql_query($sql);
		
		echo "<ul>";
		
		while ( $row = mysql_fetch_array($result) ) {
			
			echo "<li>" ;
			echo "<b> " . $row['title'] . "</b> ";			
			echo "</li>" ;
		}
		echo "</ul>";
		
		
	?>

