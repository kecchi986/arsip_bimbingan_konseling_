const express = require('express');
const cors = require('cors');
const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const sqlite3 = require('sqlite3').verbose();
const helmet = require('helmet');
const rateLimit = require('express-rate-limit');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 5000;
const JWT_SECRET = process.env.JWT_SECRET || 'your-secret-key-change-in-production';

// Middleware
app.use(helmet());
app.use(cors());
app.use(express.json());

// Rate limiting
const limiter = rateLimit({
  windowMs: 15 * 60 * 1000, // 15 minutes
  max: 100 // limit each IP to 100 requests per windowMs
});
app.use(limiter);

// Database setup
const db = new sqlite3.Database('./database.sqlite', (err) => {
  if (err) {
    console.error('Error opening database:', err);
  } else {
    console.log('Connected to SQLite database');
    initializeDatabase();
  }
});

// Initialize database tables
function initializeDatabase() {
  db.serialize(() => {
    // Users table
    db.run(`CREATE TABLE IF NOT EXISTS users (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      email TEXT UNIQUE NOT NULL,
      password TEXT NOT NULL,
      name TEXT NOT NULL,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )`);

    // Students table
    db.run(`CREATE TABLE IF NOT EXISTS students (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      nis TEXT UNIQUE NOT NULL,
      name TEXT NOT NULL,
      grade TEXT NOT NULL,
      major TEXT NOT NULL,
      room TEXT NOT NULL,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )`);

    // Services table
    db.run(`CREATE TABLE IF NOT EXISTS services (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      name TEXT NOT NULL,
      parent_id INTEGER,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY (parent_id) REFERENCES services (id)
    )`);

    // Counseling records table
    db.run(`CREATE TABLE IF NOT EXISTS counseling_records (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      date TEXT NOT NULL,
      activity TEXT NOT NULL,
      location TEXT NOT NULL,
      description TEXT,
      notes TEXT,
      student_id INTEGER NOT NULL,
      service_id INTEGER NOT NULL,
      user_id INTEGER NOT NULL,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY (student_id) REFERENCES students (id),
      FOREIGN KEY (service_id) REFERENCES services (id),
      FOREIGN KEY (user_id) REFERENCES users (id)
    )`);

    // Insert default admin user
    const defaultPassword = bcrypt.hashSync('admin123', 10);
    db.run(`INSERT OR IGNORE INTO users (email, password, name) VALUES (?, ?, ?)`, 
      ['admin@school.com', defaultPassword, 'Administrator']);
  });
}

// Authentication middleware
const authenticateToken = (req, res, next) => {
  const authHeader = req.headers['authorization'];
  const token = authHeader && authHeader.split(' ')[1];

  if (!token) {
    return res.status(401).json({ error: 'Access token required' });
  }

  jwt.verify(token, JWT_SECRET, (err, user) => {
    if (err) {
      return res.status(403).json({ error: 'Invalid token' });
    }
    req.user = user;
    next();
  });
};

// Routes

// Login
app.post('/api/auth/login', (req, res) => {
  const { email, password } = req.body;

  if (!email || !password) {
    return res.status(400).json({ error: 'Email and password required' });
  }

  db.get('SELECT * FROM users WHERE email = ?', [email], (err, user) => {
    if (err) {
      return res.status(500).json({ error: 'Database error' });
    }

    if (!user) {
      return res.status(401).json({ error: 'Invalid credentials' });
    }

    const validPassword = bcrypt.compareSync(password, user.password);
    if (!validPassword) {
      return res.status(401).json({ error: 'Invalid credentials' });
    }

    const token = jwt.sign({ id: user.id, email: user.email }, JWT_SECRET, { expiresIn: '24h' });
    res.json({ token, user: { id: user.id, email: user.email, name: user.name } });
  });
});

// Change password
app.post('/api/auth/change-password', authenticateToken, (req, res) => {
  const { oldPassword, newPassword } = req.body;
  const userId = req.user.id;

  if (!oldPassword || !newPassword) {
    return res.status(400).json({ error: 'Old and new password required' });
  }

  db.get('SELECT password FROM users WHERE id = ?', [userId], (err, user) => {
    if (err) {
      return res.status(500).json({ error: 'Database error' });
    }

    if (!user) {
      return res.status(404).json({ error: 'User not found' });
    }

    const validOldPassword = bcrypt.compareSync(oldPassword, user.password);
    if (!validOldPassword) {
      return res.status(400).json({ error: 'Invalid old password' });
    }

    const hashedNewPassword = bcrypt.hashSync(newPassword, 10);
    db.run('UPDATE users SET password = ? WHERE id = ?', [hashedNewPassword, userId], (err) => {
      if (err) {
        return res.status(500).json({ error: 'Database error' });
      }
      res.json({ message: 'Password updated successfully' });
    });
  });
});

