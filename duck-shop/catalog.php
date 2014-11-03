<?php
	if(isset($_POST['q'])) {

		$q = $_POST['q'];
		$sql = "SELECT * FROM `products` WHERE (title LIKE '$q');";
		echo $q . " <br/>";
	} 
	else {
		$sql = "SELECT * FROM `products` ;";
	}
	$result = $rm->mysql_query($sql);
?>
<h3>Product Catalog :</h3>
<?php

	while($row = mysql_fetch_array($result)) {
		echo '<a href="index.php?p=product.php&pid='.$row['id'].'" >';
		echo $row['title'] . "</a> " . $row['price'] . "$ <br/>" ;
	}
?>	
