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
  
  $user = $_COOKIE[user];
  
  # insert new product into cart if there is a POST product :
  if ($_POST[prodId] != NULL)
  {
    $prodId = $_POST[prodId];
    $sql = "SELECT COUNT(*) FROM CART_PROD WHERE product_id = $prodId";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $prodCnt = $row[0];
    # if this is a new product :
    if ($prodCnt == 0)
    {
      $sql = "INSERT INTO CART_PROD 
                VALUES
                (
                  (
                    SELECT id
                      FROM CUSTOMER
                      WHERE user = '$user'
                  ),
                  $prodId,
                  1
                )";
      if (!mysql_query($sql,$conn)){die('Error: ' . mysql_error());}
    }
    # if this is a product that is already in cart :
    else
    {
      $sql = "UPDATE CART_PROD SET
                quantity = (quantity + 1)
                WHERE cart_id IN
                (
                  SELECT id
                    FROM CUSTOMER
                    WHERE user = '$user'
                )
                AND product_id = $prodId";
      if (!mysql_query($sql,$conn)){die('Error: ' . mysql_error());}
    }
  }
  
  # retrieve cart information :
  $sql = "SELECT p.*, c.quantity 
            FROM PRODUCT AS p JOIN CART_PROD AS c ON p.id = c.product_id, 
                 CUSTOMER AS cust 
            WHERE cust.id IN 
            (
              SELECT id 
                FROM CUSTOMER 
                WHERE user = '$user'
            )";
  $result = mysql_query($sql);
  
  
  # display the results :
  $totPrice = 0.0;               # total order price
  echo "<h1>$user's Cart :</h1>";
  
  echo "<table border='0' cellpadding='5' rules='groups'>
          <tr>
            <th>&nbsp</th>
            <th>Product Name</th>
            <th>Brand</th>
            <th>Price</th>
            <th>Indiv.<br>Weight</th>
            <th>Quantity</th>
            <th>Total<br>Price</th>
            <th>&nbsp</th>
          </tr>";
  
  while($row = mysql_fetch_array($result))
  {
    $totProdPrice = $row[quantity] * $row[price];
    $totPrice += $totProdPrice;
    
    echo "<tr>";
    echo "    <td><img src='./images/$row[id].jpg'  height='50' border='2'
                   style='border:2px solid black;'></td>";
    echo "  <td>$row[name]</td>";
    echo "  <td>$row[brand]</td>";
    echo "  <td>\$$row[price]</td>";
    echo "  <td>$row[weight] lbs</td>";
    echo "  <td>
               <form name='update' action='updateCart.php' method='POST'>
                 <input type='text' size='1' name='quantity' 
                  value=$row[quantity]>
                 <input type='hidden' name='prodId' value=$row[id]>
                 <input type='submit' value='Refresh'>
               </form>
             </td>";
    echo " <td>\$$totPrice</td>";
    echo "  <td>
               <form name='input' action='productDetails.php' method='POST'>
                 <input type='hidden' name='id' value=$row[id]>
                 <input type='submit' value='Details'>
               </form>
            </td>";
    echo "</tr>";
  }
  echo "</table><br/><br/>";
  
  echo "<b>TOTAL ORDER COST : \$$totPrice</b>";
  
  echo "<form name='order' action='order.php' method='POST'>
          <input type='hidden' name='user' value=$user>
          <input type='hidden' name='totPrice' value=$totPrice>
          <input type='submit' value='Place Order'>
        </form>";
  
  echo "<br/><a href='customer.php?user=$user'>Account Home</a>";
  echo "&nbsp&nbsp<a href='custLogin.html'>Logout</a>";
  echo "&nbsp&nbsp<a href='hobby.php'>Continue Browsing</a>";
?>
