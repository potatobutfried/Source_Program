<?php
require_once 'config.php'; // Include the database connection

session_start();

if (!isset($_SESSION['restrictLogin'])) {
    // Redirect to login if not logged in
    header("Location: ../index.php");
    exit();
}

// Fetch user data from the database
$stmt = $pdo->prepare("SELECT firstname, lastname, phone, email, birthdate, gender, pword, user_level FROM tbl_user WHERE id = ?");
$stmt->execute([$_SESSION['id']]);
$user = $stmt->fetch();

if ($user && is_array($user)) {
    $fullname = htmlspecialchars($user['firstname'] . ' ' . $user['lastname']);
    $phone = htmlspecialchars($user['phone']);
    $email = htmlspecialchars($user['email']);
    $userLevel = htmlspecialchars($user['user_level']);
    $birthdate = $user['birthdate'];

    // Calculate age
    $birthDate = new DateTime($birthdate);
    $currentDate = new DateTime();
    $age = $birthDate->diff($currentDate)->y;  // Calculates the difference in years
} else {
    $fullname = 'Unknown User';
    $phone = '';
    $email = '';
    $userLevel = '';
    $age = 'N/A'; // Default if age can't be calculated
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Libis GYM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
<style>
h3 {
    margin-top: 100px;
    color: white;
    font-size: 25px;
    text-align: center;
}
h6 {
    margin-top: none;
    color: yellow;
    font-size: 15px;
    text-align: center;
}
.btnedit {
    background-color: red;
    border-color: yellow;
    color: yellow;
    width: 100px;
    height: 30px;
    font-size: 15px;
    border-radius: 15px;
    margin-top: 10px;
    margin-left: 5px;
}
.btnedit:hover {
    color: red;
    background-color: yellow;
    border-color: red;
}
.btnupdate {
    background-color: red;
    border-color: yellow;
    color: yellow;
    width: 100px;
    height: 30px;
    font-size: 15px;
    border-radius: 15px;
    margin-top: 10px;
    margin-left: 10px;
    display: none;
}
.btnupdate:hover {
    color: red;
    background-color: yellow;
    border-color: red;
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
                            <li><a class="dropdown-item" href="equipment.php">Equipment</a></li>
                            <li><a class="dropdown-item" href="contact.php">Contact</a></li>
                        </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: red;" href="../index.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    
    <!--profile section-->
    <div class="container profile" style="margin-top: 150px; width: 500px;">
        <form method="POST" action="">
            <h3><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></h3>
        <h6>
            <?php
            $userLevel = htmlspecialchars($user['user_level']); 
            if ($userLevel == 1) {
                echo "Admin";
            } elseif ($userLevel == 2) {
                echo "Guest";
            } else {
                echo "Unknown User Level";
            }
            ?>
        </h6>
            <div class="mb-3">
                <label for="age" class="form-label" style="color: white; margin-top: 30px; font-size: 12px;">Age: </label>
                <input type="text" class="form-control" id="age" name="age" value="<?php echo htmlspecialchars($age); ?>" readonly style="background: none; border-color: white; color: white;">
            </div>
            <div class="mb-3">
                <label for="birthdate" class="form-label" style="color: white; font-size: 12px;">Birthdate: </label>
                <input type="date" class="form-control" id="birthdate" style="background: none; border-color: white; color: white;" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label" style="color: white; font-size: 12px;">Gender: </label>
                <input type="gender" class="form-control" id="gender" style="background: none; border-color: white; color: white;" name="gender" value="<?php echo htmlspecialchars($user['gender']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label" style="color: white; font-size: 12px;">Phone: </label>
                <input type="text" class="form-control" id="phone" style="background: none; border-color: white; color: white;" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label" style="color: white; font-size: 12px;">Email: </label>
                <input type="email" class="form-control" id="email" style="background: none; border-color: white; color: white;" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="pword" class="form-label" style="color: white; font-size: 12px;">Password: </label>
                <input type="password" class="form-control" id="pword" style="background: none; border-color: white; color: white;" name="pword" value="<?php echo htmlspecialchars($user['pword']); ?>" readonly>
            </div>
                <button type="button" class="btnedit" onclick="editProfile()">Edit</button>
                <button type="submit" class="btnupdate" style="display: none;">Update</button>
        </form>
    </div>
<!--footer section-->
<footer class="text-center">
    <p>
        <a href="#" data-toggle="modal" data-target="#infoModal">Privacy Policy and Terms and Conditions</a>
    </p>
</footer>
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
     <script>
        function editProfile() {
            // Make the input fields editable
            document.getElementById('phone').readOnly = false;
            document.getElementById('email').readOnly = false;
            document.getElementById('pword').readOnly = false;
            document.getElementById('pword').type = 'text'; // Show the password
            
            // Show the update button and hide the edit button
            document.querySelector('.btnupdate').style.display = 'inline-block';
            document.querySelector('.btnedit').style.display = 'none';
        }
    </script>
</body>
</html>