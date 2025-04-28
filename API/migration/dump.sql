CREATE TABLE IF NOT EXISTS boards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS threads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    board_id INT,
    subject VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    bumped_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (board_id) REFERENCES boards (id)
);

CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    thread_id INT,
    name VARCHAR(50),
    email VARCHAR(100),
    subject VARCHAR(255),
    message TEXT,
    image_path VARCHAR(255),
    thumb_path VARCHAR(255),
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (thread_id) REFERENCES threads (id)
);

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO boards (`name`, `description`, `created_at`)
VALUES  ('a','Anime & Manga', CURRENT_TIMESTAMP()),
        ('w','Wallpapaer', CURRENT_TIMESTAMP()),
        ('v','Video Games', CURRENT_TIMESTAMP()),
        ('vr','Video Games Retro', CURRENT_TIMESTAMP()),
        ('mu','Music', CURRENT_TIMESTAMP()),
        ('news','Current News', CURRENT_TIMESTAMP()),
        ('tv','Television & Film', CURRENT_TIMESTAMP()),
        ('gd','Graphic Design', CURRENT_TIMESTAMP()),
        ('diy','Do It Yourself', CURRENT_TIMESTAMP());