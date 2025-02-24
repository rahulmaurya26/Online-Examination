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
    $password = $_POST['new_password'];
    $conform_password = $_POST['conform_password'];
    $old__password= $_POST['password'];

    // Validate passwords match
    if ($password !== $conform_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the password before storing it
   
    // Check if user exists by high school roll number
    $sql = "SELECT * FROM users WHERE password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $old__password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, proceed with password update
        $sql = "UPDATE users SET password = ? ,conform_password=? WHERE password = ?";
        $stmt = $conn->prepare($sql);  // Prepare first
        $stmt->bind_param("sss", $password,$conform_password, $old__password);  // Then bind parameters
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            $fptr=fopen("subjectchoose.html","r");
            if(!$fptr){
                die("invalid");
            }
            $content=fread($fptr,filesize("subjectchoose.html"));
            echo  $content;
            echo "Password updated successfully!";
        } else {
            echo "Failed to update password or no rows affected.";
        }

    } 
    else {
        echo "NOT Found Password";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
