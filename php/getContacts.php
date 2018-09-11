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

// get the q parameter from URL
if(isset($_REQUEST["q"])) {
$q = stripslashes($_REQUEST["q"]);
} else {
  $q = "";
}

$sql = "SELECT User, Name, Phone, Email FROM Contacts WHERE Name LIKE '$q%'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      if($row["User"] === $user) {
        echo $row["Name"] . ", " . $row["Phone"] .  ", " . $row["Email"] . "<br>";
      }
    }
} else {
    echo "0 results";
}
?>
