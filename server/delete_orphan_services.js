// Script untuk menghapus layanan orphan dari database
const sqlite3 = require('sqlite3').verbose();
const db = new sqlite3.Database('./server/database.sqlite');

db.serialize(() => {
  db.all(`SELECT id FROM services`, (err, rows) => {
    if (err) throw err;
    const validIds = rows.map(r => r.id);
    db.all(`SELECT id, name, parent_id FROM services WHERE parent_id IS NOT NULL`, (err2, services) => {
      if (err2) throw err2;
      const orphanIds = services.filter(s => !validIds.includes(s.parent_id)).map(s => s.id);
      if (orphanIds.length === 0) {
        console.log('Tidak ada layanan orphan yang perlu dihapus.');
        db.close();
        return;
      }
      db.run(`DELETE FROM services WHERE id IN (${orphanIds.map(() => '?').join(',')})`, orphanIds, function(err3) {
        if (err3) throw err3;
        console.log(`Berhasil menghapus ${this.changes} layanan orphan.`);
        db.close();
      });
    });
  });
}); 