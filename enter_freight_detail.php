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
			
			<p id = "freight_barcode">运单条形码: <?php echo $_SESSION["freight_barcode"]; ?></p>
			
			<p>磅数</p>
			<input type = "text" id = "weight" required><br/>
			
			<p>线路</p>
			<select id = "shipping_line">
			  	<option value="未选">未选</option>
				<option value="奶粉线">奶粉线 MP</option>
			  	<option value="食品线">食品线 SH</option>
			  	<option value="普货线">普货线 JM</option>
			  	<option value="香港线">香港线 HK</option>
			</select>
			
			<p>泛捷账号</p>
			<input type = "text" id = "account" onkeyup = "account_reform()" required><div id = "reform"></div>
			<br/>
			
			<p>收件人姓名</p>
			<input type = "text" id = "receiver" required><br/>
		</fieldset>
	</form>
	<form action= "" method= "POST" id = product_barcode_field>
		<fieldset>
			<legend>产品条形码</legend>
			<input type = "text" id = "product_barcode" onKeyUp="search_product_name()">
			<input type = "button" onclick = "search_product_barcode()" value= "确定此条形码" >
			<input type = "button" onclick = "reset('product_barcode')" value = "清除"> <br/>
<!--			<input list = "product_name"  id = "product_name">-->
		  	<table border='1' id = 'search_list'>
				<tr>
					<th>商品条形码</th>
					<th>商品描述</th>
					<th> </th>
				</tr>
				<tbody id = 'search_display'></tbody>
			</table>
			
		</fieldset>
		<input type = "button" onclick = "update_freight()" value = "确定">
		<input type="button" onclick="location.href='../index.php'" value="返回"/></br>
<!--		<input type="button" onclick="insert_new_empty_row()" value="新增加一个空白行"/></br>-->
		
	</form>
	
	
	<table border="1" id = "table_list">
		<tr>
			<th>商品条形码</th>
			<th>商品名称</th>
			<th>数量</th>
			<th>单件含量和单位</th>
			<th>预计价格(总共)</th>
			<th> </th>
		</tr>
		<tbody id = "display"></tbody>
	</table>
	<div id = "haha"></div>
	
</body>
</html>