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
$barcode = $_GET["product_barcode"];
$product_name = $_GET["product_name"];
$content = $_GET["content"];
$unit = $_GET["unit"];
$price = $_GET["price"];

$sql = "INSERT INTO product (barcode, product_name, content, unit, price)
		VALUES ('$barcode', '$product_name', '$content', '$unit', '$price')";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo "good";
} else {
    echo "bad";
	echo $barcode;
}

$conn->close();
?>