<?php

$db = mysqli_connect('localhost', 'f32ee', 'f32ee', 'f32ee');

// Check connection
if (!$db) {
    die("erro failed: " . mysqli_connect_error());
}

//Obtain Latest Order 
$getLatestOrder_Entry = [
    'colour_picked'        =>   'SELECT  colour          FROM order_table WHERE id=(select MAX(id) from order_table)',
    'size_picked'            =>   'SELECT	 size            FROM order_table WHERE id=(select MAX(id) from order_table)',
    'quantity_picked'      =>   'SELECT  quantity        FROM order_table WHERE id=(select MAX(id) from order_table)',
    'cream_price'             =>   'SELECT  cream_subtotal  FROM order_table WHERE id=(select MAX(id) from order_table)',
    'pink_price'           =>   'SELECT  pink_subtotal   FROM order_table WHERE id=(select MAX(id) from order_table)',
    'purple_price'         =>   'SELECT  purple_subtotal FROM order_table WHERE id=(select MAX(id) from order_table)',
    'total_price'          =>   'SELECT  total_cost      FROM order_table WHERE id=(select MAX(id) from order_table)'
];

$colour_picked             = $db->query($getLatestOrder_Entry['colour_picked'])->fetch_object();
$size_picked               = $db->query($getLatestOrder_Entry['size_picked'])->fetch_object();
$quantity_picked           = $db->query($getLatestOrder_Entry['quantity_picked'])->fetch_object();
$cream_price                = $db->query($getLatestOrder_Entry['cream_price'])->fetch_object();
$pink_price                = $db->query($getLatestOrder_Entry['pink_price'])->fetch_object();
$purple_price               = $db->query($getLatestOrder_Entry['purple_price'])->fetch_object();
$total_price               = $db->query($getLatestOrder_Entry['total_price'])->fetch_object();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>NoName Dress Catalog</title>
    <!--Stylesheet-->
    <link rel="stylesheet" href="stylesheet.css?v=<?php echo time(); ?>">
</head>

<body>
    <div id="nav-bar">
        <nav>
            <ul class="nav">
                <li class="left-nav"><a href="index.php"><strong>Home</strong></a></li>
                <li class="left-nav"><a href="Product-Catalog.php><strong>Dress</strong></a></li>
				<li class=" left-nav"><a href=""><strong>Tops</strong></a></li>
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

    <div class="catalog-header">
        <h1>Products</h1>
    </div>

    <div class="catalog-display">
        <div class="catalog-row1">
            <div id="cata1">
                <!--Image Source: https://unsplash.com/@priscilladupreez-->
                <a href="Product-Page.php"><img src="woman-dress.jpg"></a>
                <p><a href="Product-Page.php">Noname Maxi Dress</a></p>
                <p><a href="Product-Page.php"><strong>SGD$29.99</strong></a></p>
            </div>

            <div id="cata2">
                <img src="catalog6.jpg">
                <p>Noname Dress</p>
                <p><strong>SGD$29.99</strong></p>
            </div>
            <div id="cata3">
                <img src="catalog4.jpg">
                <p>Noname Dress</p>
                <p><strong>SGD$29.99</strong></p>
            </div>
        </div>

        <div class="catalog-row2">
            <div id="cata4">
                <!--Image Sources all from: https://unsplash.com/-->
                <img src="catalog3.jpg">
                <p>Noname Maxi Dress</p>
                <p><strong>SGD$29.99</strong></p>
            </div>

            <div id="cata5">
                <img src="catalog5.jpg">
                <p>Noname Dress</p>
                <p><strong>SGD$29.99</strong></p>
            </div>
            <div id="cata6">
                <img src="catalog2.jpg">
                <p>Noname Dress</p>
                <p><strong>SGD$29.99</strong></p>
            </div>
        </div>
        <div class="catalog-row3">
            <div id="cata7">
                <!--Image Sources all from: https://unsplash.com/photos/xQ1OOz6BRaU-->
                <img src="catalog7.jpg">
                <p>Noname Maxi Dress</p>
                <p><strong>SGD$29.99</strong></p>
            </div>

            <div id="cata8">
                <!--Image source: https://unsplash.com/photos/ZgBn3GfwUig-->
                <img src="catalog8.jpg">
                <p>Noname Dress</p>
                <p><strong>SGD$29.99</strong></p>
            </div>
            <div id="cata9">
                <!--Image source: https://unsplash.com/photos/L7YRd_pcawg-->
                <img src="catalog9.jpg">
                <p>Noname Dress</p>
                <p><strong>SGD$29.99</strong></p>
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