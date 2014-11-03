<?php 
	
	switch ( $__SECURITY_LEVEL ) {
		case 'high':
			include('levels/high/' . basename( __FILE__) );
			break;

		case 'medium':
			include('levels/medium/' . basename( __FILE__) );
			break;

		case 'low':
		default:			
			include('levels/low/' . basename( __FILE__) );
			break;
		
	}
