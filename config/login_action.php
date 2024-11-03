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
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']); // Trim password to remove whitespace

        // Basic validation
        if (empty($email) || empty($password)) {
            swal_error(
                'Error',
                'Please fill in all fields',
                'OK',
                'javascript:history.back()'
            );
            exit();
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            swal_error(
                'Error',
                'Invalid email format',
                'OK',
                'javascript:history.back()'
            );
            exit();
        }

        // Prepare and execute query - comparing email and password directly
        $stmt = $conn->prepare("SELECT user_id, email, full_name FROM users WHERE email = ? AND password = ?");
        if (!$stmt) {
            throw new Exception("Database preparation failed");
        }

        $stmt->bind_param("ss", $email, $password);
        if (!$stmt->execute()) {
            throw new Exception("Database execution failed");
        }

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_email'] = $user['email'];
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
            'Invalid email or password',
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
