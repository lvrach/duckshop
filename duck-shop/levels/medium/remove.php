 <?php 

    if (isset($_POST['confirm']) ) {        

        $name = $_SESSION['name'];
        $rm->title("User: $name delete account");
        
        unlink($_SESSION['avatar']);

        $sql = "DELETE FROM `users` WHERE name='$name';";
        $result = $rm->mysql_query($sql); 

        session_destroy(); //logout 
    }

?>

<form method="POST" >
	<input hidden="hidden" type="text" name="confirm"/><br/>
	Remove Account :
	<input type="submit" value="Confirm">
</form>
