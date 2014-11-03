<?php

	
	if(isset($_POST['q'])) {

		$rm->title("Search products in the catalog");
		$q = $_POST['q'];
		$sql = "SELECT * FROM `products` WHERE (title LIKE '$q');";
		$result = $rm->mysql_query($sql);
		$rm->hl_sql($q);
		echo "search for:" . $q . " <br/>";
	} 
	else {
		$rm->title("Showing all products");
		$sql = "SELECT * FROM `products` ;";
		$result = $rm->mysql_query($sql);
	}
	
?>
<h3>Product Catalog :</h3>
<?php

	while($row = mysql_fetch_array($result)) {
	
		echo '<a href="index.php?p=product.php&pid='.$row['id'].'" >';
		echo $row['title'] . "</a> " . $row['price'] . "$ <br/>" ;
	}
?>	
