<?php
$page_title = 'Daftar Kontak';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/functions.php';

force_login();

$user_id = get_current_user_id();
$all_user_contacts = get_user_contacts($user_id); 
$contacts_to_display = $all_user_contacts;

$search_query = $_GET['q'] ?? '';
if (!empty($search_query)) {
    $contacts_to_display = [];
    foreach ($all_user_contacts as $contact) {
        if (
            stripos($contact['nama'], $search_query) !== false ||
            stripos($contact['email'], $search_query) !== false ||
            stripos($contact['telepon'], $search_query) !== false
        ) {
            $contacts_to_display[] = $contact;
        }
    }
}
?>

<div class="bg-white p-6 rounded-xl shadow-lg">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Kontak Anda</h1>
\
        <form action="index.php" method="GET" class="flex-1 max-w-sm">
            <div class="relative">
                <input type="search" name="q" value="<?php echo htmlspecialchars($search_query); ?>"
                       placeholder="Cari nama, email, atau telepon..."
                       class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </form>
    </div>

    <?php if (isset($_SESSION['notification'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
            <?php 
                echo htmlspecialchars($_SESSION['notification']);
                unset($_SESSION['notification']); 
            ?>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <?php if (empty($contacts_to_display)): ?>
            <div class="text-center py-10 px-6 bg-gray-50 rounded-lg">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">
                    <?php if (!empty($search_query)): ?>
                        Kontak tidak ditemukan
                    <?php else: ?>
                        Belum ada kontak
                    <?php endif; ?>
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    <?php if (!empty($search_query)): ?>
                        Coba kata kunci lain untuk mencari kontak.
                    <?php else: ?>
                        Mulai tambahkan kontak baru Anda.
                    <?php endif; ?>
                </p>
                <?php if (empty($search_query)): ?>
                <div class="mt-6">
                    <a href="tambah.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        + Tambah Kontak Baru
                    </a>
                </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($contacts_to_display as $contact): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($contact['nama']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600"><?php echo htmlspecialchars($contact['email']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600"><?php echo htmlspecialchars($contact['telepon']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo htmlspecialchars($contact['alamat'] ?? '-'); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="edit.php?id=<?php echo $contact['id']; ?>" class="text-white bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded-md text-xs">Edit</a>
                                <a href="hapus.php?id=<?php echo $contact['id']; ?>" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-xs">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>