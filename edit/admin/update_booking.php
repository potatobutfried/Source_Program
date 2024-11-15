<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $pdo = new PDO("mysql:host=localhost;dbname=libisgym_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Assuming you have user ID and new user level from a form submission
$bookId = $_POST['id']; // example from form
$newBookStatus = $_POST['book_stats']; // example from form

$stmt = $pdo->prepare("UPDATE tbl_book SET book_stats = ? WHERE id = ?");
$stmt->execute([$newBookStatus, $bookId]);
        echo "<script>
                alert('Message Submitted');
                window.location.href = 'contact.php'; // Redirect after alert
                </script>";
        exit();
?>
