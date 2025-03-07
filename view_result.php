<?php
session_start();
$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "OnlineExaminationSystem"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}
if (!isset($_SESSION["name"])) {
    die(json_encode(["success" => false, "message" => "Please login first!"]));
}

$Roll_Number = $_POST['Roll_Number'];
$sql = "SELECT * FROM quiz_results WHERE Roll_Number = ? ORDER BY id ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $Roll_Number);
$stmt->execute();
$result = $stmt->get_result();

$results = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $results[] = [
            "student_name" => $row["student_name"],
            "subject_name" => $row["subject_name"],
            "total_questions" => $row["total_questions"],
            "attempted" => $row["attempted"],
            "correct" => $row["correct"],
            "wrong" => $row["wrong"],
            "percentage" => $row["percentage"],
            "total_score" => $row["total_score"],
            "quiz_date" => $row["quiz_date"],
            "quiz_time" => $row["quiz_time"],
            "Roll_Number" => $row["Roll_Number"]
        ];
    }
    echo json_encode(["success" => true, "results" => $results]);
} 
else {
    echo json_encode(["success" => false, "message" => "No result found"]);
    
}
$stmt->close();
$conn->close();
?>
