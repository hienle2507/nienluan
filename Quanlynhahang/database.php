<?php
$host = 'localhost';
$db = 'quanlynhahang';
$user = 'root';
$pass = '';
$charset = 'utf8mb4'; 

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    //echo "Kết nối thành công";
} 
catch (\PDOException $e) {
    echo "Không kết nối: " . $e->getMessage(); // Đưa thông báo lỗi ra ngoài
}
?>
