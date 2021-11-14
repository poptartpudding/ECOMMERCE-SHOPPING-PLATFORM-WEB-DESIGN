<?php
$db = mysqli_connect('localhost', 'f32ee', 'f32ee', 'f32ee');

// Check connection
if (!$db)
{
    die("error connection failed: " . mysqli_connect_error());
}

// Capture order when customer adds to cart
if (isset($_POST['add_order'])) {
    $radiogroup  = $_POST['color'];
    $radiogroup_size = $_POST['size'];
    $quantity_chosen =  $_POST['qty'];

	// When customer selects one of the radio button
    // Get colour chosen and subtotal of that colour 
	if (isset($radiogroup)) {
		if ($radiogroup === 'cream') {
			$colour_chosen   =   $radiogroup;
            $subTotal_cream  =   29.99 * $quantity_chosen;
		}
		elseif ($radiogroup === 'pink') {
			$colour_chosen 	 =   $radiogroup;
            $subTotal_pink   =   29.99 * $quantity_chosen;          
		}
        elseif ($radiogroup === 'purple') {
            $colour_chosen 	 =   $radiogroup;
            $subTotal_purple =   29.99 * $quantity_chosen;
        }
	}
    if (isset($radiogroup_size)) {
        if ($radiogroup_size === 'XS') {
			$size_chosen 	 =   $radiogroup_size;
		}
		elseif ($radiogroup_size === 'S') {
			$size_chosen 	 =   $radiogroup_size;
		}
        elseif ($radiogroup_size === 'M') {
			$size_chosen 	 =   $radiogroup_size;
		}
        elseif ($radiogroup_size === 'L') {
            $size_chosen 	 =   $radiogroup_size;
        }       
        }  
    $Total = $subTotal_cream + $subTotal_pink + $subTotal_purple;

   //Insert new Order 
   $insertNewOrder_Entry = "INSERT INTO order_table
   VALUES (DEFAULT, 
       '$colour_chosen', 
       '$size_chosen',
       '$quantity_chosen',
       '$subTotal_cream',
       '$subTotal_pink',
       '$subTotal_purple',
       '$Total'
   )";
   

    $db->query($insertNewOrder_Entry);

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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>NoName Maxi Dress</title>
    <!--Stylesheet-->
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

        <div class="wrapper">
            <div class="row">
                <div class="product-image">
                    <div class="product-image-slides">
                        <!--Image sourcefrom pixabay: https://unsplash.com/photos/c2ldRce-6vM-->
                        <img src="woman-dress.jpg">
                    </div>
                    <div class="product-image-slides">
                        <!--Image sourcefrom pixabay: https://unsplash.com/photos/c2ldRce-6vM-->
                        <img src="woman-dress-2.jpg">
                    </div>
                    <div class="product-image-slides">
                        <!--Image sourcefrom pixabay: https://unsplash.com/photos/c2ldRce-6vM-->
                        <img src="woman-dress-3.jpg">
                    </div>
                    <a class="prev" onclick="plusSlides(-1, 0)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1, 0)">&#10095;</a>
                </div>

                <div class="product-detail">
                    <div class="product-heading">
                        <h1 class="product-title">NoName Maxi Dress</h1>
                        <h2>$29.99</h2>
                        <p>NoName's top selling Maxi Dress, perfect for any occassion.</p>
                    </div>
                    <hr>
                    <!--Form is for user to submit order and inputs from the form are stored into php variables-->
                    <form id="submit_cart" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <div class="product-color">
                            <span>Color</span>
                            <div class="color-select">
                                <div>
                                    <input type="radio" id="cream" name="color" value="cream">
                                    <label for="cream"><span>cream</span></label>
                                </div>
                                <div>
                                    <input type="radio" id="pink" name="color" value="pink">
                                    <label for="pink"><span>pink</span></label>
                                </div>
                                <div>
                                    <input type="radio" id="purple" name="color" value="purple">
                                    <label for="purple"><span>purple</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="product-size">
                            <span>Size</span>
                            <div class="size-select">
                                <input type="radio" id="extra_small" name="size" value="XS">XS
                                &emsp;<input type="radio" id="small" name="size" value="S">S
                                &emsp;<input type="radio" id="medium" name="size" value="M">M
                                &emsp;<input type="radio" id="large" name="size" value="L">L
                            </div>
                        </div>

                        <hr>
                        <div class="product-quantity">
                            <span>Quantity</span>
                            <div class="quantity-select">
                                <select id="qty" name="qty">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <!--Customer to add to cart-->
                        <div class="cart-out">
                            <input type="submit" class="cart-btn" name="add_order" value="Add to cart" id="submit-btn">
                        </div>
                    </form>
                    <hr>

                    <div class="product-info" role="tablist">
                        <div class="product-info-header">
                            <ul>
                                <li>
                                    <a href="#tab1" aria-controls="tab" role="tab" data-toggle="tab" aria-expanded="true">Details</a>
                                </li>
                                <li>
                                    <a href="#tab2" aria-controls="tab" role="tab" data-toggle="tab" aria-expanded="true">Size Guide</a>
                                </li>
                                <li>
                                    <a href="#tab3" aria-controls="tab" role="tab" data-toggle="tab" aria-expanded="true">Returns</a>
                                </li>

                            </ul>
                        </div>

                        <div class="product-size-info">
                            <table class="product-size-guide">
                                <tr>
                                    <th>Size</th>
                                    <td>XS</td>
                                    <td>S</td>
                                    <td>M</td>
                                    <td>L</td>
                                </tr>

                                <tr>
                                    <th>PTP</th>
                                    <td>33</td>
                                    <td>35</td>
                                    <td>37</td>
                                    <td>40</td>
                                </tr>

                                <tr>
                                    <th>Waist</th>
                                    <td>25.5</td>
                                    <td>27.5</td>
                                    <td>29.5</td>
                                    <td>32.5</td>
                                </tr>

                                <tr>
                                    <th>Hip</th>
                                    <td>35.5</td>
                                    <td>37.5</td>
                                    <td>39.5</td>
                                    <td>42.5</td>
                                </tr>

                            </table>
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
<?php
$db->close();
?>