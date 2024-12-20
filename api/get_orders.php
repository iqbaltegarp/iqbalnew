<?php
include '../db.php';

$result = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");

$orders = [];
while ($row = $result->fetch_assoc()) {
    $row['cart'] = json_decode($row['cart'], true);
    $orders[] = $row;
}

header('Content-Type: application/json');
echo json_encode($orders);
?>
