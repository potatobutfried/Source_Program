<?php
session_start(); // Start the session
// Assuming the user data is stored in session after login
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
header {
    text-align: center;
    padding: 20px;
    background: none;
    color: red;
    margin-top: 30px;
    margin-bottom: 30px;
    
}
h5 {
    font-size: 60px;
    font-weight: bolder;
}
.equipment-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    padding: 20px;
}

.equipment-item {
    background-color: yellow;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px;
    width: 200px;
    text-align: center;
    padding: 20px;
}
.equipment-item img {
    width: 100%;
    height: auto;
    border-radius: 10px;
}
.equipment-item h2 {
    font-size: 1.5rem;
    margin-bottom: 20px;
    text-align: center;
    margin-top: 10px;
}
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
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Book</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="book.php">Book Now</a></li>
                            <li><a class="dropdown-item" href="history.php">Book History</a></li>
                        </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Gym</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item active" href="equipment.php">Equipment</a></li>
                            <li><a class="dropdown-item" href="contact.php">Contact</a></li>
                        </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: red;" href="../index.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <!--equipment section-->
    <header>
        <h5>Gym Equipment</h5>
    </header>

    <section class="equipment-list">
        <div class="equipment-item">
            <h2>Dumbbell</h2>
            <img src="../pic/dumbbell.png">
        </div>
        <div class="equipment-item">
            <h2>Barbell</h2>
            <img src="../pic/barbell.png">
        </div>
        <div class="equipment-item">
            <h2>Treadmill</h2>
            <img src="../pic/treadmill.png">
        </div>
        <div class="equipment-item">
            <h2>Shoulder Press</h2>
            <img src="../pic/shoulder_press.png">
        </div>
        <div class="equipment-item">
            <h2>Stationary Bikes</h2>
            <img src="../pic/stationary_bike.png">
        </div>
        <div class="equipment-item">
            <h2>Leg Press Machine</h2>
            <img src="../pic/leg_press.png">
        </div>
        <div class="equipment-item">
            <h2>Kettle Bells</h2>
            <img src="../pic/kettlebell.png">
        </div>
        <div class="equipment-item">
            <h2>Cable Crossover Machine</h2>
            <img src="../pic/cable_crossover.png">
        </div>
        <div class="equipment-item">
            <h2>Plates</h2>
            <img src="../pic/plates.png">
        </div>
        <div class="equipment-item">
            <h2>Bench Press</h2>
            <img src="../pic/bench_press.png">
        </div>
        <div class="equipment-item">
            <h2>Power Cage</h2>
            <img src="../pic/power_cage.png">
        </div>
        <div class="equipment-item">
            <h2>Cable Row Machine</h2>
            <img src="../pic/cable_row.png">
        </div>
        <div class="equipment-item">
            <h2>Back Training Machine</h2>
            <img src="../pic/back_training.png">
        </div>
        <div class="equipment-item">
            <h2>AB Roller</h2>
            <img src="../pic/abroller.png">
        </div>
        <div class="equipment-item">
            <h2>Leg Curl Machine</h2>
            <img src="../pic/leg_curl.png">
        </div>
    </section>
<!--footer section-->
<footer class="text-center">
    <p>
        <a href="#" data-toggle="modal" data-target="#infoModal">Privacy Policy and Terms and Conditions</a>
    </p>
</footer>
    <!--login section-->

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
