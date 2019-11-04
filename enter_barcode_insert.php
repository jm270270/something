
<?php
require("../conn.php");
session_start(); 
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