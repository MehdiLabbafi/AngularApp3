<?php
// فعال‌سازی گزارش تمام خطاها
error_reporting(E_ALL);
ini_set('display_errors', 1);

// بارگذاری فایل اتصال به دیتابیس
require_once('db.php');

// تنظیم هدرهای CORS برای ارتباط با Angular
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {
        case 'GET':
            // دریافت لیست کتاب‌ها
            $stmt = $conn->query('SELECT * FROM books');
            $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // افزودن مسیر صحیح به تصاویر کاور
            foreach ($books as &$book) {
                if ($book['coverImage']) {
                    $book['coverImage'] = 'http://localhost/BookManagerAPI/uploads/' . $book['coverImage'];
                }
            }
            echo json_encode($books);
            break;

            case 'POST':
                // افزودن یک کتاب جدید
                $input = json_decode(file_get_contents('php://input'), true);
                $coverImagePath = null;
            
                // بررسی آپلود فایل
                if (isset($_FILES['coverImage']) && $_FILES['coverImage']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'uploads/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $coverImagePath = basename($_FILES['coverImage']['name']);
                    move_uploaded_file($_FILES['coverImage']['tmp_name'], $uploadDir . $coverImagePath);
                }
            
                if ($input && isset($input['title'], $input['author'], $input['genre'], $input['price'], $input['rating'])) {
                    $stmt = $conn->prepare('INSERT INTO books (title, author, genre, price, rating, coverImage) VALUES (:title, :author, :genre, :price, :rating, :coverImage)');
                    $stmt->execute([
                        ':title' => $input['title'],
                        ':author' => $input['author'],
                        ':genre' => $input['genre'],
                        ':price' => $input['price'],
                        ':rating' => $input['rating'],
                        ':coverImage' => $coverImagePath
                    ]);
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['error' => 'Invalid input data']);
                }
                break;
            

        case 'PUT':
            // بروزرسانی یک کتاب
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
            // حذف یک کتاب
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
