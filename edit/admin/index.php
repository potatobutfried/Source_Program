<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "libisgym_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Count for pending booking
$sql = "SELECT COUNT(*) AS pending_count FROM tbl_book WHERE book_stats = 1";
$result = $conn->query($sql);

// Fetch the count
$pending_count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pending_count = $row['pending_count'];
}
// Count for confirmed booking
$sql = "SELECT COUNT(*) AS confirmed_count FROM tbl_book WHERE book_stats = 2";
$result = $conn->query($sql);

// Fetch the count
$confirmed_count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $confirmed_count = $row['confirmed_count'];
}
// Count for ongoing booking
$sql_ongoing = "SELECT COUNT(*) AS ongoing_count FROM tbl_book WHERE book_stats = 3";
$result_ongoing = $conn->query($sql_ongoing);

// Fetch the count
$ongoing_count = 0;
if ($result_ongoing->num_rows > 0) {
    $row_ongoing = $result_ongoing->fetch_assoc();
    $ongoing_count = $row_ongoing['ongoing_count'];
}
// Count for completed booking
$sql = "SELECT COUNT(*) AS completed_count FROM tbl_book WHERE book_stats = 4";
$result = $conn->query($sql);

// Fetch the count
$completed_count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $completed_count = $row['completed_count'];
}
// Count for cancelled booking
$sql = "SELECT COUNT(*) AS cancelled_count FROM tbl_book WHERE book_stats = 6";
$result = $conn->query($sql);

// Fetch the count
$cancelled_count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cancelled_count = $row['cancelled_count'];
}
// Count for message booking
$sql = "SELECT COUNT(*) AS message_count FROM tbl_message WHERE message_status = 2";
$result = $conn->query($sql);

// Fetch the count
$message_count = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $message_count = $row['message_count'];
}

$sql = "SELECT id, fullname, btime_in, btime_out FROM tbl_book WHERE book_stats != 4";
$result = $conn->query($sql);
$ongoing_bookings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ongoing_bookings[] = $row;
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
  overflow: auto;
  border-top: solid 1px black;
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
.card-data {
  background: none;
  border-color: yellow;
  color: yellow;
  border-radius: 15px;
  text-align: center;
  padding: 20px;
  
}
.card-data:hover {
  color: red;
  background-color: yellow;
  border-color: red;
  
}
.card-data h3 {
  font-size: 18px;
}
.card-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
.card-container .card-data {
    width: 300px;
    height: 100px;
    margin: 10px;
    margin-top: 40px;
    border: solid 1px yellow;

}
.card-body {
    padding: 20px;
}
.form-label {
    font-weight: bold;
    color: yellow;
}

.form-control {
    border-radius: 10px;
    border: 1px solid yellow;
    background-color: rgba(255, 255, 255, 0.8);
}

.form-select {
    border-radius: 10px;
    border: 1px solid yellow;
    background-color: rgba(255, 255, 255, 0.8);
}

