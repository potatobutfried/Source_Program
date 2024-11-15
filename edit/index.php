<?php
// config.php
$host = 'localhost';
$db = 'libisgym_db';
$user = 'root'; // replace with your DB user
$pass = ''; // replace with your DB password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Libis GYM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
</head>
<style>
/* Nav bar design */
@media (max-width: 768px) {
  .navbar-nav .nav-link {
    font-size: 16px;
    padding-right: 10px;
  }

  .btnLogin {
    font-size: 14px;
    padding: 5px 10px;
  }
}
.btnLogin {
    background-color: red;
    border-color: yellow;
    color: yellow;
    width: 200px;
    height: 40px;
    border-radius: 15px;
}
.btnLogin:hover {
    color: red;
    background-color: yellow;
    border-color: red;
}
.navbar-toggler {
    border: none;
}
.navbar-toggler-icon {
    background-color: none;
    width: 25px;
    height: 30px;
}
.logo-container {
  display: flex;
  align-items: center;
}
.logo-container img {
  margin-left: 10px;
}
.logo-container .text {
  font-size: 24px;
  font-weight: bold;
  color: black;
}
.navbar {
  background-color: yellow !important;
}
.navbar-nav .nav-link {
  font-size: 17px;
  padding-right: 20px;
  color: black;
  font-weight: bold;
  margin-right: 30px;
}
.navbar-nav .nav-link:hover,
.navbar-nav .nav-link.active {
    border-bottom: 3px solid red;
}
.dropdown-menu {
    background-color: yellow;
    border: none;
    border-radius: 5px;
    padding: 10px 0;
}
.dropdown-item {
    padding: 10px 20px;
    font-size: 17px;
    color: black;
    font-weight: bold;
    transition: background-color 0.3s;
}
.dropdown-item:hover {
    background-color: red;
    color: yellow;
    border-radius: 5px;
}

/* Footer design */
footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: yellow;
    padding: 10px 0;
    width: 100%;
}
footer p {
    font-size: 16px;
    margin: 0;
}
footer a {
    color: black;
    text-decoration: none;
}
footer a:hover {
    text-decoration: none;
    color: red;
}

.modal-header {
    background-color: yellow;
    color: black;
}
.modal-footer {
    background-color: yellow;
    width: 500px
}
.modal-body h6 {
    margin-top: 0;
    font-weight: bold;
}
.modal-body p {
    font-size: 14px;
    line-height: 1.5;
}
.btn-close-custom {
    background-color: transparent;
    color: red;
    border: none;
    padding: 10px 20px;
    font-size: 30px;
}
.btn-close-custom:hover {
    background-color: none;
    cursor: pointer;
}
.custom-modal-dialog {
    max-width: 800px;
    width: 100%;
    height: 900px;
    margin: 0;
    display: flex;
    align-items: center;
}
.btnclose {
    background-color: red;
    border-color: yellow;
    color: yellow;
    width: 200px;
    height: 40px;
    border-radius: 15px;
}
.btnclose:hover {
    color: red;
    background-color: yellow;
    border-color: red;
}
.g-recaptcha-container {
    max-width: 100%;
    margin: 0 auto;
}

.g-recaptcha {
    width: 100%;
    transform: scale(0.77);
    transform-origin: 0 0;
}
</style>
<body>
<!--header section-->
<nav class="navbar navbar-expand-lg navbar-light bg-warning">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="pic/logo.png" alt="Logo" width="60" height="50">
            <span class="text ms-2">LIBIS GYM</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Gym</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index/equipment.php">Equipment</a></li>
                            <li><a class="dropdown-item" href="index/contact.php">Contact</a></li>
                        </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index/about.php">About</a>
                </li>
            </ul>
                <button class="btn btnLogin ms-3" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        </div>
    </div>
</nav>
<!-- Home Section -->
<div class="home">
    <div class="home-content d-none d-md-block">
        <h1 data-text="Libis GYM">Libis GYM</h1>
        <p>
            Libis Gym is dedicated to providing top-notch fitness <br>training for all levels. Whether you’re a beginner or an
            <br>athlete, we have the right program for you!
        </p>
        <button class="btnappoint" data-bs-toggle="modal" data-bs-target="#loginModal">Appoint Now!</button>
    </div>
    <div class="home-logo d-none d-md-block">
        <img src="pic/logo.png" alt="home-logo" class="img-fluid" style="max-width: 100%; height: auto;">
    </div>
