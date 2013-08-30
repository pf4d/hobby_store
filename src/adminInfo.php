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
  <title>Admin Info</title>
</head>
<body bgcolor="#ffffff">

<?php
  # connect to the database :
  $conn=mysql_connect("db.cs.umt.edu", "CSCI340-08", "KrS9qvP8");
  if (!$conn)  {die('Could not connect: ' . mysql_error());  }
  mysql_select_db("CSCI340-08",$conn);
  
  if (!mysql_select_db("CSCI340-08",$conn)) {die('Error: ' . mysql_error());}
  
  # retrieve information on admin :
  $user = $_COOKIE["user"];
  $sql="SELECT * FROM ADMIN WHERE user = '$user'";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  
  # display the results :
  echo "<h1>$user's Info</h1>";
  
  echo "<table border='0'>";
  echo "  <tr>
            <td><b>User Name : </td></b>
            <td>&nbsp&nbsp$row[user]</td>
          </tr>";
  echo "  <tr>
            <td><b>Password : </td></b>
            <td>&nbsp&nbsp$row[password]</td>
          </tr>";
  echo "  <tr>
            <td><b>Name : </td></b>
            <td>&nbsp&nbsp$row[fname] $row[lname]</td>
          </tr>";
  echo "  <tr>
            <td><b>Street Address : </td></b>
            <td>&nbsp&nbsp$row[st_address]</td>
          </tr>";
  echo "  <tr>
            <td><b></td></b>
            <td>&nbsp&nbsp$row[city], $row[state] $row[zip]</td>
          </tr>";
  echo "  <tr>
            <td><b>Phone Number : </td></b>
            <td>&nbsp&nbsp$row[phone]</td>
          </tr>";
  echo "</table><br/>";
  
  # allow admin to change data :
  echo "<p><b>Update Data :</b></p>";
  echo "
        <form action='updateAdmin.php' method='POST'>
          <table border='0'>
            <tr>
              <td>Firstname :</td>
              <td>
                <input type='text' name='fname' 
                 value=$row[fname] />
              </td>
            </tr>
            <tr>
              <td>Lastname :</td>
              <td>
                <input type='text' name='lname' 
                 value=$row[lname] />
              </td>
            </tr>  
            <tr>  
              <td>Password :</td>
              <td>
                <input type='text' name='password' 
                 value=$row[password] />
              </td>
            </tr>
            <tr>
              <td>Street Address :</td>
              <td>
                <input type='text' name='st_address' 
                 value=$row[st_address] />
              </td>
            </tr>
            <tr>  
              <td>City :</td>
              <td>
                <input type='text' name='city'  
                 value=$row[city] />
              </td>
            </tr>
            <tr>  
              <td>State :</td>
              <td>
                <input type='text' name='state'  
                 value=$row[state] />
              </td>
            </tr>
            <tr>  
              <td>Zipcode :</td>
              <td>
                <input type='text' name='zip'  
                 value=$row[zip] />
              </td>
            </tr>
            <tr>  
              <td>Phone :</td>
              <td>
                <input type='text' name='phone'  
                 value=$row[phone] />
              </td>
            </tr>
          </table>
          <input type='submit' />
        </form>";
  
  
  
  echo "<br/><a href='admin.php'>Account Home</a>";
  echo "&nbsp&nbsp<a href='adminLogin.html'>Logout</a>";
  echo "&nbsp&nbsp<a href='hobby.php'>Browse Inventory</a>";
?>
</body>
</html>


