-- =====================================================
-- Sample Data for Student Registration System
-- =====================================================

USE student_registration_system;

-- =====================================================
-- 1. INSERT COLLEGES/UNIVERSITIES
-- =====================================================
INSERT INTO colleges (code, name, full_name, type, location, website, established_year) VALUES
('UM', 'Universiti Malaya', 'Universiti Malaya (University of Malaya)', 'public', 'Kuala Lumpur', 'https://www.um.edu.my', 1905),
('UKM', 'Universiti Kebangsaan Malaysia', 'Universiti Kebangsaan Malaysia (National University of Malaysia)', 'public', 'Bangi, Selangor', 'https://www.ukm.my', 1970),
('USM', 'Universiti Sains Malaysia', 'Universiti Sains Malaysia (University of Science Malaysia)', 'public', 'Penang', 'https://www.usm.my', 1969),
('UTM', 'Universiti Teknologi Malaysia', 'Universiti Teknologi Malaysia (Malaysia University of Technology)', 'public', 'Johor Bahru', 'https://www.utm.my', 1904),
('UPM', 'Universiti Putra Malaysia', 'Universiti Putra Malaysia (Putra University Malaysia)', 'public', 'Serdang, Selangor', 'https://www.upm.edu.my', 1931),
('TAYLOR', 'Taylor\'s University', 'Taylor\'s University', 'private', 'Subang Jaya, Selangor', 'https://www.taylors.edu.my', 1969),
('SUNWAY', 'Sunway University', 'Sunway University', 'private', 'Bandar Sunway, Selangor', 'https://www.sunway.edu.my', 1987),
('MONASH', 'Monash University Malaysia', 'Monash University Malaysia', 'international', 'Bandar Sunway, Selangor', 'https://www.monash.edu.my', 1998),
('HELP', 'HELP University', 'HELP University', 'private', 'Kuala Lumpur', 'https://www.help.edu.my', 1986),
('INTI', 'INTI International University', 'INTI International University & Colleges', 'private', 'Nilai, Negeri Sembilan', 'https://www.newinti.edu.my', 1986);

-- =====================================================
-- 2. INSERT PROGRAMS/CLASSES
-- =====================================================
INSERT INTO programs (code, name, description, category, duration_years, degree_level) VALUES
('CS', 'Computer Science', 'Bachelor of Computer Science with focus on software development, algorithms, and system design', 'computer_science', 4, 'bachelor'),
('SE', 'Software Engineering', 'Bachelor of Software Engineering focusing on large-scale software development and project management', 'computer_science', 4, 'bachelor'),
('IT', 'Information Technology', 'Bachelor of Information Technology covering network administration, database management, and IT infrastructure', 'computer_science', 4, 'bachelor'),
('DS', 'Data Science', 'Bachelor of Data Science specializing in big data analytics, machine learning, and statistical analysis', 'computer_science', 4, 'bachelor'),
('CYB', 'Cybersecurity', 'Bachelor of Cybersecurity focusing on information security, ethical hacking, and digital forensics', 'computer_science', 4, 'bachelor'),
('WD', 'Web Development', 'Diploma in Web Development covering frontend and backend web technologies', 'computer_science', 3, 'diploma'),
('MD', 'Mobile Development', 'Diploma in Mobile App Development for iOS and Android platforms', 'computer_science', 3, 'diploma'),
('AI', 'Artificial Intelligence', 'Bachelor of Artificial Intelligence and Machine Learning', 'computer_science', 4, 'bachelor'),
('CE', 'Computer Engineering', 'Bachelor of Computer Engineering combining hardware and software engineering', 'engineering', 4, 'bachelor'),
('IS', 'Information Systems', 'Bachelor of Information Systems focusing on business applications of technology', 'computer_science', 4, 'bachelor');

