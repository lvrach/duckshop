<?php 
	session_start();
	require_once('remote-monitor/RemoteMonitor.php');
	$rm = new RemoteMonitor('7070');
		
	require_once('connect_db.php');

	$rm->title("Duck shop");
?>

<html>
	<head>
		<title> Duck Shop </title>
		<link href="style.css" rel="stylesheet" type="text/css"></link>
	<head>
	<body>
		<div class="header">
			<div class="logo left">
				<h1> Duck Shop </h1> 			
			
				
			</div>	
			
			<div class="right">
				<div class="search">
					<form  method="POST" action="index.php?p=catalog" > 
						<input type="text" name="q"/>
						<input type="submit" value="Search"/>
					</form>
				</div>

				<div class="avatar">
				<?php 
					if(session_is_registered("login")) {
						echo '<img src="' .$_SESSION['avatar'] . '" width="60px" height="60px" ></img>';
						echo '<span> Wellcome ' . $_SESSION['name'] . '</span>';
						echo '<div class="hnavbar"><ul>';
						echo '<li><a href="?p=logout">Logout</a></li> ' ;
						echo '<li><a href="?p=remove">Delete </a></li>' ;
						echo '</ul></div>';
					}
				?>		
				</div>
				
			</div>



		</div>	

		
		<div  class="main-container">
			<div class="menu hnavbar">
				<ul>
				<li><a href="?p=catalog">Cataloge</a></li>	
				<?php 
					if(!session_is_registered("login")) {
						echo '<li><a href="?p=register">Register</a></li>		
							<li><a href="?p=login">Login</a></li>';
					}
					else {		
						echo '<li><a href="?p=cart">Cart</a></li>';					
					}
					if( $_SESSION['role'] == 'admin' ) {
						echo '<li><a href="?p=admin"> Admin panel</a></li>';
					}
				?>
				</ul>
			</div>
				
				<div class="contex">
				<?php
					if($_GET['p']=="")
						include('home.php');
					else	
						include($_GET['p'] . '.php');	
				?>	
				</div>	
			</div>
		</div>
		
	</body>

</html>
