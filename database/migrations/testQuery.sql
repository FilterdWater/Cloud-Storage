-- Insert test roles
INSERT INTO roles (id, name) VALUES
(1, 'Admin'),
(2, 'User');

-- Insert test users
INSERT INTO users (id, name, email, password, role_id) VALUES
(1, 'John Doe', 'john@example.com', '$2y$10$DUMMYPASSWORDHASH', 1), -- Admin
(2, 'Jane Smith', 'jane@example.com', '$2y$10$DUMMYPASSWORDHASH', 2); -- User

-- Insert test files
INSERT INTO files (id, path, created_at, updated_at) VALUES
(1, '/uploads/file1.pdf', NOW(), NOW()),
(2, '/uploads/file2.pdf', NOW(), NOW());

-- Insert test shared file entries (sharing a file with another user)
INSERT INTO shared (id, file_id, owner_email, recipient_email) VALUES
(1, 1, 'john@example.com', 'jane@example.com'), -- John shares file1 with Jane
(2, 2, 'jane@example.com', 'john@example.com'); -- Jane shares file2 with John

-- Insert into users_has_files (associating users with files)
INSERT INTO users_has_files (users_id, files_id) VALUES
(1, 1), -- John owns file1
(2, 2); -- Jane owns file2