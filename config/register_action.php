<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimpleNews | Register</title>
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

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            // Get form data and sanitize inputs
            $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $full_name = filter_var(trim($_POST['fullname']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['password']);

            // Basic validation
            if (empty($username) || empty($full_name) || empty($email) || empty($password)) {
                throw new Exception('Please fill in all fields');
            }

            // Validate username format (optional, adjust as needed)
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                throw new Exception('Invalid username format');
            }

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Invalid email format');
            }

            // **Important Note:** Storing passwords without hashing is a security risk. 
            // Consider using password_hash() for secure storage.

            // Prepare and execute query
            $stmt = $conn->prepare("INSERT INTO users (username, full_name, email, password) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Database preparation failed");
            }

            // Hash password before inserting (replace with your hashing function)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt->bind_param("ssss", $username, $full_name, $email, $hashed_password);
            if (!$stmt->execute()) {
                throw new Exception("Database execution failed");
            }

            // Check if insertion was successful
            if ($stmt->affected_rows === 1) {
                // Registration successful
                $_SESSION['success'] = 'Registration successful!';
                swal_success(
                    'Success',
                    'Registration successful',
                    'OK',
                    '../pages/login.php' // Redirect to login page after registration
                );
                exit();
            } else {
                // Registration failed
                $_SESSION['error'] = 'Registration failed. Please try again.';
                swal_error(
                    'Error',
                    'Registration failed. Please try again.',
                    'OK',
                    'javascript:history.back()'
                );
            }
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            swal_error(
                'Error',
                $e->getMessage(),
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
        header("Location: ../pages/register.php");
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