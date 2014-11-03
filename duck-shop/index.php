<?php 
	session_start();
	require_once('RemoteMonitor.php');
	$rm = new RemoteMonitor('7070');
	
	require_once('connect_db.php');
?>

<html>
	<head>
		<title> Duck Shop </title>
	<head>
	<body>
		<h1> Duck Shop </h1> 
		
		<img src="<? echo $_SESSION['avatar']; ?>" width="auto" height="60" ></img>
		<?php 
			if(session_is_registered("login")) 
				echo 'Wellcome ' . $_SESSION['name'] . ' Duck';
		?>		
		<hr/>
		<a href="?p=catalog.php">Cataloge</a>
		<?php if(!session_is_registered("login")){ ?>
		<a href="?p=register.php">Register</a>		
		<a href="?p=login.php">Login</a>
		<?php } else { ?>
		<a href="?p=cart.php">Cart</a>	
		
		<a href="?p=logout.php">Logout</a> ||
		<a href="?p=remove.php">Remove Account</a>
		<?php } ?>

		<form method="POST" action="index.php?p=catalog.php" > 
			<input name="q"/>
			<input type="submit" value="Search"/>
		</form>

		<hr/>
		<?php
				
			include($_GET['p']);	
		?>		

		
	</body>

</html>
