<?php
session_start();
$message = "";

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
    $sql = "SELECT name, Roll_Number, password FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['password'] === $password) {
            $_SESSION['name'] = $user['name'];
            $_SESSION['Roll_Number'] = $user['Roll_Number'];

            echo "<script>window.open('subjectchoose.html?name=" . urlencode($_SESSION['name']) . "&Roll_Number=" . urlencode($_SESSION['Roll_Number']) . "', '_blank');</script>";
            echo "<script> var win = window.open('', '_self'); win.close(); </script>";

        } else {
            echo "<script>alert('Wrong Password')</script>";
            echo "<script>window.close();</script>";
            echo "<script>window.location.href='index.html','_blank';</script>";
        }
    } else {
        echo "<script>alert('Invalid Username')</script>";
        echo "<script>window.location.href='index.html','_blank';</script>";
    }
    $stmt->close();
    $conn->close();
}
?>
