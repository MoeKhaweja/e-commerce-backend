<?php
include("../connection.php");
include("../decode_jwt.php");

$decoded=decodeJWT();


if ($result = $mysqli->query("SELECT * FROM product")) {
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    echo json_encode(['products' => $products]);
    $result->free();
} else {
    echo json_encode(['error' => $mysqli->error]);
}

?>
