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
		<div class="banner_image"></div>
		<div class="logo"><a href="/finget">Finget</a></div>
		<div class="list_form">
			<?php
			$db = new mysqli('localhost', 'root', '', 'invoice_crt');
			if($db->connect_errno){
				echo 'failed';
				exit;
			}
			$sql = "SELECT * FROM products";
			$result = $db->query($sql);
			?>
			<table class="table">
				<thead>
					<tr>
					  <th scope="col">Name</th>
					  <th scope="col">Quantity</th>
					  <th scope="col">Price($)</th>
					  <th scope="col">Tax(%)</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$subtotal_with_tax = array();
					$subtotal_without_tax = array();
					while($row = $result->fetch_assoc()) {
						echo '<tr>';
						echo '<td>'.$row['name'].'</td>';
						echo '<td>'.$row['quantity'].'</td>';
						echo '<td>'.$row['price'].'</td>';
						echo '<td>'.$row['tax'].'</td>';
						echo '</tr>';
						array_push($subtotal_without_tax,$row['price']);
						$tax_rate = $row['price']+(($row['price']*$row['tax'])/100);
						array_push($subtotal_with_tax,$tax_rate);
					}
					?>
				</tbody>
				<tfoot class="text-right">
					<tr>
						<td colspan="4"><strong>SubTotal(Without Tax): $<?php echo array_sum($subtotal_without_tax); ?></strong></td>
					</tr>
					<tr>
						<td colspan="4"><strong>Discount(%): </strong><input type="number" class="discount"><button type="button" class="apply" data-price="<?php echo array_sum($subtotal_with_tax); ?>">Apply</button></td>
					</tr>
					<tr>
						<td colspan="4"><strong>SubTotal(With Tax): $<?php echo array_sum($subtotal_with_tax); ?></strong></td>
					</tr>
					<tr>
						<td colspan="4"><strong>Total Amount to pay: $<span class="amount_to_pay"><?php echo array_sum($subtotal_with_tax); ?></span></strong></td>
					</tr>
					<tr>
						<td colspan="4"><button type="button" class="invoice" onclick="window.print()">Generate Invoice</button></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<script>
		$(document).ready(function(){
			$(".apply").click(function(){
				var original_price = $(this).attr('data-price');
				if(original_price){
					var discount_per = $('.discount').val();
					//var pay = original_price-((original_price*discount_per)/100);
					var pay = (original_price - ( original_price * discount_per / 100 )).toFixed(2);
					$('.amount_to_pay').text(pay);
				}
			});
		});
		</script>
	</body>
</html>