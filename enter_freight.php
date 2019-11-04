<?php 
session_start(); 

if($_SESSION['login_user'] == false){
	header("location: ../login.php");
}else if(!isset($_SESSION['login_user']) || empty($_SESSION['login_user'])){
	header("location: ../login.php");
}else{
	
}
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>箱子条形码</title>
	<script src="enter_freight.js"></script>
</head>

<body>
	<form action= "" method= "POST">
		<fieldset>
			<legend>泛捷条形码</legend>
			<input type = "text" id = "freight_barcode">
		</fieldset>
		
		<input type = "button" onclick = "freight_create()" value = "确定"> 
		<input type="button" onclick="location.href='../index.php'" value="返回"/></br>
	</form>
	
	<table border="1" id = "table_list">
		<tr>
			<th>运单条形码</th>
			<th>泛捷帐号</th>
			<th>收件人</th>
			<th>磅数</th>
			<th>线路</th>
			<th>运单详细</th>
		</tr>
		<tbody id = "display"></tbody>
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
					LIMIT 5";

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
					
					echo "<tr>" . 
						"<th>" . $barcode . "</th>" . 
						"<th>" . $account . "</th>" .
						"<th>" . $receiver . "</th>" . 
						"<th>" . $weight . "</th>" .
						"<th>" . $shipping_line . "</th>" . 
						"<th>" . $newDescription . "</th>" .
						"<th>" . $date . "</th>" .
					"</tr>";	
				}
				
			} else {
				echo "bad";
			}

		?>
		
	</table>
	
	<?php
	$sql = "SELECT count(*) AS temp
			FROM freight_note";

			$result = $conn->query($sql);



			// output standard of table tag

			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "总共运单数: <b>" . $row["temp"] ;
				}
			}
			else{
				echo "0 result";
			}
			
			$conn->close();
	?>
</body>
</html>