// Students routes
app.get('/api/students', authenticateToken, (req, res) => {
  const { search } = req.query;
  let query = 'SELECT * FROM students';
  let params = [];

  if (search) {
    query += ' WHERE name LIKE ? OR nis LIKE ?';
    params = [`%${search}%`, `%${search}%`];
  }

  query += ' ORDER BY name';

  db.all(query, params, (err, students) => {
    if (err) {
      return res.status(500).json({ error: 'Database error' });
    }
    res.json(students);
  });
});

app.post('/api/students', authenticateToken, (req, res) => {
  const { nis, name, grade, major, room } = req.body;

  if (!nis || !name || !grade || !major || !room) {
    return res.status(400).json({ error: 'All fields are required' });
  }

  db.run('INSERT INTO students (nis, name, grade, major, room) VALUES (?, ?, ?, ?, ?)',
    [nis, name, grade, major, room], function(err) {
      if (err) {
        if (err.message.includes('UNIQUE constraint failed')) {
          return res.status(400).json({ error: 'NIS already exists' });
        }
        return res.status(500).json({ error: 'Database error' });
      }
      res.json({ id: this.lastID, nis, name, grade, major, room });
    });
});

app.get('/api/students/:id', authenticateToken, (req, res) => {
  db.get('SELECT * FROM students WHERE id = ?', [req.params.id], (err, student) => {
    if (err) {
      return res.status(500).json({ error: 'Database error' });
    }
    if (!student) {
      return res.status(404).json({ error: 'Student not found' });
    }
    res.json(student);
  });
});

app.put('/api/students/:id', authenticateToken, (req, res) => {
  const { nis, name, grade, major, room } = req.body;
  const { id } = req.params;

  if (!nis || !name || !grade || !major || !room) {
    return res.status(400).json({ error: 'All fields are required' });
  }

  db.run('UPDATE students SET nis = ?, name = ?, grade = ?, major = ?, room = ? WHERE id = ?',
    [nis, name, grade, major, room, id], function(err) {
      if (err) {
        if (err.message.includes('UNIQUE constraint failed')) {
          return res.status(400).json({ error: 'NIS already exists' });
        }
        return res.status(500).json({ error: 'Database error' });
      }
      if (this.changes === 0) {
        return res.status(404).json({ error: 'Student not found' });
      }
      res.json({ id, nis, name, grade, major, room });
    });
});

app.delete('/api/students/:id', authenticateToken, (req, res) => {
  db.run('DELETE FROM students WHERE id = ?', [req.params.id], function(err) {
    if (err) {
      return res.status(500).json({ error: 'Database error' });
    }
    if (this.changes === 0) {
      return res.status(404).json({ error: 'Student not found' });
    }
    res.json({ message: 'Student deleted successfully' });
  });
});

// Services routes
app.get('/api/services', authenticateToken, (req, res) => {
  db.all('SELECT * FROM services ORDER BY name', (err, services) => {
    if (err) {
      return res.status(500).json({ error: 'Database error' });
    }
    res.json(services);
  });
});

app.post('/api/services', authenticateToken, (req, res) => {
  const { name, parent_id } = req.body;

  if (!name) {
    return res.status(400).json({ error: 'Service name is required' });
  }

  db.run('INSERT INTO services (name, parent_id) VALUES (?, ?)',
    [name, parent_id || null], function(err) {
      if (err) {
        return res.status(500).json({ error: 'Database error' });
      }
      res.json({ id: this.lastID, name, parent_id });
    });
});

app.put('/api/services/:id', authenticateToken, (req, res) => {
  const { name, parent_id } = req.body;
  const { id } = req.params;

  if (!name) {
    return res.status(400).json({ error: 'Service name is required' });
  }

  db.run('UPDATE services SET name = ?, parent_id = ? WHERE id = ?',
    [name, parent_id || null, id], function(err) {
      if (err) {
        return res.status(500).json({ error: 'Database error' });
      }
      if (this.changes === 0) {
        return res.status(404).json({ error: 'Service not found' });
      }
      res.json({ id, name, parent_id });
    });
});

