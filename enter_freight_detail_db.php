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

$product_barcode = $_GET["product_barcode"];

$barcode = "";
$product_name = "";
$content = "";
$unit = "";
$price = "";

$sql = "SELECT *
		FROM product 
		WHERE barcode = '$product_barcode'";
$result = $conn->query($sql);



// output standard of table tag

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $barcode = $row['barcode'];
		$product_name = $row['product_name'];
		$content = $row['content'];
		$unit = $row['unit'];
		$price = $row['price'];
    }
	echo "<tr>" . 
		"<th contenteditable='true'>" . $barcode . "</th>" . 
		"<th contenteditable='true'>" . $product_name . "</th>" .
		"<th contenteditable='true'>" . 1 . "</th>" .
		"<th contenteditable='true'>" . $content . " " . $unit . "</th>" .
		"<th>" . $price . "</th>" . 
		"<th><input type = 'button' id = 'delete' value = '删除' onclick = 'delete_row(this)'></th>" . 
	"</tr>";	
} else {
    echo "bad";
}
$conn->close();

?>
