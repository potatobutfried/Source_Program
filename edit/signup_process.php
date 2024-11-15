<?php
$host = 'localhost';
$db = 'libisgym_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

session_start();

//sign up
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $secretKey = '6LcyemUqAAAAAJEKFKYCQlFh5SQspVDHjOr7Pm2Z';
    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $response = file_get_contents($recaptchaUrl . '?secret=' . $secretKey . '&response=' . $recaptchaResponse);
    $responseKeys = json_decode($response, true);

    if (intval($responseKeys["success"]) !== 1) {
        echo "<script>
                alert('Please complete the reCAPTCHA.');
                window.location.href = 'index.php';
              </script>";
        exit();
    }

    // Check if email already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // User with this email already exists
        echo "A user with this email already exists.";
    } else {
        // Insert new user into the database
        $stmt = $pdo->prepare("INSERT INTO tbl_user (firstname, lastname, phone, birthdate, gender, email, pword, user_level) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$firstname, $lastname, $phone, $birthdate, $gender, $email, $password, 2]);

        // After signup, log the user in and start the session
        $_SESSION['restrictLogin'] = 1;
        $_SESSION['email'] = $email;

        // Redirect to a dashboard or home page after signup
        header("Location: index.php");
        exit();
    }
}
?>