
<?php
$error=''; // Variable To Store Error Message
if (session_status() == PHP_SESSION_NONE) {
    session_start();
if (isset($_POST['submit'])) {
  if (empty($_POST['username']) || empty($_POST['password'])) {
    $error = "Username or Password is invalid";
  }
else
{
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
  $sql = "SELECT * from Accounts where Hashword='$password' AND Username='$username'";

  $result = $conn->query($sql);
  if (mysqli_num_rows($result) > 0) {
      $_SESSION['login_user'] = $username;
      $error = "Logged in!";

  } else {
    $error = "Incorrect username/password";
  }
    $conn->close();
}
}
} else {
  if(isset($_SESSION['login_user'])){
    $error = "Already logged in";
}
}
?>
