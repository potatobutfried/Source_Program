<?php
require 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}

$userId = $_SESSION['id']; // Get the logged-in user's ID

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $remarks = $_POST['remarks'];

    // Fetch user details from tbl_user
    $stmtUser = $pdo->prepare("SELECT firstname, lastname, phone, email FROM tbl_user WHERE id = ?");
    $stmtUser->execute([$userId]);
    $user = $stmtUser->fetch();

    if ($user) {
        $fullname = isset($user['firstname'], $user['lastname']) ? htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) : 'Unknown User';
        $phone = isset($user['phone']) ? htmlspecialchars($user['phone']) : null; // Set to null if phone not provided
        $email = isset($user['email']) ? htmlspecialchars($user['email']) : 'No email';

        // Check if the phone is available before proceeding
        if (empty($phone)) {
            echo "Error: Phone number is required.";
            exit();
        }

        // Check how many bookings exist for the same date and time
        $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM tbl_book WHERE bdate = ? AND btime_in = ?");
        $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM tbl_book WHERE bdate = ? AND btime_in = ?");
        $stmtCheck->execute([$date, $time]);
        $bookingCount = $stmtCheck->fetchColumn();
        
        // If there are fewer than 3 bookings, set status to confirmed (1), else set status to pending (2)
        if ($bookingCount < 3) {
            $bookStats = 2; // Confirmed
        } else {
            $bookStats = 1; // Pending
        }
        
        // Insert booking details into tbl_book
        $stmt = $pdo->prepare("INSERT INTO tbl_book (fullname, phone, email, bdate, btime_in, remarks, book_stats) 
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$fullname, $phone, $email, $date, $time, $remarks, $bookStats]);
        
        // Check if the booking was set to pending and show an alert if so
        if ($bookStats === 1) {
            echo "<script>
                alert('The time you selected has reached its booking limit. Your booking is now pending confirmation from the admin.');
                window.location.href = 'history.php'; // Redirect after alert
            </script>";
            exit(); // Stop further execution
        } else {
            // Redirect to history page if the booking was confirmed
            header("Location: history.php");
            exit();
        }
}
}
?>
