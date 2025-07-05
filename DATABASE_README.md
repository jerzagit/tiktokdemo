# Student Registration System - Database Structure

## 📋 Overview

This database structure is designed for a comprehensive student registration system that handles student information, college/university data, academic programs, and registration tracking with full audit capabilities.

## 🗄️ Database Schema

### Core Tables

#### 1. **colleges** - Educational Institutions
- Stores information about universities and colleges
- Includes public, private, and international institutions
- Tracks establishment year, location, and website

#### 2. **programs** - Academic Programs
- Contains all available courses/programs
- Categorized by field (Computer Science, Engineering, etc.)
- Includes degree levels (Diploma, Bachelor, Master, PhD)

#### 3. **students** - Main Registration Data
- Primary student information and registration details
- Links to colleges and programs via foreign keys
- Tracks registration status and enrollment dates

#### 4. **student_profiles** - Extended Student Information
- Additional personal information (DOB, gender, address)
- Emergency contacts and interests
- Profile pictures and bio information

#### 5. **registration_logs** - Activity Tracking
- Logs all form submissions and validations
- Stores JSON data of form submissions
- Tracks IP addresses and browser information

#### 6. **system_settings** - Configuration
- System-wide settings and configurations
- Supports different data types (string, number, boolean, JSON)

#### 7. **admin_users** - System Administration
- Admin user accounts with role-based permissions
- Password hashing and session management

#### 8. **audit_trail** - Change Tracking
- Comprehensive audit log for all database changes
- Tracks old and new values for updates

## 🚀 Setup Instructions

### 1. Database Installation

```bash
# Start XAMPP services
# Open phpMyAdmin (http://localhost/phpmyadmin)

# Or use MySQL command line:
mysql -u root -p
```

### 2. Create Database and Tables

```sql
-- Run the schema file
source /path/to/database_schema.sql

-- Or copy and paste the contents of database_schema.sql
```

### 3. Insert Sample Data

```sql
-- Run the sample data file
source /path/to/sample_data.sql

-- Or copy and paste the contents of sample_data.sql
```

### 4. Configure PHP Connection

Update the database configuration in `config/database.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'student_registration_system');
define('DB_USER', 'root');
define('DB_PASS', ''); // Your MySQL password
```

## 📊 Database Features

### Views
- **student_complete_info**: Complete student data with college and program names
- **registration_statistics**: Daily registration statistics

### Stored Procedures
- **RegisterStudent**: Automated student registration with validation

### Triggers
- **Audit Trail Triggers**: Automatically log all changes to student records

### Indexes
- Optimized for common queries (username, email, student_id)
- Foreign key relationships for data integrity

## 🔧 API Endpoints

### Registration API (`/api/register.php`)

#### POST Requests
```javascript
// Register new student
fetch('/api/register.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        action: 'register',
        username: 'john_doe',
        fname: 'John',
        lname: 'Doe',
        email: 'john@university.edu',
        phone: '+60 12-345 6789',
        college: 'UM',
        class: 'CS'
    })
});

// Validate form data
fetch('/api/register.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        action: 'validate',
        username: 'john_doe',
        // ... other form fields
    })
});
```

#### GET Requests
```javascript
// Get all colleges
fetch('/api/register.php?action=colleges')

// Get all programs
fetch('/api/register.php?action=programs')

// Get all students
fetch('/api/register.php?action=students&limit=50&offset=0')

// Get specific student
fetch('/api/register.php?action=student&id=1')

// Get registration statistics
fetch('/api/register.php?action=stats')

// Get system settings
fetch('/api/register.php?action=settings')
```

## 📈 Sample Queries

### Get Student Information
```sql
-- Get all students with complete information
SELECT * FROM student_complete_info 
ORDER BY registration_date DESC;

-- Get students by registration status
SELECT registration_status, COUNT(*) as count 
FROM students 
GROUP BY registration_status;
```

### Registration Analytics
```sql
-- Daily registration statistics
SELECT * FROM registration_statistics 
ORDER BY registration_date DESC 
LIMIT 30;

-- Most popular programs
SELECT p.name, COUNT(s.id) as student_count 
FROM programs p 
LEFT JOIN students s ON p.id = s.program_id 
GROUP BY p.id, p.name 
ORDER BY student_count DESC;
```

### Audit and Logging
```sql
-- Get recent activities
SELECT rl.*, s.username, s.first_name, s.last_name 
FROM registration_logs rl 
LEFT JOIN students s ON rl.student_id = s.id 
ORDER BY rl.created_at DESC 
LIMIT 20;

-- Get audit trail for specific student
SELECT * FROM audit_trail 
WHERE table_name = 'students' AND record_id = 1 
ORDER BY changed_at DESC;
```

## 🔒 Security Features

### Data Protection
- **Password Hashing**: Admin passwords use PHP's password_hash()
- **SQL Injection Prevention**: All queries use prepared statements
- **Input Validation**: Server-side validation for all form fields
- **Audit Trail**: Complete change tracking for accountability

### Access Control
- **Role-based Permissions**: Different admin levels (super_admin, admin, moderator)
- **Session Management**: Secure session handling
- **IP Tracking**: Log IP addresses for security monitoring

## 📱 Integration with HTML Form

The database structure is designed to work seamlessly with your HTML registration form:

### Form Field Mapping
```javascript
// HTML form fields → Database columns
{
    "username": "students.username",
    "fname": "students.first_name", 
    "lname": "students.last_name",
    "email": "students.email",
    "phone": "students.phone",
    "college": "colleges.code → students.college_id",
    "class": "programs.code → students.program_id",
    "student-id": "students.student_id"
}
```

### JSON Logging
All form submissions are logged in JSON format in the `registration_logs` table:

```json
{
    "timestamp": "2024-01-15T10:30:45.123Z",
    "formData": {
        "username": "john_doe",
        "fname": "John",
        "lname": "Doe",
        "email": "john@university.edu",
        "phone": "+60 12-345 6789",
        "college": "UM",
        "class": "CS"
    },
    "validationResults": {
        "isValid": true,
        "validationErrors": [],
        "validFields": [...]
    }
}
```

## 🛠️ Maintenance

### Regular Tasks
1. **Backup Database**: Regular automated backups
2. **Clean Logs**: Archive old registration logs
3. **Update Statistics**: Refresh materialized views if needed
4. **Monitor Performance**: Check slow queries and optimize indexes

### Monitoring Queries
```sql
-- Check database size
SELECT 
    table_name,
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'Size (MB)'
FROM information_schema.tables 
WHERE table_schema = 'student_registration_system'
ORDER BY (data_length + index_length) DESC;

-- Check recent registrations
SELECT DATE(created_at) as date, COUNT(*) as registrations
FROM students 
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
GROUP BY DATE(created_at)
ORDER BY date DESC;
```

## 🎯 Next Steps

1. **Set up the database** using the provided SQL files
2. **Configure PHP connection** in the config file
3. **Test API endpoints** using the provided examples
4. **Integrate with your HTML form** using JavaScript fetch calls
5. **Monitor and maintain** using the provided queries

The database structure is production-ready and includes all necessary features for a professional student registration system!