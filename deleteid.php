<?php
$servername = "localhost";
$username = "root";  
$password = "";     
$dbname = "onlineexaminationsystem";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        echo "<script>window.close();</script>";
        echo "<script>alert('User deleted successfully!'); window.location.href='admins.php';</script>";
    } else {
        echo "<script>alert('Error deleting user!'); window.location.href='admins.php';</script>";
    }
}
?>

