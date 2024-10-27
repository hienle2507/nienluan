<?php
// Kết nối đến cơ sở dữ liệu
include 'database.php';


try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Kiểm tra nếu biểu mẫu đã được gửi
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = $_POST['username'];
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu
        $role = $_POST['role'];

        // Câu lệnh INSERT
        $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $user);
        $stmt->bindParam(':password', $pass);
        $stmt->bindParam(':role', $role);

        // Thực thi
        if ($stmt->execute()) {
            echo "User added successfully!";
        } else {
            echo "Error adding user.";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Đóng kết nối
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
</head>
<body>
    <h2>Add New User</h2>
    <form action="" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="role">Role:</label><br>
        <select id="role" name="role" required>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
        </select><br><br>

        <input type="submit" value="Add User">
    </form>
</body>
</html>
