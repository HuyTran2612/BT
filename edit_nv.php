<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    echo "Bạn không có quyền truy cập!";
    exit();
}
?>