-- =====================================================
-- 3. INSERT SAMPLE STUDENTS
-- =====================================================
INSERT INTO students (student_id, username, first_name, last_name, email, phone, college_id, program_id, registration_status, enrollment_date) VALUES
('2024001001', 'ahmad_hassan', 'Ahmad', 'Hassan', 'ahmad.hassan@student.um.edu.my', '+60 12-345 6789', 1, 1, 'approved', '2024-01-15'),
('2024001002', 'siti_nurhaliza', 'Siti', 'Nurhaliza', 'siti.nurhaliza@student.ukm.my', '+60 13-456 7890', 2, 2, 'approved', '2024-01-16'),
('2024001003', 'lim_wei_ming', 'Wei Ming', 'Lim', 'weiming.lim@student.usm.my', '+60 14-567 8901', 3, 3, 'pending', '2024-01-17'),
('2024001004', 'raj_kumar', 'Raj', 'Kumar', 'raj.kumar@student.utm.my', '+60 15-678 9012', 4, 4, 'approved', '2024-01-18'),
('2024001005', 'fatimah_zahra', 'Fatimah', 'Zahra', 'fatimah.zahra@student.upm.edu.my', '+60 16-789 0123', 5, 5, 'approved', '2024-01-19'),
('2024001006', 'john_smith', 'John', 'Smith', 'john.smith@student.taylors.edu.my', '+60 17-890 1234', 6, 1, 'pending', '2024-01-20'),
('2024001007', 'michelle_tan', 'Michelle', 'Tan', 'michelle.tan@student.sunway.edu.my', '+60 18-901 2345', 7, 6, 'approved', '2024-01-21'),
('2024001008', 'david_wong', 'David', 'Wong', 'david.wong@student.monash.edu.my', '+60 19-012 3456', 8, 7, 'approved', '2024-01-22'),
('2024001009', 'sarah_ibrahim', 'Sarah', 'Ibrahim', 'sarah.ibrahim@student.help.edu.my', '+60 11-123 4567', 9, 8, 'pending', '2024-01-23'),
('2024001010', 'kevin_lee', 'Kevin', 'Lee', 'kevin.lee@student.newinti.edu.my', '+60 12-234 5678', 10, 9, 'approved', '2024-01-24');

-- =====================================================
-- 4. INSERT STUDENT PROFILES
-- =====================================================
INSERT INTO student_profiles (student_id, date_of_birth, gender, nationality, city, state, country, interests) VALUES
(1, '2002-05-15', 'male', 'Malaysian', 'Kuala Lumpur', 'Kuala Lumpur', 'Malaysia', '["programming", "gaming", "technology", "sports"]'),
(2, '2001-08-22', 'female', 'Malaysian', 'Kajang', 'Selangor', 'Malaysia', '["software engineering", "music", "travel", "reading"]'),
(3, '2002-03-10', 'male', 'Malaysian', 'George Town', 'Penang', 'Malaysia', '["web development", "photography", "cycling", "technology"]'),
(4, '2001-11-30', 'male', 'Malaysian', 'Johor Bahru', 'Johor', 'Malaysia', '["data science", "machine learning", "basketball", "movies"]'),
(5, '2002-07-18', 'female', 'Malaysian', 'Serdang', 'Selangor', 'Malaysia', '["cybersecurity", "ethical hacking", "martial arts", "books"]'),
(6, '2001-12-05', 'male', 'British', 'Subang Jaya', 'Selangor', 'Malaysia', '["programming", "football", "travel", "music"]'),
(7, '2002-04-25', 'female', 'Malaysian', 'Petaling Jaya', 'Selangor', 'Malaysia', '["mobile development", "design", "dancing", "cooking"]'),
(8, '2001-09-14', 'male', 'Australian', 'Bandar Sunway', 'Selangor', 'Malaysia', '["artificial intelligence", "robotics", "tennis", "gaming"]'),
(9, '2002-01-08', 'female', 'Malaysian', 'Kuala Lumpur', 'Kuala Lumpur', 'Malaysia', '["computer engineering", "electronics", "swimming", "art"]'),
(10, '2001-06-20', 'male', 'Malaysian', 'Nilai', 'Negeri Sembilan', 'Malaysia', '["information systems", "business", "badminton", "technology"]');

-- =====================================================
-- 5. INSERT SYSTEM SETTINGS
-- =====================================================
INSERT INTO system_settings (setting_key, setting_value, setting_type, description) VALUES
('registration_enabled', 'true', 'boolean', 'Enable or disable new student registrations'),
('max_registrations_per_day', '100', 'number', 'Maximum number of registrations allowed per day'),
('email_verification_required', 'true', 'boolean', 'Require email verification for new registrations'),
('auto_approve_registrations', 'false', 'boolean', 'Automatically approve new registrations'),
('maintenance_mode', 'false', 'boolean', 'Enable maintenance mode to disable the system'),
('supported_file_types', '["jpg", "jpeg", "png", "pdf", "doc", "docx"]', 'json', 'Supported file types for document uploads'),
('max_file_size_mb', '5', 'number', 'Maximum file size in MB for uploads'),
('session_timeout_minutes', '30', 'number', 'Session timeout in minutes'),
('password_min_length', '8', 'number', 'Minimum password length requirement'),
('contact_email', 'admin@university.edu.my', 'string', 'Contact email for system administration');

