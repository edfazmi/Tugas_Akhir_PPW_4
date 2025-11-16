<?php
$page_title = 'Tambah Kontak Baru';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/functions.php';

force_login();

$user_id = get_current_user_id();
$errors = [];
$input = ['nama' => '', 'email' => '', 'telepon' => '', 'alamat' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input['nama'] = trim($_POST['nama'] ?? '');
    $input['email'] = trim($_POST['email'] ?? '');
    $input['telepon'] = trim($_POST['telepon'] ?? '');
    $input['alamat'] = trim($_POST['alamat'] ?? '');

    if (empty($input['nama'])) {
        $errors[] = 'Nama wajib diisi.';
    }
    if (empty($input['telepon'])) {
        $errors[] = 'Telepon wajib diisi.';
    }
    if (!empty($input['email']) && !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    }
    
    if (empty($errors)) {
        $new_contact_data = [
            'nama' => $input['nama'],
            'email' => $input['email'],
            'telepon' => $input['telepon'],
            'alamat' => $input['alamat'],
        ];
        add_contact($user_id, $new_contact_data);

        $_SESSION['notification'] = 'Kontak baru berhasil ditambahkan!';
        header('Location: index.php');
        exit;
    }
}
?>

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Kontak Baru</h1>

    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" role="alert">
            <p class="font-bold">Gagal menambahkan kontak!</p>
            <ul class="mt-2 list-disc list-inside">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="tambah.php" method="POST">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama <span class="text-red-500">*</span></label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($input['nama']); ?>" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($input['email']); ?>"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">Telepon <span class="text-red-500">*</span></label>
                <input type="tel" id="telepon" name="telepon" value="<?php echo htmlspecialchars($input['telepon']); ?>" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="md:col-span-2">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo htmlspecialchars($input['alamat']); ?></textarea>
            </div>
        </div>
        
        <div class="mt-8 flex justify-end gap-4">
            <a href="index.php"
               class="py-2 px-4 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-100 transition duration-300">
                Batal
            </a>
            <button type="submit"
                    class="py-2 px-4 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition duration-300">
                Simpan Kontak
            </button>
        </div>
    </form>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>