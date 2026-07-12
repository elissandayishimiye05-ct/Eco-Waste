-- =============================================
-- Database: waste_management
-- Eco-Waste: Waste Collection & Recycling Management System
-- =============================================

CREATE DATABASE IF NOT EXISTS waste_management;
USE waste_management;

-- =============================================
-- Table: USERS
-- Stores all system users with role-based access
-- =============================================
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'resident', 'collector', 'recycling_staff') NOT NULL DEFAULT 'resident',
    profile_image VARCHAR(255) DEFAULT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    last_login DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_is_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: RESIDENTS
-- Resident-specific information
-- =============================================
CREATE TABLE residents (
    resident_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50) DEFAULT NULL,
    zip_code VARCHAR(20) DEFAULT NULL,
    latitude DECIMAL(10, 8) DEFAULT NULL,
    longitude DECIMAL(11, 8) DEFAULT NULL,
    preferred_collection_day ENUM('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_city (city)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: COLLECTORS
-- Collector-specific information
-- =============================================
CREATE TABLE collectors (
    collector_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    employee_number VARCHAR(50) UNIQUE NOT NULL,
    hire_date DATE NOT NULL,
    work_status ENUM('active', 'inactive', 'on_leave') DEFAULT 'active',
    vehicle_assigned INT DEFAULT NULL,
    rating DECIMAL(3, 2) DEFAULT 0.00,
    total_collections INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_employee_number (employee_number),
    INDEX idx_work_status (work_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: VEHICLES
-- Waste collection vehicles
-- =============================================
CREATE TABLE vehicles (
    vehicle_id INT PRIMARY KEY AUTO_INCREMENT,
    plate_number VARCHAR(20) UNIQUE NOT NULL,
    vehicle_type ENUM('truck', 'van', 'compactor', 'flatbed') NOT NULL,
    capacity DECIMAL(10, 2) NOT NULL COMMENT 'Capacity in tons',
    fuel_type ENUM('diesel', 'petrol', 'electric', 'hybrid') DEFAULT 'diesel',
    status ENUM('available', 'assigned', 'maintenance', 'out_of_service') DEFAULT 'available',
    current_location VARCHAR(255) DEFAULT NULL,
    last_maintenance DATE DEFAULT NULL,
    next_maintenance DATE DEFAULT NULL,
    mileage DECIMAL(12, 2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_plate_number (plate_number),
    INDEX idx_status (status),
    INDEX idx_vehicle_type (vehicle_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add foreign key after vehicles table exists
ALTER TABLE collectors ADD CONSTRAINT fk_collector_vehicle 
    FOREIGN KEY (vehicle_assigned) REFERENCES vehicles(vehicle_id) ON DELETE SET NULL;

-- =============================================
-- Table: WASTE_REQUESTS
-- Resident waste collection requests
-- =============================================
CREATE TABLE waste_requests (
    request_id INT PRIMARY KEY AUTO_INCREMENT,
    resident_id INT NOT NULL,
    waste_type ENUM('general', 'recyclable', 'organic', 'hazardous', 'electronic', 'construction', 'medical') NOT NULL,
    description TEXT,
    image VARCHAR(255) DEFAULT NULL,
    location TEXT NOT NULL,
    latitude DECIMAL(10, 8) DEFAULT NULL,
    longitude DECIMAL(11, 8) DEFAULT NULL,
    estimated_quantity DECIMAL(10, 2) DEFAULT NULL COMMENT 'Estimated quantity in kg',
    urgency ENUM('low', 'medium', 'high', 'emergency') DEFAULT 'medium',
    request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    preferred_date DATE DEFAULT NULL,
    preferred_time TIME DEFAULT NULL,
    status ENUM('pending', 'approved', 'assigned', 'in_progress', 'completed', 'cancelled', 'rejected') DEFAULT 'pending',
    admin_notes TEXT DEFAULT NULL,
    completed_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (resident_id) REFERENCES residents(resident_id) ON DELETE CASCADE,
    INDEX idx_resident_id (resident_id),
    INDEX idx_status (status),
    INDEX idx_waste_type (waste_type),
    INDEX idx_request_date (request_date),
    INDEX idx_urgency (urgency)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: COLLECTION_SCHEDULES
-- Scheduled waste collections
-- =============================================
CREATE TABLE collection_schedules (
    schedule_id INT PRIMARY KEY AUTO_INCREMENT,
    request_id INT NOT NULL,
    collector_id INT NOT NULL,
    vehicle_id INT NOT NULL,
    collection_date DATE NOT NULL,
    collection_time TIME NOT NULL,
    estimated_arrival_time TIME DEFAULT NULL,
    actual_arrival_time TIME DEFAULT NULL,
    actual_completion_time TIME DEFAULT NULL,
    area VARCHAR(100) NOT NULL,
    route_sequence INT DEFAULT 1,
    status ENUM('scheduled', 'assigned', 'ongoing', 'completed', 'cancelled', 'missed') DEFAULT 'scheduled',
    notes TEXT DEFAULT NULL,
    collected_quantity DECIMAL(10, 2) DEFAULT NULL COMMENT 'Actual collected quantity in kg',
    signature VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (request_id) REFERENCES waste_requests(request_id) ON DELETE CASCADE,
    FOREIGN KEY (collector_id) REFERENCES collectors(collector_id) ON DELETE CASCADE,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(vehicle_id) ON DELETE CASCADE,
    INDEX idx_request_id (request_id),
    INDEX idx_collector_id (collector_id),
    INDEX idx_vehicle_id (vehicle_id),
    INDEX idx_collection_date (collection_date),
    INDEX idx_status (status),
    INDEX idx_area (area)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: RECYCLING_CENTERS
-- Recycling center information
-- =============================================
CREATE TABLE recycling_centers (
    center_id INT PRIMARY KEY AUTO_INCREMENT,
    center_name VARCHAR(100) NOT NULL,
    location TEXT NOT NULL,
    latitude DECIMAL(10, 8) DEFAULT NULL,
    longitude DECIMAL(11, 8) DEFAULT NULL,
    contact_phone VARCHAR(20) NOT NULL,
    contact_email VARCHAR(100) DEFAULT NULL,
    operating_hours VARCHAR(255) DEFAULT NULL,
    capacity DECIMAL(10, 2) DEFAULT NULL COMMENT 'Processing capacity in tons per day',
    accepted_materials TEXT DEFAULT NULL,
    status ENUM('active', 'inactive', 'maintenance') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_center_name (center_name),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: RECYCLED_MATERIALS
-- Recycled materials tracking
-- =============================================
CREATE TABLE recycled_materials (
    material_id INT PRIMARY KEY AUTO_INCREMENT,
    center_id INT NOT NULL,
    request_id INT DEFAULT NULL,
    material_type ENUM('paper', 'plastic', 'glass', 'metal', 'organic', 'electronic', 'textile', 'hazardous', 'other') NOT NULL,
    quantity DECIMAL(10, 2) NOT NULL COMMENT 'Quantity in kg',
    unit VARCHAR(20) DEFAULT 'kg',
    quality_grade ENUM('A', 'B', 'C', 'D') DEFAULT 'B',
    date_received DATE NOT NULL,
    processed_date DATE DEFAULT NULL,
    source_type ENUM('residential', 'commercial', 'industrial', 'institutional') DEFAULT 'residential',
    notes TEXT DEFAULT NULL,
    selling_price DECIMAL(10, 2) DEFAULT 0.00,
    buyer_name VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (center_id) REFERENCES recycling_centers(center_id) ON DELETE CASCADE,
    FOREIGN KEY (request_id) REFERENCES waste_requests(request_id) ON DELETE SET NULL,
    INDEX idx_center_id (center_id),
    INDEX idx_request_id (request_id),
    INDEX idx_material_type (material_type),
    INDEX idx_date_received (date_received)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: NOTIFICATIONS
-- System notifications
-- =============================================
CREATE TABLE notifications (
    notification_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('info', 'success', 'warning', 'error', 'reminder') DEFAULT 'info',
    status ENUM('unread', 'read', 'archived') DEFAULT 'unread',
    link VARCHAR(255) DEFAULT NULL,
    scheduled_date DATETIME DEFAULT NULL,
    sent_date DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_type (type),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: PAYMENTS
-- Payment transactions
-- =============================================
CREATE TABLE payments (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    request_id INT NOT NULL,
    user_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    service_fee DECIMAL(10, 2) DEFAULT 0.00,
    total_amount DECIMAL(10, 2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'USD',
    payment_method ENUM('mtn_money', 'airtel_money', 'bank_transfer', 'card', 'cash') NOT NULL,
    transaction_id VARCHAR(100) UNIQUE DEFAULT NULL,
    payment_date DATETIME NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    description TEXT DEFAULT NULL,
    reference_number VARCHAR(50) DEFAULT NULL,
    receipt_number VARCHAR(50) DEFAULT NULL,
    gateway_response TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (request_id) REFERENCES waste_requests(request_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_request_id (request_id),
    INDEX idx_user_id (user_id),
    INDEX idx_transaction_id (transaction_id),
    INDEX idx_status (status),
    INDEX idx_payment_date (payment_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: INVOICES
-- Generated invoices
-- =============================================
CREATE TABLE invoices (
    invoice_id INT PRIMARY KEY AUTO_INCREMENT,
    payment_id INT NOT NULL,
    invoice_number VARCHAR(50) UNIQUE NOT NULL,
    invoice_date DATE NOT NULL,
    due_date DATE NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_address TEXT,
    subtotal DECIMAL(10, 2) NOT NULL,
    tax DECIMAL(10, 2) DEFAULT 0.00,
    total DECIMAL(10, 2) NOT NULL,
    status ENUM('draft', 'sent', 'paid', 'overdue', 'cancelled') DEFAULT 'draft',
    pdf_path VARCHAR(255) DEFAULT NULL,
    notes TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (payment_id) REFERENCES payments(payment_id) ON DELETE CASCADE,
    INDEX idx_payment_id (payment_id),
    INDEX idx_invoice_number (invoice_number),
    INDEX idx_status (status),
    INDEX idx_invoice_date (invoice_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: COLLECTOR_PERFORMANCE
-- Collector performance tracking
-- =============================================
CREATE TABLE collector_performance (
    performance_id INT PRIMARY KEY AUTO_INCREMENT,
    collector_id INT NOT NULL,
    month_year DATE NOT NULL,
    total_collections INT DEFAULT 0,
    completed_collections INT DEFAULT 0,
    missed_collections INT DEFAULT 0,
    total_collected_weight DECIMAL(10, 2) DEFAULT 0.00,
    average_rating DECIMAL(3, 2) DEFAULT 0.00,
    on_time_count INT DEFAULT 0,
    late_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (collector_id) REFERENCES collectors(collector_id) ON DELETE CASCADE,
    UNIQUE KEY unique_performance (collector_id, month_year),
    INDEX idx_collector_id (collector_id),
    INDEX idx_month_year (month_year)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: VEHICLE_MAINTENANCE
-- Vehicle maintenance records
-- =============================================
CREATE TABLE vehicle_maintenance (
    maintenance_id INT PRIMARY KEY AUTO_INCREMENT,
    vehicle_id INT NOT NULL,
    maintenance_date DATE NOT NULL,
    maintenance_type ENUM('routine', 'repair', 'emergency', 'inspection') NOT NULL,
    description TEXT NOT NULL,
    cost DECIMAL(10, 2) DEFAULT 0.00,
    technician VARCHAR(100) DEFAULT NULL,
    next_maintenance_date DATE DEFAULT NULL,
    status ENUM('scheduled', 'in_progress', 'completed', 'cancelled') DEFAULT 'scheduled',
    notes TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(vehicle_id) ON DELETE CASCADE,
    INDEX idx_vehicle_id (vehicle_id),
    INDEX idx_maintenance_date (maintenance_date),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: SERVICE_RATINGS
-- Resident ratings for collection services
-- =============================================
CREATE TABLE service_ratings (
    rating_id INT PRIMARY KEY AUTO_INCREMENT,
    request_id INT NOT NULL,
    resident_id INT NOT NULL,
    collector_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    review TEXT DEFAULT NULL,
    response TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (request_id) REFERENCES waste_requests(request_id) ON DELETE CASCADE,
    FOREIGN KEY (resident_id) REFERENCES residents(resident_id) ON DELETE CASCADE,
    FOREIGN KEY (collector_id) REFERENCES collectors(collector_id) ON DELETE CASCADE,
    UNIQUE KEY unique_rating (request_id, resident_id),
    INDEX idx_request_id (request_id),
    INDEX idx_collector_id (collector_id),
    INDEX idx_rating (rating)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: SYSTEM_LOGS
-- System activity logs
-- =============================================
CREATE TABLE system_logs (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT DEFAULT NULL,
    action VARCHAR(50) NOT NULL,
    table_name VARCHAR(50) DEFAULT NULL,
    record_id INT DEFAULT NULL,
    old_value JSON DEFAULT NULL,
    new_value JSON DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_id (user_id),
    INDEX idx_action (action),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Table: SETTINGS
-- System settings and configurations
-- =============================================
CREATE TABLE settings (
    setting_id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT NOT NULL,
    setting_type ENUM('string', 'integer', 'boolean', 'json', 'file') DEFAULT 'string',
    category VARCHAR(50) DEFAULT 'general',
    description TEXT DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_setting_key (setting_key),
    INDEX idx_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Insert Default System Settings
-- =============================================
INSERT INTO settings (setting_key, setting_value, setting_type, category, description) VALUES
('system_name', 'Eco-Waste WCRMS', 'string', 'general', 'System name'),
('system_version', '1.0.0', 'string', 'general', 'System version'),
('timezone', 'UTC', 'string', 'general', 'System timezone'),
('currency', 'USD', 'string', 'payment', 'Default currency'),
('tax_rate', '0.00', 'decimal', 'payment', 'Default tax rate'),
('collection_base_fee', '5.00', 'decimal', 'payment', 'Base collection service fee'),
('max_request_image_size', '5242880', 'integer', 'general', 'Maximum image upload size in bytes'),
('allowed_image_types', 'jpg,jpeg,png,gif', 'string', 'general', 'Allowed image file extensions'),
('maintenance_mode', 'false', 'boolean', 'general', 'Enable maintenance mode'),
('notification_enabled', 'true', 'boolean', 'notification', 'Enable system notifications');

-- =============================================
-- Insert Default Admin User
-- =============================================
INSERT INTO users (fullname, email, phone, password, role, is_active) VALUES
('System Administrator', 'admin@ecowaste.com', '+250781234567', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1);

-- Note: Password is 'admin123' hashed using password_hash()

-- =============================================
-- Create Views for Common Queries
-- =============================================

-- View for active collection requests
CREATE VIEW vw_active_requests AS
SELECT 
    r.request_id,
    u.fullname AS resident_name,
    r.waste_type,
    r.status,
    r.request_date,
    r.preferred_date,
    r.location,
    s.status AS schedule_status,
    s.collection_date
FROM waste_requests r
JOIN residents res ON r.resident_id = res.resident_id
JOIN users u ON res.user_id = u.user_id
LEFT JOIN collection_schedules s ON r.request_id = s.request_id
WHERE r.status NOT IN ('completed', 'cancelled', 'rejected');

-- View for collector schedule
CREATE VIEW vw_collector_schedule AS
SELECT 
    s.schedule_id,
    c.employee_number,
    u.fullname AS collector_name,
    r.request_id,
    r.waste_type,
    r.location,
    v.plate_number,
    s.collection_date,
    s.collection_time,
    s.status AS schedule_status,
    u2.fullname AS resident_name
FROM collection_schedules s
JOIN collectors c ON s.collector_id = c.collector_id
JOIN users u ON c.user_id = u.user_id
JOIN waste_requests r ON s.request_id = r.request_id
JOIN residents res ON r.resident_id = res.resident_id
JOIN users u2 ON res.user_id = u2.user_id
LEFT JOIN vehicles v ON s.vehicle_id = v.vehicle_id
WHERE s.status NOT IN ('completed', 'cancelled');

-- View for recycling summary
CREATE VIEW vw_recycling_summary AS
SELECT 
    rc.center_name,
    rm.material_type,
    SUM(rm.quantity) AS total_quantity,
    COUNT(rm.material_id) AS total_items,
    DATE_FORMAT(rm.date_received, '%Y-%m') AS month_received
FROM recycled_materials rm
JOIN recycling_centers rc ON rm.center_id = rc.center_id
GROUP BY rc.center_name, rm.material_type, DATE_FORMAT(rm.date_received, '%Y-%m');

-- View for payment summary
CREATE VIEW vw_payment_summary AS
SELECT 
    u.fullname AS user_name,
    p.payment_method,
    COUNT(p.payment_id) AS total_transactions,
    SUM(p.total_amount) AS total_amount,
    p.status,
    DATE_FORMAT(p.payment_date, '%Y-%m') AS month
FROM payments p
JOIN users u ON p.user_id = u.user_id
GROUP BY u.fullname, p.payment_method, p.status, DATE_FORMAT(p.payment_date, '%Y-%m');

-- =============================================
-- Create Stored Procedures
-- =============================================

DELIMITER //

-- Procedure to assign collector to collection
CREATE PROCEDURE assign_collector(
    IN p_request_id INT,
    IN p_collector_id INT,
    IN p_vehicle_id INT,
    IN p_collection_date DATE,
    IN p_collection_time TIME,
    IN p_area VARCHAR(100)
)
BEGIN
    -- Insert schedule
    INSERT INTO collection_schedules (
        request_id, collector_id, vehicle_id, 
        collection_date, collection_time, area, status
    ) VALUES (
        p_request_id, p_collector_id, p_vehicle_id,
        p_collection_date, p_collection_time, p_area, 'scheduled'
    );
    
    -- Update request status
    UPDATE waste_requests SET status = 'assigned' 
    WHERE request_id = p_request_id;
    
    -- Update vehicle status
    UPDATE vehicles SET status = 'assigned' 
    WHERE vehicle_id = p_vehicle_id;
    
    -- Send notification to resident
    INSERT INTO notifications (user_id, title, message, type)
    SELECT 
        res.user_id,
        'Collection Assigned',
        CONCAT('Your waste collection has been scheduled for ', p_collection_date, ' at ', p_collection_time),
        'info'
    FROM waste_requests wr
    JOIN residents res ON wr.resident_id = res.resident_id
    WHERE wr.request_id = p_request_id;
END //

-- Procedure to complete collection
CREATE PROCEDURE complete_collection(
    IN p_schedule_id INT,
    IN p_actual_completion_time TIME,
    IN p_collected_quantity DECIMAL(10, 2)
)
BEGIN
    DECLARE v_request_id INT;
    DECLARE v_collector_id INT;
    
    -- Get request and collector info
    SELECT request_id, collector_id INTO v_request_id, v_collector_id
    FROM collection_schedules
    WHERE schedule_id = p_schedule_id;
    
    -- Update schedule
    UPDATE collection_schedules 
    SET 
        actual_completion_time = p_actual_completion_time,
        collected_quantity = p_collected_quantity,
        status = 'completed'
    WHERE schedule_id = p_schedule_id;
    
    -- Update request
    UPDATE waste_requests 
    SET 
        status = 'completed',
        completed_at = NOW()
    WHERE request_id = v_request_id;
    
    -- Update vehicle status
    UPDATE vehicles v
    JOIN collection_schedules s ON v.vehicle_id = s.vehicle_id
    SET v.status = 'available'
    WHERE s.schedule_id = p_schedule_id;
    
    -- Update collector statistics
    UPDATE collectors 
    SET total_collections = total_collections + 1
    WHERE collector_id = v_collector_id;
    
    -- Send notification to resident
    INSERT INTO notifications (user_id, title, message, type)
    SELECT 
        res.user_id,
        'Collection Completed',
        CONCAT('Your waste collection has been completed successfully. Quantity: ', p_collected_quantity, ' kg'),
        'success'
    FROM waste_requests wr
    JOIN residents res ON wr.resident_id = res.resident_id
    WHERE wr.request_id = v_request_id;
END //

DELIMITER ;

-- =============================================
-- Create Triggers
-- =============================================

DELIMITER //

-- Trigger to update collector performance after rating
CREATE TRIGGER update_collector_rating
AFTER INSERT ON service_ratings
FOR EACH ROW
BEGIN
    -- Update collector's average rating
    UPDATE collectors c
    SET c.rating = (
        SELECT AVG(rating) 
        FROM service_ratings 
        WHERE collector_id = NEW.collector_id
    )
    WHERE c.collector_id = NEW.collector_id;
END //

-- Trigger to log system actions
CREATE TRIGGER log_waste_request_status_change
AFTER UPDATE ON waste_requests
FOR EACH ROW
BEGIN
    IF OLD.status != NEW.status THEN
        INSERT INTO system_logs (
            user_id, action, table_name, record_id, 
            old_value, new_value
        ) VALUES (
            NULL, -- Will be set by application
            'status_change',
            'waste_requests',
            NEW.request_id,
            JSON_OBJECT('status', OLD.status),
            JSON_OBJECT('status', NEW.status)
        );
    END IF;
END //

DELIMITER ;

-- =============================================
-- Indexes for Performance Optimization
-- =============================================

-- Additional indexes for common queries
CREATE INDEX idx_waste_requests_status_date ON waste_requests(status, request_date);
CREATE INDEX idx_collection_schedules_date_status ON collection_schedules(collection_date, status);
CREATE INDEX idx_payments_status_date ON payments(status, payment_date);
CREATE INDEX idx_notifications_user_status ON notifications(user_id, status);

-- Full-text search indexes
CREATE FULLTEXT INDEX ft_waste_requests_description ON waste_requests(description);
CREATE FULLTEXT INDEX ft_notifications_message ON notifications(title, message);

-- =============================================
-- Initial Data for Testing
-- =============================================

-- Insert sample recycling centers
INSERT INTO recycling_centers (center_name, location, contact_phone, contact_email, capacity) VALUES
('Green Recycling Hub', 'Kigali, Rwanda', '+250788123456', 'info@greenhub.rw', 50.00),
('Eco-Waste Recycling Center', 'Kigali, Rwanda', '+250788654321', 'info@ecowaste.rw', 75.00);

-- Insert sample residents
INSERT INTO users (fullname, email, phone, password, role) VALUES
('John Doe', 'john@example.com', '+250780000001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'resident'),
('Jane Smith', 'jane@example.com', '+250780000002', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'resident');

INSERT INTO residents (user_id, address, city, zip_code) VALUES
(2, '123 Main St, Kigali', 'Kigali', '00001'),
(3, '456 Avenue du Commerce, Kigali', 'Kigali', '00002');

-- Insert sample collectors
INSERT INTO users (fullname, email, phone, password, role) VALUES
('James Collector', 'collector1@ecowaste.com', '+250780000003', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'collector');

INSERT INTO collectors (user_id, employee_number, hire_date, work_status) VALUES
(4, 'EMP001', '2024-01-15', 'active');

-- Insert sample vehicles
INSERT INTO vehicles (plate_number, vehicle_type, capacity, status) VALUES
('RAB 123A', 'truck', 5.00, 'available'),
('RAB 456B', 'compactor', 8.00, 'available');

-- Insert sample waste requests
INSERT INTO waste_requests (resident_id, waste_type, description, location, status, request_date) VALUES
(1, 'general', 'General household waste collection', '123 Main St, Kigali', 'pending', NOW()),
(2, 'recyclable', 'Plastic bottles and paper', '456 Avenue du Commerce, Kigali', 'pending', NOW());

-- =============================================
-- Sample Queries for Testing
-- =============================================

-- 1. Get all pending requests with resident details
/*
SELECT 
    wr.request_id,
    u.fullname AS resident_name,
    wr.waste_type,
    wr.description,
    wr.location,
    wr.request_date,
    wr.status
FROM waste_requests wr
JOIN residents r ON wr.resident_id = r.resident_id
JOIN users u ON r.user_id = u.user_id
WHERE wr.status = 'pending'
ORDER BY wr.request_date DESC;
*/

-- 2. Get collector schedule for today
/*
SELECT 
    s.schedule_id,
    u.fullname AS collector_name,
    v.plate_number,
    r.waste_type,
    r.location,
    s.collection_time,
    s.status
FROM collection_schedules s
JOIN collectors c ON s.collector_id = c.collector_id
JOIN users u ON c.user_id = u.user_id
JOIN vehicles v ON s.vehicle_id = v.vehicle_id
JOIN waste_requests r ON s.request_id = r.request_id
WHERE s.collection_date = CURDATE()
ORDER BY s.collection_time;
*/

-- 3. Get recycling center summary
/*
SELECT 
    rc.center_name,
    rm.material_type,
    SUM(rm.quantity) AS total_quantity,
    COUNT(rm.material_id) AS total_items
FROM recycled_materials rm
JOIN recycling_centers rc ON rm.center_id = rc.center_id
WHERE rm.date_received >= DATE_SUB(NOW(), INTERVAL 30 DAY)
GROUP BY rc.center_name, rm.material_type
ORDER BY total_quantity DESC;
*/

-- 4. Get payment summary
/*
SELECT 
    u.fullname,
    COUNT(p.payment_id) AS total_payments,
    SUM(p.total_amount) AS total_amount,
    p.payment_method
FROM payments p
JOIN users u ON p.user_id = u.user_id
WHERE p.status = 'completed'
GROUP BY u.fullname, p.payment_method;
*/

-- =============================================
-- End of Database Schema
-- =============================================