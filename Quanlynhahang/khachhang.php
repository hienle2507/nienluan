<?php
// Kết nối đến cơ sở dữ liệu
include 'database.php';

try {
    // Kiểm tra xem dữ liệu có được gửi qua POST hay không
    if (isset($_POST['tenkh']) && isset($_POST['email']) && isset($_POST['sdt'])) {
        $tenkh = $_POST['tenkh'];
        $email = $_POST['email'];
        $sdt = $_POST['sdt'];

        // Kiểm tra xem khách hàng đã tồn tại hay chưa
        $sql_check = "SELECT makh FROM khachhang WHERE tenkh = :tenkh AND email = :email";
        $stmt = $pdo->prepare($sql_check);
        $stmt->bindParam(':tenkh', $tenkh);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Nếu khách hàng đã tồn tại, lấy makh
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $makh = $row['makh'];
            echo "Khách hàng đã tồn tại với mã: $makh\n";
        } else {
            // Nếu chưa tồn tại, thêm mới vào bảng khachhang
            $sql_insert_khachhang = "INSERT INTO khachhang (tenkh, email, sdt) VALUES (:tenkh, :email, :sdt)";
            $stmt = $pdo->prepare($sql_insert_khachhang);
            $stmt->bindParam(':tenkh', $tenkh);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':sdt', $sdt);

            if ($stmt->execute()) {
                // Lấy makh mới vừa thêm
                $makh = $pdo->lastInsertId();
                echo "Khách hàng mới đã được thêm thành công với mã: $makh\n";
            } else {
                echo "Có lỗi xảy ra khi thêm khách hàng.\n";
                exit;
            }
        }
    } else {
        echo "Dữ liệu khách hàng không đầy đủ.\n";
    }
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>
