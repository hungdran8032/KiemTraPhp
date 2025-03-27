<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        header("Location: index.php");
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không đúng!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome cho icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 transform transition-all hover:shadow-2xl">
        <!-- Logo hoặc tiêu đề -->
        <div class="flex justify-center mb-6">
            <i class="fas fa-lock text-blue-600 text-3xl"></i>
        </div>
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-2">Đăng nhập</h2>
        <p class="text-gray-600 text-center mb-8">Vui lòng nhập thông tin của bạn</p>

        <!-- Thông báo lỗi -->
        <?php if (isset($error)): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg animate-fade-in">
                <p><i class="fas fa-exclamation-circle mr-2"></i><?php echo $error; ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div class="relative">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Tên đăng nhập</label>
                <div class="absolute inset-y-0 left-0 top-6 flex items-center pl-3">
                    <i class="fas fa-user text-gray-400"></i>
                </div>
                <input type="text" 
                       class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                       name="username" 
                       placeholder="Nhập tên đăng nhập" 
                       required>
            </div>

            <div class="relative">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                <div class="absolute inset-y-0 left-0 top-6 flex items-center pl-3">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <input type="password" 
                       class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                       name="password" 
                       placeholder="Nhập mật khẩu" 
                       required>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <span class="ml-2 text-sm text-gray-600">Ghi nhớ tôi</span>
                </label>
                <a href="#" class="text-sm text-blue-600 hover:underline">Quên mật khẩu?</a>
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300">
                Đăng nhập
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            Chưa có tài khoản? 
            <a href="#" class="text-blue-600 hover:underline">Đăng ký ngay</a>
        </p>
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
</body>

</html>