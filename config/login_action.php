<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/icons/favicon.png" type="image/x-icon">
    <title>SimpleNews | Login</title>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php
    require_once '../config/config.php';
    require_once '../config/validation.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['user_id'])) {
        header("Location: ../admin/dashboard.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = trim($_POST['password']);

            if (empty($username) || empty($password)) {
                swal_error('Error', 'Please fill in all fields', 'OK', 'javascript:history.back()');
                exit();
            }

            if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                swal_error('Error', 'Invalid username format', 'OK', 'javascript:history.back()');
                exit();
            }

            $stmt = $conn->prepare("SELECT user_id, username, full_name FROM users WHERE username = ? AND password = ?");
            if (!$stmt) {
                throw new Exception("Database preparation failed");
            }

            $stmt->bind_param("ss", $username, $password);
            if (!$stmt->execute()) {
                throw new Exception("Database execution failed");
            }

            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                session_regenerate_id(true);
                swal_success('Success', 'Login successful', 'OK', '../admin/dashboard.php');
                exit();
            }

            swal_error('Error', 'Invalid username or password', 'OK', 'javascript:history.back()');
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            swal_error('Error', 'An error occurred. Please try again later.', 'OK', 'javascript:history.back()');
        } finally {
            if (isset($stmt)) $stmt->close();
            if (isset($conn)) $conn->close();
        }
    } else {
        header("Location: ../pages/login.php");
        exit();
    }
    ?>
    <!-- flowbite -->
    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
    <!-- preline -->
    <script src="../node_modules/preline/dist/preline.js"></script>
    <!-- js -->
    <script src="../assets/js/script.js"></script>
</body>

</html>