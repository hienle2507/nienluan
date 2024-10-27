<?php
session_start();
include 'database.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Chỉ định biến $menu_items để lấy dữ liệu menu
$menu_items = []; // Khởi tạo mảng để lưu các món ăn

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_loai = $_POST['ma_loai'];
    $tenmon = $_POST['tenmon'];
    $giamon = $_POST['giamon'];
    $mota = $_POST['mota'];
    $trangthai = $_POST['trangthai'];
    
    // Câu lệnh SQL
    $sql = "INSERT INTO monan (tenmon, giamon, mota, trangthai, ma_loai) 
                        VALUES (:tenmon, :giamon, :mota, :trangthai, :ma_loai)";
    
    // Chuẩn bị câu lệnh
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tenmon', $tenmon);
    $stmt->bindParam(':giamon', $giamon);
    $stmt->bindParam(':mota', $mota);
    $stmt->bindParam(':trangthai', $trangthai);
    $stmt->bindParam(':ma_loai', $ma_loai);

    // Thực hiện câu lệnh
    if ($stmt->execute()) {
        echo "<p>Item added successfully!</p>";
    } else {
        echo "<p>Error adding item.</p>";
    }
}

// Lấy danh sách món ăn hiện tại từ cơ sở dữ liệu
$menu_items = $conn->query("SELECT * FROM monan")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Manage Menu</h1>
<form method="POST">
    Name: <input type="text" name="tenmon" required><br>
    Price: <input type="number" step="0.01" name="giamon" required><br>
    Description: <textarea name="mota" required></textarea><br>
    Mã loại: <input type="int" name="ma_loai" required><br>
    <label for="trangthai">Trạng Thái:</label><br>
    <select id="trangthai" name="trangthai" required>
        <option value="Có sẵn">Có sẵn</option>
        <option value="Hết món">Hết món</option>
        <option value="Ngưng phục vụ">Ngưng phục vụ</option>
    </select><br><br>
    <button type="submit">Add Item</button>
</form>

<h2>Current Menu Items</h2>
<ul>
    <?php foreach ($menu_items as $item): ?>
        <li><?php echo htmlspecialchars($item['tenmon']) . ' - ' . number_format($item['giamon'], 2) . ' VNĐ'; ?></li>
    <?php endforeach; ?>
</ul>
<a href="dashboard.php">Back to Dashboard</a>
