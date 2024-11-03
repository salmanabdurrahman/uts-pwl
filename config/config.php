<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simple_news_website_2961";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// echo "Connected successfully";
