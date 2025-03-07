<?php
session_start();
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "onlineexaminationsystem");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit();
}

if (!isset($_SESSION['Roll_Number'])) {
    echo json_encode(["success" => false, "message" => "Roll Number not found in session"]);
    exit();
}

$roll_number = $_SESSION['Roll_Number'];

$sql = "SELECT user_name, name, email, phone_number, Roll_Number FROM users WHERE Roll_Number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $roll_number);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    echo json_encode([
        "success" => true,
        "user_name" => $row["user_name"],
        "name" => $row["name"],
        "email" => $row["email"],
        "phone_number" => $row["phone_number"],
        "Roll_Number" => $row["Roll_Number"]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "No data found"]);
}

$stmt->close();
$conn->close();
?>
