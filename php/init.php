<?php

$servername = "kubernetes.docker.internal";
$username = "sail";
$password = "password";
$dbname = "test_db";
$port = "3306";



try {
$conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
echo "Connection failed: " . $e->getMessage();
}
?>