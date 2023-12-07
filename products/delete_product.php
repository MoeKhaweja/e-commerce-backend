<?php
include("../connection.php");
include("../decode_jwt.php");

$decoded=decodeJWT();
//assuming 1 is seller id
if ($decoded->user_type_id == 1) {

    $productId = $_POST['product_id'] ?? '';
    $sellerId = $_POST['seller_id'] ?? '';

    $stmt = $mysqli->prepare("DELETE FROM product WHERE product_id = ? AND seller_id = ?");
    $stmt->bind_param("ii", $productId, $sellerId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }

}
else{ echo json_encode('error');}
?>
