<!--
Evan Cummings
CSCI 340 - Database Design
Spring '12 - Min Chen
Final Project
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
                      "http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Pay History</title>
</head>
<body bgcolor="#ffffff">

<?php
  # connect to the database :
  $conn=mysql_connect("db.cs.umt.edu", "CSCI340-08", "KrS9qvP8");
  if (!$conn)  {die('Could not connect: ' . mysql_error());  }
  mysql_select_db("CSCI340-08",$conn);
  
  if (!mysql_select_db("CSCI340-08",$conn)) {die('Error: ' . mysql_error());}
  
  # query the database :
  $user = $_COOKIE["user"];
  $sql = "SELECT id FROM ADMIN WHERE user = '$user'";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $id = $row[0];
  
  $sql="SELECT * FROM PAYCHECK WHERE admin_id = $id";
  $result = mysql_query($sql);
  
  # display order history :
  print "<h1>$user's Pay History</h1>";
  
  echo 
        "<table border='0' cellpadding='10' rules='groups'>
           <tr>
             <th>Employee Number</th>
             <th>Check Number</th>
             <th>Date</th>
             <th>Amount</th>
           </tr>";
  
  while($row = mysql_fetch_array($result))
  {
    echo "<tr>";
    echo "  <td>$row[admin_id]</td>";
    echo "  <td>$row[id]</td>";
    echo "  <td>$row[date]</td>";
    echo "  <td>\$$row[amount]</td>";
    echo "</tr>";
  }
  echo "</table><br/>";
  
  print "<a href='admin.php?user=$user'>Employee Info</a>";
  print "&nbsp&nbsp<a href='hobby.php?user=$user'>Browse</a>";
  print "<br/><br/><a href='adminLogin.html'>Logout</a>";
?>

</body>
</html>