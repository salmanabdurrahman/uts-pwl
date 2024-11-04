<?php
// Import required files
require_once '../config/config.php';
require_once '../config/validation.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get and sanitize email input
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

        // Validate email field
        if (empty($email)) {
            echo json_encode([
                "status" => "error",
                "message" => "Please enter an email address"
            ]);
            exit();
        }

        // Check if email already exists in the subscribe table
        $check_stmt = $conn->prepare("SELECT subscribe_id FROM subscribe WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo json_encode([
                "status" => "error",
                "message" => "This email is already subscribed."
            ]);
            exit();
        }

        // Insert new subscription into database
        $stmt = $conn->prepare("INSERT INTO subscribe (email) VALUES (?)");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "You have successfully subscribed to our newsletter!"
            ]);
        } else {
            throw new Exception("Failed to save subscription.");
        }
    } catch (Exception $e) {
        error_log("Subscription error: " . $e->getMessage());
        echo json_encode([
            "status" => "error",
            "message" => "An error occurred. Please try again later."
        ]);
    } finally {
        if (isset($check_stmt)) $check_stmt->close();
        if (isset($stmt)) $stmt->close();
        if (isset($conn)) $conn->close();
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method."
    ]);
}
