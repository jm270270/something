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


$barcode = "";
$account = "";
$receiver = "";
$weight = "";
$shipping_line = "";
$description = "";
$date = "";

$sql = "SELECT * 
		FROM freight_note 
		ORDER BY id DESC, date DESC
		LIMIT 20";

$result = $conn->query($sql);



// output standard of table tag

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$barcode = $row["barcode"];
		$account = $row["account"];
		$receiver = $row["receiver"];
		$weight = $row["weight"];
		$shipping_line = $row["shipping_line"];
		$description = $row["description"];
		$date = $row["date"];
		
		$temp = $description;
		$substr = "]";
		$attachment = $substr . "<br>";
		$newDescription = str_replace($substr, $attachment, $temp);
    }
	echo "<tr>" . 
		"<th>" . $barcode . "</th>" . 
		"<th>" . $account . "</th>" .
		"<th>" . $receiver . "</th>" . 
		"<th>" . $weight . "</th>" .
		"<th>" . $shipping_line . "</th>" . 
		"<th>" . $description . "</th>" .
		"<th>" . $date . "</th>" .
	"</tr>";	
} else {
    echo "bad";
}
echo "hello";
$conn->close();

?>