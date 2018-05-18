
<?php
header('Content-type: text/html; charset=utf-8');
require_once 'connection.php'; 

$uri = $_SERVER['REQUEST_URI'];
$ip = $_SERVER['REMOTE_ADDR'];
$dtime = date("Y-n-j", $timestamp = time());

$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));  

$query = "INSERT INTO statictics(`stat_date`,`stat_ip`,`stat_url`) VALUES ('$dtime','$ip','$uri')";
$result = mysqli_query($link,$query) or die("Ошибка " . mysqli_error($link)); 

mysqli_close($link);  
        
?>