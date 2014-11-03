 <?php 

    if (session_is_registered("login") ) {        
 		$rm->title("User logout");
        session_destroy(); //logout 
        header('Location: index.php');
    }

?>
