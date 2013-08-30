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
  <title>Employee main page</title>
</head>
<body bgcolor="#ffffff">
<h1>Employee main page</h1>

<?php
  # connect to the database :
  $conn=mysql_connect("db.cs.umt.edu", "CSCI340-08", "KrS9qvP8");
  if (!$conn)  {die('Could not connect: ' . mysql_error());  }
  mysql_select_db("CSCI340-08",$conn);
  
  # check to see if user is in database :
  $user = $_GET[user];
  $pass = $_GET[password];
  $sql = "SELECT * FROM ADMIN WHERE user = '$user'";
  $result = mysql_query($sql,$conn);
  $row = mysql_fetch_array($result);
  
  # if user is not in database, create user :
  if ($row[id] == NULL)
  {
    echo "User not in database, add?";
    echo 
     "<table border='0'>
        <tr>
          <td>
            <form name='addUser' action='addUser.php' method='GET'>
              <input type='hidden' name='user' value=$user>
              <input type='hidden' name='password' value=$pass>
              <input type='hidden' name='type' value='ADMIN'>
              <input type='submit' value='YES'>
            </form>
          </td>
          <td>
            <form method='LINK' action='hobby.php'>
              <input type='submit' value='NO'>
            </form>
          </td>
        </tr>
      </table>";
  }
  # otherwise print welcome screen :
  else
  {
    print "Welcome back $user!<br/><br/>";

    echo "<p><a href='adminInfo.php'>View / Update Personal Info</a></p>";
    echo "<p><a href='adminPay.php'>View Payroll History</a></p>";
  }
  
  mysql_close($conn);
?>
<br/><br/><a href="adminLogin.html">Logout</a>
&nbsp
<a href="hobby.php">Home</a>
</body>
</html>