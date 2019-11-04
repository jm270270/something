// JavaScript Document

function freight_create(){
	var freight_barcode = document.getElementById("freight_barcode").value;
	
	xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
			var temp = this.responseText.replace(/\s/g, '');		
			if (temp == "good"){
				if(confirm("成功创建运单: " + freight_barcode + ", 点击确定键, 跳转到箱子详细信息填补页面")) {
					localStorage.setItem("freight_barcode", freight_barcode);
					window.open("enter_freight_detail.php","_self")
				}	
			}
            else{
				
				alert("创建运单 " + freight_barcode + " 失败, 数据库已经有此运单号");
			}
			
    	}
    };
    xmlhttp.open("GET",
				 "enter_freight_insert.php?freight_barcode=" + freight_barcode,
				 true);
    xmlhttp.send();
}

function search_product_barcode(){
	var product_barcode = document.getElementById("product_barcode").value;
	product_barcode = encodeURIComponent(product_barcode);
	
	xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
			var temp = this.responseText.replace(/\s/g, '');
			temp = decodeURIComponent(temp);
			
            if (temp == "bad"){
				var product_name = prompt("新的产品名称:", "");
				var content = prompt("容量:", "");
				var unit = prompt("单位:", "");
				var price = prompt("预估单价:", "");
				
				insert_product(product_barcode, product_name, content, unit, price);
			}
			else {
				document.getElementById("display").innerHTML += this.responseText;
			}
    	}
    };
    xmlhttp.open("GET",
				 "enter_freight_detail_db.php?product_barcode=" + product_barcode,
				 true);
    xmlhttp.send();
	document.getElementById("product_barcode_field").reset();
}

function search_product_barcode2(x){
	var i = x.parentNode.parentNode.rowIndex;
	var product_barcode = document.getElementById("search_display").rows[i-1].cells[0].innerHTML;
	product_barcode = encodeURIComponent(product_barcode);
	console.log(i);
	
	xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
			var temp = this.responseText.replace(/\s/g, '');
			temp = decodeURIComponent(temp);
			console.log(temp);
            if (temp == "bad"){
//				var product_name = prompt("新的产品名称:", "");
//				var content = prompt("容量:", "");
//				var unit = prompt("单位:", "");
//				var price = prompt("预估单价:", "");
//				
//				insert_product(product_barcode, product_name, content, unit, price);
			}
			else {
				document.getElementById("display").innerHTML += this.responseText;
			}
    	}
    };
    xmlhttp.open("GET",
				 "enter_freight_detail_db.php?product_barcode=" + product_barcode,
				 true);
    xmlhttp.send();
	document.getElementById("product_barcode_field").reset();
}

function reset(x){
	document.getElementById(x).reset();
}  

function delete_row(x){
	var i = x.parentNode.parentNode.rowIndex;
	document.getElementById("table_list").deleteRow(i);
}

function update_freight(){
	if (null_validation()){
		var column = 6;
		var freight_barcode = localStorage.getItem("freight_barcode");
		var weight = document.getElementById("weight").value;
		var shipping_line = document.getElementById("shipping_line").value;
		var account = document.getElementById("account").value;
		var receiver = document.getElementById("receiver").value;
		
		var product_list = "";
		var target = document.getElementById("display").getElementsByTagName("th");
		var temp = "";
		for (var i = 0; i < target.length; i++){
			switch(i%column){
				case 0: break;
				case 1: product_list += target.item(i).innerHTML;break;
				case 2: 
					if (target.item(i+1).innerHTML.replace(/\s/g, '') != 0){
						temp = ")x" + target.item(i).innerHTML;
					}
					else{
						temp = "x" + target.item(i).innerHTML;
					}
					break;
				case 3: 
					if (target.item(i).innerHTML.replace(/\s/g, '') != 0){
						product_list += "(" + target.item(i).innerHTML + temp + "\n";
					}
					else{
						product_list += temp + "\n";
					}
					break;
				case 4: break;
				case 5: break;
			}
			
		}
		if(confirm("你确定要提交本运单的所有信息吗?\n运单号: " + freight_barcode +
				  		"\n重量: " + weight + 
				  		"\n线路: " + shipping_line +
				  		"\n帐号: " + account + 
				  		"\n收件人: " + receiver +
				  		"\n所有商品: " + product_list)) {
			update_freight_info();
			update_freight_description();
			alert("你已经成功上传此运单信息到数据库")
			window.open("enter_freight.php","_self")
		}
	}
	
	
}

function update_freight_info(){
	var weight = document.getElementById("weight").value;
	var shipping_line = document.getElementById("shipping_line").value;
	var account = document.getElementById("account").value;
	var receiver = document.getElementById("receiver").value;
	
	xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
//            document.getElementById("haha").innerHTML += this.responseText;
    	}
    };
    xmlhttp.open("GET",
				 "enter_freight_detail_update_info.php?freight_barcode=" + product_barcode +
				 	"&weight=" + weight +
				 	"&shipping_line=" + shipping_line +
				 	"&account=" + account +
				 	"&receiver=" + receiver,
				 true);
    xmlhttp.send();
}

