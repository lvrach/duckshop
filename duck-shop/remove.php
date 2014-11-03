 <?php 

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
