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
  
  # variables :
  $user = $_POST[user];
  $cust_id = $_POST[cust_id];
  $order_id = $_POST[order_id];
  
  # display the results :
  print "<h1>Order Number $order_id :</h1>";
  
  $sql="SELECT * FROM SHIPMENT WHERE order_id = $order_id";
  $result = mysql_query($sql);
  while($row = mysql_fetch_array($result))
  {
    # show the shipment info :
    echo 
        "<table border='0' cellpadding='5'>
           <tr>
             <th>Order ID</th>
             <th>Shipment ID</th>
             <th>Tracking Number</th>
             <th>Shipment <br>Weight</th>
             <th>&nbsp</th>
           </tr>";
    echo "<tr>";
    echo "  <td>$row[order_id]</td>";
    echo "  <td>$row[id]</td>";
    echo "  <td>$row[tracking_num]</td>";
    echo "  <td>$row[weight] lbs</td>";
    echo "</tr>";
    echo "</table>";
    
    # show all the products ordered for this shipment :
    echo 
        "<table border='0' cellpadding='5' rules='groups'>
           <tr>
             <th>Product Name</th>
             <th>Brand</th>
             <th>Price</th>
             <th>Indiv. <br>Weight</th>
             <th>Quantity</th>
             <th>&nbsp</th>
           </tr>";
    
    $sql="SELECT p.*, s.quantity 
            FROM PRODUCT AS p JOIN SHIP_PROD AS s 
            ON p.id = s.product_id AND s.ship_id = $row[id]";
    $result2 = mysql_query($sql);
    while($row2 = mysql_fetch_array($result2))
    {
      echo "<tr>";
      echo "  <td>$row2[name]</td>";
      echo "  <td>$row2[brand]</td>";
      echo "  <td>\$$row2[price]</td>";
      echo "  <td>$row2[weight] lbs</td>";
      echo "  <td>$row2[quantity]</td>";
      echo "  <td>
                 <form name='input' action='productDetails.php' method='POST'>
                   <input type='hidden' name='id' value=$row2[id]>
                   <input type='submit' value='Details'>
                 </form>
              </td>";
      echo "</tr>";
    }
    echo "</table><br/><br/>";
  }
  print "<a href='customer.php?user=$user'>Account Home</a>";
  print "&nbsp&nbsp<a href='hobby.php?user=$user'>Browse</a>";
  print "<br/><br/><a href='custLogin.html'>Logout</a>";
?>

</body>
</html>