<?php

$servername = "localhost";
$username = "root";  
$password = "";  
$dbname = "OnlineExaminationSystem";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user_name = $_POST['user_name'];
$password = $_POST['password'];
$conform_password = $_POST['conform_password'];
$name = $_POST['name'];
$high_school_rollnumber = $_POST['high_school_rollnumber'];
$city = $_POST['city'];
$phone_number = $_POST['phone_number'];
$email = $_POST['email'];


if ($password !== $conform_password) {
    die("Passwords do not match.");
}

$sql = "SELECT * FROM users WHERE user_name = ? AND password = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user_name, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $users = $result->fetch_assoc();
   echo"Username already saved database";
    
}
else{
   
   $sql = "INSERT INTO users (user_name, password, conform_password, name , high_school_rollnumber, city, phone_number, email) 
   VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

   
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssisis", $user_name, $password, $conform_password, $name, $high_school_rollnumber, $city, $phone_number, $email);


if ($stmt->execute()) {
   echo "Registered Successfully";

} else {
   echo "Error: " . $sql . "<br>" . $conn->error;
}
}

$stmt->close();
$conn->close();
?>
