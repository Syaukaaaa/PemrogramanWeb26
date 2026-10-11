<?php
require __DIR__ . '/../includes/koneksi.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = (int) ($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    header('Location: list.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$page_title = "Edit Buku";
include __DIR__ . '/../includes/header.php';
?>
        <section>
            <h2>Edit Buku</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>
            <form id="form-tambah" class="form-edit" method="post" action="proses_edit.php">
            <form id="form-tambah" method="post" action="proses_edit.php">
                <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">

                <label for="judul">Judul Buku</label>
                <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($buku['judul']); ?>" required>

                <label for="pengarang">Pengarang</label>
                <input type="text" id="pengarang" name="pengarang" value="<?php echo htmlspecialchars($buku['pengarang']); ?>" required>

                <label for="tahun">Tahun Terbit</label>
                <input type="number" id="tahun" name="tahun" min="1900" max="2026" value="<?php echo $buku['tahun']; ?>" required>

                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($buku['isbn'] ?? ''); ?>">

                <label for="stok">Stok</label>
                <input type="number" id="stok" name="stok" min="0" value="<?php echo $buku['stok']; ?>" required>

                <label for="kategori">Kategori</label>
                <input type="text" id="kategori" name="kategori" value="<?php echo htmlspecialchars($buku['kategori'] ?? ''); ?>">

                <button type="submit">Simpan Perubahan</button>
                <a href="list.php">Batal</a>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>