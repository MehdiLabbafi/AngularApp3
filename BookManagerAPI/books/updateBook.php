<?php
header("Content-Type: application/json");
include_once '../db.php';

$data = json_decode(file_get_contents("php://input"));
$id = $_GET['id'];

$sql = "UPDATE books SET 
    title = '{$data->title}', 
    author = '{$data->author}', 
    genre = '{$data->genre}', 
    price = {$data->price}, 
    rating = {$data->rating}, 
    coverImage = '{$data->coverImage}'
WHERE id = $id";

if ($conn->query($sql)) {
    echo json_encode(["message" => "Book updated successfully."]);
} else {
    echo json_encode(["error" => "Failed to update book."]);
}
?>