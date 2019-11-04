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
//echo $_GET["product_barcode"];
$freight_barcode = $_SESSION["freight_barcode"];
$weight = $_GET["weight"];
$shipping_line = $_GET["shipping_line"];
$account = $_GET["account"];
$receiver = $_GET["receiver"];

$sql = "UPDATE freight_note
		SET weight = '$weight', shipping_line = '$shipping_line', account = '$account', receiver = '$receiver'
		WHERE barcode = '$freight_barcode'";
$result = $conn->query($sql);
if ($result === true){
	echo "good";
} else {
    echo "bad";
}

$conn->close();
?>