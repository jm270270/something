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
	<title>箱子详细信息</title>
	<script src="enter_freight.js"></script>
</head>

<body>
	<form action= "" method= "POST">
		<fieldset>
			<legend>箱子详细信息</legend>
			<input type = "text" id = "freight_barcode">
		</fieldset>
		
		<input type = "button" onclick = "freight_create()" value = "确定"> <br/>
		<input type="button" onclick="location.href='../index.php'" value="返回"/></br>
	</form>
	<div id = "display" ></div>
</body>
</html>