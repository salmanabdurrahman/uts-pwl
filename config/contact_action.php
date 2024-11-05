<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/icons/favicon.png" type="image/x-icon">
    <title>SimpleNews | Contact</title>
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $firstname = filter_var(trim($_POST['firstname']), FILTER_SANITIZE_STRING);
            $lastname = filter_var(trim($_POST['lastname']), FILTER_SANITIZE_STRING);
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $phone_number = filter_var(trim($_POST['number']), FILTER_SANITIZE_STRING);
            $details = filter_var(trim($_POST['details']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (empty($firstname) || empty($lastname) || empty($email)) {
                swal_error('Error', 'Please fill in all required fields', 'OK', 'javascript:history.back()');
                exit();
            }

            $stmt = $conn->prepare("INSERT INTO contact (firstname, lastname, email, phone_number, details) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $firstname, $lastname, $email, $phone_number, $details);

            if ($stmt->execute()) {
                swal_success('Success', 'Your contact request has been submitted successfully!', 'OK', '../pages/contact.php');
            } else {
                throw new Exception("Failed to save contact information.");
            }
        } catch (Exception $e) {
            error_log("Contact submission error: " . $e->getMessage());
            swal_error('Error', 'An error occurred. Please try again later.', 'OK', 'javascript:history.back()');
        } finally {
            if (isset($stmt)) $stmt->close();
            if (isset($conn)) $conn->close();
        }
    } else {
        header("Location: ../pages/contact.php");
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