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
$product_barcode = $_GET["product_barcode"];
$product_name = $_GET["product_name"];
$amount = $_GET["amount"];
$content_unit = $_GET["content_unit"];
$price = $_GET["price"];

$description = "";
$total_price = 0;
$sql = "SELECT *
		FROM freight_note
		WHERE barcode = '$freight_barcode'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $description = $row["description"];
		$total_price = $row["total_price"];
    }
} else {
    echo "0 results";
}

$sql2 = "SELECT *
		FROM product
		WHERE barcode = '$product_barcode'";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
    while($row2 = $result2->fetch_assoc()) {
        $content = $row2["content"];
		$unit = $row2["unit"];
    }
} else {
    echo "0 results";
}


if ($content == 0){	//如果是0
	$description .= "[" . $product_name . "x" . $amount . "]" ;
}
else{
	$description .= "[" . $product_name . "(" . $content_unit. ")x" . $amount . "]" ;
}

$total_price += $price;





$sql = "UPDATE freight_note
		SET description = '$description', total_price = '$total_price'
		WHERE barcode = '$freight_barcode'";
$result = $conn->query($sql);
if ($result === true){
	echo "good";
} else {
    echo "bad";
}

$conn->close();
?>