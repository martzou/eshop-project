<?php
session_start();
include('server/connection.php');

// Enable error reporting for debugging (Disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Redirect already logged-in users to account
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('location: account.php');
    exit;
}

// Handle login form submission
if (isset($_POST['Login'])) {
    // Collect and sanitize input data
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('location: login.php?error=Invalid email format');
        exit;
    }

    // Prepare SQL statement to fetch the user with the given email
    $stmt = $conn->prepare("SELECT user_id, name, password FROM users WHERE email = ? LIMIT 1");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if a user with that email exists
    if ($stmt->num_rows === 1) {
        // Bind the result to variables
        $stmt->bind_result($user_id, $name, $hashed_password);
        $stmt->fetch();

        // Verify the entered password with the hashed password from the database
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['logged_in'] = true;

            header('location: account.php?login_success=Logged in successfully');
            exit;
        } else {
            // Invalid password
            header('location: login.php?error=Invalid email or password');
            exit;
        } if(!empty($_SESSION['cart'])){
            header('location: checkout.php');
        }
    } else {
        // No user found with that email
        header('location: login.php?error=Invalid email or password');
        exit;
    }

    $stmt->close();
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
        <h2>LOGIN</h2>
    </section>

    <section id="form-details" >
        <form class="register-login" method="POST" action="login.php" >

            <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>

            <label class="register-login">Email</label>
            <input type="text" class="register-login" id="login-email" placeholder="Email" name="email" required>
            <label class="register-login" >Password</label>
            <input type="password" class="register-login" id="login-password" placeholder="Password" name="password" required>
            <button type="submit" class="log-reg-btn" id="login-btn" name="Login">Login</button>
            
            <a href="register.php" id="register-url">Don't have an account? <span>Register</span></a>
        </form>
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
