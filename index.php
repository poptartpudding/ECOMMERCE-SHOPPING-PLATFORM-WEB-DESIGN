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

?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>NoName</title>
    <!--Stylesheet-->
    <link rel="stylesheet"  href="stylesheet.css?v=<?php echo time(); ?>">
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
						<a href="view_bag.php" class="cart-btn">Checkout</a>
					</div>
				</li>
			</ul>
		</nav>
	</div>

    <div class="homepage-content">

        <div class="homepage-header">

            <img src="landing-header.jpg" alt="Header">
            <div id="header-content">
                <h1>NoName&copy;</h1>
                <p>Timeless pieces for every occassion.</p>
                <a href="Product-Catalog.php" class="browse-catalog">Browse Catalog</a>
            </div>
        </div>

        <div class="second-nav-bar">
            <div id="nav-dress">
                <!--Image Source: https://www.flaticon.com/free-icon/dress_1785255?term=dress&page=1&position=1&page=1&position=1&related_id=1785255&origin=search-->
                <a href="Product-Catalog.php"><img src="dress.png"></a>
                <p><a href="Product-Catalog.php"><strong>Dress</strong></a></p>
            </div>

            <div id="nav-tops">
                <!--Image source: https://www.flaticon.com/free-icon/tshirt_863684?term=shirt&page=1&position=7&page=1&position=7&related_id=863684&origin=search-->
                <img src="tshirt.png" alt="Tops Icon">
                <p><strong>Tops</strong></p>
            </div>
            <div id="nav-bottoms">
                <!--Image source: https://www.flaticon.com/free-icon/jeans_664466?term=jeans&page=1&position=15&page=1&position=15&related_id=664466&origin=search-->
                <img src="jeans.png" alt="Bottoms Icon">
                <p><strong>Bottoms</strong></p>
            </div>
            <div id="nav-sale">
                <!--Image source: https://www.flaticon.com/free-icon/shopping-bag_743131?term=shopping%20bag&page=1&position=4&page=1&position=4&related_id=743131&origin=search-->
                <img src="shopping-bag.png" alt="Sale Icon">
                <p><strong>Sale</strong></p>
            </div>
        </div>

        <div class="homepage-gallery">
            <div class="gallery-intro">
                <h4>Only bringing you the best of our collection.</h4>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Doloribus, </p>
                <p>qui nesciunt ipsum fugit, porro eveniet eligendi vel,</p>
                <p>adipisci sequi temporibus natus magni iure a earum! Est debitis error illumnam.</p>
            </div>

            <div class="image-gallery">

                <div class="image-gallery-left">
                    <div id="gallery-left-1">
                        <!--Image Source: https://unsplash.com/-->
                        <a href="Product-Catalog.php"><img src="catalog4.jpg"></a>
                        <p><a href="Product-Catalog.php"><strong>Noname Dresses</strong></a></p>
                        <p>A dress for every ocassion.</p>
                    </div>

                    <div id="gallery-left-2">
                        <!--Image Source: https://unsplash.com/-->
                        <img src="gallery-bottom.jpg">
                        <p><strong>Noname Bottoms</strong></a></p>
                        <p>A bottom for every ocassion.</p>
                    </div>
                </div>

                <div class="image-gallery-right">
                    <div id="gallery-right">
                         <!--Image Source: https://unsplash.com/-->
                         <img src="gallery-top.jpg">
                         <p><strong>Noname Tops</strong></a></p>
                         <p>A Top for every ocassion.</p>
                    </div>
                </div>


            </div>

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


</body>

</html>