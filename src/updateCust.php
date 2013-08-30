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
  $user = $_COOKIE["user"]; 
  $sql="UPDATE CUSTOMER SET
          fname='$_POST[fname]',
          lname='$_POST[lname]', 
          password='$_POST[password]',
          st_address='$_POST[st_address]',
          city='$_POST[city]',
          state='$_POST[state]',
          zip='$_POST[zip]',
          phone='$_POST[phone]'
        WHERE user = '$user'";
  
  if (!mysql_query($sql,$conn)){die('Error: ' . mysql_error());}
  echo "Info updated.<br/>";
  
  # back link :
  echo "<a href='custInfo.php?user=$user'>Customer Info</a>";
  mysql_close($conn);
?>