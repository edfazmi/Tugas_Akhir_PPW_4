<?php
$page_title = 'Hapus Kontak';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/functions.php';

force_login();

$user_id = get_current_user_id();
$contact_id = $_GET['id'] ?? null;
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm_delete'])) {
        delete_contact($user_id, $contact_id); 
        $_SESSION['notification'] = 'Kontak berhasil dihapus.';
        header('Location: index.php');
        exit;
    }
}
?>

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg mx-auto">
    <h1 class="text-3xl font-bold text-center text-red-600 mb-6">Konfirmasi Hapus Kontak</h1>

    <div class="text-center">
        <svg class="mx-auto h-16 w-16 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <p class="text-lg text-gray-700 mt-4">
            Anda yakin ingin menghapus kontak ini?
        </p>

        <div class="my-4 p-4 bg-gray-100 rounded-lg text-left inline-block">
            <p><strong>Nama:</strong> <?php echo htmlspecialchars($contact['nama']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($contact['email']); ?></p>
            <p><strong>Telepon:</strong> <?php echo htmlspecialchars($contact['telepon']); ?></p>
        </div>
        
        <p class="text-gray-600">Tindakan ini akan permanen (sampai Anda logout).</p>
        
        <form action="hapus.php?id=<?php echo htmlspecialchars($contact_id); ?>" method="POST" class="mt-8 flex justify-center gap-4">
            <input type="hidden" name="confirm_delete" value="1">
            <a href="index.php"
               class="py-2 px-6 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-100 transition duration-300">
                Batal
            </a>
            <button type="submit"
                    class="py-2 px-6 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition duration-300">
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>