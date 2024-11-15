<?php
  // TO CONNECT ON DATABASE
  require_once('config.php'); 
  // START SESSION
  if(!isset($_SESSION)) 
  { 
    session_start(); 
  } 
  // CHECK IF THE ['restrictLogin'] 0 OR 1. IF 1 THE SESSION IS LOGGEDIN AND 0 IF THE USER LOGOUT
  $_SESSION['restrictLogin']=0;

?>
<!DOCTYPE html>
<html>
<head>
    <title>Libis GYM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
<style>
h4 {
    font-size: 50px;
    font-weight: bold;
    color: red;
    text-align: center;
    margin-top: 50px;
    margin-bottom: 30px;
}
h6 {
    color: white;
    text-align: center;
    margin-bottom: 20px;
}
.cform{
    align-content: center;
}
.btnsend {
    background-color: red;
    border-color: yellow;
    color: yellow;
    width: 150px;
    height: 40px;
    border-radius: 15px;
    margin-top: 20px;
    margin-left: 1150px;
}
.btnsend:hover {
    color: red;
    background-color: yellow;
    border-color: red;
}
@media (max-width: 768px) {
      #message {
          margin-top: 20px;
          width: 90%;
      }
  }

@media (max-width: 1024px) {
      #message {
          margin-top: 30px;
          width: 95%;
      }
  }
  .btnsend {
    background-color: red;
    border-color: yellow;
    color: yellow;
    width: 100%;
    max-width: 150px;
    height: 40px;
    border-radius: 15px;
    margin-top: 20px;
    margin-left: 1150px;
    margin-left: auto;
    margin-right: auto;
    display: block;
    text-align: center;
}
.btnsend:hover {
    color: red;
    background-color: yellow;
    border-color: red;
}
@media (max-width: 768px) {
      #message {
          margin-top: 20px;
          width: 90%;
      }
  }
@media (max-width: 1024px) {
      #message {
          margin-top: 30px;
          width: 95%;
      }
  }
@media (max-width: 768px) {
    .btnsend {
        width: 80%;
        max-width: none;
        height: 35px;
        margin-left: auto;
        margin-right: auto;
    }
}
@media (max-width: 480px) {
    .btnsend {
        width: 90%;
        height: 35px;
    }
}
.transparent-input {
    background-color: transparent;
    border: solid 1px white;
    color: white;
}
.transparent-input:focus {
    background-color: transparent;
    border-color: white;
    color: white;
}
.transparent-input::placeholder {
    color: white;
    opacity: 1;
}


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
.dropdown-item.active{
    border-bottom: 3px solid red;
    background: none;
    color: red;
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
</style>
</head>
<body>
<!--header section-->
<nav class="navbar navbar-expand-lg navbar-light bg-warning">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="../pic/logo.png" alt="Logo" width="60" height="50">
            <span class="text ms-2">LIBIS GYM</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Gym</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="equipment.php">Equipment</a></li>
                            <li><a class="dropdown-item active" href="contact.php">Contact</a></li>
                        </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
            </ul>
                <button class="btn btnLogin ms-3" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        </div>
    </div>
</nav>



<!--contact section-->
<div class="container profile" style="margin-top: 50px;">
        <h4>Contact Us</h4>
        <h6>Baranggay 16, Libis Espina, Caloocan City</h6>
        <h6>libisgym@gmail.com</h6>
        <h6>0956 017 4140</h6>
        <form action="contact_process.php" method="POST" style="text-align: center;">
            <div class="mb-3">
                <label for="email" class="form-label" style="float: left; color: red; font-size: 20px;">Fullname: </label>
                <input type="text" class="form-control transparent-input" style="margin-top: 50px" id="name" name="name" placeholder="Enter Your Full Name..." required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label" style="float: left; color: red; font-size: 20px;">Email: </label>
                <input type="text" class="form-control transparent-input" style="margin-top: 50px" id="email" name="email" placeholder="Enter Your Email..." required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label" style="float: left; color: red; font-size: 20px;">Message: </label>
                <textarea id="message" class="form-control transparent-input" name="message" rows="5" style="border-radius: 7px; margin-top: 50px; width: 100%; max-width: 1300px; display: flex;" placeholder="Enter Your Message..." required></textarea>
            </div>
                <button type="submit" class="btnsend">Send Message</button>
        </form>
    </div>
<!--footer section-->
<footer class="text-center">
    <p>
        <a href="#" data-toggle="modal" data-target="#infoModal">Privacy Policy and Terms and Conditions</a>
    </p>
</footer>
<!--login section-->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="loginModalLabel">Login</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form method="POST" action="../process.php">
                  <div class="lform">
                      <label for="email" class="form-label">Email: </label>
                      <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                  <div class="lform">
                      <label for="password" class="form-label">Password: </label>
                      <input type="password" class="form-control" id="password" name="password" required>
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
        <div class="modal-content signup-modal-content" style="margin-top: 60px">
            <div class="modal-header">
                <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="signupForm" method="POST" action="../signup_process.php">
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
                        <input type="tel" class="form-control" id="contact" name="phone" pattern="[0-9]{10}" required title="Phone Number">
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
                    <button type="submit" class="btnsignup">Sign Up</button>
                </form>
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