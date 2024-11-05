<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simple_news_website_2961";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
