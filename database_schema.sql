-- =====================================================
-- Student Registration System Database Schema
-- =====================================================

-- Create database
CREATE DATABASE IF NOT EXISTS student_registration_system;
USE student_registration_system;

-- =====================================================
-- 1. COLLEGES/UNIVERSITIES TABLE
-- =====================================================
CREATE TABLE colleges (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    full_name VARCHAR(500),
    type ENUM('public', 'private', 'international') DEFAULT 'public',
    location VARCHAR(255),
    website VARCHAR(255),
    established_year YEAR,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- 2. PROGRAMS/CLASSES TABLE
-- =====================================================
CREATE TABLE programs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    category ENUM('computer_science', 'engineering', 'business', 'arts', 'science', 'other') DEFAULT 'other',
    duration_years INT DEFAULT 4,
    degree_level ENUM('diploma', 'bachelor', 'master', 'phd') DEFAULT 'bachelor',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- 3. STUDENTS TABLE (Main Registration Data)
-- =====================================================
CREATE TABLE students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id VARCHAR(50) UNIQUE,
    username VARCHAR(100) UNIQUE NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    college_id INT,
    program_id INT,
    registration_status ENUM('pending', 'approved', 'rejected', 'suspended') DEFAULT 'pending',
    enrollment_date DATE,
    graduation_date DATE NULL,
    gpa DECIMAL(3,2) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Foreign key constraints
    FOREIGN KEY (college_id) REFERENCES colleges(id) ON DELETE SET NULL,
    FOREIGN KEY (program_id) REFERENCES programs(id) ON DELETE SET NULL,
    
    -- Indexes for better performance
    INDEX idx_student_id (student_id),
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_college_program (college_id, program_id),
    INDEX idx_registration_status (registration_status)
);

-- =====================================================
-- 4. STUDENT PROFILES TABLE (Additional Information)
-- =====================================================
CREATE TABLE student_profiles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT UNIQUE NOT NULL,
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other'),
    nationality VARCHAR(100),
    address TEXT,
    city VARCHAR(100),
    state VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100) DEFAULT 'Malaysia',
    emergency_contact_name VARCHAR(255),
    emergency_contact_phone VARCHAR(20),
    emergency_contact_relationship VARCHAR(100),
    profile_picture VARCHAR(500),
    bio TEXT,
    interests JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- =====================================================
-- 5. REGISTRATION LOGS TABLE (Track Form Submissions)
-- =====================================================
CREATE TABLE registration_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    action_type ENUM('registration', 'update', 'validation', 'reset') NOT NULL,
    form_data JSON,
    validation_results JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    browser_info JSON,
    session_id VARCHAR(255),
    status ENUM('success', 'failed', 'pending') DEFAULT 'pending',
    error_message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE SET NULL,
    INDEX idx_action_type (action_type),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
);

-- =====================================================
-- 6. SYSTEM SETTINGS TABLE
-- =====================================================
CREATE TABLE system_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type ENUM('string', 'number', 'boolean', 'json') DEFAULT 'string',
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- 7. ADMIN USERS TABLE (For System Management)
-- =====================================================
CREATE TABLE admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(255),
    role ENUM('super_admin', 'admin', 'moderator') DEFAULT 'moderator',
    permissions JSON,
    last_login TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_role (role)
);

-- =====================================================
-- 8. AUDIT TRAIL TABLE (Track All Changes)
-- =====================================================
CREATE TABLE audit_trail (
    id INT PRIMARY KEY AUTO_INCREMENT,
    table_name VARCHAR(100) NOT NULL,
    record_id INT NOT NULL,
    action ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    old_values JSON,
    new_values JSON,
    changed_by INT,
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    user_agent TEXT,
    
    INDEX idx_table_record (table_name, record_id),
    INDEX idx_action (action),
    INDEX idx_changed_at (changed_at)
);

-- =====================================================
-- CREATE VIEWS FOR EASY DATA ACCESS
-- =====================================================

-- View: Complete Student Information
CREATE VIEW student_complete_info AS
SELECT 
    s.id,
    s.student_id,
    s.username,
    s.first_name,
    s.last_name,
    CONCAT(s.first_name, ' ', s.last_name) as full_name,
    s.email,
    s.phone,
    c.name as college_name,
    c.full_name as college_full_name,
    p.name as program_name,
    p.degree_level,
    s.registration_status,
    s.enrollment_date,
    s.gpa,
    sp.date_of_birth,
    sp.gender,
    sp.nationality,
    sp.city,
    sp.country,
    s.created_at as registration_date
