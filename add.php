<?php
include 'db_connect.php';
// Lấy danh sách mã phòng từ database
$sqlPhong = "SELECT MaPhong, TenPhong FROM PhongBan";
$resultPhong = $conn->query($sqlPhong);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaNV = $_POST['MaNV'];
    $TenNV = $_POST['TenNV'];
    $Phai = $_POST['Phai'];
    $NoiSinh = $_POST['NoiSinh'];
    $MaPhong = $_POST['MaPhong'];
    $Luong = $_POST['Luong'];

    $sql = "INSERT INTO NhanVien (MaNV, TenNV, Phai, NoiSinh, MaPhong, Luong) VALUES ('$MaNV', '$TenNV', '$Phai', '$NoiSinh', '$MaPhong', '$Luong')";
    
    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "<p class='error'>Lỗi: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Nhân viên</title>

    <link rel="stylesheet" href="style.css">


      
</head>
<body>
<div class="container">
    <h2>Thêm Nhân viên</h2>
    <form method="POST">
        <label>Mã NV:</label>
        <input type="text" name="MaNV" required>
        
        <label>Tên NV:</label>
        <input type="text" name="TenNV" required>
        
        <label>Phái:</label>
        <select name="Phai">
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select>
        
        <label>Nơi Sinh:</label>
        <input type="text" name="NoiSinh" required>
        
        <label>Mã Phòng:</label>
        <select name="MaPhong" required>
            <option value="">-- Chọn phòng ban --</option>
            <?php while ($row = $resultPhong->fetch_assoc()) { ?>
                <option value="<?php echo $row['MaPhong']; ?>">
                    <?php echo $row['TenPhong']; ?>
                </option>
            <?php } ?>
        </select>
        
        <label>Lương:</label>
        <input type="number" name="Luong" required>
        
        <button type="submit">Thêm</button>
    </form>
</div>
</body>
</html>
