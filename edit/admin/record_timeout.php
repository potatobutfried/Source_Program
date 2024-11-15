<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "libisgym_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$booking_id = $_POST['ongoing_booking_id'];
$time = $_POST['time'];

$sql = "UPDATE tbl_book SET btime_out = ?, book_stats = ? WHERE id = ?";
$book_status = 4;
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $time, $book_status, $booking_id);

if ($stmt->execute()) {
    echo "<script>
                alert('Timeout Submitted');
                window.location.href = 'index.php'; // Redirect after alert
            </script>";
            exit();
}

$stmt->close();
$conn->close();
?>