FROM students s
LEFT JOIN colleges c ON s.college_id = c.id
LEFT JOIN programs p ON s.program_id = p.id
LEFT JOIN student_profiles sp ON s.id = sp.student_id;

-- View: Registration Statistics
CREATE VIEW registration_statistics AS
SELECT 
    DATE(created_at) as registration_date,
    COUNT(*) as total_registrations,
    COUNT(CASE WHEN registration_status = 'approved' THEN 1 END) as approved_count,
    COUNT(CASE WHEN registration_status = 'pending' THEN 1 END) as pending_count,
    COUNT(CASE WHEN registration_status = 'rejected' THEN 1 END) as rejected_count
FROM students
GROUP BY DATE(created_at)
ORDER BY registration_date DESC;

-- =====================================================
-- CREATE STORED PROCEDURES
-- =====================================================

DELIMITER //

-- Procedure: Register New Student
CREATE PROCEDURE RegisterStudent(
    IN p_username VARCHAR(100),
    IN p_first_name VARCHAR(100),
    IN p_last_name VARCHAR(100),
    IN p_email VARCHAR(255),
    IN p_phone VARCHAR(20),
    IN p_college_code VARCHAR(50),
    IN p_program_code VARCHAR(50),
    IN p_student_id VARCHAR(50),
    OUT p_result_id INT,
    OUT p_message VARCHAR(500)
)
BEGIN
    DECLARE v_college_id INT DEFAULT NULL;
    DECLARE v_program_id INT DEFAULT NULL;
    DECLARE v_error_count INT DEFAULT 0;
    
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
    BEGIN
        SET p_result_id = -1;
        SET p_message = 'Database error occurred during registration';
        ROLLBACK;
    END;
    
    START TRANSACTION;
    
    -- Get college ID
    IF p_college_code IS NOT NULL AND p_college_code != '' THEN
        SELECT id INTO v_college_id FROM colleges WHERE code = p_college_code AND status = 'active';
    END IF;
    
    -- Get program ID
    IF p_program_code IS NOT NULL AND p_program_code != '' THEN
        SELECT id INTO v_program_id FROM programs WHERE code = p_program_code AND status = 'active';
    END IF;
    
    -- Insert student record
    INSERT INTO students (
        student_id, username, first_name, last_name, email, phone, 
        college_id, program_id, enrollment_date
    ) VALUES (
        p_student_id, p_username, p_first_name, p_last_name, p_email, p_phone,
        v_college_id, v_program_id, CURDATE()
    );
    
    SET p_result_id = LAST_INSERT_ID();
    SET p_message = 'Student registered successfully';
    
    COMMIT;
END //

DELIMITER ;

-- =====================================================
-- CREATE TRIGGERS FOR AUDIT TRAIL
-- =====================================================

DELIMITER //

-- Trigger: Students Insert
CREATE TRIGGER students_insert_audit
AFTER INSERT ON students
FOR EACH ROW
BEGIN
    INSERT INTO audit_trail (table_name, record_id, action, new_values)
    VALUES ('students', NEW.id, 'INSERT', JSON_OBJECT(
        'student_id', NEW.student_id,
        'username', NEW.username,
        'first_name', NEW.first_name,
        'last_name', NEW.last_name,
        'email', NEW.email,
        'phone', NEW.phone,
        'college_id', NEW.college_id,
        'program_id', NEW.program_id,
        'registration_status', NEW.registration_status
    ));
END //

-- Trigger: Students Update
CREATE TRIGGER students_update_audit
AFTER UPDATE ON students
FOR EACH ROW
BEGIN
    INSERT INTO audit_trail (table_name, record_id, action, old_values, new_values)
    VALUES ('students', NEW.id, 'UPDATE', 
        JSON_OBJECT(
            'student_id', OLD.student_id,
            'username', OLD.username,
            'first_name', OLD.first_name,
            'last_name', OLD.last_name,
            'email', OLD.email,
            'phone', OLD.phone,
            'registration_status', OLD.registration_status
        ),
        JSON_OBJECT(
            'student_id', NEW.student_id,
            'username', NEW.username,
            'first_name', NEW.first_name,
            'last_name', NEW.last_name,
            'email', NEW.email,
            'phone', NEW.phone,
            'registration_status', NEW.registration_status
        )
    );
END //

DELIMITER ;