<?php
header('Access-Controll-Allow-Origin:*');
include("connection.php");

$user_type_name = $_POST['user_type_name'];

$query = $mysqli->prepare('insert into user_type (user_type_name) 
values(?)');
$query->bind_param('s', $user_type_name);
$query->execute();

$response = [];
$response["status"] = "true";

echo json_encode($response);
