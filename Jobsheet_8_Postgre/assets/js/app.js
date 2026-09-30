// ===== Hamburger menu (JS-driven, menggantikan checkbox hack) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;
 
    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}
 
// ===== Konfirmasi hapus (front-end only, belum ke server) =====
// Memakai event delegation di document karena baris tabel sekarang
// dirender dinamis via fetch (lihat buku.js/anggota.js) sehingga
// tombol .btn-hapus belum tentu ada saat DOMContentLoaded.
function initHapusConfirm() {
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-hapus");
        if (!btn) return;
 
        const row = btn.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
        if (yakin && row) {
            row.remove();
        }
    });
}
 
// ===== Filter/pencarian tabel real-time =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;
 
    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}
 
// ===== Validasi form (client-side) =====
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}
 
function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}
 
function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;
 
    form.addEventListener("submit", function (e) {
        let valid = true;
 
        // Field wajib pertama: judul (form buku) atau nama (form anggota)
        const judul = form.querySelector("[name='judul'], [name='nama']");
        if (judul && judul.value.trim() === "") {
            tampilkanError(judul, "Field ini wajib diisi.");
            valid = false;
        } else if (judul) {
            hapusError(judul);
        }
 
        // Field wajib kedua: pengarang (form buku) atau no_anggota (form anggota)
        const pengarang = form.querySelector("[name='pengarang'], [name='no_anggota']");
        if (pengarang && pengarang.value.trim() === "") {
            tampilkanError(pengarang, "Field ini wajib diisi.");
            valid = false;
        } else if (pengarang) {
            hapusError(pengarang);
        }
 
        // Tahun terbit (form buku)
        const tahun = form.querySelector("[name='tahun']");
        if (tahun) {
            const nilai = parseInt(tahun.value, 10);
            if (isNaN(nilai) || nilai < 1900 || nilai > 2026) {
                tampilkanError(tahun, "Tahun harus di antara 1900-2026.");
                valid = false;
            } else {
                hapusError(tahun);
            }
        }
 
        // Stok (form buku)
        const stok = form.querySelector("[name='stok']");
        if (stok) {
            const nilaiStok = parseInt(stok.value, 10);
            if (isNaN(nilaiStok) || nilaiStok < 0) {
                tampilkanError(stok, "Stok harus berupa angka 0 atau lebih.");
                valid = false;
            } else {
                hapusError(stok);
            }
        }
 
        // Latihan 8.4 no. 1: ISBN (boleh kosong), kalau diisi hanya angka dan tanda hubung
        const isbn = form.querySelector("[name='isbn']");
        if (isbn) {
            if (isbn.value.trim() !== "" && !/^[0-9-]+$/.test(isbn.value.trim())) {
                tampilkanError(isbn, "ISBN hanya boleh berisi angka dan tanda hubung.");
                valid = false;
            } else {
                hapusError(isbn);
            }
        }
 
        // Email (form anggota, boleh kosong): pengganti cek bawaan type="email"
        // karena form memakai novalidate
        const email = form.querySelector("[name='email']");
        if (email) {
            if (email.value.trim() !== "" && !/^\S+@\S+\.\S+$/.test(email.value.trim())) {
                tampilkanError(email, "Format email tidak valid.");
                valid = false;
            } else {
                hapusError(email);
            }
        }
 
        if (!valid) {
            e.preventDefault();
        }
    });
}
 
document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});