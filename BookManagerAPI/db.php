<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$db_name = 'BookManager';
$username = 'root';
$password = '13501361'; // اضافه کردن رمز عبور جدید

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // خط زیر را حذف کنید:
    // echo "Connection successful";
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
