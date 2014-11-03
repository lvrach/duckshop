<?php
		
	switch ( $__SECURITY_LEVEL ) {
		case 'high':
				$rm->mysql_connect("localhost","duck-shop_high","Ge5Lx7rrtzYP8fXG");
				mysql_select_db("duck-shop_high") or die(mysql_error());
			break;

		case 'medium':
				$rm->mysql_connect("localhost","duck-shop_medium","7maBLefaXuAKuA86");
				mysql_select_db("duck-shop_medium") or die(mysql_error());
			break;

		case 'low':
		default:			
				$rm->mysql_connect("localhost","duck-shop_low","FrLLHy5mmA8H2dZJ");
				mysql_select_db("duck-shop_low") or die(mysql_error());
			break;
		
	}