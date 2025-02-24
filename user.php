<?php
session_start();
$message = "";
$filename = "computerfundamental.html";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $sql = "SELECT name FROM users WHERE user_name = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_name, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $users = $result->fetch_assoc();
        $_SESSION['name'] = $users['name']; 
        echo "<script>window.location.href='subjectchoose.html?name=" . urlencode($_SESSION['name']) . "';</script>";
    } else {
        echo "Invalid username or password";
    }
    $stmt->close();
    $conn->close();
}
?>
