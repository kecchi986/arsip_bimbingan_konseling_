// Script untuk menghapus semua data layanan dari tabel services
const sqlite3 = require('sqlite3').verbose();
const db = new sqlite3.Database('./server/database.sqlite');

db.run('DELETE FROM services', function(err) {
  if (err) throw err;
  console.log('Semua data layanan berhasil dihapus.');
  db.close();
}); 