app.delete('/api/services/:id', authenticateToken, (req, res) => {
  db.run('DELETE FROM services WHERE id = ?', [req.params.id], function(err) {
    if (err) {
      return res.status(500).json({ error: 'Database error' });
    }
    if (this.changes === 0) {
      return res.status(404).json({ error: 'Service not found' });
    }
    res.json({ message: 'Service deleted successfully' });
  });
});

// Counseling records routes
app.get('/api/counseling-records', authenticateToken, (req, res) => {
  const { search } = req.query;
  let query = `
    SELECT cr.*, s.name as student_name, s.nis, sv.name as service_name, u.name as user_name
    FROM counseling_records cr
    JOIN students s ON cr.student_id = s.id
    JOIN services sv ON cr.service_id = sv.id
    JOIN users u ON cr.user_id = u.id
  `;
  let params = [];

  if (search) {
    query += ' WHERE s.name LIKE ? OR cr.activity LIKE ? OR cr.description LIKE ?';
    params = [`%${search}%`, `%${search}%`, `%${search}%`];
  }

  query += ' ORDER BY cr.date DESC';

  db.all(query, params, (err, records) => {
    if (err) {
      return res.status(500).json({ error: 'Database error' });
    }
    res.json(records);
  });
});

app.post('/api/counseling-records', authenticateToken, (req, res) => {
  const { date, activity, location, description, notes, student_id, service_id } = req.body;
  const user_id = req.user.id;

  if (!date || !activity || !location || !student_id || !service_id) {
    return res.status(400).json({ error: 'Required fields missing' });
  }

  db.run('INSERT INTO counseling_records (date, activity, location, description, notes, student_id, service_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
    [date, activity, location, description, notes, student_id, service_id, user_id], function(err) {
      if (err) {
        return res.status(500).json({ error: 'Database error' });
      }
      res.json({ id: this.lastID, date, activity, location, description, notes, student_id, service_id, user_id });
    });
});

app.get('/api/counseling-records/:id', authenticateToken, (req, res) => {
  const query = `
    SELECT cr.*, s.name as student_name, s.nis, s.grade, s.major, s.room, sv.name as service_name, u.name as user_name
    FROM counseling_records cr
    JOIN students s ON cr.student_id = s.id
    JOIN services sv ON cr.service_id = sv.id
    JOIN users u ON cr.user_id = u.id
    WHERE cr.id = ?
  `;

  db.get(query, [req.params.id], (err, record) => {
    if (err) {
      return res.status(500).json({ error: 'Database error' });
    }
    if (!record) {
      return res.status(404).json({ error: 'Record not found' });
    }
    res.json(record);
  });
});

app.put('/api/counseling-records/:id', authenticateToken, (req, res) => {
  const { date, activity, location, description, notes, student_id, service_id } = req.body;
  const { id } = req.params;

  if (!date || !activity || !location || !student_id || !service_id) {
    return res.status(400).json({ error: 'Required fields missing' });
  }

  db.run('UPDATE counseling_records SET date = ?, activity = ?, location = ?, description = ?, notes = ?, student_id = ?, service_id = ? WHERE id = ?',
    [date, activity, location, description, notes, student_id, service_id, id], function(err) {
      if (err) {
        return res.status(500).json({ error: 'Database error' });
      }
      if (this.changes === 0) {
        return res.status(404).json({ error: 'Record not found' });
      }
      res.json({ id, date, activity, location, description, notes, student_id, service_id });
    });
});

app.delete('/api/counseling-records/:id', authenticateToken, (req, res) => {
  db.run('DELETE FROM counseling_records WHERE id = ?', [req.params.id], function(err) {
    if (err) {
      return res.status(500).json({ error: 'Database error' });
    }
    if (this.changes === 0) {
      return res.status(404).json({ error: 'Record not found' });
    }
    res.json({ message: 'Record deleted successfully' });
  });
});

// Serve static files in production
if (process.env.NODE_ENV === 'production') {
  app.use(express.static(path.join(__dirname, '../client/build')));
  app.get('*', (req, res) => {
    res.sendFile(path.join(__dirname, '../client/build', 'index.html'));
  });
}

app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
}); 