CREATE TABLE post (
    id INT UNSIGNED AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(200),
    subtitle VARCHAR(200),
    likes INT,
    content MEDIUMTEXT,
    image_path VARCHAR(255),
    posted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);