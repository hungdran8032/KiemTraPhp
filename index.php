<?php
    session_start();
    include 'db.php';

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    $limit = 5;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $limit;

    $sql = "SELECT n.*, p.Ten_Phong FROM NHANVIEN n JOIN PHONGBAN p ON n.Ma_Phong = p.Ma_Phong LIMIT $start, $limit";
    $result = mysqli_query($conn, $sql);

    $total_sql = "SELECT COUNT(*) as total FROM NHANVIEN";
    $total_result = mysqli_query($conn, $total_sql);
    $total_row = mysqli_fetch_assoc($total_result);
    $total_pages = ceil($total_row['total'] / $limit);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin nhân viên</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-gray-900 shadow-lg">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <!-- Logo/Brand -->
                <div class="flex items-center space-x-3">
                    <i class="fas fa-users text-blue-500 text-2xl"></i>
                    <a href="#" class="text-white text-xl font-bold hover:text-blue-400 transition-colors">
                        Quản lý nhân viên
                    </a>
                </div>

                <!-- User Info & Logout -->
                <div class="flex items-center space-x-4">
                    <div class="hidden md:flex items-center text-white">
                        <i class="fas fa-user-circle mr-2"></i>
                        <span class="text-sm"><?php echo $_SESSION['username']; ?></span>
                        <span class="mx-2">|</span>
                        <span class="text-sm capitalize"><?php echo $_SESSION['role']; ?></span>
                    </div>
                    <a href="logout.php" 
                       class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        <span>Đăng xuất</span>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="menu-toggle" class="md:hidden text-white focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden hidden mt-4 pb-4">
                <div class="flex flex-col space-y-2">
                    <div class="text-white flex items-center">
                        <i class="fas fa-user-circle mr-2"></i>
                        <span><?php echo $_SESSION['username']; ?> (<?php echo $_SESSION['role']; ?>)</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-8 px-4">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">THÔNG TIN NHÂN VIÊN</h2>

       <?php if ($_SESSION['role'] == 'admin') { ?>
            <a href="add.php" 
               class="inline-flex items-center justify-center w-full md:w-auto bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:from-blue-700 hover:to-blue-800 transition-all duration-300 transform hover:-translate-y-1 mb-6">
                <i class="fas fa-user-plus mr-2"></i>
                <span>Thêm nhân viên mới</span>
            </a>
        <?php } ?>

        <!-- Table -->
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4">Mã NV</th>
                        <th class="py-3 px-4">Tên NV</th>
                        <th class="py-3 px-4">Giới tính</th>
                        <th class="py-3 px-4 hidden md:table-cell">Nơi Sinh</th>
                        <th class="py-3 px-4">Tên Phòng</th>
                        <th class="py-3 px-4 hidden md:table-cell">Lương</th>
                        <th class="py-3 px-4 <?php echo ($_SESSION['role'] == 'admin') ? '' : 'hidden'; ?>">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4"><?php echo $row['Ma_NV']; ?></td>
                            <td class="py-3 px-4"><?php echo $row['Ten_NV']; ?></td>
                            <td class="py-3 px-4">
                                <?php echo ($row['Phai'] == 'NU') ? 
                                    '<img src="asset/woman.png" alt="Nữ" class="w-8 h-8">' : 
                                    '<img src="asset/man.png" alt="Nam" class="w-8 h-8">'; ?>
                            </td>
                            <td class="py-3 px-4 hidden md:table-cell"><?php echo $row['Noi_Sinh']; ?></td>
                            <td class="py-3 px-4"><?php echo $row['Ten_Phong']; ?></td>
                            <td class="py-3 px-4 hidden md:table-cell"><?php echo number_format($row['Luong'], 0, ',', '.'); ?></td>
                            <td class="py-3 px-4 <?php echo ($_SESSION['role'] == 'admin') ? '' : 'hidden'; ?>">
                                <div class="flex space-x-2">
                                    <a href="edit.php?id=<?php echo $row['Ma_NV']; ?>" 
                                       class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition-colors">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <a href="delete.php?id=<?php echo $row['Ma_NV']; ?>" 
                                       class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition-colors"
                                       onclick="return confirm('Xác nhận xóa?')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center flex-wrap gap-2">
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <a href="index.php?page=<?php echo $i; ?>" 
                   class="px-4 py-2 border rounded <?php echo ($i == $page) ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 hover:bg-blue-50'; ?> transition-colors">
                    <?php echo $i; ?>
                </a>
            <?php } ?>
        </div>
    </div>

    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>