-- =====================================================
-- 6. INSERT ADMIN USERS
-- =====================================================
INSERT INTO admin_users (username, email, password_hash, full_name, role, permissions) VALUES
('admin', 'admin@university.edu.my', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', 'super_admin', '["all"]'),
('moderator1', 'mod1@university.edu.my', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Registration Moderator', 'moderator', '["view_students", "approve_registrations", "edit_students"]'),
('registrar', 'registrar@university.edu.my', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'University Registrar', 'admin', '["manage_students", "manage_programs", "view_reports"]');

-- =====================================================
-- 7. INSERT SAMPLE REGISTRATION LOGS
-- =====================================================
INSERT INTO registration_logs (student_id, action_type, form_data, validation_results, ip_address, user_agent, status) VALUES
(1, 'registration', 
 '{"username": "ahmad_hassan", "first_name": "Ahmad", "last_name": "Hassan", "email": "ahmad.hassan@student.um.edu.my", "phone": "+60 12-345 6789", "college": "UM", "program": "CS"}',
 '{"isValid": true, "validationErrors": [], "validFields": ["username", "first_name", "last_name", "email", "phone", "college", "program"]}',
 '192.168.1.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', 'success'),

(2, 'registration',
 '{"username": "siti_nurhaliza", "first_name": "Siti", "last_name": "Nurhaliza", "email": "siti.nurhaliza@student.ukm.my", "phone": "+60 13-456 7890", "college": "UKM", "program": "SE"}',
 '{"isValid": true, "validationErrors": [], "validFields": ["username", "first_name", "last_name", "email", "phone", "college", "program"]}',
 '192.168.1.101', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36', 'success'),

(3, 'validation',
 '{"username": "test_user", "first_name": "", "last_name": "Test", "email": "invalid-email", "phone": "", "college": "", "program": ""}',
 '{"isValid": false, "validationErrors": [{"field": "first_name", "error": "Required field is empty"}, {"field": "email", "error": "Invalid email format"}], "validFields": ["username", "last_name"]}',
 '192.168.1.102', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15', 'failed');

-- =====================================================
-- USEFUL QUERIES FOR TESTING
-- =====================================================

-- Query 1: Get all students with their college and program information
-- SELECT * FROM student_complete_info ORDER BY registration_date DESC;

-- Query 2: Get registration statistics by date
-- SELECT * FROM registration_statistics ORDER BY registration_date DESC LIMIT 10;

-- Query 3: Get students by registration status
-- SELECT registration_status, COUNT(*) as count FROM students GROUP BY registration_status;

-- Query 4: Get most popular programs
-- SELECT p.name, COUNT(s.id) as student_count 
-- FROM programs p 
-- LEFT JOIN students s ON p.id = s.program_id 
-- GROUP BY p.id, p.name 
-- ORDER BY student_count DESC;

-- Query 5: Get most popular colleges
-- SELECT c.name, COUNT(s.id) as student_count 
-- FROM colleges c 
-- LEFT JOIN students s ON c.id = s.college_id 
-- GROUP BY c.id, c.name 
-- ORDER BY student_count DESC;

-- Query 6: Get recent registration activities
-- SELECT rl.*, s.username, s.first_name, s.last_name 
-- FROM registration_logs rl 
-- LEFT JOIN students s ON rl.student_id = s.id 
-- ORDER BY rl.created_at DESC 
-- LIMIT 20;

-- Query 7: Search students by name or email
-- SELECT * FROM student_complete_info 
-- WHERE full_name LIKE '%john%' OR email LIKE '%john%';

-- Query 8: Get students enrolled in a specific date range
-- SELECT * FROM student_complete_info 
-- WHERE enrollment_date BETWEEN '2024-01-01' AND '2024-01-31';

-- Query 9: Get audit trail for a specific student
-- SELECT * FROM audit_trail 
-- WHERE table_name = 'students' AND record_id = 1 
-- ORDER BY changed_at DESC;

-- Query 10: Get system settings
-- SELECT * FROM system_settings WHERE is_active = TRUE;