function update_freight_description(){
	var column = 6;
	
	var target = document.getElementById("display").getElementsByTagName("th");
	var freight_barcode = localStorage.getItem("freight_barcode");
	
	var product_barcode = "";
	var product_name = "";
	var amount = "";
	var content_unit = "";
	var price = "";
	
	for (var i = 0; i < target.length; i++){
		switch(i%column){
			case 0: product_barcode = target.item(i).innerHTML;break;
			case 1: product_name = target.item(i).innerHTML;break;
			case 2: amount = target.item(i).innerHTML;break;
			case 3: content_unit = target.item(i).innerHTML;break;
			case 4: price = target.item(i).innerHTML;break;
			case 5: break;
		}

		if (product_barcode != "" && product_name !="" && amount !="" && content_unit != "" && price != ""){
			xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
//					document.getElementById("haha").innerHTML += this.responseText;
    			}
			};
			xmlhttp.open("GET",
						 "enter_freight_detail_update_description.php?product_barcode=" + product_barcode + 
						 	"&product_name=" + product_name +
						 	"&amount=" + amount +
						 	"&content_unit=" + content_unit +
						 	"&price=" + price,
						 true);
			xmlhttp.send();
			
			var product_barcode = "";
			var product_name = "";
			var amount = "";
			var content_unit = "";
			var price = "";
		}
		
	}
}

function insert_product(product_barcode, product_name, content, unit, price){
	console.log(product_barcode);
	
	xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //document.getElementById("haha").innerHTML += this.responseText;
    	}
    };
    xmlhttp.open("GET",
				 "enter_freight_product_insert.php?product_barcode=" + product_barcode + 
						 	"&product_name=" + product_name +
						 	"&content=" + content +
						 	"&unit=" + unit +
						 	"&price=" + price,
				 true);
    xmlhttp.send();
}

function insert_new_empty_row(){
	var table = document.getElementById("display");
//	var delete_button = document.createElement("input");
//	delete_button.type = "button";
//	delete_button.id = "delete";
//	delete_button.value = "删除";
//	delete_button.addEventListener("click", delete_row(this));
	
	var row = table.insertRow(0);
	var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);
	var cell5 = row.insertCell(4);
	var cell6 = row.insertCell(5);
    cell1.innerHTML = "";
    cell2.innerHTML = "";
	cell3.innerHTML = "";
    cell4.innerHTML = "";
	cell5.innerHTML = "0";
	cell6.innerHTML = "<input type = 'button' id = 'delete' value = '删除' onclick = 'delete_row(this)'>";
//    cell6.appendChild(delete_button);
	
	cell1.contentEditable = true;
	cell2.contentEditable = true;
	cell3.contentEditable = true;
	cell4.contentEditable = true;
	
}

function update_price(x){
	var i = x.parentNode.parentNode.rowIndex;
	var price = document.getElementById("table_list").row[i].cells[4];
	var amount = document.getElementById("table_list").row[i].cells[2];
	var temp = price * amount;
	document.getElementById("table_list").row[i].cells[5] = temp;
}

function null_validation(){
	var message = "";
	var isValid = true;
	if (document.getElementById("weight").value == ""){
		isValid = false;
		message += "磅数\n";
	}
	if (document.getElementById("shipping_line").value == "未选"){
		isValid = false;
		message += "线路\n";
	}
	if (document.getElementById("account").value == ""){
		isValid = false;
		message += "帐号\n";
	}
	if (document.getElementById("receiver").value == ""){
		isValid = false;
		message += "收件人\n";
	}
	
	
	if (isValid == false){
		alert("以下信息未填写:\n" + message);
		return false;
	}
	return true;
}

function search_product_name(){
	var product_name = document.getElementById("product_barcode").value;
	
	if (product_name ==""){
		document.getElementById("search_display").innerHTML = "数据库无此信息";
		document.getElementById("search_display").style.color = "RED";
	}
	else{
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("search_display").innerHTML = this.responseText;
				document.getElementById("search_display").style.color = "BLACK";
				console.log(this.responseText);
			}
		};

		xmlhttp.open("GET",
					 "enter_freight_search_product_name.php?product_name=" + product_name,
					 true);
		xmlhttp.send();
	}
	//document.getElementById("product_name").reset();
}

function account_reform(){
	var account = document.getElementById("account").value;
	if (account.length == 10){
		account = account.substring(0,3) + "-" + account.substring(3,6) + "-" + account.substring(6,10);
	}
	document.getElementById("reform").innerHTML = account;
}

function search_freight_20(){

	xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
			var temp = this.responseText.replace(/\s/g, '');
			console.log(temp);
			document.getElementById("display").innerHTML = this.responseText;
    	}
    };
    xmlhttp.open("GET",
				 "enter_freight_search_freight_20.php",
				 true);
    xmlhttp.send();
}