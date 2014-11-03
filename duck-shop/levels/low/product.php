<?php 
	$rm->title("Product Page");
	$uid = $_SESSION['uid'];
	
	$pid = $_GET['pid'];

	if(isset($_POST['text']) &&
		session_is_registered("login") ) {
		$rm->title("New comment at product");

		$text = addslashes($_POST['text']);		
			
		$sql = "INSERT INTO `comments` (`uid`, `pid`,`text`) 
				VALUES ('$uid','$pid','$text') ;";
					
		$rm->mysql_query($sql);
		
	}

?>

<?php
	
	$sql = "SELECT * FROM `products` WHERE id=$pid  ;";
	$result = $rm->mysql_query($sql);
	$rm->hl_sql($pid);
	
	$row = mysql_fetch_array($result);
	
	echo "<h2>" . $row['title'] . "</h2>" ;
	echo '<img src="' . $row['thumbnail-url'] . '" width="200" />';
	echo $row['description'] . "<br/><br/>" ;
	echo "<b>price " . $row['price'] . "$ </b><br/>" ;
	
	if(session_is_registered("login")) {
		echo '<a href="index.php?p=cart.php&a=add&pid=' . $pid .'"> add to cart</a>';
	}
	else {
		echo '<a href="index.php?p=login.php">login to buy </a>';
	}

?>
<h3>Comments:</h3>
<div class="comments">
<?php	
	$sql = "SELECT * FROM `comments` 
			JOIN users ON comments.uid = users.id 
			WHERE comments.pid= $pid ;";			
	$result = $rm->mysql_query($sql);
	$rm->hl_sql($pid);
	echo "<ul>";
	while ( $row = mysql_fetch_array($result) ) {
		echo "<li>" ;
		echo '<img src="'. $row['imgurl'] . '" width="40px" height="40px" ></img>';
		echo "<b> " . $row['name'] . "</b> :<br/>  " . $row['text'];
		echo "</li>" ;
		
	}
	echo "</ul>";
?>
</div>

<?php if(session_is_registered("login")) { ?>

	<form method="POST" >		
		<b>add your comment:</b><br/>
		<textarea name="text"></textarea><br/>
		<input type="submit" value="send">
	</form>

<?php } ?>
