<?php 
	require('RemoteMonitor.php');
	
	$rm = new RemoteMonitor('7070');	
	$rm->mysql_connect("localhost","test","test");


?>
