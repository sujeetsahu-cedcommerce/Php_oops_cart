<?php
session_start();
if(!isset($_SESSION['productArray']))
{
$_SESSION['productArray'] = array();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>
		Products
	</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<link href="style.css" type="text/css" rel="stylesheet">
</head>
<body>
	<div id="header">
		<h1 id="logo">Logo</h1>
		<nav>
			<ul id="menu">
				<li><a href="index.php">Home</a></li>
				<li><a href="products.php">Products</a></li>
				<li><a href="contact.php">Contact</a></li>
				<li><a href="logout.php">Empty</a></li>
			</ul>
		</nav>
		<a href="./logout.php">Clear Session</a>
	</div>
	<div id="main">
		<div id="products">

		<?php include 'config.php';?>
		<?php	foreach($_SESSION['product'] as $j){ ?>
			<div id= <?php echo $j['id']?> class="product">
			<img src="images/<?php echo $j["image"]?>">
			<h3 class="title">
			<a href="#" id="productName" class="pname">
			<?php echo $j['productName'] ?></a></h3>
			<span id="price">Price: $</span><span id="price" class="pric">
				<?php echo $j["price"] ?></span>
			<a class="add-to-cart" id="addtocart" >Add To Cart</a>
			</div>
			<?php } ?> 
		</div>
	</div>

	<table id="addtocartHeadTable" style="height: 50px;border-collapse: collapse;width: 90%;margin-left: 5%;margin-right: 5%;">
			<tr style="background-color:#3e9cbf ;color: white;">
			<th style="width: 20%;">Id</th>
			<th style="width: 20%;">Name</th>
			<th style="width: 20%;">Price</th>
			<th style="width: 20%;">Quantity</th>
			<th style="width: 20%;">Action</th>
			</tr>
	</table>
	<table id="addtocartTable" style="height: 50px;border-collapse: collapse;width: 90%;margin-left: 5%;margin-right: 5%;">
			
	</table>
	<div id="footer">
		<nav>
			<ul id="footer-links">
				<li><a href="#">Privacy</a></li>
				<li><a href="#">Declaimers</a></li>
			</ul>
		</nav>
	</div>

	<script>
		$(document).ready(function(){
        // displaying products
		$(".add-to-cart").click(function()
		{
			var id=$(this).closest("div")[0].id;
			var name=$(this).parent().find(".pname").text().trim();
			var price=$(this).parent().find(".pric").text();
			$.ajax({
				url:"server.php",
				type: "POST",
				data:{
					ids : id,
					names : name,
					prices : price,
					quant : 1,
					},
				success:function(result)
				{
					$("#addtocartTable").html(result);
					}
				});			
		});
        // Deleting products
		$("#addtocartTable").on("click", "#deleteRow", function(e) 
		{
		$(this).parent().parent().remove();
		var id = $(this).closest('tr').children().first().text();
		$.ajax({
			url:'server.php',
			data:{delvalue : id},
			type:"POST",
			success:function(result){
				$("#addtocartTable").html(result);
			}
		});

     });
		});
	</script>
</body>
</html>