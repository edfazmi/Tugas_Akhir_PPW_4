<?php
$page_title = 'Edit Kontak';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/functions.php';

force_login();

$user_id = get_current_user_id();
$contact_id = $_GET['id'] ?? null;
$errors = [];
$contact = null;
if (!$contact_id) {
    header('Location: index.php');
    exit;
}

$contact = get_contact_by_id($user_id, $contact_id); 

if (!$contact) {
    $_SESSION['notification'] = 'Error: Kontak tidak ditemukan.';
    header('Location: index.php');
    exit;
}

$input = $contact;

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
        $updated_data = [
            'nama' => $input['nama'],
            'email' => $input['email'],
            'telepon' => $input['telepon'],
            'alamat' => $input['alamat'],
        ];
        update_contact($user_id, $contact_id, $updated_data); // Fungsi ini sekarang menyimpan ke session
        
        $_SESSION['notification'] = 'Kontak berhasil diperbarui!';
        header('Location: index.php');
        exit;
    }
}
?>

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Kontak</h1>

    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4" role="alert">
            <p class="font-bold">Gagal memperbarui kontak!</p>
            <ul class="mt-2 list-disc list-inside">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="edit.php?id=<?php echo htmlspecialchars($contact_id); ?>" method="POST">
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
                    class="py-2 px-4 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                Update Kontak
            </button>
        </div>
    </form>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>