
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
  if (empty($_POST['username']) || empty($_POST['password'])) {
    $error = "Invalid username or password";
  }
  else if (strlen($_POST['username']) < 1 || strlen($_POST['password']) < 8) {
    $error = "Username or password is too short";
  }
  else {
    // Define $username and $password
    $username=$_POST['username'];
    $password=$_POST['password'];
    // Establishing Connection with Server by passing server_name, user_id and password as a parameter
    // To protect MySQL injection for Security purpose
    $username = stripslashes($username);
    $password = stripslashes($password);
  //  $username = mysql_real_escape_string($username);
  //  $password = mysql_real_escape_string($password);
    $password = hash('sha512', $password, false);

    $servername = "localhost";
    $user = "root";
    $pass = "root";
    $dbname = "ContactBook";

    // Create connection
    $conn = new mysqli($servername, $user, $pass, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * from Accounts where Username='$username'";
    $result = $conn->query($sql);
    if (mysqli_num_rows($result) > 0) {
      $error = "Username already exists";
    } else {
      $sql = "INSERT INTO Accounts (Username, Hashword)
      VALUES ('$username', '$password')";
      $result = $conn->query($sql);
      $error = "Successfully added a new user";
    }
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Signup Form in PHP with Session</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="main">
<h1>PHP Signup</h1>
<div id="login">
<h2>Login Form</h2>
<form action="" method="post">
<label>UserName :</label>
<input id="name" name="username" placeholder="username" type="text">
<label>Password :</label>
<input id="password" name="password" placeholder="**********" type="password">
<input name="submit" type="submit" value=" Login ">
<span><?php echo $error; ?></span>
</form>
</div>
</div>
</body>
</html>
