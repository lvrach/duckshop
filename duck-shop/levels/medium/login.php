<? 	

	$rm->title("login page");

    if (isset($_POST['name']) && 
        isset($_POST['pass']) &&
        $_POST['name'] != "" &&
        $_POST['pass'] != "" ) {
        
        $rm->title("User login");

        // Sanitise username input 
        $name = $_POST['name']; 
        $name = addslashes($name);
       

        // hashing password input 
        $pass = $_POST['pass']; 

        $pass = md5( $pass ); 

        $sql = "SELECT * FROM `users` WHERE name='$name' AND pass='$pass';";
        $result = $rm->mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' ); 
        $rm->hl_sql($name);
        $rm->hl_sql($pass);

        if( $result && mysql_num_rows( $result ) == 1 )
        { 
    		$row = mysql_fetch_array($result);
    		
    		session_register("login");
    		$_SESSION['uid'] = $row['id'];
    		$_SESSION['name']= $row['name'];
    		$_SESSION['role'] = $row['role'];
            $_SESSION['avatar'] = $row['imgurl'];
            
             
            if($row['role'] == "admin") 
                $rm->title("admin login successful"); 
            else
                $rm->title("User login successful");

            //echo "login successful " . $row['name'];
            header('Location: index.php'); 
        }
        else { 
            // Login failed 
            //s3//sleep(3); //give a hard time at brude forcers
            $rm->title("User login failed"); 
            echo "<pre>Username and/or password incorrect.</pre><br/>"; 
        } 
    }

?>

<form method="POST" >
<table>
    <tbody>
         <tr><td>Name:</td><td><input type="text" name="name"/></td></tr>
          <tr><td>Password:</td><td><input type="password" name="pass"/></td></tr>
          <tr><td><input type="submit" value="Login"/></td><td><span>login</span></td></tr>
     </tbody>
 </table>
 </form>
