<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/icons/favicon.png" type="image/x-icon">
    <title>SimpleNews | Dashboard</title>
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

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        swal_error(
            'Error',
            'You need to log in first',
            'OK',
            '../pages/login.php'
        );
        exit();
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            // Get form data and sanitize inputs
            $user_id = $_SESSION['user_id'];
            $username = $_SESSION['username']; // Username cannot be changed
            $fullname = filter_var(trim($_POST['fullname']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
            // $phone = filter_var(trim($_POST['number']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $gender = filter_var(trim($_POST['gender']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = trim($_POST['password']);
            $new_password = trim($_POST['new-password']);

            // Basic validation
            if (empty($fullname) || empty($email) || empty($password)) {
                swal_error(
                    'Error',
                    'Please fill in all required fields',
                    'OK',
                    'javascript:history.back()'
                );
                exit();
            }

            // Validate email format
            if (!$email) {
                swal_error(
                    'Error',
                    'Invalid email format',
                    'OK',
                    'javascript:history.back()'
                );
                exit();
            }

            // Validate password (check if current password is correct)
            $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
            if (!$stmt) {
                throw new Exception("Database preparation failed");
            }

            $stmt->bind_param("i", $user_id);
            if (!$stmt->execute()) {
                throw new Exception("Database execution failed");
            }

            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if (!password_verify($password, $user['password'])) {
                swal_error(
                    'Error',
                    'Current password is incorrect',
                    'OK',
                    'javascript:history.back()'
                );
                exit();
            }

            // If new password is provided, hash it
            $new_password_hashed = !empty($new_password) ? password_hash($new_password, PASSWORD_DEFAULT) : $user['password'];

            // Prepare update query
            $update_stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ?, phone = ?, gender = ?, password = ? WHERE user_id = ?");
            if (!$update_stmt) {
                throw new Exception("Database preparation for update failed");
            }

            $update_stmt->bind_param("sssssi", $fullname, $email, $phone, $gender, $new_password_hashed, $user_id);
            if (!$update_stmt->execute()) {
                throw new Exception("Database execution for update failed");
            }

            // Show success message and redirect
            swal_success(
                'Success',
                'Profile updated successfully',
                'OK',
                '../admin/dashboard.php'
            );
            exit();
        } catch (Exception $e) {
            error_log("Update profile error: " . $e->getMessage());
            swal_error(
                'Error',
                'An error occurred. Please try again later.',
                'OK',
                'javascript:history.back()'
            );
        } finally {
            // Close statements if they exist
            if (isset($stmt)) {
                $stmt->close();
            }
            if (isset($update_stmt)) {
                $update_stmt->close();
            }
            // Close connection
            if (isset($conn)) {
                $conn->close();
            }
        }
    } else {
        // Redirect if accessed directly
        header("Location: ../admin/dashboard.php");
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