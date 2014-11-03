<?php 
	session_start();
	require_once('remote-monitor/RemoteMonitor.php');
	$rm = new RemoteMonitor('7070');
	header('X-XSS-Protection:0');	
	$__REAL_DIRECTORY = $_SERVER['DOCUMENT_ROOT'] . '/';
	
	if(isset($_POST['o__sec-level'])) {
		
		session_destroy(); //logout 
		switch ($_POST['o__sec-level']) {			
			case 'high':				
        		setcookie('SECURITY_LEVEL', 'high', time()+60*60*24*30);
				$__SECURITY_LEVEL =  'high';
				symlink('levels/high/images', 'images');
			break;
			case 'medium':
				setcookie('SECURITY_LEVEL', 'medium', time()+60*60*24*30);
				$__SECURITY_LEVEL =  'medium';
				symlink('levels/medium/images', 'images');
				break;
			case 'low':		
			default:				
				setcookie('SECURITY_LEVEL', 'low', time()+60*60*24*30);
				$__SECURITY_LEVEL =  'low';
				symlink('levels/low/images', 'images');
				break;
		}
		header('Location: index.php');
	}
	else {

		if(!isset($_COOKIE['SECURITY_LEVEL'])) {
			
			setcookie('SECURITY_LEVEL', 'low', time()+60*60*24*30);
			$__SECURITY_LEVEL =  'low';
			symlink('levels/low/images', 'images');
		}
		else {
			$__SECURITY_LEVEL = $_COOKIE['SECURITY_LEVEL'];
		}
	}
	
	require_once('connect_db.php');

	$rm->title("Duck shop");
	

	echo '<div class="web-sec">  <form method="POST">';
	echo 'security level: '   ;
	echo '<select value="' . $__SECURITY_LEVEL . '" name="o__sec-level" >
  			<option '.(($__SECURITY_LEVEL == 'low')?'selected="selected"':'').'value="low">low</option>
  			<option '.(($__SECURITY_LEVEL == 'medium')?'selected="selected"':'').'value="medium">medium</option>
  			<option '.(($__SECURITY_LEVEL == 'high')?'selected="selected"':'').'value="high">high</option>  			
		</select> <input type="submit" value="set" />';
	echo '</form></div>';
	
		switch ( $__SECURITY_LEVEL ) {
		case 'high':
			include('levels/high/' . basename($_SERVER['SCRIPT_FILENAME']) );
			break;

		case 'medium':
			include('levels/medium/' . basename($_SERVER['SCRIPT_FILENAME']) );
			break;

		case 'low':
		default:			
			include('levels/low/' . basename($_SERVER['SCRIPT_FILENAME']) );
			break;
		
	}
?>
