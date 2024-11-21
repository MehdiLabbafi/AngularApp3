<?php
header("Content-Type: application/json");
include_once '../db.php';

$data = json_decode(file_get_contents("php://input"));

$sql = "INSERT INTO books (title, author, genre, price, rating, coverImage) VALUES (
    '{$data->title}', '{$data->author}', '{$data->genre}', {$data->price}, {$data->rating}, '{$data->coverImage}'
)";

if ($conn->query($sql)) {
    echo json_encode(["message" => "Book added successfully."]);
} else {
    echo json_encode(["error" => "Failed to add book."]);
}
?>