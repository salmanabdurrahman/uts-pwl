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
    require_once '../config/config.php';
    require_once '../functions/validation_functions.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        swal_error(
            'Error',
            'You need to log in first',
            'OK',
            '../pages/login.php'
        );
        exit();
    }

    if (isset($_GET['id'])) {
        $id_to_delete = $_GET['id'];

        if (!filter_var($id_to_delete, FILTER_VALIDATE_INT)) {
            swal_error(
                'Error',
                'ID pengguna tidak valid.',
                'OK',
                '../admin/dashboard.php'
            );
            exit();
        }

        try {
            $deleteQuery = "DELETE FROM users WHERE user_id = ?";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i", $id_to_delete);

            if ($stmt->execute()) {
                swal_success(
                    'Success',
                    'User successfully deleted.',
                    'OK',
                    '../admin/dashboard.php'
                );
                exit();
            } else {
                swal_error(
                    'Error',
                    'An error occurred while deleting the user: ' . $stmt->error,
                    'OK',
                    'javascript:history.back()'
                );
                exit();
            }

            $stmt->close();
        } catch (Exception $e) {
            error_log("Database error: " . $e->getMessage());
            swal_error(
                'Error',
                'An error occurred while deleting the user. Please try again.',
                'OK',
                'javascript:history.back()'
            );
        }
    } else {
        header("Location: ../admin/dashboard.php");
        exit();
    }

    $conn->close();
    ?>
    <!-- flowbite -->
    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
    <!-- preline -->
    <script src="../node_modules/preline/dist/preline.js"></script>
    <!-- js -->
    <script src="../assets/js/script.js"></script>
</body>

</html>