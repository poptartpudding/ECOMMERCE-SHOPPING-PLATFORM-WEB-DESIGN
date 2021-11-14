<?php
$db = mysqli_connect('localhost', 'f32ee', 'f32ee', 'f32ee');

// Check connection
if (!$db) 
{
	die("error connection failed: ".mysqli_connect_error());
}

//Obtain Latest Order
$getLatestOrder_Entry = [
	'colour_picked'          => 'SELECT colour           FROM order_table WHERE id=(select MAX(id) from order_table)',
	'size_picked'     		 => 'SELECT	size             FROM order_table WHERE id=(select MAX(id) from order_table)',
	'quantity_picked'        => 'SELECT quantity   		 FROM order_table WHERE id=(select MAX(id) from order_table)',
	'cream_price'      		 => 'SELECT cream_subtotal   FROM order_table WHERE id=(select MAX(id) from order_table)',
	'pink_price'             => 'SELECT pink_subtotal    FROM order_table WHERE id=(select MAX(id) from order_table)',
	'purple_price'           => 'SELECT purple_subtotal  FROM order_table WHERE id=(select MAX(id) from order_table)',
	'total_price'            => 'SELECT total_cost       FROM order_table WHERE id=(select MAX(id) from order_table)'
];

$colour_picked              = $db->query($getLatestOrder_Entry['colour_picked'])->fetch_object();
$size_picked                = $db->query($getLatestOrder_Entry['size_picked'])->fetch_object();
$quantity_picked            = $db->query($getLatestOrder_Entry['quantity_picked'])->fetch_object();
$cream_price     			= $db->query($getLatestOrder_Entry['cream_price'])->fetch_object();
$pink_price         	    = $db->query($getLatestOrder_Entry['pink_price'])->fetch_object();
$purple_price    		    = $db->query($getLatestOrder_Entry['purple_price'])->fetch_object();
$total_price                = $db->query($getLatestOrder_Entry['total_price'])->fetch_object();


// Capture order when customer clicks "confirm order"
if (isset($_POST['confirm'])) {
	$radiogroup  = $_POST['radio1'];

	// If customer selects one of the radio buttons to edit/remove latest order
	if (isset($radiogroup)) {
		if ($radiogroup === 'edit') {
			$colour_update  = $_POST['colour'];
			$size_update  = $_POST['size'];
			$qty_update  = $_POST['qty'];

			if ($colour_update === 'cream')
			{
				$subTotal_Cream_Update  =   29.99 * $qty_update;
			}
			elseif ($colour_update === 'pink') 
			{
				$subTotal_Pink_Update 	 =   29.99 * $qty_update;
			}
			elseif ($colour_update === 'purple') 
			{
				$subTotal_Purple_Update  =   29.99 * $qty_update;
			}
			$total_Update = $subTotal_Cream_Update + $subTotal_Pink_Update + $subTotal_Purple_Update;
			
			//update latest order 	
			$updateLatestOrder  = "UPDATE order_table SET 
										 colour 		= '$colour_update',
										 size 			= '$size_update', 
										 quantity 		= '$qty_update', 
										 cream_subtotal = '$subTotal_Cream_Update',
										 pink_subtotal  = '$subTotal_Pink_Update',
										 purple_subtotal= '$subTotal_Purple_Update',
										 total_cost		= '$total_Update'
										 ORDER BY id desc limit 1";
			$db->query($updateLatestOrder);							 
		}
		elseif ($radiogroup === 'remove') {
			$deleteLatestOrder_Entry    = "DELETE FROM order_table 
										  ORDER BY id desc limit 1";
			$db->query($deleteLatestOrder_Entry);
			//When customer removes order, direct customer back to product-page.php
			header('Location:Product-Page.php');
			exit;
		}
	}
	//When customer clicks "confirm order", direct customer to checkout.php
	header('Location:checkout.php');
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>View Cart</title>
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

		<div class="view-bag-header">
			<h1 id="title_page">
				My Shopping Bag
			</h1>
		</div>

		<hr>


		<!--Order Details will be displayed here-->
		<div class="order-details">
			<h3>Order Details</h3>
			<table class="order-details-table">
				<tr>
					<th>Item Name</th>
					<th>Color / Size</th>
					<th>Quantity</th>
					<th>Total Price</th>
				</tr>

				<tr>
					<td>NoName Maxi Dress&emsp;</td>
					<td><?= $colour_picked->colour ?> / <?= $size_picked->size ?></td>
					<td><?= $quantity_picked->quantity ?></td>
					<td>$<?php
						if (($cream_price->cream_subtotal) != 0) 
						{
							echo $cream_price->cream_subtotal;
						}
						if (($pink_price->pink_subtotal) != 0) 
						{
							echo $pink_price->pink_subtotal;
						}
						if (($purple_price->purple_subtotal) != 0) 
						{
							echo $purple_price->purple_subtotal;
						}
					?></td>
				</tr>
			</table>

		</div>

		<hr>

		<!-- Javascript function for onclick event in radio button-->
		<script>
			function pressed()
			{
				if (document.getElementById('edit_radio').checked)
				{
					document.getElementById('edit_order').style.display='block';
				}	
			}
		</script>

		<!--Form is for user to confirm order and inputs from the form are stored into php variables-->
		<form id="submit_form" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

			<!-- User can choose to edit/remove order-->
			<div class="update-selected">
				<input type="radio" id="edit_radio" name="radio1" value="edit" onclick="pressed()"><strong>Edit
					&emsp; </strong><input type="radio" id="remove_radio" name="radio1" value="remove"><strong>Remove</strong>
			</div>

			<!-- Display this div element when user wants to edit order-->
			<div id="edit_order" style="display: none">
				<h3>Order Amendments</h3>
				<!--For user to edit colour-->
				<div id="edit_colour">
					<strong id="label_edit_order">Colour</strong>
					<select id="select_colour" name="colour">
						<option value="cream">cream</option>
						<option value="pink">pink</option>
						<option value="purple">purple</option>
					</select>
				</div>
				<!--For user to edit size-->
				<div id="edit_size">
					<strong id="label_edit_order">Size</strong>
					<select id="select_size" name="size">
						<option value="XS">XS</option>
						<option value="S">S</option>
						<option value="M">M</option>
						<option value="L">L</option>
					</select>
				</div>
				<!--For user to edit quantity-->
				<div id="edit_qty">
					<strong id="label_edit_order">Quantity</strong>
					<select id="select_qty" name="qty">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select>
				</div>
			</div>

			<!--User confirms order-->
			<div class="confirm-bag">
				<input type="submit" class="cart-btn" name="confirm" value="Confirm Order" id="submit-btn">
			</div>
		</form>
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
</body>

</html>
<?php
$db->close();
?>