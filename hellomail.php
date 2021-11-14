<!DOCTYPE html>
<html>
<body>
<?php

$db = mysqli_connect('localhost', 'f32ee', 'f32ee', 'f32ee');

// Check connection
if (!$db) 
{
	die("erro failed: ".mysqli_connect_error());
}

//Obtain Latest Delivery Details 
$getLatestBilling_Entry = [
	'first'              => 'SELECT first_name  FROM billing WHERE id=(select MAX(id) from billing)',
	'last'     			 => 'SELECT	last_name   FROM billing WHERE id=(select MAX(id) from billing)'
];

$first              	 = $db->query($getLatestBilling_Entry['first'])->fetch_object();
$last      				 = $db->query($getLatestBilling_Entry['last'])->fetch_object();

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
	



//https:192.168.56.2:20000  
$to      = 'f32ee@localhost';     
$subject = 'the subject';       
$message = 'Hi'." $first->first_name" ." $last->last_name".'! Thank you for your order. 
We have received your order and it will be shipped out within 3 days. 
Your order is shown below: 
NoName Maxi Dress'." $colour_picked->colour" .' / '."$size_picked->size".' Qty: '." $quantity_picked->quantity";

$headers = 'From: f32ee@localhost' . "\r\n" .
    'Reply-To: f32ee@localhost' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers,'-ff32ee@localhost');
echo ("mail sent to : ".$to);
?> 

</body>
</html>
