<?php
session_start();
include 'db.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM NHANVIEN WHERE Ma_NV='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ma_nv = $_POST['Ma_NV'];
    $ten_nv = $_POST['Ten_NV'];
    $phai = $_POST['Phai'];
    $noi_sinh = $_POST['Noi_Sinh'];
    $ma_phong = $_POST['Ma_Phong'];
    $luong = $_POST['Luong'];

    $sql = "UPDATE NHANVIEN SET Ten_NV='$ten_nv', Phai='$phai', Noi_Sinh='$noi_sinh', 
            Ma_Phong='$ma_phong', Luong='$luong' WHERE Ma_NV='$ma_nv'";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
    } else {
        $error = "Lỗi: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa nhân viên</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-lg w-full bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">SỬA NHÂN VIÊN</h2>
        <p class="text-gray-600 text-center mb-6">Cập nhật thông tin nhân viên</p>

        <?php if (isset($error)): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg">
                <p><i class="fas fa-exclamation-circle mr-2"></i><?php echo $error; ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
            <div>
                <label for="Ma_NV" class="block text-sm font-medium text-gray-700">Mã NV</label>
                <input type="text" 
                       name="Ma_NV" 
                       value="<?php echo $row['Ma_NV']; ?>" 
                       readonly
                       class="mt-1 w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none">
            </div>

            <div>
                <label for="Ten_NV" class="block text-sm font-medium text-gray-700">Tên NV</label>
                <input type="text" 
                       name="Ten_NV" 
                       value="<?php echo $row['Ten_NV']; ?>" 
                       required
                       class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label for="Phai" class="block text-sm font-medium text-gray-700">Giới tính</label>
                <select name="Phai" 
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="NAM" <?php echo ($row['Phai'] == 'NAM') ? 'selected' : ''; ?>>Nam</option>
                    <option value="NU" <?php echo ($row['Phai'] == 'NU') ? 'selected' : ''; ?>>Nữ</option>
                </select>
            </div>

            <div>
                <label for="Noi_Sinh" class="block text-sm font-medium text-gray-700">Nơi sinh</label>
                <input type="text" 
                       name="Noi_Sinh" 
                       value="<?php echo $row['Noi_Sinh']; ?>" 
                       required
                       class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label for="Ma_Phong" class="block text-sm font-medium text-gray-700">Phòng ban</label>
                <select name="Ma_Phong" 
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <?php
                    $phongban_sql = "SELECT * FROM PHONGBAN";
                    $phongban_result = mysqli_query($conn, $phongban_sql);
                    while ($phong = mysqli_fetch_assoc($phongban_result)) {
                        $selected = ($row['Ma_Phong'] == $phong['Ma_Phong']) ? 'selected' : '';
                        echo "<option value='" . $phong['Ma_Phong'] . "' $selected>" . $phong['Ten_Phong'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="Luong" class="block text-sm font-medium text-gray-700">Lương</label>
                <input type="number" 
                       name="Luong" 
                       value="<?php echo $row['Luong']; ?>" 
                       required
                       class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="flex space-x-4">
                <button type="submit" 
                        class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-save mr-2"></i>Cập nhật
                </button>
                <a href="index.php" 
                   class="flex-1 bg-gray-500 text-white py-3 rounded-lg hover:bg-gray-600 text-center transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Quay lại
                </a>
            </div>
        </form>
    </div>
</body>

</html>