module.exports = {
  plugins: [
    require('autoprefixer'), // Ini biasanya sudah ada, penting untuk kompatibilitas browser
    require('postcss-purgecss')({
      content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
      ],
      defaultExtractor: content => {
        // Hapus karakter khusus dan ekstrak kelas CSS
        return content.match(/[\w-/:]+(?<!:)/g) || [];
      },
      safelist: [ // Opsional: Tambahkan kelas yang tidak boleh dihapus PurgeCSS
        // Contoh: kelas yang ditambahkan via JavaScript atau dari pustaka pihak ketiga
        'show', // untuk dropdown seperti notifikasi atau user menu
        'open', // untuk user dropdown
        'active', // untuk navigasi aktif, filter button aktif, thumbnail aktif
        'completed', // untuk step stepper completed
        'processing', 'success', 'warning', 'info', 'pending', 'rejected', // untuk status badge
        // Tambahkan kelas CSS lain yang mungkin dinamis atau tidak langsung terlihat di HTML
        // Contoh: kelas dari library JS, kelas untuk transisi animasi, dll.
      ]
    })
  ]
}