<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "libisgym_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Handle delete request (no change here)
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM tbl_user WHERE id = $delete_id");
  }
  
  // Handle search request
  $search_query = '';
  if (isset($_POST['search'])) {
      $search_query = $conn->real_escape_string($_POST['search']);
  }
  
  // Handle user level filter
  $user_level_filter = '';
  if (isset($_POST['user_level_filter']) && $_POST['user_level_filter'] !== '') {
      $user_level_filter = intval($_POST['user_level_filter']);
  }
  
  // Modify SQL query to filter by search and user level
  $sql = "SELECT * FROM tbl_user";
  $conditions = [];
  
  // Add search condition if search query is not empty
  if (!empty($search_query)) {
      $conditions[] = "(firstname LIKE '%$search_query%' OR lastname LIKE '%$search_query%' OR email LIKE '%$search_query%')";
  }
  
  // Add user level filter condition if selected
  if (!empty($user_level_filter)) {
      $conditions[] = "user_level = $user_level_filter";
  }
  
  // If there are any conditions, append them to the SQL query
  if (count($conditions) > 0) {
      $sql .= " WHERE " . implode(' AND ', $conditions);
  }
  
  // Execute the query
  $result = $conn->query($sql);

  $sql .= " ORDER BY date_created DESC";
  $result = $conn->query($sql);

  // Process the result into an array (no change here)
  $users = [];
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          $users[] = $row;
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
  overflow: hidden;
  height: 100%;
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
select.transparent-input {
    background-color: transparent; 
    color: white;               
    border: 1px solid white;     
    width: 150px;
}

select.transparent-input option {
    background-color: black; 
    color: white;            
}

select.transparent-input:focus {
    background-color: transparent;
    color: white;                 
    border-color: white;         
}
.password {
    display: inline-block;
    max-width: 100px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    color: white; 
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
        <a class="active" href="users.php">Users</a>
        <a href="message.php">Messages</a>
    </div>
    <div class="content user-content">
    <h2>Users</h2>
    <form method="POST" class="mb-3 row">
        <div class="col-md-6 mb-2">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search by name or email" class="form-control transparent-input" style="width: 100%;">
        </div>
        <div class="col-md-4 mb-2">
            <select name="user_level_filter" class="form-control transparent-input" style="width: 150px;">
                <option value="">All Levels</option>
                <option value="1" <?php echo (isset($_POST['user_level_filter']) && $_POST['user_level_filter'] == 1) ? 'selected' : ''; ?>>Admin</option>
                <option value="2" <?php echo (isset($_POST['user_level_filter']) && $_POST['user_level_filter'] == 2) ? 'selected' : ''; ?>>Guest</option>
            </select>
        </div>
        <div class="col-12 col-md-4 d-flex">
            <button type="submit" class="btn btn-primary btnupdate w-100 me-2" style="width: 100px">Search</button>
            <button type="button" class="btn btn-primary btnupdate w-100 me-2" style="width: 100px" onclick="window.location.href='users.php';">Refresh</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-value">
            <thead class="user-head">
                <tr>
                    <th style="color: red;">Fullname</th>
                    <th>Phone</th>
                    <th>Birthdate</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Date Created</th>
                    <th>User Level</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody class="user-data">
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></td>
                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                    <td>
                        <?php
                            $birthdate = new DateTime($user['birthdate']);
                            $today = new DateTime('today');
                            $age = $today->diff($birthdate)->y;
                            echo htmlspecialchars($age);
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($user['gender']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <?php
                            $dateTime = new DateTime($user['date_created']);
                            echo htmlspecialchars($dateTime->format('F j, Y'));
                            echo ' at ' . htmlspecialchars($dateTime->format('h:i A'));
                        ?>
                    </td>
                    <td><?php
                    switch ($user['user_level']) {
                        case 1:
                            echo "Admin";
                            break;
                        case 2:
                            echo "Guest";
                            break;
                        default:
                            echo "Unknown";
                            break;
                    }
                    ?></td>
                    <td>
                        <form action="update_users.php" method="POST" class="d-flex align-items-center">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                            <input type="text" style="text-align: center; width: 60px; background: none; color: white; border: solid 1px white;" name="user_level" value="<?php echo htmlspecialchars($user['user_level']); ?>" required>
                            <button type="submit" class="btn btn-primary btnupdate ms-2">Update</button>
                            <a href="?delete_id=<?php echo htmlspecialchars($user['id']); ?>" class="btn btn-danger btnupdate ms-2">Delete</a>
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
