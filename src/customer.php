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
  <title>Customer Account Home</title>
</head>
<body bgcolor="#ffffff">
<h1>Customer Account Home</h1>

<?php
  # connect to the database :
  $conn=mysql_connect("db.cs.umt.edu", "CSCI340-08", "KrS9qvP8");
  if (!$conn)  {die('Could not connect: ' . mysql_error());  }
  mysql_select_db("CSCI340-08",$conn);
  
  # check to see if user is in database :
  $user = $_GET[user];
  $pass = $_GET[password];
  $sql = "SELECT * FROM CUSTOMER WHERE user = '$user'";
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
              <input type='hidden' name='type' value='CUSTOMER'>
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

    echo '<p><a href="custInfo.php">View / Update Personal Info</a></p>
          <p><a href="custOrder.php">View Order History</a></p>
          <p><a href="cart.php">Shopping Cart</a></p>';
  }
  
  mysql_close($conn);
?>
<br/><br/><a href="custLogin.html">Logout</a>
&nbsp
<a href="hobby.php">Browse</a>
</body>
</html>