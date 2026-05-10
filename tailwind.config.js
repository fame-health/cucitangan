import preset from './vendor/filament/support/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php', // WAJIB ada agar komponen Filament tidak berantakan
    ],
    // Hapus atau kosongkan theme jika sudah menggunakan preset Filament
}
