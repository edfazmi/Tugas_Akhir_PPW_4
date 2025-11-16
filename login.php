<?php
$page_title = 'Login - EdfaContact';
require_once __DIR__ . '/includes/header.php';

if (is_logged_in()) {
    header('Location: index.php');
    exit;
}

$error_message = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error_message = 'Username dan password tidak boleh kosong.';
    } else {
        if (login_user($username, $password)) {
            header('Location: index.php');
            exit;
        } else {
            $error_message = 'Username atau password salah.';
        }
    }
}
?>

<div class="flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Login EdfaContact</h1>

        <?php if ($error_message): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Login
                </button>
            </div>
        </form>
        
        <p class="text-center text-gray-500 mt-6 text-sm">
            Gunakan akun dummy: <br> User: <span class="font-medium text-gray-700">edfa</span> / Pass: <span class="font-medium text-gray-700">admin123</span>
        </p>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>