<?php
session_start();

if(!isset($_SESSION['login_user'])) {
  die("error not logged in");
}


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "ContactBook";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("error");
}

$user = $_SESSION['login_user'];
$user = stripslashes($user);

$name=$_POST['name'];
$phone=$_POST['phone'];
$email=$_POST['email'];

$sql = "INSERT INTO Contacts (User, Name, Phone, Email)
VALUES ('$user', '$name', '$phone', '$email')";
$result = $conn->query($sql);
$error = "success";
?>
