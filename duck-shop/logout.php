 <?php 

    if (session_is_registered("login") ) {        
 
        session_destroy(); //logout 
        header('Location: index.php');
    }

?>
