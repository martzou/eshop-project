<?php

session_start();

if(isset($_POST['add_to_cart'])){
    
    // if user has already added a product to cart
    if(isset($_SESSION['cart'])){

        $product_array_ids = array_column($_SESSION['cart'], "product_id");
        // if product has already been added or not 
        if(!in_array($_POST['product_id'], $product_array_ids) ){

            $product_id = $_POST['product_id'];

                $product_array = array(
                                'product_id' => $_POST['product_id'],
                                'product_image' => $_POST['product_image'],
                                'product_name' => $_POST['product_name'],
                                'price' => $_POST['price'],
                                'quantity' => $_POST['quantity']

                );

                $_SESSION['cart'] [$product_id] = $product_array;

        // product has already been added
        }else{

            echo '<script>alert("Product was already to cart");</script>';

        }
        
    // else this is the first product
    }else {

        $product_id = $_POST['product_id'];

        $product_array = array(
                        'product_id' => $_POST['product_id'],
                        'product_image' => $_POST['product_image'],
                        'product_name' => $_POST['product_name'],
                        'price' => $_POST['price'],
                        'quantity' => $_POST['quantity']

        );

        $_SESSION['cart'] [$product_id] = $product_array;
        // an array with the product_array inside: [ 2=>[], 3=>[], 5=>[] ]

    }

    // calculate total
    calculateCartTotal();

// remove product from cart
}else if(isset($_POST['product_remove'])) { 
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);

    // calculate total
    calculateCartTotal();


}else if(isset($_POST['edit_quantity'])) {

    // we get id and quantity from the form
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // get the product array from the session
    $product_array = $_SESSION['cart'][$product_id];

    // update product quantity
    $product_array['quantity'] = $quantity;
    // return array back to its place 
    $_SESSION['cart'][$product_id] = $product_array;

    // calculate total
    calculateCartTotal();


}else {
    // header('location: index.php');
}


function calculateCartTotal(){

    $total = 0;
    
    foreach($_SESSION['cart'] as $key => $product){
        

        $product = $_SESSION['cart'][$key];

        $price = $product['price'];
        $quantity = $product['quantity'];

        $total += $price * $quantity;
    }


    $_SESSION['total'] = $total;
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>T-shirt Eshop</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    
    <section id="header"> 
        <h3><a href="#"><img src="img/logo.png" class="logo" alt="logo" width="120"
            height="110"></a></h3>
            
            <div>
                <ul id="navbar">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li id="login-sign-up"><a href="login.php"><i class="fa fa-user-o" aria-hidden="true"></i></a></li>
                    <li id="shopping-basket"><a href="cart.php"><i class="fa fa-shopping-basket"></i></a></li>
                    <li><a href="#" id="close"><i class="fa fa-times"></i></a></li>
                </ul>
            </div>
            <div id="mobile">
                <a href="login.php"><i class="fa fa-user-o" aria-hidden="true"></i></a>
                <a href="cart.php"><i class="fa fa-shopping-basket"></i></a>
                <i id="bar" class="fa fa-bars"></i>
            </div>
    </section> 

    <section id="contact-header">
        <h2>Cart</h2>
        <h3>One step left before you get your favourite items!</h3>
    </section>

    <section id="cart" class="section-p1">
        <table width="100%">
            <thead>
                <tr>
                    <td>Product</td>
                    <td>Name</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                    <td>Remove</td>
                </tr>
            </thead>

            <tbody>

                <?php foreach($_SESSION['cart'] as $key => $value){ ?>
                
                <tr>
                    <td><img src="img/<?php echo $value['product_image']; ?>" alt=""></td>
                    <td><?php echo $value['product_name']; ?></td>
                    <td>$<?php echo $value['price']; ?></td>
                    <td>
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $value['quantity']; ?>">    
                            <input class="edit-btn" type="submit" value="edit" name="edit_quantity" >
                        </form>
                    </td>

                    <td>
                        <span>$</span>
                        <span><?php echo $value['quantity'] * $value['price']; ?></span>

                    </td>

                    <td>
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                            <input type="hidden" name="product_remove" value="1">
                            <button type="submit"><i class="fa fa-trash trash"></i></button>
                        </form>
                    </td>
                </tr>

                <?php } ?>

            </tbody>
        </table>

    </section>

    <section id="cart-add" class="section-p1">
        <div id="coupon">
            <h3>Apply Coupon</h3>
            <div><input type="text" placeholder="Enter Your Coupon">
                <button>Apply</button>
            </div>
        </div>

        <div id="total">
            <h3>Cart Total</h3>
            <table>
                <tr>
                    <td>Shipping</td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong> $ <?php echo $_SESSION['total']; ?></strong></td>
                </tr>
            </table>
            <form  method="POST" action="checkout.php">
                <input type="submit" class="checkout-btn" value="Proceed to Checkout" name="checkout">
            </form>
        </div>
    </section>

    <footer class="section-p1">
        <div class="column">
            <h4>Contact us</h4>
            <p><strong>Address: </strong> Paddington 123, London</p>
            <p><strong>Phone: </strong>+0158974586/ (+80)69857458</p>
            <p><strong>Monday - Friday: </strong>09:00-21:00</p>
            <p><strong>Saturday: </strong>09:00-17:00</p>
            <div class="follow">
                <h4>Follow us</h4>
                <div class="icon">
                    <i class="fa fa-facebook-f"></i>
                    <i class="fa fa-instagram"></i>
                    <i class="fa fa-pinterest"></i>
                    <i class="fa fa-twitter"></i>
                </div>
            </div>
        </div>

        <div class="column">
            <h4>The Company</h4>
            <a href="#">About us</a>
            <a href="#">Contact</a>
            <a href="#">Shipping</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms and Conditions</a>
            
        </div>

        <div class="column">
            <h4>Account</h4>
            <a href="#">Sign in</a>
            <a href="#">My order</a>
            <a href="#">Wishlist</a>
            <a href="#">Return Policy</a>
            <a href="#">FAQ</a>
        </div>

        <div class="column install">
            <h4>Install App</h4>
            <p>From App Store or Play Store</p>
            <div class="stores">
                <img src="img/play.jpg" alt="">
                <img src="img/app.jpg" alt="">
            </div>
            <p>Secured Payment Method</p>
            <img src="img/pay.png" alt="">
        </div>

        <div class="copyright">
            <p>&copy; 2024, (T)-Shirt All Rights Reserved</p>
        </div>

    </footer>

    <script src="script.js"> </script>
</body>

</html>