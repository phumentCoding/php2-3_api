<?php 
  //i want connect and create database
  $host = "127.0.0.1";
  $user = "root";
  $password = "";
  $database = "etec-database";

  $con = mysqli_connect($host, $user, $password, $database,3307);

  if (!$con) {
    die("Error: " . mysqli_connect_error());
  }

  
?>