.btn {
    border-radius: 10px;
    padding: 10px 20px;
    font-size: 16px;
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
.btnform {
  background-color: red;
  border-color: yellow;
  color: yellow;
  width: 200px;
  height: 50px;
  font-size: 15px;
  border-radius: 15px;
  margin-top: 100px;
}
.btnform:hover {
    color: red;
    background-color: yellow;
    border-color: red;
}
.card-header {
    border-radius: 10px;
}
.custom-card {
    background: none;
    border: solid 1px yellow;
    border-radius: 15px;
    text-align: center;
    padding: 20px;
    color: yellow;
}

.custom-card-header {
    padding: 10px;
    font-size: 20px;
}

.custom-card-body {
    padding: 15px;
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
    width:230px
}
#date option:checked {
    background-color: rgba(255, 255, 255, 0.1);
}
#date option[disabled] {
    color: grey;
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
    <nav class="col-md-3 col-lg-2 d-md-block sidebar">
      <div class="sidebar">
        <a class="active" href="index.php">Dashboard</a>
        <a href="booking.php">Booking</a>
        <a href="users.php">Users</a>
        <a href="message.php">Messages</a>
      </div>
    </nav>
  <!-- Booking Count Card -->
    <div class="content">
      <div class="card-container">
        <!-- Display Pending Bookings Count -->
        <div class="card-data">
          <h3>Pending Booking</h3>
          <p>
            <?php echo $pending_count; ?> Pending
          </p>
        </div>
        <div class="card-data">
          <h3>Ongoing Booking</h3>
          <p>
            <?php echo $ongoing_count; ?> Ongoing
          </p>
        </div>
        <div class="card-data">
          <h3>Confirmed Booking</h3>
          <p>
            <?php echo $confirmed_count; ?> Confirmed
          </p>
        </div>
        <div class="card-data">
          <h3>Cancelled Booking</h3>
          <p>
            <?php echo $cancelled_count; ?> Cancelled
          </p>
        </div>
        <div class="card-data">
          <h3>Completed Booking</h3>
          <p>
            <?php echo $completed_count; ?> Completed
          </p>
        </div>
      </div>
      
      <div class="container mt-5">
        <div class="row justify-content-center">
        <div class="col-md-3 d-flex justify-content-center mb-4">
            <div class="custom-card card" style="width: 600px;">
                <div class="custom-card-header bg-danger" style="color: white;">
                    <h5>Walk-in Booking</h5>
                </div>
                <div class="custom-card-body">
                    <form action="submit_booking.php" method="POST">
                        <div class="mb-2">
                            <label for="fullname" class="form-label text-white">Full Name:</label>
                            <input type="text" style="background: none; border-color: white; color: white;" class="form-control transparent-input" name="fullname" id="fullname" placeholder="Enter your fullname" required>
                        </div>
                        <div class="mb-2">
                          <label for="date" class="form-label" style="color: white; margin-top: 30px; font-size: 15px;">Date: </label>
                          <div class="col-sm-8">
                              <select class="form-select custom-select" id="date" name="date" style="background: none; width: 230px; border-color: white; color: white;" required>
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
                        </div>
                        <div class="mb-3">
                        <label for="time" class="form-label" style="margin-top: 20px; color: white; font-size: 15px;">Time: </label>
                          <div class="col-sm-8">
                            <select class="form-select custom-select" id="time" name="time" style="background: none; width: 230px; border-color: white; color: white;" required>
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
                        </div>
                        <button type="submit" class="btn btn-primary btnform">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 d-flex justify-content-center mb-4">
    <div class="custom-card card" style="width: 600px;">
        <div class="custom-card-header bg-danger" style="color: white;">
            <h5>Time Out</h5>
        </div>
        <div class="custom-card-body">
            <form action="record_timeout.php" method="POST">
                <div class="mb-2">
                    <label for="ongoing_booking_id" class="form-label text-white" >Ongoing Booking</label>
                    <select class="form-select select" name="ongoing_booking_id" style="background: none; border-color: white; color: white;" id="ongoing_booking_id" required onchange="updateTimeFields(this)">
                      <option selected disabled>Select ongoing booking</option>
                        <?php foreach ($ongoing_bookings as $booking): ?>
                        <option style="background: none; border-color: white; color: black;" value="<?php echo $booking['id']; ?>" 
                          data-btimein="<?php echo htmlspecialchars($booking['btime_in']); ?>" 
                          data-btimeout="<?php echo htmlspecialchars($booking['btime_out']); ?>">
                          <?php echo htmlspecialchars($booking['fullname']); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="time_in" class="form-label" style="color: white; margin-top: 30px; font-size: 15px;">Time In:</label>
                    <input type="text" class="form-control" id="time_in" style="background: none; border-color: white; color: white;" name="time_in" value="" readonly>
                </div>
                <div class="mb-3">
                    <label for="time" class="form-label" style="color: white; margin-top: 20px; font-size: 15px;">Time Out:</label>
                    <input type="time" class="form-control" id="time" style="background: none; border-color: white; color: white;" name="time" required>
                </div>
                <button type="submit" class="btn btn-warning btnform">Time Out</button>
            </form>
        </div>
    </div>
</div>

<script>
    function updateTimeFields(select) {
        const selectedOption = select.options[select.selectedIndex];
        const timeInValue = selectedOption.getAttribute('data-btimein');
        const timeOutValue = selectedOption.getAttribute('data-btimeout');

        // Update the readonly input fields with Time In and Time Out values
        document.getElementById('time_in').value = timeInValue ? timeInValue : ''; 
        document.getElementById('time_out').value = timeOutValue ? timeOutValue : ''; 
    }
</script>
  </div>
</div>
    
</div>
<!--footer section-->
<footer class="text-center">
    <p>
        <a href="#" data-toggle="modal" data-target="#infoModal">Privacy Policy and Terms and Conditions</a>
    </p>
</footer>
</div>
</body>
</html>
