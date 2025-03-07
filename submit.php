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
$gender = $_POST['gender'];
$Roll_Number=rand(1000000000, 9999999999);

if ($password !== $conform_password) {
    die("Passwords do not match.");
}

$sql = "SELECT * FROM users WHERE user_name = ? OR password = ? AND phone_number = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $user_name, $password, $phone_number);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $users = $result->fetch_assoc();
    echo "<script> alert('Username Already Saved Database')</script>";
    echo "<script>window.location.href='registation.html'</script>";
}
else{
   $sql = "INSERT INTO users (user_name, password, conform_password, name , high_school_rollnumber, city, phone_number, email,Roll_Number,gender) 
   VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssisisis", $user_name, $password, $conform_password, $name, $high_school_rollnumber, $city, $phone_number, $email, $Roll_Number,$gender);


if ($stmt->execute()) {
   echo "<script> alert('Registration Successfully')</script>";
   echo "<script> window.close();</script>";
   echo "<script>window.location.href='index.html','_blank'</script>";

} else {
   echo "<script>alert(' . $sql . $conn->error')</script>";
}
}

$stmt->close();
$conn->close();
?>
