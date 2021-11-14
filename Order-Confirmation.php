<?php

$db = mysqli_connect('localhost', 'f32ee', 'f32ee', 'f32ee');

// Check connection
if (!$db) {
	die("erro failed: " . mysqli_connect_error());
}

//Obtain Latest Order 
$getLatestOrder_Entry = [
	'colour_picked'        =>   'SELECT  colour          FROM order_table WHERE id=(select MAX(id) from order_table)',
	'size_picked'     	   =>   'SELECT	 size            FROM order_table WHERE id=(select MAX(id) from order_table)',
	'quantity_picked'      =>   'SELECT  quantity        FROM order_table WHERE id=(select MAX(id) from order_table)',
	'cream_price'      	   =>   'SELECT  cream_subtotal  FROM order_table WHERE id=(select MAX(id) from order_table)',
	'pink_price'           =>   'SELECT  pink_subtotal   FROM order_table WHERE id=(select MAX(id) from order_table)',
	'purple_price'         =>   'SELECT  purple_subtotal FROM order_table WHERE id=(select MAX(id) from order_table)',
	'total_price'          =>   'SELECT  total_cost      FROM order_table WHERE id=(select MAX(id) from order_table)'
];

$colour_picked             = $db->query($getLatestOrder_Entry['colour_picked'])->fetch_object();
$size_picked               = $db->query($getLatestOrder_Entry['size_picked'])->fetch_object();
$quantity_picked           = $db->query($getLatestOrder_Entry['quantity_picked'])->fetch_object();
$cream_price     		   = $db->query($getLatestOrder_Entry['cream_price'])->fetch_object();
$pink_price         	   = $db->query($getLatestOrder_Entry['pink_price'])->fetch_object();
$purple_price    		   = $db->query($getLatestOrder_Entry['purple_price'])->fetch_object();
$total_price               = $db->query($getLatestOrder_Entry['total_price'])->fetch_object();

//Obtain Latest Delivery Details 
$getLatestBilling_Entry = [
	'first'              => 'SELECT first_name  FROM billing WHERE id=(select MAX(id) from billing)',
	'last'     			 => 'SELECT	last_name   FROM billing WHERE id=(select MAX(id) from billing)',
	'coun'            	 => 'SELECT country     FROM billing WHERE id=(select MAX(id) from billing)',
	'street'      		 => 'SELECT street_add  FROM billing WHERE id=(select MAX(id) from billing)',
	'unit_num'           => 'SELECT unit        FROM billing WHERE id=(select MAX(id) from billing)',
	'postal_code'        => 'SELECT postal      FROM billing WHERE id=(select MAX(id) from billing)',
	'city_add'           => 'SELECT city        FROM billing WHERE id=(select MAX(id) from billing)',
	'code_discount'      => 'SELECT	Discount    FROM billing WHERE id=(select MAX(id) from billing)'
];

$first              	 = $db->query($getLatestBilling_Entry['first'])->fetch_object();
$last      				 = $db->query($getLatestBilling_Entry['last'])->fetch_object();
$coun             	 	 = $db->query($getLatestBilling_Entry['coun'])->fetch_object();
$street     			 = $db->query($getLatestBilling_Entry['street'])->fetch_object();
$unit_num         	     = $db->query($getLatestBilling_Entry['unit_num'])->fetch_object();
$postal_code    		 = $db->query($getLatestBilling_Entry['postal_code'])->fetch_object();
$city_add      		     = $db->query($getLatestBilling_Entry['city_add'])->fetch_object();
$code_discount    		 = $db->query($getLatestBilling_Entry['code_discount'])->fetch_object();

//Obtain Additional Remarks Details 
$getLatestPaymentInfo_Entry = [
	'comments'           => 'SELECT commentbox  FROM paymentMethod WHERE id=(select MAX(id) from paymentMethod)'
];

$comments              	 = $db->query($getLatestPaymentInfo_Entry['comments'])->fetch_object();
?>



<!DOCTYPE html>
<html lang="en">

<head>
	<title>Order Comfirmation Page</title>
	<meta charset=“utf-8”>
	<link rel="stylesheet" href="stylesheet.css?v=<?php echo time(); ?>">
</head>

