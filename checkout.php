<?php

$db = mysqli_connect('localhost', 'f32ee', 'f32ee', 'f32ee');

// Check connection
if (!$db) {
	die("error connection failed: " . mysqli_connect_error());
}

// Capture order when customer submits
if (isset($_POST['confirm'])) {
	$first_name  = $_POST['myFirstName'];
	$last_name   = $_POST['myLastName'];
	$coun     	 = $_POST['myCountry'];
	$street_add  = $_POST['myStreet'];
	$unit     	 = $_POST['myUnit'];
	$postal_add  = $_POST['myPostal'];
	$city_add    = $_POST['myCity'];
	$email_add   = $_POST['myEmail'];
	$code 		 = $_POST['discount_code'];

	$radiogroup  = $_POST['radio1'];

	$commentbox  = $_POST['comment'];

	// When customer selects one of the radio button
	if (isset($radiogroup)) {
		if ($radiogroup === 'paylah_paynow') {
			$mobileNum 	 = $_POST['hp'];
		} elseif ($radiogroup === 'credit_card') {
			$cardNum 		=  md5($_POST['card_no']);
			$userName 		=  $_POST['myName'];
			$exp			=  md5($_POST['expir']);
			$ccvNum     	=  md5($_POST['ccv-#']);
		}
	}

	//Insert new billing information record
	$insertNewBillingInfo_Entry = "INSERT INTO billing
	VALUES (DEFAULT, 
		'$first_name', 
		'$last_name', 
		'$coun',
		'$street_add',
		'$unit',
		'$postal_add',
		'$city_add',
		'$email_add',
		'$code'
	)";

	$db->query($insertNewBillingInfo_Entry);

	// Insert new payment information record 
	$insertNewPaymentInfo_Entry = "INSERT INTO paymentMethod
	VALUES (DEFAULT, 
		'$userName', 
		'$commentbox',
		'$mobileNum',
		'$cardNum',
		'$exp',
		'$ccvNum'
	)";

	$db->query($insertNewPaymentInfo_Entry);
	//When customer clicks "Submit", direct customer to Order-Confirmation.php
	header('Location:Order-Confirmation.php');
	exit;
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
?>



<!DOCTYPE html>
<html lang="en">

<head>
	<title>Checkout Page</title>
	<meta charset=“utf-8”>
	<link rel="stylesheet" href="stylesheet.css?v=<?php echo time(); ?>">
</head>

<body>

	<!-- Javascript function for onclick event in radio buttons
		 To display the div element of paylah_paynow_info -->
	<script>
		function clicked() {
			/*If radiobutton for paylah/paynow is clicked,
			div element of paylah_paynow_info will be displayed*/
			if (document.getElementById('pp').checked) {
				document.getElementById('paylah_paynow_info').style.display = 'block';
			} else {
				document.getElementById('paylah_paynow_info').style.display = "none";
			}
			/*If radiobutton for credit card is clicked,
			table element of credit_info will be displayed*/
			if (document.getElementById('cc').checked) {
				document.getElementById('credit_info').style.display = 'block';
			} else {
				document.getElementById('credit_info').style.display = "none";
			}
		}
	</script>

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
		<!--Form is for user to submit details and inputs from the form are stored into php variables
			"onmousemove" event is to display the red text that input is required-->
		<form id="submit_form" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" onmousemove="require_input()" method="POST">

			<header>
				<h1> Checkout </h1>
			</header>
			<h2>Billing Information</h2>
			<table id="billing_info" cellspacing="20">

				<tr>
					<td class="custom-field">
						<label>First Name*
							<!-- "onkeyup" event occurs when user releases a key on keyboard-->
							<input type="text" name="myFirstName" placeholder="Enter First Name" onkeyup="validateBilling_Add(1)" required id="FirstName">
						</label>
						<!-- Display the error text when input is not of required format-->
						<span id="first_name_validation_text" class="error-message"></span>
					</td>

					<td class="custom-field">
						<label>Last Name*
							<!-- "onkeyup" event occurs when user releases a key on keyboard-->
							<input type="text" name="myLastName" required onkeyup="validateBilling_Add(2)" placeholder="Enter Last Name" id="lastname">
						</label>
						<!-- Display the error text when input is not of required format-->
						<span id="last_name_validation_text" class="error-message"></span>
					</td>

				</tr>

				<tr>
					<td class="custom-field">
						<label>Country*
							<!-- "onkeyup" event occurs when user releases a key on keyboard-->
							<input type="text" name="myCountry" required placeholder="Enter Country" onkeyup="validateBilling_Add(3)" id="country">
						</label>
						<!-- Display the error text when input is not of required format-->
						<span id="country_validation_text" class="error-message"></span>
					</td>

					<td class="custom-field">
						<label>City*
							<!-- "onkeyup" event occurs when user releases a key on keyboard-->
							<input type="text" required name="myCity" onkeyup="validateBilling_Add(7)" placeholder="Enter City" id="city">
						</label>
						<span id="city_validation_text" class="error-message"></span>
					</td>

				</tr>

				<tr>

					<td class="custom-field">
						<label>Street Address*
							<input type="text" name="myStreet" required placeholder="Enter Address" onkeyup="validateBilling_Add(4)" id="Street_address"></label>
						<span id="street_validation_text" class="error-message"></span>
					</td>

					<td class="custom-field">
						<label>Unit Number*
							<input type="text" name="myUnit" required onkeyup="validateBilling_Add(5)" placeholder="Enter Unit" id="Unit_No"></label>
						<span id="unit_validation_text" class="error-message"></span>
					</td>

				</tr>

				<tr>
					<td class="custom-field">
						<label>Postal Code*
							<input type="text" name="myPostal" required onkeyup="validateBilling_Add(6)" placeholder="Enter Postal Code" id="Postal_code"></label>
						<span id="postal_validation_text" class="error-message"></span>
					</td>

				</tr>

				<tr>
					<td class="custom-field">
						<label>Email Address*
							<input type="email" name="myEmail" required id="Email_Address"></label>
						<span id="email_validation_text" class="error-message"></span>
					</td>

				</tr>

			</table>

			<h3>Discount/Voucher</h3>

			<div class="discount_voucher">
				<label><input type="text" name="discount_code" id="discount" placeholder="Enter Dicount Code"></label>
			</div>

			<br>
			<h4>Select a Payment Method*</h4>

			<!-- Table displays the 3 radio buttons under Payment Method-->
			<table id="pay" cellspacing="20">

				<tr>

					<td class="custom-bullet">
						<!-- PayLah logo:https://www.pinterest.com/pin/647885096365495197/-->
						<!-- PayNow Logo:https://vectorlogo4u.com/paynow-logo-vector/-->
						<img src="logo_paylah.png" height="80" width="100">
						<img src="logo_paynow.png" height="70" width="130">
					</td>

					<td class="custom-bullet">
						<label><input type="radio" value="paylah_paynow" name="radio1" id="pp" onclick="clicked()">Paylah/Paynow</label>
					</td>

				</tr>

				<tr>

					<td class="custom-bullet">
						<!-- mastercard logo: https://brandslogo.net/mastercard-2016-logo-91215 -->
						<!-- visa logo: https://brandslogo.net/visa-logo-91735 -->
						<img src="logo_mastercard.png" height="70" width="125">
						<img src="logo_visa.png" height="70" width="125">
					</td>

					<td class="custom-bullet">
						<label><input type="radio" name="radio1" value="credit_card" id="cc" onclick="clicked()">Credit Card</label>
					</td>

				</tr>

				<tr>

					<td class="custom-bullet">
						<img src="logo_gpay.png" height="50" width="210">
					</td>

					<td class="custom-bullet">
						<label><input type="radio" name="radio1" value="gp" id="googlepay_link" onclick="clicked()">GooglePay</label>
					</td>

				</tr>

			</table>

			<br>
			<!--If radiobutton for paylah/paynow is clicked,
			this div element will be displayed-->

			<div id="paylah_paynow_info" style="display: none" class="number">

				<label>Phone Number*

					<!--"onkeyup" event occurs when user releases a key on keyboard-->
					<input type="text" name="hp" onkeyup="validatePayment(1)" id="hp_number">
				</label>

				<!-- Inform user correct format for mobile hp -->
				<span id="mobile_validation_text" class="error-message"></span>
			</div>

			<!--If radiobutton for credit card is clicked,
			this table element will be displayed-->
			<table id="credit_info" cellspacing="20" style="display: none">

				<tr>
					<th colspan="2">Credit Card</th>
				</tr>

				<tr>

					<th>Credit Card Number*</th>
					<td class="custom-field">
						<!-- 
						"onkeyup" event to detect when user releases a key. Validate card number
						format is xxxx-xxxx-xxxx-xxxx 
						4 digits, '-', 4 digits, '-', 4 digits,'-', 4 digits-->
						<label><input type="text" pattern="[\d]{4}-{1}[\d]{4}-{1}[\d]{4}-{1}[\d]{4}" id="card_number" onkeyup="validatePayment(2)" title="Numbers only. Format: xxxx-xxxx-xxxx-xxxx" name="card_no"></label>
						<!-- Inform user correct format for credit card no -->
						<span id="card_validation_text" class="error-message"></span>
					</td>

				</tr>

				<tr>

					<th>
						Expiry date(valid thru)*</th>
					<td class="custom-field">
						<!-- "onchange" event to detect changes and validate expiry date-->
						<label><input type="month" name="expir" id="exp_date" onchange="validatePayment(3)"></label>
						<!-- Inform user correct format for expiry date -->
						<span id="expiry_validation_text" class="error-message"></span>
					</td>

				</tr>

				<tr>
					<th>
						CVV*</th>
					<td class="custom-field">
						<label><input type="text" onkeyup="validatePayment(4)" name="ccv-#" id="ccv"></label>
						<!-- Inform user correct format for card ccv  -->
						<span id="ccv_validation_text" class="error-message"></span>
					</td>

				</tr>

				<tr>

					<th>Name on card*
					</th>
					<td class="custom-field">
						<label><input type="text" onkeyup="validatePayment(5)" name="myName" id="custName"></label>
						<!-- Inform user correct format for Name  -->
						<span id="name_validation_text" class="error-message"></span>
					</td>

				</tr>

			</table>

			<h5>Additional Remarks</h5>
			<label><textarea id="comment_section" name="comment" rows="5" cols="75"></textarea></label>
			<!--"onclick" event to prevent user from submitting if inputs are not of required format-->
			<br><br><input type="submit" name="confirm" value="Submit" id="submit-btn" onclick="return checkFields();">

			<p><a href="index.php">Cancel</a></p>
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
	<script src="checkout_validation.js"></script>
	<script type="text/javascript" src="Product-Page-Java.js"></script>
</body>

</html>
<?php
$db->close();
?>