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
    $conn->query("DELETE FROM tbl_message WHERE id = $delete_id");
}

// Handle update request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $message_id = intval($_POST['id']);
    $message_status = intval($_POST['message_status']);

    $conn->query("UPDATE tbl_message SET message_status = $message_status WHERE id = $message_id");
}

$search_query = '';
$message_filter = isset($_POST['message_filter']) ? intval($_POST['message_filter']) : null;

$sql = "SELECT * FROM tbl_message WHERE 1=1";

// Handle search query
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['search'])) {
        $search_query = $conn->real_escape_string($_POST['search']);
        $sql .= " AND (name LIKE '%$search_query%' OR email LIKE '%$search_query%')";
    }

    if ($message_filter) {
        $sql .= " AND message_status = $message_filter";
    }
}

// Order by date_created
$sql .= " ORDER BY date_created DESC";

$messages = [];
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
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
    color: red;
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
        <a href="booking.php">Booking</a>
        <a href="users.php">Users</a>
        <a class="active" href="message.php">Messages</a>
    </div>
    
    <div class="content user-content">
    <h2>Messages</h2>
    <div class="mb-3">
        <form method="POST" class="mb-3 row">
            <div class="col-md-6 mb-2">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search by name or email" class="form-control transparent-input" style="width: 100%;">
            </div>
            <div class="col-md-4 mb-2">
            <select name="message_filter" class="form-control transparent-select">
                <option value="">All Status</option>
                <option value="1" <?php if ($message_filter == 1) echo 'selected'; ?>>Read</option>
                <option value="2" <?php if ($message_filter == 2) echo 'selected'; ?>>Unread</option>
            </select>
        </div>
            <div class="col-12 col-md-4 d-flex">
                <button type="submit" class="btn btn-primary btnupdate w-100 me-2" style="width: 100px">Search</button>
                <button type="button" class="btn btn-primary btnupdate w-100 me-2" style="width: 100px" onclick="window.location.href='message.php';">Refresh</button>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-value">
            <thead class="user-head">
                <tr>
                    <th style="color: red;">Fullname</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date Created</th>
                    <th>Status</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody class="user-data">
                <?php foreach ($messages as $message): ?>
                <tr>
                    <td><?php echo htmlspecialchars($message['name']); ?></td>
                    <td><?php echo htmlspecialchars($message['email']); ?></td>
                    <td><?php echo htmlspecialchars($message['message']); ?></td>
                    <td>
                        <?php
                            $dateTime = new DateTime($message['date_created']);
                            echo htmlspecialchars($dateTime->format('F j, Y'));
                            echo ' at ' . htmlspecialchars($dateTime->format('h:i A'));
                        ?>
                    </td>
                    <td><?php
                    switch ($message['message_status']) {
                        case 1:
                            echo "Read";
                            break;
                        case 2:
                            echo "Unread";
                            break;
                        default:
                            echo "Unknown";
                            break;
                    }
                    ?></td>
                    <td>
                        <form action="" method="POST" class="d-flex">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($message['id']); ?>">
                                <select name="message_status" class="transparent-select" required>
                                    <option value="1" <?php echo $message['message_status'] == 1 ? 'selected' : ''; ?>>Read</option>
                                    <option value="2" <?php echo $message['message_status'] == 2 ? 'selected' : ''; ?>>Unread</option>
                                </select>
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary btnupdate flex-fill me-1">Update</button>
                                    <a href="?delete_id=<?php echo htmlspecialchars($message['id']); ?>" class="btn btn-danger btnupdate flex-fill">Delete</a>
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
