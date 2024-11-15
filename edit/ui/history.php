<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "libisgym_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$user_email = $_SESSION['email'];

// Initialize filter variables
$booking_filter = isset($_POST['booking_filter']) ? $_POST['booking_filter'] : '';
$search_query = isset($_POST['search']) ? $_POST['search'] : '';

// Base SQL query
$sql = "SELECT * FROM tbl_book WHERE email = ?";
$conditions = [];

if ($booking_filter === 'upcoming') {
    $conditions[] = "STR_TO_DATE(bdate, '%Y-%m-%d') >= CURDATE()"; // Upcoming bookings
    $conditions[] = "book_stats = 2"; // Only Confirmed bookings (assuming '2' is for Confirmed)
} elseif ($booking_filter === 'completed') {
    $conditions[] = "STR_TO_DATE(bdate, '%Y-%m-%d') < CURDATE()"; // Completed bookings
    $conditions[] = "book_stats = 4"; // Only Completed bookings
} elseif ($booking_filter === 'pending') {
    $conditions[] = "STR_TO_DATE(bdate, '%Y-%m-%d') >= CURDATE()"; // Include upcoming dates for pending
    $conditions[] = "book_stats = 1"; // Only Pending bookings
}


if (!empty($search_query)) {
    $search_query = $conn->real_escape_string($search_query); // Prevent SQL injection
    $conditions[] = "(fullname LIKE '%$search_query%' OR email LIKE '%$search_query%')";
}

// Append conditions to the query if any
if (!empty($conditions)) {
    $sql .= " AND " . implode(' AND ', $conditions);
}

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libis GYM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/styles.css">
<style>
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
select.transparent-select {
    background-color: transparent;
    color: white;
    border: solid 1px white;
    width: 150px;
    padding: 5px;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    display: inline-block;
}
select.transparent-select option {
    background-color: black;
    color: white;
}
.btnupdate {
    background-color: red;
    border-color: yellow;
    color: yellow;
    width: 100px;
    height: 100%;
    font-size: 12px;
    border-radius: 15px;
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
                            <li><a class="dropdown-item active" href="history.php">Book History</a></li>
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
<!-- Booking History Section -->
<div class="container history" style="margin-top: 50px;">
    <h2 style="color: red; margin-bottom: 20px">Booking History</h2>
    <form method="POST" class="mb-3">
        <div class="row mb-2">
            <div class="col-12 col-md-4">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search by name or email" class="form-control transparent-input">
            </div>
            <div class="col-12 col-md-4">
                <select name="booking_filter" class="form-control transparent-select">
                    <option value="">All Bookings</option>
                    <option value="upcoming" <?php if ($booking_filter == 'upcoming') echo 'selected'; ?>>Upcoming</option>
                    <option value="completed" <?php if ($booking_filter == 'completed') echo 'selected'; ?>>Completed</option>
                    <option value="pending" <?php if ($booking_filter == 'pending') echo 'selected'; ?>>Pending</option>
                </select>
            </div>
            <div class="col-12 col-md-4 d-flex">
                <button type="submit" class="btn btn-primary btnupdate w-100 me-2">Search</button>
                <button type="button" class="btn btn-primary btnupdate w-100 me-2" onclick="window.location.href='history.php';">Refresh</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered" style="border: white; background-color: transparent; color: white;">
            <thead style="color: white;">
                <tr>
                    <th style="color: red">Full Name</th>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($bookings) > 0): ?>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['fullname']); ?></td>
                            <td>
                                <?php 
                                    $date = DateTime::createFromFormat('Y-m-d', $booking['bdate']);
                                    echo htmlspecialchars($date->format('F j, Y'));
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($booking['btime_in']); ?></td>
                            <td>
                                <?php 
                                    $timeOut = DateTime::createFromFormat('H:i:s', $booking['btime_out']);
                                    echo htmlspecialchars($timeOut ? $timeOut->format('h:i A') : 'N/A');
                                ?>
                            </td>
                            <td>
                                <?php
                                // Display booking status based on book_stats value
                                switch ($booking['book_stats']) {
                                    case 1:
                                        echo "Pending";
                                        break;
                                    case 2:
                                        echo "Confirmed";
                                        break;
                                    case 3:
                                        echo "Cancelled";
                                        break;
                                    case 4:
                                        echo "Completed";
                                        break;
                                    case 5:
                                        echo "Rejected";
                                        break;
                                    default:
                                        echo "Unknown"; // For any undefined status
                                        break;
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No bookings found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!--footer section-->
<footer class="text-center">
    <p>
        <a href="#" data-toggle="modal" data-target="#infoModal">Privacy Policy and Terms and Conditions</a>
    </p>
</footer>

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