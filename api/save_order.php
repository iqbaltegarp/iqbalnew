<?php
include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);

$name = $data['name'];
$phone = $data['phone'];
$address = $data['address'];
$cart = json_encode($data['cart']);
$total_price = $data['total_price'];

$stmt = $conn->prepare("INSERT INTO orders (name, phone, address, cart, total_price) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $name, $phone, $address, $cart, $total_price);
$stmt->execute();

$response = ["success" => $stmt->affected_rows > 0];
header('Content-Type: application/json');
echo json_encode($response);

$stmt->close();
$conn->close();
?>
