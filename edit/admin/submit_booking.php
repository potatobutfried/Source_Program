<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "libisgym_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO tbl_book (fullname, bdate, btime_in, book_stats) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $fullname, $date, $time, $book_stats);

$fullname = $_POST['fullname'];
$date = $_POST['date'];
$time = $_POST['time'];
$book_stats = 3;

if ($stmt->execute()) {
    echo
            "<script>
                alert('Booked Successfully');
                window.location.href = 'index.php';
            </script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: index.php");
exit();
?>