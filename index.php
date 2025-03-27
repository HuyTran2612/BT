<?php
include 'db_connect.php';

session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Lấy thông tin người dùng từ session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$user_role = $_SESSION['role']; // Lưu role khi đăng nhập

// Phân trang
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;
$total_records = $conn->query("SELECT COUNT(*) AS total FROM NhanVien")->fetch_assoc()['total'];
$total_pages = ceil($total_records / $limit);

// Lấy danh sách nhân viên
$sql = "SELECT * FROM NhanVien LIMIT $start, $limit";
$result = $conn->query($sql);

// Xóa nhân viên (chỉ Admin mới có thể xóa)
if (isset($_GET['delete_id']) && $user_role == 'Admin') {
    $id = $_GET['delete_id'];
    $conn->query("DELETE FROM NhanVien WHERE MaNV='$id'");
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Nhân viên</title>
    <link rel="stylesheet" href="style.css">
<!-- 
    <style>
        table { width: 80%; margin: auto; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 10px; text-align: center; }
        img { width: 50px; height: 50px; }
        .pagination { text-align: center; margin-top: 20px; }
        .pagination a { padding: 5px 10px; margin: 5px; text-decoration: none; border: 1px solid black; }
        .pagination a.active { font-weight: bold; background-color: #ddd; }
        .btn { padding: 5px 10px; text-decoration: none; margin: 2px; border: 1px solid; display: inline-block; }
        .btn-delete { color: red; }
        .btn-edit { color: blue; }
    </style> -->
</head>
<body>
<?php if (isset($_SESSION['username'])): ?>
    <a href="logout.php">Đăng xuất (<?= $_SESSION['username'] ?>)</a>
<?php endif; ?>

<h2 style="text-align: center;">Danh sách Nhân viên</h2>

<?php if ($user_role == 'Admin'): ?>
    <a href="add.php" class="btn">➕ Thêm Nhân viên</a>
<?php endif; ?>

<table>
    <tr>
        <th>Mã NV</th>
        <th>Tên NV</th>
        <th>Phái</th>
        <th>Nơi Sinh</th>
        <th>Mã Phòng</th>
        <th>Lương</th>
        <?php if ($user_role == 'Admin'): ?>
            <th>Hành động</th>
        <?php endif; ?>
    </tr>
    
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['MaNV'] ?></td>
        <td><?= $row['TenNV'] ?></td>
        <td>
            <img src="<?= $row['Phai'] == 'Nữ' ? 'woman.jpg' : 'man.jpg' ?>" alt="Giới tính">
        </td>
        <td><?= $row['NoiSinh'] ?></td>
        <td><?= $row['MaPhong'] ?></td>
        <td><?= number_format($row['Luong']) ?> VND</td>
        <?php if ($user_role == 'Admin'): ?>
        <td>
            <a href="edit.php?id=<?= $row['MaNV'] ?>" class="btn btn-edit">✏️ Sửa</a>
            <a href="?delete_id=<?= $row['MaNV'] ?>" class="btn btn-delete" onclick="return confirm('Xóa nhân viên này?')">🗑️ Xóa</a>
        </td>
        <?php endif; ?>
    </tr>
    <?php endwhile; ?>
</table>

<div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>
