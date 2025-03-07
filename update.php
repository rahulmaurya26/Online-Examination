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
    $Roll_Number = $_POST['Roll_Number'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $user_name = $_POST['user_name'];
    $phone_number = $_POST['phone_number'];
    $city = $_POST['city'];

    $sql = "SELECT * FROM users WHERE Roll_Number=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Roll_Number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, proceed with password update
        $sql = "UPDATE users SET user_name = ?, name =?, email=?, phone_number = ?, city = ? WHERE Roll_Number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisi", $user_name, $name, $email, $phone_number, $city, $Roll_Number);
        // Then bind parameters
        $stmt->execute();
        if ($stmt->affected_rows > 0) {

            echo "<script> alert(' update successfully')</script>";
            echo "<script>window.close();</script>";
            echo "<script>window.location.href='user_information.html'</script>";
        } else {
            echo "<script> alert('not update')</script>.";
            echo "<script>window.location.href='user_information.html'</script>";
        }

    } 
    else {
        echo "<script> alert('Wrong HIGH SCHOOL ROLL NUMBER')</script>";
        echo "<script>window.location.href='update_information.html'</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
