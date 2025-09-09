import './bootstrap';
import Alpine from 'alpinejs';
import lucide from 'lucide-static';

window.Alpine = Alpine;
Alpine.start();

// aktifkan ikon setelah DOM ready
document.addEventListener("DOMContentLoaded", () => {
    lucide.createIcons();
});
