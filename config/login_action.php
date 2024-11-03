<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    // Import required files
    require_once '../config/config.php';
    require_once '../config/validation.php';

    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check if user is already logged in
    if (isset($_SESSION['user_id'])) {
        header("Location: ../pages/home.php");
        exit();
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            // Get form data and sanitize inputs
            $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = trim($_POST['password']);

            // Basic validation
            if (empty($username) || empty($password)) {
                swal_error(
                    'Error',
                    'Please fill in all fields',
                    'OK',
                    'javascript:history.back()'
                );
                exit();
            }

            // Validate username format
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                swal_error(
                    'Error',
                    'Invalid username format',
                    'OK',
                    'javascript:history.back()'
                );
                exit();
            }

            // Prepare and execute query - comparing username and password directly
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

                // Set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];

                // Regenerate session ID for security
                session_regenerate_id(true);

                // Show success message and redirect
                swal_success(
                    'Success',
                    'Login successful',
                    'OK',
                    '../pages/home.php'
                );
                exit();
            }

            // Invalid credentials
            swal_error(
                'Error',
                'Invalid username or password',
                'OK',
                'javascript:history.back()'
            );
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            swal_error(
                'Error',
                'An error occurred. Please try again later.',
                'OK',
                'javascript:history.back()'
            );
        } finally {
            // Close statement if it exists
            if (isset($stmt)) {
                $stmt->close();
            }
            // Close connection
            if (isset($conn)) {
                $conn->close();
            }
        }
    } else {
        // If someone tries to access this file directly
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