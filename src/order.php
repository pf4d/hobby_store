<!--
Evan Cummings
CSCI 340 - Database Design
Spring '12 - Min Chen
Final Project
-->

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
                      "http://www.w3.org/TR/html401/loose.dtd">

<?php
  # connect to the database :
  $conn=mysql_connect("db.cs.umt.edu", "CSCI340-08", "KrS9qvP8");
  if (!$conn)  {die('Could not connect: ' . mysql_error());  }
  mysql_select_db("CSCI340-08",$conn);
  
  if (!mysql_select_db("CSCI340-08",$conn)) {die('Error: ' . mysql_error());}
  
  $user = $_COOKIE[user];
  $totPrice = $_POST[totPrice];
  
  # get the user id :
  $sql = "SELECT id FROM CUSTOMER WHERE user = '$user'";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $userId = $row[0];
  
  # add order to the database :
  $sql="INSERT INTO ORDERS (cust_id, date, cost) 
          VALUES 
          (
            $userId, 
            CURRENT_TIMESTAMP, 
            $totPrice
          )";
  if (!mysql_query($sql,$conn)){die('Error: ' . mysql_error());}
  
  # get the order id of the order just created :
  $sql = "SELECT MAX(id) FROM ORDERS";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $orderId = $row[0];
  
  # add shipment to the database :
  $sql = "INSERT INTO SHIPMENT (order_id) VALUES ($orderId)";
  if (!mysql_query($sql,$conn)){die('Error: ' . mysql_error());}
  
  # get the shipment id of the shipment just created :
  $sql = "SELECT MAX(id) FROM SHIPMENT";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $shipId = $row[0];
  
  # retrieve cart information :
  $sql = "SELECT p.*, c.quantity 
            FROM PRODUCT AS p JOIN CART_PROD AS c ON p.id = c.product_id, 
                 CUSTOMER AS cust 
            WHERE cust.id = $userId";
  $result = mysql_query($sql);
  
  # insert values from the cart into SHIP_PROD :
  while($row = mysql_fetch_array($result))
  {
    $totProdPrice = $row[quantity] * $row[price];
    print "shipId: $shipId, product_id: $row[id], quan.: $row[quantity]";
    $sql = "INSERT INTO SHIP_PROD 
              VALUES ($shipId, $row[id], $row[quantity])";
    if (!mysql_query($sql,$conn)){die('Error: ' . mysql_error());}
  }
  
  # back link :
  echo "<a href='hobby.php'>Continue Browsing</a>";
  mysql_close($conn);
?>