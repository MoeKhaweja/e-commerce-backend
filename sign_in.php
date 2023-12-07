<?php
header('Access-Control-Allow-Origin: *');
include("connection.php");


require __DIR__ . '/vendor/autoload.php';
use Firebase\JWT\JWT;

$username = $_POST['username'];
$password = $_POST['password'];

$query = $mysqli->prepare('SELECT user_id, first_name, last_name, user_type_id, password FROM users WHERE username = ?');
$query->bind_param('s', $username);
$query->execute();
$query->store_result();
$num_rows = $query->num_rows;
$query->bind_result($user_id, $first_name, $last_name, $user_type_id, $hashed_password);
$query->fetch();

$response = [];
if ($num_rows == 0) {
    $response['status'] = 'user not found';
    echo json_encode($response);
} else {
    if (password_verify($password, $hashed_password)) {
        $payload_array = [];
        $payload_array["user_id"] = $user_id;
        $payload_array["first_name"] = $first_name;
        $payload_array["last_name"] = $last_name;
        $payload_array["user_type_id"] = $user_type_id;
        $payload_array["exp"] = time() + 3600;
        $payload = $payload_array;
        $key = "your_secret";

        $response['status'] = 'logged in';
        $jwt = JWT::encode($payload, $key, 'HS256');
        $response['jwt'] = $jwt;
        echo json_encode($response);
    } else {
        $response['status'] = 'wrong credentials';
        echo json_encode($response);
    }
}
