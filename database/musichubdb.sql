-- Create database
CREATE DATABASE IF NOT EXISTS musichubdb;
USE musichubdb;

-- Create Users table
CREATE TABLE IF NOT EXISTS users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255),
    is_admin TINYINT(1) DEFAULT 0,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS profiles (
    profile_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    age INT,
    gender ENUM('Male', 'Female', 'Other'),
    bio TEXT,
    profile_picture VARCHAR(255),
    CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users(user_id)
);


-- Create Music Items table
CREATE TABLE IF NOT EXISTS musicitems (
    music_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    artist VARCHAR(255) NOT NULL,
    genre VARCHAR(255) NOT NULL,
    album VARCHAR(255),
    release_date DATE,
    cover_image VARCHAR(255),
    file_path VARCHAR(255)
);

-- Create Playlists table
CREATE TABLE IF NOT EXISTS playlists (
    playlist_id INT PRIMARY KEY AUTO_INCREMENT,
    playlist_name VARCHAR(255) NOT NULL,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Create Playlist Items table
CREATE TABLE IF NOT EXISTS playlistitems (
    playlist_item_id INT PRIMARY KEY AUTO_INCREMENT,
    playlist_id INT,
    music_id INT,
    FOREIGN KEY (playlist_id) REFERENCES playlists(playlist_id),
    FOREIGN KEY (music_id) REFERENCES musicitems(music_id)
);

-- Create Comments table
CREATE TABLE IF NOT EXISTS comments (
    comment_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    music_id INT,
    comment_text TEXT,
    comment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (music_id) REFERENCES musicitems(music_id)
);

-- Create Interactions table
CREATE TABLE IF NOT EXISTS interactions (
    interaction_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    music_id INT,
    interaction_type VARCHAR(255),
    interaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (music_id) REFERENCES musicitems(music_id)
);

-- Create Genres table
CREATE TABLE IF NOT EXISTS genres (
    genre_id INT PRIMARY KEY AUTO_INCREMENT,
    genre_name VARCHAR(255)
);

-- Create Albums table
CREATE TABLE IF NOT EXISTS albums (
    album_id INT PRIMARY KEY AUTO_INCREMENT,
    album_name VARCHAR(255),
    artist VARCHAR(255),
    cover_image VARCHAR(255),
    release_date DATE
);

-- Create Knowledge table
CREATE TABLE IF NOT EXISTS knowledge (
    knowledge_id INT PRIMARY KEY AUTO_INCREMENT,
    knowledge_topic VARCHAR(255),
    knowledge_content TEXT
);