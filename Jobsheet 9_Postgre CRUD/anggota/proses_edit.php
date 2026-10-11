<?php
require __DIR__ . '/../includes/koneksi.php';
session_start();

$id         = (int) ($_POST['id'] ?? 0);
$no_anggota = trim($_POST['no_anggota'] ?? '');
$nama       = trim($_POST['nama'] ?? '');
$alamat     = trim($_POST['alamat'] ?? '');
$no_hp      = trim($_POST['no_hp'] ?? '');

if ($id <= 0) {
    header('Location: list.php');
    exit;
}

$errors = [];
if ($no_anggota === '') {
    $errors[] = "No. Anggota wajib diisi.";
} elseif (!preg_match('/^A[0-9]{3}$/', $no_anggota)) {
    $errors[] = "Format No. Anggota harus huruf A diikuti 3 angka (contoh: A005).";
}
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($no_hp !== '' && !preg_match('/^[0-9]{10,13}$/', $no_hp)) {
    $errors[] = "No. HP harus 10-13 digit angka.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

try {
    $stmt = $pdo->prepare(
        "UPDATE anggota SET no_anggota = :no_anggota, nama = :nama,
         alamat = :alamat, no_hp = :no_hp WHERE id = :id"
    );
    $stmt->execute([
        'no_anggota' => $no_anggota,
        'nama'       => $nama,
        'alamat'     => $alamat,
        'no_hp'      => $no_hp,
        'id'         => $id,
    ]);
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'No. Anggota sudah dipakai anggota lain.'];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil diperbarui.'];
header('Location: list.php');
exit;