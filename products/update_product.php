<?php
include("../connection.php");
include("../decode_jwt.php");

$productId = $_POST['product_id'];
$productName = $_POST['product_name'];
$productDescription = $_POST['product_description'];
$productPrice = $_POST['product_price'];
$productQuantity = $_POST['product_quantity'];
$sellerId = $_POST['seller_id'];



$decoded=decodeJWT();
    //assuming 1 is seller id

if ($decoded->user_type_id == 1) {
    $stmt = $mysqli->prepare("UPDATE product SET product_name = ?, product_description = ?, product_price = ?, product_quantity = ? WHERE product_id = ? AND seller_id = ?");
    $stmt->bind_param("ssdiii", $productName, $productDescription, $productPrice, $productQuantity, $productId, $sellerId);
    if ($stmt->execute()) {
        
        echo json_encode("product updated succesfully");
    }else {
        echo json_encode(['error' => $stmt->error]);
    }

}
else{ echo json_encode('error');}
?>
