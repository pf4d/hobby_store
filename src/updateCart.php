<!--
Evan Cummings
CSCI 340 - Database Design
Spring '12 - Min Chen
Final Project
-->

<?php
  # connect to the database :
  $conn=mysql_connect("db.cs.umt.edu", "CSCI340-08", "KrS9qvP8");
  if (!$conn)  {die('Could not connect: ' . mysql_error());  }
  mysql_select_db("CSCI340-08",$conn);
  
  if (!mysql_select_db("CSCI340-08",$conn)) {die('Error: ' . mysql_error());}
  
  # update the database :
  $prodId = $_POST[prodId];
  $quantity = $_POST[quantity];
  $user = $_COOKIE[user];
  print "$quantity, $prodId, $user.</br>";
  $sql="UPDATE CART_PROD SET
          quantity = $quantity
          WHERE cart_id IN 
          (
            SELECT id
              FROM CUSTOMER
              WHERE user = '$user'
          )
          AND product_id = $prodId";
  if (!mysql_query($sql,$conn)){die('Error: ' . mysql_error());}
  mysql_close($conn);
  
  #  refresh / re-direct without delay
  header('location: cart.php');
?>