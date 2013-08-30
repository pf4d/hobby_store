<!--
Evan Cummings
CSCI 340 - Database Design
Spring '12 - Min Chen
Final Project
-->

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
                      "http://www.w3.org/TR/html401/loose.dtd">
<?php
  setcookie("user", $_GET["user"], time()+3600);
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Add User to Database</title>
</head>
<body bgcolor="#ffffff">
<h1>Add User:</h1>

<?php
  # connect to the database :
  $conn=mysql_connect("db.cs.umt.edu", "CSCI340-08", "KrS9qvP8");
  if (!$conn)  {die('Could not connect: ' . mysql_error());  }
  mysql_select_db("CSCI340-08",$conn);
  
  # check to see if user is in database :
  $user = $_GET[user];
  $pass = $_GET[password];
  $type = $_GET[type];
  
  # add new user to database :
  $sql = "INSERT INTO $type (user, password) VALUES ('$user', '$pass')";
  if (!mysql_query($sql,$conn)){die('Error: ' . mysql_error());}
  echo "new user created : user name = '$user', password = '$pass'";
  
  mysql_close($conn);
?>
<br/><br/><a href="custLogin.html">Logout</a>
&nbsp
<a href="hobby.php">Browse</a>
</body>
</html>