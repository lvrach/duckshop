<?php 
	session_start();
	require_once('RemoteMonitor.php');
	$rm = new RemoteMonitor('7070');
	
	require_once('connect_db.php');
?>

<html>
	<head>
		<title>Admin Panel</title>
	</head>
	<body>
		<h1> Shop Admin Panel </h1> 
		
		<image src="<? echo $_SESSION['avatar']; ?>" width="60" height="auto" ></image>
		<?php 
			if(session_is_registered("login") && $_SESSION['role'] == "admin") {
				echo 'Wellcome ' . $_SESSION['name'] . ' Duck';
		
				include("admin/" . $_GET['p']);	
			}
			else {

				echo "You are not admin, you are just a " . $_SESSION['role'];	
			}

		?>		

		
	</body>

</html>