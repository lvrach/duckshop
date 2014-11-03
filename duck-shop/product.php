<?php 
	
	$uid = $_SESSION['uid'];
	
	$pid = $_GET['pid'];

	if(isset($_POST['text']) &&
		session_is_registered("login") ) {

		$text = $_POST['text'];
		
		
			
		$sql = "INSERT INTO `comments` (`uid`, `pid`,`text`) 
				VALUES ('$uid','$pid','$text') ;";
					
		$rm->mysql_query($sql);
		
	}

?>

<?php
	
	$sql = "SELECT * FROM `products` WHERE id=$pid  ;";
	$result = $rm->mysql_query($sql);
	
	$row = mysql_fetch_array($result);
	
	echo "<h2>" . $row['title'] . "</h2>" ;
	echo '<img src="' . $row['thumbnail-url'] . '" width="200" />';
	echo $row['description'] . "<br/><br/>" ;
	echo "<b>price " . $row['price'] . "$ </b><br/>" ;
	
?>
<a href="index.php?p=cart.php&a=add&pid=<?echo $pid;?>"> add to cart</a>
<h3>Comments:</h3>

<?php	
	$sql = "SELECT * FROM `comments` 
			JOIN users ON comments.uid = users.id 
			WHERE comments.pid= $pid ;";
	$result = $rm->mysql_query($sql);
	echo "<ul>";
	while ( $row = mysql_fetch_array($result) ) {
		echo "<li>" ;
		echo '<img src="images/avatars/' . $_SESSION['name'] . '.jpg" width="auto" height="40" ></img>';
		echo "<b> " . $row['name'] . "</b> :<br/>  " . $row['text'];
		echo "</li>" ;
		
	}
	echo "</ul>";
?>

<?php if(session_is_registered("login")) { ?>

	<form method="POST" >		
		<b>add your comment:</b><br/>
		<textarea name="text"></textarea><br/>
		<input type="submit" value="send">
	</form>

<?php } ?>
