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
session_start();

if (!isset($_SESSION['restrictLogin'])) {
    header("Location: ../index.php");
    exit();
}

$userId = $_SESSION['id']; // Assuming the user ID is stored in the session

// Fetch user data
$stmt = $pdo->prepare("SELECT firstname, lastname, phone, email, user_level FROM tbl_user WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if ($user && is_array($user)) {
    $fullname = htmlspecialchars($user['firstname'] . ' ' . $user['lastname']);
    $phone = htmlspecialchars($user['phone']);
    $email = htmlspecialchars($user['email']);
    $userLevel = htmlspecialchars($user['user_level']);
} else {
    $fullname = 'Unknown User';
    $phone = '';
    $email = '';
    $userLevel = '';
}
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
h3 {
    color: red;
    font-size: 40px;
}
h6 {
    color: yellow;
    font-size: 30px;
}
h4 {
    color: white;
    font-size: 15px;
    margin-left: 20px;
    margin-top: 10px;
}
.btnconfirm {
    background-color: red;
    border-color: yellow;
    color: yellow;
    font-size: 15px;
    width: 100px;
    height: 30px;
    border-radius: 15px;
}
.btnconfirm:hover {
    color: red;
    background-color: yellow;
    border-color: red;
}
.btnbook {
    background-color: red;
    border-color: yellow;
    color: yellow;
    font-size: 15px;
    width: 100px;
    height: 30px;
    border-radius: 15px;
    margin-top: 10px;
    margin-left: 630px;
}
.btnbook:hover {
    color: red;
    background-color: yellow;
    border-color: red;
}
#time {
    background-color: black; 
    border-color: white;
    color: white;
}
#time option {
    background-color: black; 
    color: white;
}
#time option:checked {
    background: rgba(255, 255, 255, 0.1);
}
#time option[disabled] {
    color: black;
}
#date {
    background: none;
    border-color: white;
    color: white;
}
#date option {
    background-color: black; 
    color: white; 
}
#date option:checked {
    background-color: rgba(255, 255, 255, 0.1);
}
#date option[disabled] {
    color: grey;
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
                            <li><a class="dropdown-item active" href="book.php">Book Now</a></li>
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
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: red;" href="../index.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--book now section-->
<div class="container book my-5 p-4 rounded border" style="border-color: white; max-width: 800px; width: 100%;">
    <form id="bookingForm" method="POST" action="process.php" onsubmit="event.preventDefault(); showConfirmationModal();">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0"><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></h3>
            <h6 class="mb-0">
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
        </div>
        <h4 class="text-white"><?php echo htmlspecialchars($user['email']); ?></h4>
        <h4 class="text-white"><?php echo htmlspecialchars($user['phone']); ?></h4>
        
        <div class="mb-3">
            <label for="date" class="form-label text-white">Date:</label>
            <select class="form-select" id="date" name="date" required>
                <option selected disabled>Select a date</option>
                <?php
                    $daysToShow = 7;
                    $currentDate = new DateTime();        
                    for ($i = 0; $i < $daysToShow; $i++) {
                        $date = clone $currentDate;
                        $date->modify("+$i day");
                        $dateValue = $date->format('Y-m-d');
                        $dateLabel = $date->format('F j, Y');     
                            echo "<option value=\"$dateValue\">$dateLabel</option>";
                    }
                ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="time" class="form-label text-white">Time:</label>
            <select class="form-select" id="time" name="time" required>
                <option selected disabled>Select a time slot</option>
                <option value="10:00 AM">10:00 AM</option>
                <option value="11:00 AM">11:00 AM</option>
                <option value="12:00 PM">12:00 PM</option>
                <option value="01:00 PM">1:00 PM</option>
                <option value="02:00 PM">2:00 PM</option>
                <option value="03:00 PM">3:00 PM</option>
                <option value="04:00 PM">4:00 PM</option>
                <option value="05:00 PM">5:00 PM</option>
                <option value="06:00 PM">6:00 PM</option>
                <option value="07:00 PM">7:00 PM</option>
                <option value="08:00 PM">8:00 PM</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="remarks" class="form-label text-white">Remarks:</label>
            <textarea id="remarks" name="remarks" rows="3" class="form-control" style="color: white; border-color: white; background: none;"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary btnconfirm">Submit</button>
    </form>
</div>
<!--footer section-->
<footer class="text-center">
    <p>
        <a href="#" data-toggle="modal" data-target="#infoModal">Privacy Policy and Terms and Conditions</a>
    </p>
</footer>
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: black; color: white;">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel" style="color: red">Confirm Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to submit this booking?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnconfirm" style="display: inline-block; width: 100px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btnconfirm" style="display: inline-block; width: 100px; margin-left: 10px;" onclick="submitForm()">Confirm</button>
            </div>
        </div>
    </div>
    <script>
        function showConfirmationModal() {
            var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'), {
                backdrop: 'static',
                keyboard: false
            });
            confirmationModal.show();
}

        function submitForm() {
            document.getElementById('bookingForm').submit();
}
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