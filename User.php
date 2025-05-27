<?php
include 'db.php';
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Step 1 fields
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // Step 2 fields
    $marital_status = trim($_POST['marital_status']);
    $date_of_birth = trim($_POST['date_of_birth']);
    $state_of_origin = trim($_POST['state_of_origin']);
    $local_government = trim($_POST['local_government']);
    $residential_address = trim($_POST['residential_address']);
    $nationality = trim($_POST['nationality']);
    $nin = trim($_POST['nin']);
    $department = trim($_POST['department']);
    $gender = trim($_POST['gender']);
    $privacy_policy = isset($_POST['privacy_policy']) ? 1 : 0;

    if (
        empty($full_name) || empty($email) || empty($phone) || empty($nin)
        || empty($department) || empty($gender)
    ) {
        echo json_encode(["status" => "error", "message" => "Missing required fields"]);
        exit;
    }

    // Check for duplicate NIN
    $checkQuery = "SELECT id FROM users WHERE nin = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $nin);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "NIN already exists"]);
        exit;
    }

    $checkStmt->close();

    // Handle photo upload
    $photo_path = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $filename = uniqid() . "_" . basename($_FILES["photo"]["name"]);
        $target_file = $upload_dir . $filename;

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo_path = $target_file;
        }
    }

    $query = "INSERT INTO users (
        full_name, email, phone,
        marital_status, date_of_birth, state_of_origin, local_government,
        residential_address, nationality, nin, department, gender, photo, privacy_policy
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "sssssssssssssi",
        $full_name, $email, $phone,
        $marital_status, $date_of_birth, $state_of_origin, $local_government,
        $residential_address, $nationality, $nin, $department,
        $gender, $photo_path, $privacy_policy
    );

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Registration successful", "user_id" => $stmt->insert_id]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>

