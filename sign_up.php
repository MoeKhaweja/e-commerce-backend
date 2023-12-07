<?php
header('Access-Controll-Allow-Origin:*');
include("connection.php");

$email = $_POST['email'];
$password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$username = $_POST['username'];
$user_type_id = $_POST['user_type_id'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$query = $mysqli->prepare('SELECT user_type_id FROM user_type WHERE user_type_id = ?');
$query->bind_param('i', $user_type_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
$insert_query = $mysqli->prepare('insert into users(email,password,first_name,last_name,username,user_type_id) 
values(?,?,?,?,?,?)');
$insert_query->bind_param('sssssi', $email, $hashed_password, $first_name,$last_name, $username, $user_type_id);
$insert_query->execute();

$response = [];
$response["status"] = "true";

echo json_encode($response);
}

else {
    // User type does not exist, handle the error
    $response = [];
    $response["status"] = "false";
    $response["message"] = "Invalid user type";

    echo json_encode($response);
}