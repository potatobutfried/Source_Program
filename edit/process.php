<?php
$host = 'localhost';
$db = 'libisgym_db';
$user = 'root'; // replace with your DB user
$pass = ''; // replace with your DB password
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

//login.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    $stmt = $pdo->prepare("SELECT * FROM tbl_user WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        if ($password == $user['pword']) {
            $_SESSION['restrictLogin'] = 1;
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];

            switch ($user['user_level']) {
                case 1:
                    header("Location: admin/index.php");
                    break;
                case 2:
                    header("Location: ui/index.php");
                    break;
                default:
                    header("Location: index.php");
                    break;
            }
            exit();
        } else {
            echo "<script>
                    alert('Incorrect Password');
                    window.location.href = 'index.php';
                  </script>";
        }
    }
}
?>