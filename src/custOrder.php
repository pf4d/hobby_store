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
  <title>Customer Order History</title>
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
  $sql = "SELECT c.id 
            FROM ORDERS JOIN CUSTOMER AS c 
            WHERE cust_id = c.id AND c.user = '$user'";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $id = $row[0];
  
  $sql="SELECT * FROM ORDERS WHERE cust_id = $id";
  $result = mysql_query($sql);
  
  # display order history :
  print "<h1>$user's Order History</h1>";
  
  echo 
        "<table border='0' cellpadding='10' rules='groups'>
           <tr>
             <th>Order ID</th>
             <th>Date</th>
             <th>Cost</th>
             <th>Shipping<br>cost</th>
             <th>Number of<br>shipments</th>
             <th>&nbsp</th>
           </tr>";
  
  while($row = mysql_fetch_array($result))
  {
    echo "<tr>";
    echo "  <td>$row[id]</td>";
    echo "  <td>$row[date]</td>";
    echo "  <td>\$$row[cost]</td>";
    echo "  <td>\$$row[shipping_cost]</td>";
    echo "  <td>$row[num_shipments]</td>";
    echo "  <td>
               <form name='input' action='shipmentDetails.php' method='POST'>
                 <input type='hidden' name='order_id' value=$row[id]>
                 <input type='hidden' name='cust_id' value=$id>
                 <input type='hidden' name='user' value=$user>
                 <input type='submit' value='Details'>
               </form>
             </td>";
    echo "</tr>";
  }
  echo "</table><br/>";
  
  print "<a href='customer.php?user=$user'>Customer Info</a>";
  print "&nbsp&nbsp<a href='hobby.php?user=$user'>Browse</a>";
  print "<br/><br/><a href='custLogin.html'>Logout</a>";
?>

</body>
</html>