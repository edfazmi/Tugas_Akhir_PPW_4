<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'EdfaContact'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <a href="index.php" class="flex-shrink-0 flex items-center text-2xl font-bold text-blue-600">
                        EdfaContact
                    </a>
                </div>
                <div class="flex items-center">
                    <?php if (is_logged_in()): ?>
                        <span class="text-gray-700 mr-4">
                            Halo, <span class="font-medium"><?php echo htmlspecialchars(get_current_user_id()); ?></span>
                        </span>
                        <a href="tambah.php" class="mr-4 px-3 py-2 rounded-md text-sm font-medium text-white bg-green-500 hover:bg-green-600 transition duration-300">
                            + Tambah Kontak
                        </a>
                        <a href="logout.php" class="px-3 py-2 rounded-md text-sm font-medium text-red-600 hover:bg-red-100 transition duration-300">
                            Logout
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="mr-4 px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200 transition duration-300">
                            Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-10 flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">