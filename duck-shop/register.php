<?php 

	$_avatar_img_path = "images/avatars/";
	
	if( isset($_POST['name']) &&
		isset($_POST['pass']) &&
		isset($_POST['email']) &&
		isset($_POST['credit-card']) &&
		$_POST['name'] != "" &&
		$_POST['pass'] != "" &&
		$_POST['email'] != "" &&
		$_POST['credit-card'] != "" ) {

		$name=$_POST["name"];
		$pass=$_POST["pass"];	
		$email=$_POST["email"];
		$cc = $_POST["credit-card"];
	

		$sql = "SELECT * FROM `users` WHERE name='$name';";
		$result = mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' );  	
		
		if( $result && mysql_num_rows( $result ) == 0 ) {
				
			$_avatar_img_path = $_avatar_img_path . $name . pathinfo($_FILES['img-upload']['tmp_name'], PATHINFO_EXTENSION);
				
			if(move_uploaded_file($_FILES['img-upload']['tmp_name'], $_avatar_img_path)){
				echo "upload image successful <br/>" ;
			}
				
				
			$sql = "INSERT INTO `users` (`name`,`pass`,`email`,`creditcard`,`imgurl`) 
					VALUES ('$name','$pass','$email','$cc','$_avatar_img_path');";
			$result = mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' );
			
			echo "register successful";
			header('Location: index.php?p=login.php'); 
		}
	}
	
?>



<form enctype="multipart/form-data" method='POST' >
	Username : <input type="text" name="name"/> <br/>
	Password : <input type="password" name="pass"/> <br/>
	Email : <input type="text" name="email" /> <br>
	Credit card : <input type="text" name="credit-card"/> <br/>
	Avatar : <input type="file" name="img-upload" /> <br/>
	<input type="submit" value="Register" />
</form>
