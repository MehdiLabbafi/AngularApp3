<?php
// Enable error reporting for all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load the database connection file
require_once('db.php');

// Set CORS headers for Angular communication
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {
        case 'GET':
            // Retrieve the list of books
            $stmt = $conn->query('SELECT * FROM books');
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Add the correct path to cover images
            foreach ($books as &$book) {
                if (!empty($book['coverImage'])) {
                    $book['coverImage'] = 'http://localhost/BookManagerAPI/uploads/' . $book['coverImage'];
                }
            }
            echo json_encode($books);
            break;

        case 'POST':
            // Add a new book
            if (!empty($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                // Generate a unique name for the file
                $fileName = uniqid() . '_' . basename($_FILES['file']['name']);
                $filePath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                    // Get other book details from the request
                    $input = $_POST;

                    if (isset($input['title'], $input['author'], $input['genre'], $input['price'], $input['rating'])) {
                        $stmt = $conn->prepare('INSERT INTO books (title, author, genre, price, rating, coverImage) VALUES (:title, :author, :genre, :price, :rating, :coverImage)');
                        $stmt->execute([
                            ':title' => $input['title'],
                            ':author' => $input['author'],
                            ':genre' => $input['genre'],
                            ':price' => $input['price'],
                            ':rating' => $input['rating'],
                            ':coverImage' => $fileName
                        ]);
                        echo json_encode(['success' => true]);
                    } else {
                        echo json_encode(['error' => 'Invalid input data']);
                    }
                } else {
                    echo json_encode(['error' => 'Failed to upload the file']);
                }
            } else {
                echo json_encode(['error' => 'No file uploaded']);
            }
            break;

        case 'PUT':
            // Update a book
            $input = json_decode(file_get_contents('php://input'), true);
            if ($input && isset($input['id'], $input['title'], $input['author'], $input['genre'], $input['price'], $input['rating'])) {
                $stmt = $conn->prepare('UPDATE books SET title = :title, author = :author, genre = :genre, price = :price, rating = :rating, coverImage = :coverImage WHERE id = :id');
                $stmt->execute([
                    ':id' => $input['id'],
                    ':title' => $input['title'],
                    ':author' => $input['author'],
                    ':genre' => $input['genre'],
                    ':price' => $input['price'],
                    ':rating' => $input['rating'],
                    ':coverImage' => isset($input['coverImage']) ? $input['coverImage'] : null
                ]);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Invalid input data']);
            }
            break;

        case 'DELETE':
            // Delete a book
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $stmt = $conn->prepare('DELETE FROM books WHERE id = :id');
                $stmt->execute([':id' => $id]);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Missing book id']);
            }
            break;

        default:
            echo json_encode(['error' => 'Unsupported request method']);
            break;
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>