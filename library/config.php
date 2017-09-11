<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "enelsi";

$mysqli = new mysqli($host, $user, $pass, $db);

$url_website = "http://localhost";
$folder_website = "/en-el-si";

//timezone
date_default_timezone_set('Asia/Jakarta');
?>