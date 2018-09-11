<?php
session_start();

if(!isset($_SESSION['login_user'])) {
  die("error not logged in");
}
echo "Welcome " . $_SESSION['login_user'];
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
/*
$user = $_SESSION['user'];
$user = stripslashes($user);

// get the q parameter from URL
$q = stripslashes($_REQUEST["q"]);

$sql = "SELECT Name, Phone FROM Contacts WHERE User=$user AND Name LIKE $q%";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Name: " . $row["Name"]. " - Phone: " . $row["Phone"] . "<br>";
    }
} else {
    echo "0 results";
}
*/
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

    #contacts {
    font-family: 'Open Sans', sans-serif !important;
    border-collapse: collapse;
    width: 70%;
    margin-left: auto;
    margin-right: auto;
    }

#contacts td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
    }

#contacts tr:nth-child(even){background-color: #f2f2f2;}

#contacts tr:hover {background-color: #ddd;}

#contacts th {
    /*padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: dodgerblue;
    color: white;*/
    margin: 0px auto;
    background-color: dodgerblue;
    color: white

    }
</style>

<script>
display();
setInterval(display(), 1000);
    function display() {
        var str = "";
        if(document.getElementById("search") != null) {
          str = document.getElementById("search").value;
        }
        //var search = 106;
        //var prefix = document.getElementById("txtHint").value;
        makeRequest('getContacts.php?q=' + str.toLowerCase(), function(data) {

        var HTML = '<table id="contacts">';

        HTML += '<tr><th>Name</th><th>Phone Number</th><th>Email Address</th></tr>';
        var data = data.responseText.split("<br>");
        for(var i = 0;i<data.length-1;i++){
            var line = data[i].split(",");
            HTML += '<tr><td>' + line[0] + '</td><td>' + line[1] + '</td><td>' + line[2] + '</td></tr>';
        }
        HTML += '</table>';

        document.getElementById('myTable').innerHTML = HTML;
        });
    }

    function makeRequest(url, callback) {
        var request;

        if (window.XMLHttpRequest) {
            request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
        } else {
            request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
        }

        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
            callback(request);
            }
        }
        request.open("GET", url, true);
        request.send();
    }

  function showHint(str) {
    display();
  }

    function makeContact() {
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

    function confirmContact() {
        let signup = document.getElementById("addContact");
        addContact.style.transition = "background-color 0.2s";
        addContact.style.backgroundColor = "green";
        setTimeout(makeContact, 500);
        addContact.style.backgroundColor = "dodgerblue";

        let name = document.getElementById("name").value;
        let phone = document.getElementById("phone").value;
        let email = document.getElementById("email").value;

        var xhttp = new XMLHttpRequest();

        xhttp.open("POST", "addContact.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("name=" + name + "&phone=" + phone + "&email=" + email);
        document.getElementById("search").value = "";
        display();
      }
</script>

<body>

<form>
Search Contact By Name: <input type="text" value="" id="search" onkeyup="showHint(this.value)">
</form>

    <div id="myTable"></div>

    <p><a href="#" id="register" onclick="makeContact()">Add a new contact</a></p>
    <p><a href="logout.php" id="logout">Logout</a></p>
        <form method="post">
            <div id="regTriangle"></div>
            <div id="regBox">
                <h3>Add New Contact</h3>
                <h5>Name</h5>
                <input type="text" id="name" name="name" placeholder="Whitney Houston" maxlength="12"/><br>
                <h5>Phone Number</h5>
                <input type="text" id="phone" name="phone" value="" maxlength="12"/><br>
                <h5>Email Address</h5>
                <input type="text" id="email" name="email" value="" maxlength="25"/><br><br>
                <input type="button" id="addContact" value="Add" onclick="confirmContact()"/><br>
            </div>
        </form>

</body>
