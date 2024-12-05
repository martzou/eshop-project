<?php
session_start();
include('server/connection.php');

// Enable error reporting for debugging (Disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Redirect to login if not authenticated
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('location: login.php');
    exit;
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('location: login.php');
    exit;
}

// Password change functionality
if (isset($_POST['Confirm'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $email = $_SESSION['email'];

    // Basic validation
    if ($password !== $confirmPassword) {
        header('location: account.php?error=Passwords do not match');
        exit;
    } elseif (strlen($password) < 6) {
        header('location: account.php?error=Password must be at least 6 characters long');
        exit;
    } else {
        // Hash the new password securely
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        $stmt->bind_param('ss', $hashed_password, $email);
        if ($stmt->execute()) {
            header('location: account.php?message=Password updated successfully');
            exit;
        } else {
            header('location: account.php?error=Password update failed');
            exit;
        }

        $stmt->close();
    }
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

    <section id="form-details">
        <form  class="change-pass">
            <div class="change-pass">

            <p style="color: green;"><?php if(isset($_GET['register_success'])){echo $_GET['register_success'];} ?></p>
            <p style="color: green;"><?php if(isset($_GET['login_success'])){echo $_GET['login_success'];} ?></p>

                <h3>Account Info</h3>
                <br>
                <p>Name: <span><?php if(isset($_SESSION['name'])){ echo $_SESSION['name'];} ?></span></p>
                <p>Email: <span><?php if(isset($_SESSION['email'])){ echo $_SESSION['email'];} ?></span></p>
                <p><a href="#orders" id="orders-btn">Your orders</a></p>
                <p><a href="account.php?logout=1" id="logout">Logout</a></p>
            </div>
        </form>
        <form class="change-pass" method="POST" action="account.php">

            <p style="color: red;"><?php if(isset($_GET['error'])){echo $_GET['error'];} ?></p>

            <p style="color: green;"><?php if(isset($_GET['message'])){echo $_GET['message'];} ?></p>

            <div class="change-pass">
                <h3>Change Password</h3>
                <br>
                <label>Password</label>
                <input type="password" id="password" placeholder="password" name="password" required>
                <label>Confirm Password</label>
                <input type="password" id="confirmPassword" placeholder="confirm password" name="confirmPassword" required>
                <button class="log-reg-btn" type="submit" id="change-btn" name="Confirm">Confirm</button>
            </div>
        </form>    
    </section>

    <section id="orders" class="section-p1">
        
        <h2>Your Orders</h2>
        
        <table width='100%'>
            <thead>
                <tr>
                    <td>Product</td>
                    <td>Date</td>
                </tr>
            </thead>
        </table>
        <tbody>
            <tr>
                <td><img src="" alt=""></td>
                <td>Light Blue Shirt</td>
                <td>05/08/24</td>
            </tr>
        </tbody>
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
