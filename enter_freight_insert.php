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
$freight_barcode = $_GET["freight_barcode"];

$sql = "INSERT INTO freight_note (barcode, date)
		VALUES ('$freight_barcode', CURRENT_TIMESTAMP())";
$result = $conn->query($sql);

if ($result === TRUE) {
    echo "good";
	$_SESSION["freight_barcode"] = $freight_barcode;
} else {
    echo "bad";
}

$conn->close();
?>