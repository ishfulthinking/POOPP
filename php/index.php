<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$error=''; // Variable To Store Error Message
if(isset($_SESSION['login_user'])) {
   $error = "logged in";
   header('Location: profile.php');
   exit;
}
else if (isset($_POST['submit'])) {
  if (empty($_POST['password']) || (empty($_POST['username']) && empty($_POST['new_username']))) {
    alert("Invalid Username/password");
  } else {

    $servername = "localhost";
    $user = "root";
    $pass = "root";
    $dbname = "ContactBook";

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

    // Create connection
    $conn = new mysqli($servername, $user, $pass, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if($_POST['submit'] === "Log In") {
      $sql = "SELECT * from Accounts where Hashword='$password' AND Username='$username'";

      $result = $conn->query($sql);
      if (mysqli_num_rows($result) > 0) {
          $_SESSION['login_user'] = $username;
          $error = "logged in";
          header("location: profile.php");
          exit();
    } else {
      alert("Incorrect Username/password");
    }
  }
    else {
      $sql = "SELECT * from Accounts where Username='$username'";
      $result = $conn->query($sql);
      if (mysqli_num_rows($result) > 0) {
        alert("Username already exists");
      } else {
        $sql = "INSERT INTO Accounts (Username, Hashword)
        VALUES ('$username', '$password')";
        $result = $conn->query($sql);
        $error = "success";
      }
    }

    $conn->close();
  }
}

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<title>Login</title>
</head>

<style>
    body {
        font-family: 'Open Sans', sans-serif !important;
        color: #171717;
        background-color: rgb(240, 240, 240);
        height: 100%;
        margin: 0;
        text-align: center;
    }
    p {
        padding: 4px;
        font-size: 11px;
        top: -14px;
        position: relative;
    }
    h1 {
        padding: 12px;
        padding-bottom: 0px;
        margin: 4px;
    }
    h3 {
        padding: 6px;
        padding-bottom: 0px;
        margin: 4px;
    }
    h4 {
        padding: 4px;
        padding-bottom: 0px;
        margin: 4px;
    }
    h5 {
        padding: 6px;
        padding-bottom: 0px;
        margin: 4px;
    }
    #box {
        background-color: white;
        border-radius: 2px;
        box-shadow: 0px 8px 8px rgba(17,17,17,0.1);
        height: 340px;
        width: 600px;
        margin: auto;
        transform: translateY(30%);
    }

    input[type=text], input[type=password] {
        transition: border-color 0.2s ease-out;
        border: 1px solid gray;
        border-radius: 4px;
        padding: 6px;
        transition: border 0.2s ease-in-out;
    }
    input[type=text]:focus, input[type=password]:focus {
        border: 2px solid dodgerblue;
        border-radius: 4px;
        transition: border 0.2s ease-in-out;
    }

    input[type=submit] {
        border-radius: 16px;
        width: 120px;
        color: white;
        background-color: dodgerblue;
        margin: 4px;
        border: 0;
        padding: 10px;
        font-weight: bold;
        transition: box-shadow 0.2s ease-in-out;
    }
    input[type=submit]:focus, input[type=submit]:hover {
        box-shadow: 0 0 16px dodgerblue;
        transition: box-shadow 0.2s ease-in-out;
    }

    #regTriangle {
        width: 0;
        height: 0;
        position: relative;
        border-left: 24px solid transparent;
        border-right: 24px solid transparent;
        border-bottom: 24px solid white;
        margin: auto;
        opacity: 0;
        top: 38px;
    }
    #regBox {
        width: 250px;
        height: 230px;
        position: relative;
        background-color: white;
        border-radius: 2px;
        box-shadow: 0px 8px 8px rgba(17,17,17,0.1);
        margin: auto;
        opacity: 0;
        top: 30px;
    }

</style>

<script>
    function openRegistration() {
        //alert("helloo!!");
        let regBox = document.getElementById("regBox");
        let regTriangle = document.getElementById("regTriangle");
        regBox.style.transition = "opacity 0.2s";
        regTriangle.style.transition = "opacity 0.2s";

        if (regBox.style.opacity == 0) {
            regBox.style.opacity = 1;
            regTriangle.style.opacity = 1;
        }
        else {
            regBox.style.opacity = 0;
            regTriangle.style.opacity = 0;
        }
    }

    function confirmRegist() {
        let signup = document.getElementById("signup");
        signup.style.transition = "background-color 0.2s";
        signup.style.backgroundColor = "green";

        let user = document.getElementById("user").value;
        let pass = document.getElementById("pass").value;

        setTimeout(openRegistration, 500);
        signup.style.backgroundColor = "dodgerblue";
        xhttp.open("POST", "../php/signup.php", false);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("username=" + user + "&password=" + pass);
        //alert(xhttp.responseText);
        }
</script>

<body>
    <div id="box">
        <form method="post">
            <h1>Login</h1><br>
            <h4>Username</h4>
            <input type="text" name="username" value="Amanda Hugginkiss" maxlength="12" onfocus="this.value=''"/><br><br>
            <h4>Password</h4>
            <input type="password" name="password" maxlength="12"/><br><br>
            <input type="submit" name="submit" value="Log In"/><br>
            <p>Not registered? <a href="#" id="register" onclick="openRegistration()">Sign up now.</a></p>
        </form>
        <form method="post">
            <div id="regTriangle"></div>
            <div id="regBox">
                <h3>Register</h3>
                <h5>Username</h5>
                <input type="text" name="username" value="Pepe Roni" maxlength="12" onfocus="this.value=''"/><br>
                <h5>Password</h5>
                <input type="text" name="password" value="" maxlength="12" onfocus="this.value=''"/><br><br>
                <input type="submit" name="submit" id="signup" value="Sign Up" onclick="confirmRegist()"/><br>
            </div>
        </form>
    </div>
</body>
