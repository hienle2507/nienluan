<?php
include 'database.php';

try {
    // Tạo kết nối PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tạo bảng `users`
    $sql_users = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'staff') NOT NULL
        )
    ";
    $pdo->exec($sql_users);

    // Tạo bảng 'khachhang'
    $sql_khachhang = "
        CREATE TABLE IF NOT EXISTS khachhang (
            makh INT AUTO_INCREMENT PRIMARY KEY,
            tenkh VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            sdt VARCHAR(20)
        )
    ";
    $pdo->exec($sql_khachhang);

    // Tạo bảng 'loaimon'
    $sql_loaimon = "
        CREATE TABLE IF NOT EXISTS loaimon (
            maloai INT AUTO_INCREMENT PRIMARY KEY,
            tenloai VARCHAR(100) NOT NULL 
        )
    ";
    $pdo->exec($sql_loaimon);

    // Tạo bảng `monan`
    $sql_monan = "
        CREATE TABLE IF NOT EXISTS monan (
            mamon INT AUTO_INCREMENT PRIMARY KEY,
            tenmon VARCHAR(100) NOT NULL,
            giamon DECIMAL(10, 2) NOT NULL,
            mota TEXT,
            trangthai ENUM('Có sẵn', 'Hết món ăn', 'Ngưng phục vụ') NOT NULL,
            ma_loai INT NOT NULL,
            FOREIGN KEY (ma_loai) REFERENCES loaimon(maloai)
        )
    ";
    $pdo->exec($sql_monan);

    // Tạo bảng 'ban'
    $sql_ban = "
        CREATE TABLE IF NOT EXISTS ban (
            maban INT AUTO_INCREMENT PRIMARY KEY,
            soghe INT NOT NULL,
            trangthai ENUM('Còn trống', 'Đã được đặt') NOT NULL
        )
    ";
    $pdo->exec($sql_ban);

    // Tạo bảng `datban`
    $sql_datban = "
        CREATE TABLE IF NOT EXISTS datban (
            madatban INT AUTO_INCREMENT PRIMARY KEY,
            ngaydatban DATE NOT NULL,
            giodatban TIME NOT NULL,
            songuoi INT NOT NULL,
            ghichu VARCHAR(200),
            ma_mon INT NOT NULL,
            ma_ban INT NOT NULL,
            ma_kh INT NOT NULL,
            FOREIGN KEY (ma_mon) REFERENCES monan(mamon),
            FOREIGN KEY (ma_ban) REFERENCES ban(maban),
            FOREIGN KEY (ma_kh) REFERENCES khachhang(makh)
        )
    ";
    $pdo->exec($sql_datban);

    echo "Các bảng đã được tạo thành công trong cơ sở dữ liệu 'quanlynhahang'.";
} catch (PDOException $e) {
    echo "Lỗi tạo bảng: " . $e->getMessage();
}
?>
