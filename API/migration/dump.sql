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

INSERT INTO imageboard.threads (board_id,subject,created_at,bumped_at) VALUES
	 (1,'Melancolica Suzumiya','2025-04-21 15:00:31','2025-04-21 15:00:31');

INSERT INTO imageboard.posts (thread_id,name,email,subject,message,image_path,thumb_path,ip_address,created_at) VALUES
	 (1,'Anónimo',NULL,'Original','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eget urna rhoncus, imperdiet risus a, auctor magna. Maecenas dignissim purus a gravida tempus. Sed dapibus mauris eget pulvinar malesuada. Vestibulum placerat arcu et purus sodales mollis. Duis consequat facilisis eros, non pharetra mauris efficitur ut. Ut a elementum massa, non placerat magna. Donec vel luctus nisi. Suspendisse feugiat pretium justo egestas tempus. Nulla faucibus gravida velit, sit amet porta mi. Fusce viverra turpis vel velit pretium, non eleifend quam efficitur.','uploads/68065d8fa1161.jpg','uploads/thumbs/68065d8fa1161.jpg','::1','2025-04-21 15:00:31'),
	 (1,'Anónimo',NULL,'Reply 1','Aenean tristique nisi urna, in congue erat lacinia vel. Fusce eu nulla pellentesque, laoreet justo ut, sagittis ligula. Nunc mattis at metus sit amet dignissim. Phasellus vitae ultrices metus. Mauris nec libero nec ante iaculis posuere sed vel arcu. Etiam vitae justo eu sem pulvinar commodo sed ut arcu. Nam semper at enim vel rutrum. In sed erat lorem. Pellentesque id gravida dolor, id laoreet dolor. Curabitur felis neque, sodales eu hendrerit at, venenatis id ligula. Quisque sed luctus velit. Mauris et feugiat quam, non dictum orci. Pellentesque at congue metus, a aliquam justo. Nam dolor massa, fermentum sit amet purus vitae, sollicitudin faucibus tortor. Cras facilisis sapien at odio gravida, in vestibulum nibh tristique.','uploads/68065d8fa1161.jpg','uploads/thumbs/68065d8fa1161.jpg','::1','2025-04-21 15:00:31'),
	 (1,'Anónimo',NULL,'Reply 2','Vestibulum egestas magna eu massa tincidunt varius. Vivamus vitae enim est. Integer mollis laoreet egestas. Quisque auctor, erat et tincidunt ultrices, nisl nisl semper tortor, id scelerisque nisl massa sed nisi. Vestibulum condimentum consequat turpis facilisis suscipit. Praesent et est dui. Mauris nec mattis lorem. Proin consequat aliquam tristique.','uploads/68065d8fa1161.jpg','uploads/thumbs/68065d8fa1161.jpg','::1','2025-04-21 15:00:31'),
	 (1,'Anónimo',NULL,'Reply 3','Quisque malesuada efficitur mauris, vitae consequat odio consectetur vel. Mauris a dolor sollicitudin, malesuada justo sed, efficitur ipsum. Maecenas vitae efficitur massa. Mauris vulputate purus eget magna laoreet, quis gravida justo blandit. Proin quis nibh vestibulum, efficitur nisl sit amet, congue nulla. Integer condimentum lacinia nulla quis semper. Quisque tincidunt enim eget accumsan consequat','uploads/68065d8fa1161.jpg','uploads/thumbs/68065d8fa1161.jpg','::1','2025-04-21 15:00:31');
