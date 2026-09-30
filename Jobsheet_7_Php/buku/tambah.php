<?php
$page_title = "Tambah Buku";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
        <section>
            <h2>Tambah Buku</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_tambah.php">
                <label for="judul">Judul Buku</label>
                <input type="text" id="judul" name="judul" placeholder="Contoh: Laskar Pelangi" required>

                <label for="pengarang">Pengarang</label>
                <input type="text" id="pengarang" name="pengarang" placeholder="Contoh: Andrea Hirata" required>

                <label for="tahun">Tahun Terbit</label>
                <input type="number" id="tahun" name="tahun" min="1900" max="2026" placeholder="Contoh: 2005" required>

                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn" placeholder="Contoh: 978-602-1234-56-7">

                <label for="stok">Stok</label>
                <input type="number" id="stok" name="stok" min="0" placeholder="Contoh: 4" required>

                <label for="kategori">Kategori</label>
                <input type="text" id="kategori" name="kategori" placeholder="Contoh: Novel">

                <button type="submit">Simpan</button>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>