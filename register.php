<!-- <?php

//session_start();

//include('server/connection.php');

// if user has already registered take user to account page - DOESNT WORK!!!!!
// if(isset($_SESSION['logged_in'])){
//   header('location: account.php');
//   exit;
// }

// if(isset($_POST['register'])){

//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     $confirmPassword = $_POST['confirmPassword'];
    
//     // if passwords dont match
//     if($password !== $confirmPassword){
//         header('location: register.php?error=passwords dont match');
    
//     // if password is less than 6 char
//     }else if(strlen($password) < 6){
//        header('location: register.php?error=password must be at least 6 characters long');

//     // if there is no error 
//     }else{

//         // check whether there is a user with this email or not
//         $stmt1 = $conn->prepare("SELECT count(*) FROM users where email=?");
//         $stmt1->bind_param('s',$email);
//         $stmt1->execute();
//         $stmt1->bind_result($num_rows);
//         $stmt1->store_result();
//         $stmt1->fetch();

//         // if there is a user already registered with this email display an error message
//         if($num_rows !=0){
//             header('location: register.php?error=user with this email already exists');

//         // if no user registered with this email before 
//         }else{

//             // create a new user
//             $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?,?,?)");

//             $stmt->bind_param('sss', $name, $email, md5($password));

//             if($stmt->execute()){
//                 $user_id = $stmt->insert_id;
//                 $_SESSION['user_id] = $user_id;
//                 $_SESSION['email'] = $email;
//                 $_SESSION['name'] = $name;
//                 $_SESSION['logged_in'] = true;
//                 header('location: account.php?register_success=You registered successfully');

//             // account could not be created 
//             }else{
//                 header('location: register.php?error=could not create an account at the moment');
//             }
//         }
//     }

// }


?> -->




<?php
session_start();
include('server/connection.php');

// Enable error reporting for debugging (Disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Redirect logged-in users to account
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('location: account.php');
    exit;
}

// Handle registration form submission
if (isset($_POST['register'])) {
    // Collect and sanitize input data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Basic validation
    if ($password !== $confirmPassword) {
        header('location: register.php?error=Passwords do not match');
        exit;
    } elseif (strlen($password) < 6) {
        header('location: register.php?error=Password must be at least 6 characters long');
        exit;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('location: register.php?error=Invalid email format');
        exit;
    }

    // Check if email already exists
    $stmt1 = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    if ($stmt1 === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt1->bind_param('s', $email);
    $stmt1->execute();
    $stmt1->bind_result($num_rows);
    $stmt1->fetch();
    $stmt1->close();

    if ($num_rows != 0) {
        header('location: register.php?error=User with this email already exists');
        exit;
    }

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('sss', $name, $email, $hashed_password);
    if ($stmt->execute()) {
        // Retrieve the inserted user's ID
        $user_id = $stmt->insert_id;

        // Set session variables
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['logged_in'] = true;

        header('location: account.php?register_success=Registration successful');
        exit();
    } else {
        header('location: register.php?error=Account creation failed');
        exit();
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
        <h2>REGISTER</h2>
    </section>

    <section id="form-details" >
        <form id="register-form" class="register-login" method="POST" action="register.php">

        <p style="color: red;"><?php if(isset($_GET['error'])) {echo $_GET['error']; }?></p>

            <label class="register-login">Name</label>
            <input type="text" class="register-login" id="register-name" placeholder="full name" name="name" required>
            <label class="register-login">Email</label>
            <input type="text" class="register-login" id="register-email" placeholder="email" name="email" required>
            <label class="register-login" >Password</label>
            <input type="password" class="register-login" id="register-password" placeholder="password" name="password" required>
            <label class="register-login" >Confirm Password</label>
            <input type="password" class="register-login" id="register-confirm-password" placeholder="confirm password" name="confirmPassword" required>
            <button type="submit" class="log-reg-btn" id="register-btn" name="register" value="Register">Register</button>   
            
            <a href="login.php" id="login-url">Do you already have an account? <span>Login</span></a>
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