<?php
session_start();
include 'db.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ma_nv = $_POST['Ma_NV'];
    $ten_nv = $_POST['Ten_NV'];
    $phai = $_POST['Phai'];
    $noi_sinh = $_POST['Noi_Sinh'];
    $ma_phong = $_POST['Ma_Phong'];
    $luong = $_POST['Luong'];

    $sql = "INSERT INTO NHANVIEN (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) 
            VALUES ('$ma_nv', '$ten_nv', '$phai', '$noi_sinh', '$ma_phong', '$luong')";

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
    <title>Thêm nhân viên</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-lg w-full bg-white rounded-2xl shadow-xl p-8 transform transition-all hover:shadow-2xl">
        <!-- Header -->
        <div class="flex justify-center mb-6">
            <i class="fas fa-user-plus text-blue-600 text-3xl"></i>
        </div>
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-2">THÊM NHÂN VIÊN</h2>
        <p class="text-gray-600 text-center mb-8">Nhập thông tin nhân viên mới</p>

        <!-- Error Message -->
        <?php if (isset($error)): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg animate-fade-in">
                <p><i class="fas fa-exclamation-circle mr-2"></i><?php echo $error; ?></p>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST" class="space-y-6" id="addEmployeeForm">
            <div class="relative">
                <label for="Ma_NV" class="block text-sm font-medium text-gray-700 mb-1">Mã NV</label>
                <div class="absolute inset-y-0 left-0 top-6 flex items-center pl-3">
                    <i class="fas fa-id-badge text-gray-400"></i>
                </div>
                <input type="text" 
                       name="Ma_NV" 
                       placeholder="Nhập mã nhân viên" 
                       required
                       class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>

            <div class="relative">
                <label for="Ten_NV" class="block text-sm font-medium text-gray-700 mb-1">Tên NV</label>
                <div class="absolute inset-y-0 left-0 top-6 flex items-center pl-3">
                    <i class="fas fa-user text-gray-400"></i>
                </div>
                <input type="text" 
                       name="Ten_NV" 
                       placeholder="Nhập tên nhân viên" 
                       required
                       class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>

            <div>
                <label for="Phai" class="block text-sm font-medium text-gray-700 mb-1">Giới tính</label>
                <select name="Phai" 
                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <option value="NAM">Nam</option>
                    <option value="NU">Nữ</option>
                </select>
            </div>

            <div class="relative">
                <label for="Noi_Sinh" class="block text-sm font-medium text-gray-700 mb-1">Nơi sinh</label>
                <div class="absolute inset-y-0 left-0 top-6 flex items-center pl-3">
                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                </div>
                <input type="text" 
                       name="Noi_Sinh" 
                       placeholder="Nhập nơi sinh" 
                       required
                       class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>

            <div>
                <label for="Ma_Phong" class="block text-sm font-medium text-gray-700 mb-1">Phòng ban</label>
                <select name="Ma_Phong" 
                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <?php
                    $phongban_sql = "SELECT * FROM PHONGBAN";
                    $phongban_result = mysqli_query($conn, $phongban_sql);
                    while ($phong = mysqli_fetch_assoc($phongban_result)) {
                        echo "<option value='" . $phong['Ma_Phong'] . "'>" . $phong['Ten_Phong'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="relative">
                <label for="Luong" class="block text-sm font-medium text-gray-700 mb-1">Lương</label>
                <div class="absolute inset-y-0 left-0 top-6 flex items-center pl-3">
                    <i class="fas fa-money-bill-wave text-gray-400"></i>
                </div>
                <input type="number" 
                       name="Luong" 
                       placeholder="Nhập lương" 
                       required
                       min="0"
                       class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>

            <div class="flex space-x-4">
                <button type="submit" 
                        class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i>Thêm
                    <i class="fas fa-spinner fa-spin ml-2 hidden" id="spinner"></i>
                </button>
                <a href="index.php" 
                   class="flex-1 bg-gray-500 text-white py-3 rounded-lg hover:bg-gray-600 text-center transition-all flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i>Quay lại
                </a>
            </div>
        </form>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>

    <script>
        const form = document.getElementById('addEmployeeForm');
        const submitBtn = form.querySelector('button[type="submit"]');
        const spinner = document.getElementById('spinner');

        form.addEventListener('submit', function(e) {
            const luong = form.querySelector('[name="Luong"]').value;
            if (luong < 0) {
                e.preventDefault();
                alert('Lương không thể là số âm!');
                return;
            }

            submitBtn.disabled = true;
            spinner.classList.remove('hidden');
        });
    </script>
</body>

</html>