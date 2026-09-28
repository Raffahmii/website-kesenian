import './bootstrap';

import Alpine from 'alpinejs';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Swal from 'sweetalert2';

// ═══════════════════════════════════════
// Alpine.js
// ═══════════════════════════════════════
window.Alpine = Alpine;
Alpine.start();

// ═══════════════════════════════════════
// AOS — Animate On Scroll
// ═══════════════════════════════════════
AOS.init({
    duration: 800,
    easing: 'ease-out-cubic',
    once: true,
    offset: 80,
});

// ═══════════════════════════════════════
// SweetAlert2 — global helper
// ═══════════════════════════════════════
window.Swal = Swal;

window.toast = (icon, title) => {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: '#3B3F46',
        color: '#FFFFFF',
    });
};

window.confirmDelete = (callback) => {
    Swal.fire({
        title: 'Yakin hapus?',
        text: 'Data yang dihapus tidak bisa dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#F5B301',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        background: '#3B3F46',
        color: '#FFFFFF',
    }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') callback();
    });
};