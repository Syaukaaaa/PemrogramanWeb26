<?php
$page_title = "Tambah Anggota";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section>
            <h2>Tambah Anggota</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_tambah.php">
                <label for="no_anggota">No. Anggota</label>
                <input type="text" id="no_anggota" name="no_anggota" placeholder="Contoh: A005" required>

                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" placeholder="Nama anggota" required>

                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" placeholder="Contoh: Malang">

                <label for="no_hp">No. HP</label>
                <input type="tel" id="no_hp" name="no_hp" placeholder="Contoh: 08123456789">

                <button type="submit">Simpan</button>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>