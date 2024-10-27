<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

echo "Quản Lý Nhà Hàng";
?>
<ul>
    <li><a href="manage_menu.php">Manage Menu</a></li>
    <li><a href="manage_reservations.php">Manage Reservations</a></li>
</ul>
<a href="logout.php">Logout</a>
