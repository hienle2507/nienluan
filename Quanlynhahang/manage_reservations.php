<?php
session_start();
include 'database.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

try {
    // Kết nối PDO
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lấy danh sách món ăn từ cơ sở dữ liệu
    $menu_items = $conn->query("SELECT * FROM monan")->fetchAll(PDO::FETCH_ASSOC);

    // Xử lý form khi gửi
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy dữ liệu từ form
        $ngaydatban = $_POST['ngaydatban'];
        $giodatban = $_POST['giodatban'];
        $songuoi = $_POST['songuoi'];
        $ghichu = $_POST['ghichu']; // Đảm bảo trường này tồn tại trong form
        $tenkh = $_POST['tenkh'];
        $email = $_POST['email'];
        $sdt = $_POST['sdt'];

        // Kiểm tra khách hàng đã tồn tại
        $sql_check_kh = "SELECT makh FROM khachhang WHERE email = :email";
        $stmt = $conn->prepare($sql_check_kh);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Khách hàng đã tồn tại, lấy makh
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $makh = $row['makh'];
        } else {
            // Khách hàng chưa tồn tại, thêm mới vào bảng khachhang
            $sql_insert_khachhang = "INSERT INTO khachhang (tenkh, email, sdt) VALUES (:tenkh, :email, :sdt)";
            $stmt = $conn->prepare($sql_insert_khachhang);
            $stmt->bindParam(':tenkh', $tenkh);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':sdt', $sdt);
            $stmt->execute();

            // Lấy makh của khách hàng mới tạo
            $makh = $conn->lastInsertId();
        }

        // Giả sử bạn có giá trị cho ma_mon và ma_ban từ form
        $ma_mon = $_POST['ma_mon']; // Thêm trường này vào form
        $ma_ban = $_POST['ma_ban']; // Thêm trường này vào form

        // Kiểm tra xem ma_mon và ma_ban có tồn tại trong bảng tương ứng không
        $sql_check_mon = "SELECT * FROM monan WHERE mamon = :ma_mon";
        $stmt = $conn->prepare($sql_check_mon);
        $stmt->bindParam(':ma_mon', $ma_mon);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            echo "Mã món không hợp lệ.";
            exit();
        }

        $sql_check_ban = "SELECT * FROM ban WHERE maban = :ma_ban";
        $stmt = $conn->prepare($sql_check_ban);
        $stmt->bindParam(':ma_ban', $ma_ban);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            echo "Mã bàn không hợp lệ.";
            exit();
        }

        // Thêm thông tin đặt bàn vào bảng datban
        $sql_insert_datban = "INSERT INTO datban (ngaydatban, giodatban, songuoi, ghichu, ma_mon, ma_ban, makh)
            VALUES (:ngaydatban, :giodatban, :songuoi, :ghichu, :ma_mon, :ma_ban, :makh)";
        $stmt = $conn->prepare($sql_insert_datban);
        $stmt->bindParam(':ngaydatban', $ngaydatban);
        $stmt->bindParam(':giodatban', $giodatban);
        $stmt->bindParam(':songuoi', $songuoi);
        $stmt->bindParam(':ghichu', $ghichu);
        $stmt->bindParam(':ma_mon', $ma_mon);
        $stmt->bindParam(':ma_ban', $ma_ban);
        $stmt->bindParam(':makh', $makh);

        if ($stmt->execute()) {
            echo "Đặt bàn thành công!";
        } else {
            echo "Có lỗi xảy ra khi đặt bàn.";
        }
    }
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>

<h1>Manage Menu</h1>
<form method="POST">
    <h2>Thông tin khách hàng</h2>
    Tên khách hàng: <input type="text" name="tenkh" required><br>
    Email: <input type="email" name="email" required><br>
    Số điện thoại: <input type="text" name="sdt"><br>

    <h2>Thông tin đặt bàn</h2>
    Ngày đặt bàn: <input type="date" name="ngaydatban" required><br>
    Giờ đặt bàn: <input type="time" name="giodatban" required><br>
    Số người: <input type="number" name="songuoi" required><br>
    Ghi chú: <input type="varchar" name="ghichu"><br> 
    Mã món: <input type="number" name="ma_mon" required><br>
    Mã bàn: <input type="number" name="ma_ban" required><br>
    
    <button type="submit">Đặt Bàn</button>
</form>
