<?php
$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "onlineexaminationsystem"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}


$sql = "SELECT * FROM quiz_results ORDER BY id ASC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "student_name" => $row["student_name"],
        "subject_name" => $row["subject_name"],
        "total_questions" => $row["total_questions"],
        "attempted" => $row["attempted"],
        "correct" => $row["correct"],
        "wrong" => $row["wrong"],
        "percentage" => $row["percentage"],
        "total_score" => $row["total_score"]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "No result found"]);
}


$conn->close();
?>
