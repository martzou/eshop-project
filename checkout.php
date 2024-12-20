<?php

session_start();

if(!empty($_SESSION['cart']) && isset($_POST['checkout'])){
// let user in

// send user to home page
}else{

  header('location: index.php');
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
        <h2>CHECKOUT</h2>
    </section>

    <section id="checkout-details" >
        <div class="check-out">
            <div class="col-75">
              <div class="container">
                <form method="POST" action="server/place_order.php">
          
                  <div class="check-out">
                    <div class="col-50">
                      <h3>Billing Address</h3>
                      <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                      <input type="text" id="fname" name="name" placeholder="John M. Doe">
                      <label for="email"><i class="fa fa-envelope"></i> Email</label>
                      <input type="text" id="email" name="email" placeholder="john@example.com">
                      <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                      <input type="text" id="adr" name="address" placeholder="542 W. 15th Street">
                      <label for="city"><i class="fa fa-institution"></i> City</label>
                      <input type="text" id="city" name="city" placeholder="New York">
          
                      <div class="check-out">
                        <div class="col-50">
                          <label for="state">State</label>
                          <input type="text" id="state" name="state" placeholder="NY">
                        </div>
                        <div class="col-50">
                          <label for="zip">Zip</label>
                          <input type="text" id="zip" name="zip" placeholder="10001">
                        </div>
                      </div>
                    </div>
          
                    <div class="col-50">
                      <h3>Payment</h3>
                      <label for="fname">Accepted Cards</label>
                      <div class="icon-container">
                        <i class="fa fa-cc-visa" style="color:navy;"></i>
                        <i class="fa fa-cc-amex" style="color:blue;"></i>
                        <i class="fa fa-cc-mastercard" style="color:red;"></i>
                        <i class="fa fa-cc-discover" style="color:orange;"></i>
                      </div>
                      <label for="cname">Name on Card</label>
                      <input type="text" id="cname" name="cardname" placeholder="John More Doe">
                      <label for="ccnum">Credit card number</label>
                      <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
                      <label for="expmonth">Exp Month</label>
                      <input type="text" id="expmonth" name="expmonth" placeholder="September">
          
                      <div class="check-out">
                        <div class="col-50">
                          <label for="expyear">Exp Year</label>
                          <input type="text" id="expyear" name="expyear" placeholder="2018">
                        </div>
                        <div class="col-50">
                          <label for="cvv">CVV</label>
                          <input type="text" id="cvv" name="cvv" placeholder="352">
                        </div>
                      </div>
                    </div>
          
                  </div>
                  <label>
                    <input type="checkbox" checked="checked" name="sameadr">Shipping address same as billing
                  </label>
                  <input type="submit" class="btn" name="place_order" value="Place Order">
                </form>
              </div>
            </div>

            <div class="col-25">
              <div class="container">
                <h4>Cart
                  <span class="price" style="color:black">
                    <i class="fa fa-shopping-cart"></i>
                  </span>
                </h4>
                <hr>
                <p>Total amount: <span class="price"><strong> $ <?php echo $_SESSION['total']; ?></strong></span></p>
              </div>
            </div>
          </div>          
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
