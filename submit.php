<?php
// Database connection
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "";  // Replace with your MySQL password
$dbname = "OnlineExaminationSystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Get form data

$user_name = $_POST['user_name'];
$password = $_POST['password'];
$conform_password = $_POST['conform_password'];
$name = $_POST['name'];
$high_school_rollnumber = $_POST['high_school_rollnumber'];
$city = $_POST['city'];
$phone_number = $_POST['phone_number'];
$email = $_POST['email'];

// Validate password confirmation
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
   // Prepare the SQL statement to insert data into the 'users' table
   $sql = "INSERT INTO users (user_name, password, conform_password, name , high_school_rollnumber, city, phone_number, email) 
   VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare statement    
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssisis", $user_name, $password, $conform_password, $name, $high_school_rollnumber, $city, $phone_number, $email);

// Execute the statement
if ($stmt->execute()) {
   echo "Registered Successfully";

} else {
   echo "Error: " . $sql . "<br>" . $conn->error;
}
}
// Close the statement and connection
$stmt->close();
$conn->close();
?>
