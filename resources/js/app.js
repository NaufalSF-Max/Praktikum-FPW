import './bootstrap';

import Alpine from 'alpinejs';

import html2canvas from 'html2canvas';
window.html2canvas = html2canvas; // Agar bisa diakses global

window.Alpine = Alpine;

Alpine.start();
