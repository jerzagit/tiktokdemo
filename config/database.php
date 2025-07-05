<?php
/**
 * Database Configuration for Student Registration System
 * 
 * This file contains database connection settings and helper functions
 * for the student registration system.
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'student_registration_system');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Database Connection Class
class Database {
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $charset = DB_CHARSET;
    private $pdo;
    
    /**
     * Get database connection
     */
    public function getConnection() {
        $this->pdo = null;
        
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
            
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        
        return $this->pdo;
    }
}

// Student Registration Handler Class
class StudentRegistration {
    private $conn;
    private $table_name = "students";
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    /**
     * Register a new student
     */
    public function register($data) {
        try {
            // Start transaction
            $this->conn->beginTransaction();
            
            // Get college ID
            $college_id = $this->getCollegeId($data['college']);
            
            // Get program ID  
            $program_id = $this->getProgramId($data['class']);
            
            // Prepare SQL statement
            $query = "INSERT INTO " . $this->table_name . " 
                     (student_id, username, first_name, last_name, email, phone, college_id, program_id, enrollment_date) 
                     VALUES (:student_id, :username, :first_name, :last_name, :email, :phone, :college_id, :program_id, CURDATE())";
            
            $stmt = $this->conn->prepare($query);
            
            // Bind parameters
            $stmt->bindParam(':student_id', $data['student_id']);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':first_name', $data['fname']);
            $stmt->bindParam(':last_name', $data['lname']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':college_id', $college_id);
            $stmt->bindParam(':program_id', $program_id);
            
            // Execute query
            if($stmt->execute()) {
                $student_id = $this->conn->lastInsertId();
                
                // Log the registration
                $this->logRegistration($student_id, $data, 'registration', 'success');
                
                // Commit transaction
                $this->conn->commit();
                
                return [
                    'success' => true,
                    'message' => 'Student registered successfully',
                    'student_id' => $student_id,
                    'data' => $data
                ];
            }
            
        } catch(Exception $e) {
            // Rollback transaction
            $this->conn->rollback();
            
            // Log the error
            $this->logRegistration(null, $data, 'registration', 'failed', $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage(),
                'data' => $data
            ];
        }
    }
    
    /**
     * Validate form data
     */
    public function validate($data) {
        $errors = [];
        $valid_fields = [];
        
        // Required fields
        $required_fields = ['username', 'fname', 'lname', 'email', 'phone', 'college', 'class'];
        
        foreach($required_fields as $field) {
            if(empty($data[$field]) || trim($data[$field]) === '') {
                $errors[] = [
                    'field' => $field,
                    'error' => 'Required field is empty',
                    'value' => $data[$field] ?? null
                ];
            } else {
                $valid_fields[] = [
                    'field' => $field,
                    'value' => $data[$field]
                ];
            }
        }
        
        // Email validation
        if(!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = [
                'field' => 'email',
                'error' => 'Invalid email format',
                'value' => $data['email']
            ];
        }
        
        // Check if username already exists
        if(!empty($data['username']) && $this->usernameExists($data['username'])) {
            $errors[] = [
                'field' => 'username',
                'error' => 'Username already exists',
                'value' => $data['username']
            ];
        }
        
        // Check if email already exists
        if(!empty($data['email']) && $this->emailExists($data['email'])) {
            $errors[] = [
                'field' => 'email',
                'error' => 'Email already registered',
                'value' => $data['email']
            ];
        }
        
        $validation_result = [
            'timestamp' => date('c'),
            'isValid' => empty($errors),
            'formData' => $data,
            'validationErrors' => $errors,
            'validFields' => $valid_fields
        ];
        
        // Log validation
        $this->logRegistration(null, $data, 'validation', empty($errors) ? 'success' : 'failed', null, $validation_result);
        
        return $validation_result;
    }
    
    /**
     * Get college ID by code
     */
    private function getCollegeId($college_code) {
        if(empty($college_code)) return null;
        
        $query = "SELECT id FROM colleges WHERE code = :code AND status = 'active'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':code', $college_code);
        $stmt->execute();
        
        $result = $stmt->fetch();
        return $result ? $result['id'] : null;
    }
    
    /**
     * Get program ID by code
     */
    private function getProgramId($program_code) {
        if(empty($program_code)) return null;
        
        $query = "SELECT id FROM programs WHERE code = :code AND status = 'active'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':code', $program_code);
        $stmt->execute();
        
        $result = $stmt->fetch();
        return $result ? $result['id'] : null;
    }
    
    /**
     * Check if username exists
     */
    private function usernameExists($username) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
    
    /**
     * Check if email exists
     */
    private function emailExists($email) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
    
    /**
     * Log registration activity
     */
    private function logRegistration($student_id, $form_data, $action_type, $status, $error_message = null, $validation_results = null) {
        try {
            $query = "INSERT INTO registration_logs 
                     (student_id, action_type, form_data, validation_results, ip_address, user_agent, status, error_message) 
                     VALUES (:student_id, :action_type, :form_data, :validation_results, :ip_address, :user_agent, :status, :error_message)";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':action_type', $action_type);
            $stmt->bindParam(':form_data', json_encode($form_data));
            $stmt->bindParam(':validation_results', json_encode($validation_results));
            $stmt->bindParam(':ip_address', $_SERVER['REMOTE_ADDR'] ?? 'unknown');
            $stmt->bindParam(':user_agent', $_SERVER['HTTP_USER_AGENT'] ?? 'unknown');
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':error_message', $error_message);
            
            $stmt->execute();
            
        } catch(Exception $e) {
            // Silent fail for logging errors
            error_log("Failed to log registration activity: " . $e->getMessage());
        }
    }
    
    /**
     * Get all students with complete information
     */
    public function getAllStudents($limit = 50, $offset = 0) {
        $query = "SELECT * FROM student_complete_info ORDER BY registration_date DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Get student by ID
     */
    public function getStudentById($id) {
        $query = "SELECT * FROM student_complete_info WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    /**
     * Get registration statistics
     */
    public function getRegistrationStats() {
        $query = "SELECT * FROM registration_statistics ORDER BY registration_date DESC LIMIT 30";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}

// Utility Functions
class DatabaseUtils {
    
    /**
     * Get all colleges
     */
    public static function getColleges($conn) {
        $query = "SELECT * FROM colleges WHERE status = 'active' ORDER BY name";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Get all programs
     */
    public static function getPrograms($conn) {
        $query = "SELECT * FROM programs WHERE status = 'active' ORDER BY name";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    /**
     * Get system settings
     */
    public static function getSystemSettings($conn) {
        $query = "SELECT * FROM system_settings WHERE is_active = TRUE";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        
        $settings = [];
        while($row = $stmt->fetch()) {
            $value = $row['setting_value'];
            
            // Convert based on type
            switch($row['setting_type']) {
                case 'boolean':
                    $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                    break;
                case 'number':
                    $value = is_numeric($value) ? (float)$value : $value;
                    break;
                case 'json':
                    $value = json_decode($value, true);
                    break;
            }
            
            $settings[$row['setting_key']] = $value;
        }
        
        return $settings;
    }
}

// Error handling
function handleDatabaseError($error) {
    error_log("Database Error: " . $error);
    
    return [
        'success' => false,
        'message' => 'A database error occurred. Please try again later.',
        'error' => $error
    ];
}

// Response helper
function jsonResponse($data, $status_code = 200) {
    http_response_code($status_code);
    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
}
?>