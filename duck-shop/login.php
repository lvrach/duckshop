<? 	

	
    if (isset($_POST['name']) && 
        isset($_POST['pass']) &&
        $_POST['name'] != "" &&
        $_POST['pass'] != "" ) {
        
        // Sanitise username input 
        $name = $_POST['name']; 
        //s1//$name = stripslashes( $name ); 
        //s2//$name = mysql_real_escape_string( $name ); 

        // Sanitise password input 
        $pass = $_POST['pass']; 
        //s1//$pass = stripslashes( $pass ); 
        //s2//$pass = mysql_real_escape_string( $pass ); 
        //s1//$pass = sha1( $pass ); 

        $sql = "SELECT * FROM `users` WHERE name='$name' AND pass='$pass';";
        $result = $rm->mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' ); 

        if( $result && mysql_num_rows( $result ) == 1 )
        { 
    		$row = mysql_fetch_array($result);
    		
    		session_register("login");  
    		$_SESSION['uid'] = $row['id']; 
    		$_SESSION['name']= $name;
    		$_SESSION['role'] = $row['role'];
            $_SESSION['avatar'] = $row['imgurl'];
                    
            echo "login successful " . $_SESSION['name'];
            header('Location: index.php'); 
        }
        else { 
            // Login failed 
            //sleep(3); 
            echo "<pre>Username and/or password incorrect.</pre><br/>"; 
        } 
    }

?>

<form method="POST" >
	Username : <input type="text" name="name"/><br/>
	Password : <input type="password" name="pass"/><br/>
	<input type="submit" value="Login"/>
</form>
