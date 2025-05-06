CREATE TABLE post_images (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    post_id INT UNSIGNED NOT NULL, 
    image_path VARCHAR(255) NOT NULL,
    position INT NOT NULL,
    FOREIGN KEY (post_id) REFERENCES post(id) ON DELETE CASCADE
);
