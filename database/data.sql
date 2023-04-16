INSERT INTO musicitems (title, artist, genre, album, release_date, cover_image, file_path)
VALUES ('Song 1', 'Artist 1', 'Genre 1', 'Album 1', '2021-01-01', 'cover1.jpg', 'file1.mp3'),
       ('Song 2', 'Artist 2', 'Genre 2', 'Album 2', '2021-02-02', 'cover2.jpg', 'file2.mp3'),
       ('Song 3', 'Artist 3', 'Genre 3', 'Album 3', '2021-03-03', 'cover3.jpg', 'file3.mp3'),
       ('Song 4', 'Artist 4', 'Genre 4', 'Album 4', '2021-04-04', 'cover4.jpg', 'file4.mp3'),
       ('Song 5', 'Artist 5', 'Genre 5', 'Album 5', '2021-05-05', 'cover5.jpg', 'file5.mp3');

-- Insert sample data into playlists table
INSERT INTO playlists (playlist_name, user_id, created_at)
VALUES ('Playlist 1', 1, NOW()),
       ('Playlist 2', 1, NOW()),
       ('Playlist 3', 2, NOW()),
       ('Playlist 4', 2, NOW()),
       ('Playlist 5', 3, NOW());

-- Insert sample data into playlistitems table
INSERT INTO playlistitems (playlist_id, music_id)
VALUES (1, 1),
       (1, 2),
       (2, 2),
       (3, 3),
       (4, 4),
       (5, 5);