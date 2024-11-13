<?php
function process_subscription()
{
    require_once '../config/config.php';
    require_once '../functions/validation_functions.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
        try {
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Please enter a valid email address');
            }

            $check_stmt = $conn->prepare("SELECT subscribe_id FROM subscribe WHERE email = ?");
            $check_stmt->bind_param("s", $email);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                throw new Exception('This email is already subscribed');
            }

            $stmt = $conn->prepare("INSERT INTO subscribe (email) VALUES (?)");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            swal_success('Success', 'You have successfully subscribed to our newsletter!', 'OK');
        } catch (Exception $e) {
            swal_error('Error', $e->getMessage(), 'OK');
        } finally {
            if (isset($check_stmt)) $check_stmt->close();
            if (isset($stmt)) $stmt->close();
            if (isset($conn)) $conn->close();
        }

        echo "
        <script>
            setTimeout(() => { window.history.back(); }, 2500);
        </script>
        ";
    } else {
        header("Location: ../pages/error.php");
        exit();
    }
}
