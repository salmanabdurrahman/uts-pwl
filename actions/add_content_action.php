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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $user_id = $_SESSION['user_id'];
            $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $short_description = filter_var(trim($_POST['short_description']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = filter_var(trim($_POST['content']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (empty($title) || empty($short_description) || empty($content)) {
                swal_error(
                    'Error',
                    'Please fill in all required fields',
                    'OK',
                    'javascript:history.back()'
                );
                exit();
            }

            $image_url = "";
            if (isset($_FILES['image-url']) && $_FILES['image-url']['error'] == UPLOAD_ERR_OK) {
                $target_dir = "../assets/uploads/";
                $image_name = basename($_FILES["image-url"]["name"]);
                $target_file = $target_dir . $image_name;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allowed_types = ["jpg", "jpeg", "png", "gif"];

                if (!in_array($imageFileType, $allowed_types)) {
                    swal_error(
                        'Error',
                        'Only JPG, JPEG, PNG, and GIF files are allowed',
                        'OK',
                        'javascript:history.back()'
                    );
                    exit();
                }

                if (!move_uploaded_file($_FILES["image-url"]["tmp_name"], $target_file)) {
                    swal_error(
                        'Error',
                        'Error uploading file',
                        'OK',
                        'javascript:history.back()'
                    );
                    exit();
                }
                $image_url = $target_file;
            }

            $stmt = $conn->prepare("INSERT INTO articles (title, short_description, content, image_url, created_by) VALUES (?, ?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception("Database preparation failed");
            }

            $stmt->bind_param("ssssi", $title, $short_description, $content, $image_url, $user_id);
            if (!$stmt->execute()) {
                throw new Exception("Database execution failed");
            }

            if ($stmt->affected_rows === 1) {
                swal_success(
                    'Success',
                    'Content has been successfully added!',
                    'OK',
                    '../admin/dashboard.php'
                );
                exit();
            } else {
                throw new Exception("Content addition failed. Please try again.");
            }
        } catch (Exception $e) {
            error_log("Content addition error: " . $e->getMessage());
            swal_error(
                'Error',
                'An error occurred. Please try again later.',
                'OK',
                'javascript:history.back()'
            );
        } finally {
            if (isset($stmt)) $stmt->close();
            if (isset($conn)) $conn->close();
        }
    } else {
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