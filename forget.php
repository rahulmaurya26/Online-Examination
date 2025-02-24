<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";  
    $password = "";  
    $dbname = "OnlineExaminationSystem";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $password = $_POST['password'];
    $conform_password = $_POST['conform_password'];
    $high_school_rollnumber = $_POST['high_school_rollnumber'];

    // Validate passwords match
    if ($password !== $conform_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Check if user exists by high school roll number
    $sql = "SELECT * FROM users WHERE high_school_rollnumber=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $high_school_rollnumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, proceed with password update
        $sql = "UPDATE users SET password = ? ,conform_password=? WHERE high_school_rollnumber = ?";
        $stmt = $conn->prepare($sql);  // Prepare first
        $stmt->bind_param("ssi", $password,$conform_password, $high_school_rollnumber);  // Then bind parameters
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            
            echo "Password updated successfully!";
        } else {
            echo "Failed to update password or no rows affected.";
        }

    } 
    else {
        echo "Wrong HIGH SCHOOL ROLL NUMBER";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