<body>
	<div id="nav-bar">
		<nav>
			<ul class="nav">
				<li class="left-nav"><a href="index.php"><strong>Home</strong></a></li>
				<li class="left-nav"><a href="Product-Catalog.php"><strong>Dress</strong></a></li>
				<li class="left-nav"><a href=""><strong>Tops</strong></a></li>
				<li class="left-nav"><a href=""><strong>Bottoms</strong></a></li>
				<li class="left-nav"><a href=""><strong>Sale</strong></a></li>
				<li class="right-nav" id="right-nav-search"><input type="image" src="search-bar.png" name="search" alt="submit" /></li>
				<li class="right-nav-cart" id="right-nav-cart"><input onclick="myFunction()" class="dropbtn" type="image" src="shopping-cart.png" name="search" alt="submit" />
					<div id="myDropdown" class="dropdown-content">
						<h2>Your Shopping Bag</h2>
						<hr>
						<table class="dropdown-menu-table">
                            <tr>
                                <th>Item Name</th>
                                <th>Color / Size</th>
                                <th>Quantity</th>
                            </tr>

                            <tr>
                                <td>NoName Maxi Dress&emsp;</td>
                                <td><?= $colour_picked->colour ?> / <?= $size_picked->size ?></td>
                                <td><?= $quantity_picked->quantity ?></td>
                            </tr>
                        </table>
                        <hr>
						<p id="cart_subtotal"><strong>Total Price: $ <?=$total_price->total_cost?></p>
						<hr>
						<a href="view_bag.php" class="cart-btn">View Bag</a>
					</div>
				</li>
			</ul>
		</nav>
	</div>

	<div class="container">
		<div class="order-confirmation-header">
			<h1>
				Order Confirmation
			</h1>
		</div>

		<hr>

		<div class="thank-you-header">
			<h2>Thank you for shopping with us!</h2>
			<p>You should receive an email confirmation shortly.</p>
		</div>

		<hr>

		<div class="order-summary">

			<h2>Order Summary</h2>

			<div class="delivery-details">
				<h5>Delivery Details</h5>
				<!--Delivery Details will be displayed here-->
				<p><?= $first->first_name ?> <?= $last->last_name ?></p>
				<p><?= $coun->country ?></p>
				<p><?= $street->street_add ?></p>
				<p><?= $unit_num->unit ?></p>
				<p><?= $postal_code->postal ?></p>
			</div>

			<h5>Order Details</h5>
			<!--Order Details will be displayed here-->
			<div class="order_details">

				<table class="confirmation-order-table">
					<tr>
						<th>Item Name</th>
						<th>Color / Size</th>
						<th>Quantity</th>
						<th>Total Price</th>
						<th>Order Remarks</th>
						<th>Discount/Voucher</th>
					</tr>

					<tr>
						<td>NoName Maxi Dress</td>
						<td><?= $colour_picked->colour ?> / <?= $size_picked->size ?></td>
						<td><?= $quantity_picked->quantity ?></td>
						<td>$<?= $total_price->total_cost ?></td>
						<td><?= $comments->commentbox ?></td>
						<td><?= $code_discount->Discount ?></td>
					</tr>

				</table>
			</div>

			<!--Redirect Customer to Landing Page when user clicks on continue shopping-->
			<div class="continue-shopping">
				<a href="index.php" class="cart-btn">Continue Shopping</a>
			</div>
		</div>


		<footer class="footer-head">
			<div class="footer-header">
				<h2>NoName&copy;</h2>
			</div>
		</footer>

		<footer class="footer-content">


			<div class="footer-about">
				<b>About</b>
				<p>Founders</p>
				<p>Philosophy</p>
				<p>Careers</p>
			</div>

			<div class="footer-customer">
				<strong>Customer Care</strong>
				<p>Contact Us</p>
				<p>FAQ</p>
				<p>Shipping & Delivery</p>
				<p>Return Policy</p>
				<p>Terms & Conditions</p>
			</div>

			<div class="footer-locate">
				<strong>Locate Us</strong>
				<p>Lorem Ipsum</p>
				<p>#12-345</p>
				<p>S123456</p>
			</div>

			<div class="footer-join">
				<strong>Get In Touch!</strong>
				<p><input type="text" placeholder="Enter your Email Here!"></p>
			</div>

		</footer>
		<!--Javascript-->
		<script type="text/javascript" src="Product-Page-Java.js"></script>

		<!-- execute hellomail.php-->
		<?php include 'hellomail.php'; ?>

</body>

</html>
<?php
$db->close();
?>