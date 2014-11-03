<?php 
			if(session_is_registered("login") && $_SESSION['role'] == "admin") {
				echo 'Wellcome ' . $_SESSION['name'] . ' Duck';
		
				include("admin/" . $_GET['p']);	
			}
			else {

				echo "You are not admin, you are just a " . $_SESSION['role'];	
				die();
			}

	

	$_thumbnail_img_path = "images/products/";
	

	if( isset($_POST['title']) &&
		isset($_POST['description']) &&
		isset($_POST['price']) &&
		
		$_POST['title'] != "" &&
		$_POST['description'] != "" &&
		$_POST['price'] != "" ) {

		$title=$_POST["title"];
		$description=$_POST["description"];
		$price=$_POST["price"];		
		
				
		$_thumbnail_img_path = $_thumbnail_img_path . $title . pathinfo($_FILES['img-upload']['tmp_name'], PATHINFO_EXTENSION);
				
			if(move_uploaded_file($_FILES['img-upload']['tmp_name'], $_thumbnail_img_path)){
				echo "upload image successful <br/>" ;
			}				
				
			$sql = "INSERT INTO `products` (`title`,`description`,`thumbnail-url`,`price`) 
					VALUES ('$title', '$description', '$_thumbnail_img_path', '$price');";
			$result = mysql_query($sql)  or die('<pre>' . mysql_error() . '</pre>' );
			
			echo "product added successful" ;
		
	}
	
?>


<form enctype="multipart/form-data" method='POST' >
	Title : <input type="text" name="title"/> <br/>
	Description : <input type="text" name="description"/> <br/>
	Price : <input type="text" name="price" /> <br>	
	Thumbnail : <input type="file" name="img-upload" /> <br/>
	<input type="submit" value="Add" />
</form>
