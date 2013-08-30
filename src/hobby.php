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
    <title>Evan's Hobby Store</title> 
  </head> 
  <a href="http://web-dev.cs.umt.edu/~CSCI340-08/hobby/custLogin.html">
    Customer Login</a>
  <a href="http://web-dev.cs.umt.edu/~CSCI340-08/hobby/adminLogin.html">
    Admin Login</a>
  <h1>Evan's Hobby Store :</h1>
  <body> 
    <?php
      # connect to the database :
      $conn=mysql_connect("db.cs.umt.edu", "CSCI340-08", "KrS9qvP8");
      if (!$conn)  {die('Could not connect: ' . mysql_error());  }
      mysql_select_db("CSCI340-08",$conn);
      
      $user = $_COOKIE[user];
      
      # select sort method :
      if($_POST[sort] == NULL)
        $select = 'name';
      else
        $select = $_POST[sort];
      
      print "Sort by :";
      echo 
      "<form name='sortdrop' 
             action='http://web-dev.cs.umt.edu/~CSCI340-08/hobby/hobby.php'
             method='POST'>
         <select name='sort'>
           <option selected>$select</option>
           <option value='name'>name</option>
           <option value='brand'>brand</option>
           <option value='price'>price</option>
         </select>
         <input type='submit' value='Refresh'>
       </form>";
      
      # display the products :
      $sql = "SELECT * FROM PRODUCT ORDER BY $select";
      $result = mysql_query($sql);
      echo "<b>Products :</b><br/>";
      echo 
        "<table border='0'>
           <tr>
             <th>&nbsp</th>
             <th>Name</th>
             <th>Brand</th>
             <th>Price</th>
             <th>Quantity <br>in stock</th>
             <th>&nbspId #&nbsp</th>
             <th>&nbsp</th>
           </tr>";
      
      while($row = mysql_fetch_array($result))
      {
        echo "  <tr>";
        echo "    <td><img src='./images/$row[id].jpg'  height='50'
                        border='2' style='border:2px solid black;'></td>";
        echo "    <td>" . $row['name'] . "</td>";
        echo "    <td>&nbsp&nbsp" . $row[brand] . "</td>";
        echo "    <td>&nbsp&nbsp" . $row[price] . "</td>";
        echo "    <td>&nbsp&nbsp" . $row[stock_quantity] . "</td>";
        echo "    <td>&nbsp&nbsp" . $row[id] . "</td>";
        echo "    <td>
                    <form name='input' action='productDetails.php' method='POST'>
                      <input type='hidden' name='id' value=$row[id]>
                      <input type='submit' value='Details'>
                    </form>
                  </td>";
        echo "  </tr>";
      }
      echo "</table><br/>";
      
      # link to account homepage :
      echo "<p><a href='customer.php?user=$user'>Your Account</a></p>";
      
      # close the database :
      mysql_close($conn);
    ?> 
  </body>
</html>
