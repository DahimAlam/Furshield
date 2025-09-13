-- Password for all demo users = password
-- (bcrypt hash below is for "password")
INSERT INTO users (role, name, email, pass_hash, avatar) VALUES
('owner','Ayesha Khan','owner@demo.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','owner1.jpg'),
('vet','Dr. Usman Tariq','vet@demo.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','vet1.jpg'),
('shelter','Rescue Hub','shelter@demo.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','shelter1.jpg'),
('admin','Administrator','admin@demo.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin.jpg');

INSERT INTO vets (user_id, specialization, experience_years)
SELECT id, 'Small Animals', 5 FROM users WHERE email='vet@demo.com';

INSERT INTO pets (owner_id, name, species, breed, avatar)
SELECT id, 'Bella', 'Dog', 'Golden Retriever', 'pet1.jpg' FROM users WHERE email='owner@demo.com';

INSERT INTO products (name, price, stock_qty, image, description) VALUES
('Premium Kibble 2kg', 19.99, 15, 'kibble.jpg', 'High-protein dry food.'),
('Chew Toy Rubber Bone', 7.49, 30, 'toy.jpg', 'Durable and safe.'),
('Grooming Kit Deluxe', 24.00, 10, 'grooming.jpg', 'Brush + nail clipper set.');
