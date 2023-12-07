<?php
include("../connection.php");
include("../decode_jwt.php");

$decoded=decodeJWT();
//assuming 1 is seller id
if ($decoded->user_type_id == 1) {

    $sellerId = $_POST['seller_id'] ?? '';

    $stmt = $mysqli->prepare("SELECT * FROM product WHERE seller_id = ?");
    $stmt->bind_param("i", $sellerId);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $sellerProducts = [];
        while ($row = $result->fetch_assoc()) {
            $sellerProducts[] = $row;
        }
        echo json_encode(['products' => $sellerProducts]);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }
    
}
else{ echo json_encode('error');}

?>
