-- Create database
CREATE DATABASE IF NOT EXISTS pc_parts_picker;
USE pc_parts_picker;

-- Create parts table
CREATE TABLE IF NOT EXISTS parts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    specs JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create builds table
CREATE TABLE IF NOT EXISTS builds (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parts JSON NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample CPU data
INSERT INTO parts (type, name, description, price, specs) VALUES
('cpu', 'Intel Core i9-13900K', '24 cores, 32 threads', 549.99, '{"cores": 24, "threads": 32, "base_clock": "3.0 GHz", "boost_clock": "5.8 GHz"}'),
('cpu', 'AMD Ryzen 9 7950X', '16 cores, 32 threads', 699.99, '{"cores": 16, "threads": 32, "base_clock": "4.5 GHz", "boost_clock": "5.7 GHz"}'),
('cpu', 'Intel Core i7-13700K', '16 cores, 24 threads', 399.99, '{"cores": 16, "threads": 24, "base_clock": "3.4 GHz", "boost_clock": "5.4 GHz"}');

-- Insert sample motherboard data
INSERT INTO parts (type, name, description, price, specs) VALUES
('motherboard', 'ASUS ROG STRIX Z790-E', 'ATX, DDR5', 449.99, '{"form_factor": "ATX", "memory_type": "DDR5", "max_memory": "128GB"}'),
('motherboard', 'MSI MPG B650', 'ATX, DDR5', 249.99, '{"form_factor": "ATX", "memory_type": "DDR5", "max_memory": "128GB"}'),
('motherboard', 'Gigabyte B760M', 'Micro ATX, DDR4', 129.99, '{"form_factor": "Micro ATX", "memory_type": "DDR4", "max_memory": "64GB"}');

-- Insert sample GPU data
INSERT INTO parts (type, name, description, price, specs) VALUES
('gpu', 'NVIDIA GeForce RTX 4090', '24GB GDDR6X', 1599.99, '{"memory": "24GB", "memory_type": "GDDR6X", "boost_clock": "2.52 GHz"}'),
('gpu', 'AMD Radeon RX 7900 XTX', '24GB GDDR6', 999.99, '{"memory": "24GB", "memory_type": "GDDR6", "boost_clock": "2.3 GHz"}'),
('gpu', 'NVIDIA GeForce RTX 4080', '16GB GDDR6X', 1199.99, '{"memory": "16GB", "memory_type": "GDDR6X", "boost_clock": "2.51 GHz"}');

-- Insert sample RAM data
INSERT INTO parts (type, name, description, price, specs) VALUES
('ram', 'Corsair Dominator Platinum RGB', '32GB (2x16GB) DDR5', 249.99, '{"capacity": "32GB", "type": "DDR5", "speed": "6000MHz"}'),
('ram', 'G.Skill Trident Z5 RGB', '32GB (2x16GB) DDR5', 229.99, '{"capacity": "32GB", "type": "DDR5", "speed": "5600MHz"}'),
('ram', 'Crucial DDR4', '32GB (2x16GB) DDR4', 129.99, '{"capacity": "32GB", "type": "DDR4", "speed": "3200MHz"}');

-- Insert sample storage data
INSERT INTO parts (type, name, description, price, specs) VALUES
('storage', 'Samsung 990 Pro', '2TB NVMe SSD', 199.99, '{"capacity": "2TB", "type": "NVMe", "read_speed": "7450 MB/s"}'),
('storage', 'WD Black SN850X', '1TB NVMe SSD', 129.99, '{"capacity": "1TB", "type": "NVMe", "read_speed": "7300 MB/s"}'),
('storage', 'Seagate Barracuda', '2TB HDD', 49.99, '{"capacity": "2TB", "type": "HDD", "rpm": "7200"}');

-- Insert sample PSU data
INSERT INTO parts (type, name, description, price, specs) VALUES
('psu', 'Corsair HX1200', '1200W 80+ Platinum', 249.99, '{"wattage": "1200W", "efficiency": "80+ Platinum", "modular": "Full"}'),
('psu', 'EVGA SuperNOVA 850', '850W 80+ Gold', 149.99, '{"wattage": "850W", "efficiency": "80+ Gold", "modular": "Full"}'),
('psu', 'Seasonic Focus GX-750', '750W 80+ Gold', 129.99, '{"wattage": "750W", "efficiency": "80+ Gold", "modular": "Full"}');

-- Insert sample case data
INSERT INTO parts (type, name, description, price, specs) VALUES
('case', 'Lian Li O11 Dynamic', 'Full Tower ATX', 149.99, '{"form_factor": "Full Tower", "material": "Steel/Tempered Glass", "fans": "10"}'),
('case', 'Fractal Design Meshify C', 'Mid Tower ATX', 89.99, '{"form_factor": "Mid Tower", "material": "Steel/Mesh", "fans": "6"}'),
('case', 'NZXT H510', 'Mid Tower ATX', 69.99, '{"form_factor": "Mid Tower", "material": "Steel/Tempered Glass", "fans": "4"}'); 