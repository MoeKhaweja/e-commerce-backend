<?php
include("../connection.php");
include("../decode_jwt.php");

$decoded=decodeJWT();
//assuming 1 is seller id
if ($decoded->user_type_id == 1) {

    $productName = $_POST['product_name'];
    $productDescription = $_POST['product_description'];
    $productPrice = $_POST['product_price'];
    $productQuantity = $_POST['product_quantity'];
    $sellerId = $_POST['seller_id'];

   
    $stmt = $mysqli->prepare("INSERT INTO product (product_name, product_description, product_price, product_quantity, seller_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdii", $productName, $productDescription, $productPrice, $productQuantity, $sellerId);
    if ($stmt->execute()) {
            echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }
}
else{ echo json_encode('error');}
?>