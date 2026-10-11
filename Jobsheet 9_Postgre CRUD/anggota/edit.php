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

$stmt = $pdo->prepare("SELECT * FROM anggota WHERE id = :id");
$stmt->execute(['id' => $id]);
$anggota = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$anggota) {
    header('Location: list.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$page_title = "Edit Anggota";
include __DIR__ . '/../includes/header.php';


?>

        <section>
            <h2>Edit Anggota</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <form id="form-tambah" class="form-edit" method="post" action="proses_edit.php">
            <form id="form-tambah" method="post" action="proses_edit.php">
                <input type="hidden" name="id" value="<?php echo $anggota['id']; ?>">

                <label for="no_anggota">No. Anggota</label>
                <input type="text" id="no_anggota" name="no_anggota" value="<?php echo htmlspecialchars($anggota['no_anggota']); ?>" required>

                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($anggota['nama']); ?>" required>

                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" value="<?php echo htmlspecialchars($anggota['alamat'] ?? ''); ?>">

                <label for="no_hp">No. HP</label>
                <input type="tel" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($anggota['no_hp'] ?? ''); ?>">

                <button type="submit">Simpan Perubahan</button>
                <a href="list.php">Batal</a>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
