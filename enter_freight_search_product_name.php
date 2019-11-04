<?php 
session_start(); 

if($_SESSION['login_user'] == false){
	header("location: ../login.php");
}else if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
	header("location: ../login.php");
}else{
	
}
?>

<?php
require("../conn.php");

$product_name_search = $_GET["product_name"];

$sql = "SELECT *
		FROM product
		WHERE product_name LIKE '%$product_name_search%'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $barcode = $row['barcode'];
		$product_name = $row['product_name'];
		$content = $row['content'];
		$unit = $row['unit'];
		$price = $row['price'];
		
		$output = $product_name . $content . $unit;
		echo "<tr>" . 
				"<th>" . $barcode . "</th>" . 
				"<th>" . $output . "</th>" . 
				"<th><input type = 'button' id = 'insert' value = '增加到商品列表' onclick = 'search_product_barcode2(this)'></th>" . 
			"</tr>";
    }
} else {
    echo "0 result";
}
$conn->close();
?>