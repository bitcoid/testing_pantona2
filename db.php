<?php
  class db {
    function connect(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $db = 'testing_satu';

        // Create connection
        $conn = new mysqli($servername, $username, $password, $db);

        // Check connection
        if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
        } 
        return $conn;
    }
  }

?>