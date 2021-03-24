<!DOCTYPE html>
<html>
	<head>
		<title>Invoice Generation</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<?php
		$message = '';
		if(isset($_POST['submit'])){
			$db = new mysqli('localhost', 'root', '', 'invoice_crt');
			if($db->connect_errno){
				echo 'failed';
				exit;
			}
			$table = 'products';
			foreach($_POST['data'] as $data){
				$query = 'INSERT INTO products (name,quantity,price,tax) VALUES ("'.$data['name'].'","'.$data['quantity'].'","'.$data['price'].'","'.$data['tax'].'")';
				$result = $db->query($query);
				if($result){
					$message = 'Item added successfully!';
				}
			}
			$db->close();
		}
		//echo $_SERVER['HTTP_HOST'];
		//echo "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		?>
		<div class="banner_image"></div>
		<div class="logo"><a href="/finget">Finget</a></div>
		<div class="add_form">
			<form class="form-inline" method="POST">
				<?php
				if($message != ''){
					echo '<div class="alert alert-success"><strong>'.$message.'</strong></div>';
				}
				?>
				<div class="form_tag">
					<label for="name">Name: </label><input type="text" name="data[0][name]" class="name form-control" required>
					<label for="quantity">Quantity: </label><input type="number" name="data[0][quantity]" class="quantity form-control" required>
					<label for="price">Price($): </label><input type="number" step=".01" name="data[0][price]" class="price form-control" required>
					<label for="email">Tax: </label>
					<select name="data[0][tax]" class="tax form-control" required>
						<option value="0">0%</option>
						<option value="1">1%</option>
						<option value="5">5%</option>
						<option value="10">10%</option>
					</select>
				</div>
				<div class="text-center buttons">
					<button type="button" class="add_new">Add New Item</button>
					<button type="submit" class="save" name="submit">Save</button>
				</div>
			</form>
		</div>
		<div class="list_form">
			<table class="table-bordered">
				<th>Name</th>
				<th>Quantity</th>
				<th>Price</th>
				<th>Tax</th>
			</table>
		</div>
		<script>
		$(document).ready(function(){
			$(".add_new").click(function(){
				var index = $('.form_tag').length;
				//alert(index);
				var html = '<div class="form_tag">';
				html += '<label for="name">Name: </label><input type="text" name="data['+index+'][name]" class="name form-control" required>';
				html += '<label for="quantity">Quantity: </label><input type="number" name="data['+index+'][quantity]" class="quantity form-control" required>';
				html += '<label for="price">Price($): </label><input type="number" step=".01" name="data['+index+'][price]" class="price form-control" required>';
				html += '<label for="email">Tax: </label>';
				html += '<select name="data['+index+'][tax]" class="tax form-control" required>';
				html += '<option value="0">0%</option>';
				html += '<option value="1">1%</option>';
				html += '<option value="5">5%</option>';
				html += '<option value="10">10%</option>';
				html += '</select>';
				html += '</div>';
				$(html).insertAfter(".form_tag:last");
			}); 
			$(".save").click(function(){
				
			});	
		});
		</script>
	</body>
</html>