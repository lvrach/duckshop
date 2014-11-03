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

		$name=$_POST["name"];
		$pass=$_POST["pass"];	
		$email=$_POST["email"];
		$cc = $_POST["credit-card"];
	
		$rm->title("Register new user");
		
		
		$allowedExts = array("jpg", "jpeg", "gif", "png");
		$tmpinfo = pathinfo($_FILES['img-upload']['name']);
		
		if ( in_array($tmpinfo['extension'], $allowedExts) ) {

			$rm->title("Creating account");
			$sql = "SELECT * FROM `users` WHERE name='$name';";
			$result = $rm->mysql_query($sql) or die('<pre>' . mysql_error() . '</pre>' );  	
			
			if( $result && mysql_num_rows( $result ) == 0 ) {
					
				
				$_avatar_img_path = $_avatar_img_path . $name . "." . $tmpinfo['extension'] ;
					
				if(move_uploaded_file($_FILES['img-upload']['tmp_name'], $_avatar_img_path)){
					echo "upload image successful <br/>" ;
				}
				else {
					echo "error moving img <br/>" ;
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
		else {
			
			echo "Invalid image file";
		
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
		<tr><td><input type="submit" value="Register" /></td><td><?php if(isset($_GET['referral'])) echo $_GET['referral'] . ' is your referral' ?></td></tr>
	  </tbody>
 </table>

</form>
