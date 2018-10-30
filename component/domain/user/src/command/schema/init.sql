
CREATE TABLE IF NOT  EXISTS user(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  name VARCHAR(255) NOT NULL,
  login VARCHAR(255) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL
  );