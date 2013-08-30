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
  
  # retrieve information on product :
  $sql="SELECT * FROM PRODUCT WHERE id = $_POST[id]";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  
  # display the results :
  echo "<h1>Product Details :</h1>";
  echo "<img src='./images/$row[id].jpg'  border='2' style='border:2px solid black;'>";
  
  echo "<table border='0'>";
  echo "  <tr>
            <td><b>Product : </td></b>
            <td>&nbsp&nbsp$row[name]</td>
          </tr>";
  echo "  <tr>
            <td><b>Brand : </td></b>
            <td>&nbsp&nbsp$row[brand]</td>
          </tr>";
  echo "  <tr>
            <td><b>Price : </td></b>
            <td>&nbsp&nbsp\$$row[price]</td>
          </tr>";
  echo "  <tr>
            <td><b>Weight : </td></b>
            <td>&nbsp&nbsp$row[weight] lbs</td>
          </tr>";
  echo "  <tr>
            <td><b>Quantity In Stock : </td></b>
            <td>&nbsp&nbsp$row[stock_quantity]</td>
          </tr>";
  echo "  <tr>
            <td><b>ID # : </td></b>
            <td>&nbsp&nbsp$row[id]</td>
          </tr>";
  echo "</table><br/>";
  
  echo "<b>Description :</b><br>";
  echo "&nbsp&nbsp $row[description]<br/><br/>";
  
  # add the product to the cart :
  echo "<form name='cart' action='cart.php' method='POST'>
          <input type='hidden' name='prodId' value=$row[id]>
          <input type='submit' value='Add to Cart'>
        </form>";
  
  # back link :
  echo "<a href='hobby.php'>Continue Browsing</a>";
  mysql_close($conn);
?>


