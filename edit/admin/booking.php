<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "libisgym_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM tbl_book WHERE id = $delete_id");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        $id = intval($_POST['id']);
        $book_stats = intval($_POST['book_stats']);

        $stmt = $conn->prepare("UPDATE tbl_book SET book_stats = ? WHERE id = ?");
        $stmt->bind_param("ii", $book_stats, $id);

        if ($stmt->execute()) {
            header("Location: booking.php");
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Handle search request
$search_query = '';
$status_filter = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['search'])) {
        $search_query = $conn->real_escape_string($_POST['search']);
    }
    if (isset($_POST['status_filter'])) {
        $status_filter = intval($_POST['status_filter']);
    }
}

// Build SQL query
$sql = "SELECT * FROM tbl_book WHERE 1=1"; // Base query

if (!empty($search_query)) {
    $sql .= " AND (fullname LIKE '%$search_query%' OR email LIKE '%$search_query%')";
}

if ($status_filter != '') {
    $sql .= " AND book_stats = $status_filter"; // Filtering by book_stats
}

// Order by date and time
$sql .= " ORDER BY STR_TO_DATE(CONCAT(bdate, ' ', btime_in), '%m/%d/%Y %H:%i') ASC";

$result = $conn->query($sql);
$bookings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

$conn->close();
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
body {
    overflow: auto;
}
.sidebar {
  margin: 0;
  padding: 0;
  width: 200px;
  background-color: yellow;
  position: fixed;
  height: 100%;
  overflow: hidden;
  border-top: solid 1px black;;
}

.sidebar a {
  display: block;
  color: black;
  padding: 16px;
  text-decoration: none;
  border: solid 1px black;
  border-left: none;
  border-right: none;
  border-top: none;
  text-align: center;
  font-size: 18px;
}
 
.sidebar a.active {
  color: Red;
}

.sidebar a:hover:not(.active) {
  background-color: red;
  color: black;
}

div.content {
  margin-left: 200px;
  padding: 1px 16px;
  height: 1000px;
}

@media screen and (max-width: 700px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .sidebar a {float: left;}
  div.content {margin-left: 0;}
}

@media screen and (max-width: 400px) {
  .sidebar a {
    text-align: center;
    float: none;
  }
}
h2{
    font-size: 40px;
    font-weight: bold;
}
.booking-content {
    color: red;
}
.table-value {
    color: white;
    text-align: center;
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
    width: 100px;
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
    <div class="header">
        <div class="logo-container">
          <img src="../pic/logo.png" alt="Logo" width="60px" height="50px" margin-left="50px">
          <span class="text">LIBIS GYM</span>
        </div>
        <a href="../index.php" class="btnlogout" style="color: red;">Logout</a>
    </div>

    <div class="sidebar">
        <a href="index.php">Dashboard</a>
        <a class="active" href="#bookings">Booking</a>
        <a href="users.php">Users</a>
        <a href="message.php">Messages</a>
    </div>
    <div class="content booking-content">
    <h2>Bookings</h2>
    <form method="POST" class="mb-3 row">
        <div class="col-md-6 mb-2">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search by name or email" class="form-control transparent-input" style="width: 100%;">
        </div>
        <div class="col-md-4 mb-2">
            <select name="status_filter" class="form-control transparent-select">
                <option value="">All Status</option>
                <option value="1" <?php if ($status_filter == 1) echo 'selected'; ?>>Pending</option>
                <option value="2" <?php if ($status_filter == 2) echo 'selected'; ?>>Confirmed</option>
                <option value="3" <?php if ($status_filter == 3) echo 'selected'; ?>>Ongoing</option>
                <option value="4" <?php if ($status_filter == 4) echo 'selected'; ?>>Completed</option>
                <option value="5" <?php if ($status_filter == 5) echo 'selected'; ?>>Rejected</option>
                <option value="6" <?php if ($status_filter == 6) echo 'selected'; ?>>Cancelled</option>
            </select>
        </div>
        <div class="col-12 col-md-4 d-flex">
            <button type="submit" class="btn btn-primary btnupdate w-100 me-2" style="width: 100px">Search</button>
            <button type="button" class="btn btn-primary btnupdate w-100 me-2" style="width: 100px" onclick="window.location.href='booking.php';">Refresh</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-value">
            <thead>
                <tr>
                    <th style="color: red;">Full Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?php echo htmlspecialchars($booking['fullname']); ?></td>
                    <td><?php echo htmlspecialchars($booking['phone']); ?></td>
                    <td><?php echo htmlspecialchars($booking['email']); ?></td>
                    <td><?php echo date("F j, Y", strtotime($booking['bdate'])); ?></td>
                    <td><?php echo htmlspecialchars($booking['btime_in']); ?></td>
                    <td>
                        <?php 
                            if (!empty($booking['btime_out'])) {
                                $formattedTimeOut = DateTime::createFromFormat('H:i', $booking['btime_out'])->format('g:i A');
                                echo htmlspecialchars($formattedTimeOut);
                            } else {
                                echo "N/A";
                            }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($booking['remarks']); ?></td>
                    <td><?php
                    switch ($booking['book_stats']) {
                        case 1:
                            echo "Pending";
                            break;
                        case 2:
                            echo "Confirmed";
                            break;
                        case 3:
                            echo "Ongoing";
                            break;
                        case 4:
                            echo "Completed";
                            break;
                        case 5:
                            echo "Rejected";
                            break;
                        case 6:
                            echo "Cancelled";
                            break;
                        default:
                            echo "Unknown"; // For any undefined status
                            break;
                    }
                    ?></td>
                    <td>
                        <form action="" method="POST" class="d-flex">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($booking['id']); ?>">
                            <select name="book_stats" class="transparent-select" required>
                                <option value="1" <?php echo $booking['book_stats'] == 1 ? 'selected' : ''; ?>>Pending</option>
                                <option value="2" <?php echo $booking['book_stats'] == 2 ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="3" <?php echo $booking['book_stats'] == 3 ? 'selected' : ''; ?>>Ongoing</option>
                                <option value="4" <?php echo $booking['book_stats'] == 4 ? 'selected' : ''; ?>>Completed</option>
                                <option value="5" <?php echo $booking['book_stats'] == 5 ? 'selected' : ''; ?>>Rejected</option>
                                <option value="6" <?php echo $booking['book_stats'] == 6 ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        <div class="d-flex">
                            <button type="submit" name="action" value="update" class="btn btn-primary btnupdate flex-fill me-1">Update</button>
                            <a href="?delete_id=<?php echo htmlspecialchars($booking['id']); ?>" class="btn btn-danger btnupdate flex-fill">Delete</a>
                        </div>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
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
</body>
</html>
