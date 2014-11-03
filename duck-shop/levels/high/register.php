<?php 
	
	$rm->title("Register page");
	$_avatar_img_path = "images/avatars/";
	
	if( isset($_POST['name']) &&
		isset($_POST['pass']) &&
		isset($_POST['email']) &&
		isset($_POST['credit-card']) &&
		$_POST['name'] != "" &&
		$_POST['pass'] != "" &&
		$_POST['email'] != "" &&
		$_POST['credit-card'] != "" ) {

		$name=mysql_real_escape_string($_POST["name"]);
		$pass=mysql_real_escape_string($_POST["pass"]);	
		$email=mysql_real_escape_string($_POST["email"]);
		$cc = mysql_real_escape_string($_POST["credit-card"]);
	
		$pass = sha1( $pass );
		$rm->title("Register new user");

		$rm->title("Creating account");
		$sql = "SELECT * FROM `users` WHERE name='$name';";
		$result = $rm->mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' );  	
		
		if( $result && mysql_num_rows( $result ) == 0 ) {
				
			$tmpinfo = pathinfo($_FILES['img-upload']['name']);
			$_avatar_img_path = $_avatar_img_path . $name . "." . $tmpinfo['extension'] ;
				
			if(move_uploaded_file($_FILES['img-upload']['tmp_name'], $_avatar_img_path)){
				echo "upload image successful <br/>" ;
			}
				
				
			$sql = "INSERT INTO `users` (`name`,`pass`,`email`,`creditcard`,`imgurl`) 
					VALUES ('$name','$pass','$email','$cc','$_avatar_img_path');";
			$result = mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' );
			
			$rm->title("Creating account, successful");
			echo "register successful";
			header('Location: index.php?p=login.php'); 
		}
		else {
			$rm->title("Creating account, username exist");	
			echo "Error on registersion: Username already exist";
		}
	}
	
?>



<form enctype="multipart/form-data" method='POST' >
	<table>
    <tbody>
		<tr><td>Username : </td><td> <input type="text" name="name"/> </td></tr>
		<tr><td>Password : </td><td> <input type="password" name="pass"/> </td></tr>
		<tr><td>Email : </td><td><input type="text" name="email" /> </td></tr>
		<tr><td>Credit card : </td><td><input type="text" name="credit-card"/> </td></tr>
		<tr><td>Avatar : </td><td><input type="file" name="img-upload" /> </td></tr>
		<tr><td><input type="submit" value="Register" /></td><td></td></tr>
	  </tbody>
 </table>
</form>
