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

    <section id="page-header">
        <h2>New Arrivals</h2>
        <h4>New Season</h4>
    </section>

    <section id="product" class="section-p1">
        <div class="pro-container">
        
            <?php include('server/get_featured_products.php'); ?>

            <?php while($row= $featured_products->fetch_assoc()){ ?>

            <div class="pro">
                <img src="img/<?php echo $row['product_image']; ?>" />
                <div class="description">
                    <span><?php echo $row['product_description']; ?></span>
                    <h5><?php echo $row['product_name']; ?></h5>
                    <h4><?php echo $row['price']; ?></h4>
                </div>
                <a href="<?php echo "single_product.php?product_id=".$row['product_id']; ?>"><i class="fa fa-shopping-cart cart"></i></a>
            </div>
            
            <?php } ?>
        </div>

    </section>

    <section id="pagination" class="section-p1">
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#"><i class="fa fa-arrow-right"></i></a>
    </section>
    
    <section id="newsletter" class="section-p1 section m1">
        <div class="newstext">
            <h4>Subscribe to our Newsletter</h4>
            <p>Stay tuned! Get the latest style updates & the hottest offers!<p>
        </div>
        <div class="form">
            <input type="text" placeholder="Your email address">
            <button>Sign up</button>
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