CREATE TABLE IF NOT  EXISTS content_article(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  section_id INTEGER,
  title VARCHAR(255) NOT NULL,
  slug VARCHAR(255) UNIQUE NOT NULL,
  content CLOB NOT NULL,
  status TINYINT DEFAULT 0,
  created_at INTEGER default (cast(strftime('%s','now') as int)),
  updated_at INTEGER default (cast(strftime('%s','now') as int))
);

CREATE TABLE IF NOT  EXISTS content_section(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  title VARCHAR(255) NOT NULL,
  slug VARCHAR(255) UNIQUE NOT NULL,
  status TINYINT DEFAULT 0
);

CREATE TABLE IF NOT  EXISTS content_page(
  id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
  title VARCHAR(255) NOT NULL,
  slug VARCHAR(255) UNIQUE NOT NULL,
  content CLOB NOT NULL,
  status TINYINT DEFAULT 0,
  created_at INTEGER default (cast(strftime('%s','now') as int)),
  updated_at INTEGER default (cast(strftime('%s','now') as int))
);
