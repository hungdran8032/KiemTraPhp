<?php
    session_start();
    include 'db.php';

    if ($_SESSION['role'] != 'admin') {
        header("Location: index.php");
        exit();
    }

    $id = $_GET['id'];
    $sql = "DELETE FROM NHANVIEN WHERE Ma_NV='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
?>
