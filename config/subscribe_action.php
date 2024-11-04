<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/icons/favicon.png" type="image/x-icon">
    <title>SimpleNews | Subscribe</title>
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            // Get and sanitize email input
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

            // Validate email field
            if (empty($email)) {
                swal_error(
                    'Error',
                    'Please enter an email address',
                    'OK',
                    'javascript:history.back()'
                );
                exit();
            }

            // Check if email already exists in the subscribe table
            $check_stmt = $conn->prepare("SELECT subscribe_id FROM subscribe WHERE email = ?");
            $check_stmt->bind_param("s", $email);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                swal_error(
                    'Error',
                    'This email is already subscribed.',
                    'OK',
                    'javascript:history.back()'
                );
                exit();
            }

            // Insert new subscription into database
            $stmt = $conn->prepare("INSERT INTO subscribe (email) VALUES (?)");
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                swal_success(
                    'Success',
                    'You have successfully subscribed to our newsletter!',
                    'OK',
                    '../pages/subscribe.php'
                );
            } else {
                throw new Exception("Failed to save subscription.");
            }
        } catch (Exception $e) {
            error_log("Subscription error: " . $e->getMessage());
            swal_error(
                'Error',
                'An error occurred. Please try again later.',
                'OK',
                'javascript:history.back()'
            );
        } finally {
            if (isset($check_stmt)) $check_stmt->close();
            if (isset($stmt)) $stmt->close();
            if (isset($conn)) $conn->close();
        }
    } else {
        header("Location: ../pages/subscribe.php");
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