<?php
  $server = "localhost";
  $username = "root";
  $password = "";
  $db = "perpus_db";

   $conn = new mysqli($server, $username, $password, $db);

     if($conn->connect_error) {
      die("$conn->Connect_error");
     }
?>