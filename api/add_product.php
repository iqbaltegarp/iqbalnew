<?php
header('Content-Type: application/json');
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = time() . '_' . basename($_FILES['image']['name']); // Unique name
        $uploadPath = '../uploads/' . $imageName;

        if (move_uploaded_file($imageTmpPath, $uploadPath)) {
            $query = "INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssds", $name, $description, $price, $imageName);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo json_encode(["message" => "Product added successfully"]);
            } else {
                echo json_encode(["error" => "Failed to add product"]);
            }
        } else {
            echo json_encode(["error" => "Failed to upload image"]);
        }
    } else {
        echo json_encode(["error" => "Image upload error"]);
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>