</div>
<!--footer section-->
<footer class="text-center">
    <p>
        <a href="#" data-toggle="modal" data-target="#infoModal">Privacy Policy and Terms and Conditions</a>
    </p>
</footer>
<!--login section-->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 600px;">
        <div class="modal-content" style="min-height: 460px;">
            <div class="modal-header" style="width: 298px;">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="process.php">
                    <div class="lform">
                        <label for="email" class="form-label">Email: </label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="lform">
                        <label for="password" class="form-label">Password: </label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="g-recaptcha-container" style="text-align: center; margin: 20px 0;">
                        <div class="g-recaptcha" data-sitekey="6LcyemUqAAAAAFZvONIz70jsa_xFIfP2hQ8GXkkg" data-size="normal"></div>
                    </div>
                    <button type="submit" class="btnlogin">Login</button>
                </form>
                <button class="btnSignup" data-bs-toggle="modal" data-bs-target="#signupModal">Don't have an account?</button>
            </div>
        </div>
    </div>
</div>

<!--signup section-->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content signup-modal-content" style="margin-top: 200px; max-height: 500px; overflow-y: auto;">
            <div class="modal-header">
                <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="signupForm" method="POST" action="signup_process.php">
                    <div class="sform">
                        <label for="firstname" class="form-label">Firstname: </label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                    <div class="sform">
                        <label for="lastname" class="form-label">Lastname: </label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                    <div class="sform">
                        <label for="contact" class="form-label">Contact No: </label>
                        <input type="tel" class="form-control" id="contact" name="phone" pattern="[0-9]{11}" minlength="11" maxlength="11" required title="Phone Number must be 11 digits">
                    </div>
                    <div class="sform">
                        <label for="birthdate" class="form-label">Birthdate: </label>
                        <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                    </div>
                    <div class="sform">
                        <label for="gender" class="form-label">Gender: </label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option selected disabled>Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="sform">
                        <label for="signupEmail" class="form-label">Email: </label>
                        <input type="email" class="form-control" id="signupEmail" name="email" required>
                    </div>
                    <div class="sform">
                        <label for="signupPassword" class="form-label">Password: </label>
                        <input type="password" class="form-control" id="signupPassword" name="password" required>
                    </div>
                    <div class="g-recaptcha-container" style="text-align: center; margin: 20px 0;">
                        <div class="g-recaptcha" data-sitekey="6LcyemUqAAAAAFZvONIz70jsa_xFIfP2hQ8GXkkg"  data-size="normal"></div>
                    </div>
                    <button type="submit" class="btnsignup">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--privacy section-->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content custom-modal-dialog">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Terms of Use</h5>
            </div>
            <div class="modal-body">
                <h6>Effective Date: October 4, 2024</h6>
                <h6>1. Acceptance of Terms</h6>
                <p>By using our gym appointment system, you agree to comply with these Terms of Use.</p>

                <h6>2. User Responsibilities</h6>
                <p>- You must provide accurate and up-to-date information when creating an account.</p>
                <p>- You are responsible for maintaining the confidentiality of your account information.</p>

                <h6>3. Appointment Cancellations and No-Shows</h6>
                <p>- Cancellations must be made at least three (3) day/s in advance.</p>
                <p>- Failure to cancel or show up for your appointment may result in a fee.</p>

                <h6>4. Modifications to Appointments</h6>
                <p>You can modify your appointments through the system, subject to availability.</p>

                <h6>5. Limitation of Liability</h6>
                <p>We are not liable for any indirect, incidental, or consequential damages arising from your use of the appointment system.</p>

                <h6>6. Governing Law</h6>
                <p>These Terms of Use are governed by the Philippines' Republic Act 10173, officially known as the Data Privacy Act of 2012 (DPA).</p>

                <h6>7. Changes to Terms</h6>
                <p>We may revise these Terms of Use at any time. We will notify you of any changes by posting the updated terms on our website.</p>

                <h6>8. Contact Us</h6>
                <p>For any questions regarding these Terms of Use, please contact us at <a href="mailto:libisgym@gmail.com">libisgym@gmail.com</a>.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btnclose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    <script>
        function myFunction() {
            var x = document.getElementById("Nav");
            if (x.className === "nav") {
            x.className += " responsive";
            } else {
            x.className = "nav";
            }
        }
    </script>
</body>
</html>