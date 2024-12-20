<?php
include '../db.php';

$name = $_POST['name'];
$price = $_POST['price'];
$description = $_POST['description'];
$image = $_FILES['image'];

$target_dir = "../uploads/";
$target_file = $target_dir . basename($image["name"]);
move_uploaded_file($image["tmp_name"], $target_file);

$stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siss", $name, $price, $description, $image["name"]);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>alert('Produk berhasil ditambahkan!'); window.location.href='dashboard.html';</script>";
} else {
    echo "<script>alert('Gagal menambahkan produk!'); window.location.href='dashboard.html';</script>";
}
?>
