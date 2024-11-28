<?php
header("Content-Type: application/json");
include_once '../db.php';

$id = $_GET['id'];

$sql = "DELETE FROM books WHERE id = $id";

if ($conn->query($sql)) {
    echo json_encode(["message" => "Book deleted successfully."]);
} else {
    echo json_encode(["error" => "Failed to delete book."]);
}
?>