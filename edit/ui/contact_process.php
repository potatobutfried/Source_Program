<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "libisgym_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $msg = isset($_POST['message']) ? $_POST['message'] : '';
    $message_status = 2;

    $stmt = $conn->prepare("INSERT INTO tbl_message (name, email, message, message_status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $email, $msg, $message_status);

    if ($stmt->execute()) {
        echo "<script>
                alert('Message Submitted');
                window.location.href = 'contact.php'; // Redirect after alert
            </script>";
            exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
