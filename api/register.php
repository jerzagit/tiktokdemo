<?php
/**
 * Student Registration API Endpoint
 * 
 * This file handles student registration form submissions
 * and returns JSON responses.
 */

// Enable CORS for development
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Include database configuration
require_once '../config/database.php';

// Set content type to JSON
header('Content-Type: application/json');

try {
    // Initialize database connection
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        throw new Exception("Database connection failed");
    }
    
    // Initialize student registration handler
    $student_registration = new StudentRegistration($db);
    
    // Handle different request methods
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            handleRegistration($student_registration);
            break;
            
        case 'GET':
            handleGetRequests($student_registration, $db);
            break;
            
        default:
            jsonResponse([
                'success' => false,
                'message' => 'Method not allowed'
            ], 405);
    }
    
} catch (Exception $e) {
    jsonResponse([
        'success' => false,
        'message' => 'Server error occurred',
        'error' => $e->getMessage()
    ], 500);
}

/**
 * Handle POST requests (registration and validation)
 */
function handleRegistration($student_registration) {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    // If no JSON input, try form data
    if (!$input) {
        $input = $_POST;
    }
    
    // Check if this is a validation request
    $action = $input['action'] ?? 'register';
    
    switch ($action) {
        case 'validate':
            handleValidation($student_registration, $input);
            break;
            
        case 'register':
            handleStudentRegistration($student_registration, $input);
            break;
            
        default:
            jsonResponse([
                'success' => false,
                'message' => 'Invalid action specified'
            ], 400);
    }
}

/**
 * Handle form validation
 */
function handleValidation($student_registration, $data) {
    // Remove action from data
    unset($data['action']);
    
    // Validate the form data
    $validation_result = $student_registration->validate($data);
    
    // Return validation results
    jsonResponse([
        'success' => true,
        'action' => 'validation',
        'validation' => $validation_result,
        'timestamp' => date('c')
    ]);
}

/**
 * Handle student registration
 */
function handleStudentRegistration($student_registration, $data) {
    // Remove action from data
    unset($data['action']);
    
    // Generate student ID if not provided
    if (empty($data['student_id'])) {
        $data['student_id'] = generateStudentId();
    }
    
    // First validate the data
    $validation_result = $student_registration->validate($data);
    
    if (!$validation_result['isValid']) {
        jsonResponse([
            'success' => false,
            'action' => 'registration',
            'message' => 'Validation failed',
            'validation' => $validation_result,
            'timestamp' => date('c')
        ], 400);
    }
    
    // Proceed with registration
    $registration_result = $student_registration->register($data);
    
    if ($registration_result['success']) {
        jsonResponse([
            'success' => true,
            'action' => 'registration',
            'message' => $registration_result['message'],
            'student_id' => $registration_result['student_id'],
            'data' => $registration_result['data'],
            'validation' => $validation_result,
            'timestamp' => date('c')
        ]);
    } else {
        jsonResponse([
            'success' => false,
            'action' => 'registration',
            'message' => $registration_result['message'],
            'data' => $registration_result['data'],
            'timestamp' => date('c')
        ], 400);
    }
}

/**
 * Handle GET requests
 */
function handleGetRequests($student_registration, $db) {
    $action = $_GET['action'] ?? 'info';
    
    switch ($action) {
        case 'colleges':
            $colleges = DatabaseUtils::getColleges($db);
            jsonResponse([
                'success' => true,
                'data' => $colleges
            ]);
            break;
            
        case 'programs':
            $programs = DatabaseUtils::getPrograms($db);
            jsonResponse([
                'success' => true,
                'data' => $programs
            ]);
            break;
            
        case 'students':
            $limit = (int)($_GET['limit'] ?? 50);
            $offset = (int)($_GET['offset'] ?? 0);
            $students = $student_registration->getAllStudents($limit, $offset);
            jsonResponse([
                'success' => true,
                'data' => $students,
                'pagination' => [
                    'limit' => $limit,
                    'offset' => $offset
                ]
            ]);
            break;
            
        case 'student':
            $id = $_GET['id'] ?? null;
            if (!$id) {
                jsonResponse([
                    'success' => false,
                    'message' => 'Student ID required'
                ], 400);
            }
            
            $student = $student_registration->getStudentById($id);
            if ($student) {
                jsonResponse([
                    'success' => true,
                    'data' => $student
                ]);
            } else {
                jsonResponse([
                    'success' => false,
                    'message' => 'Student not found'
                ], 404);
            }
            break;
            
        case 'stats':
            $stats = $student_registration->getRegistrationStats();
            jsonResponse([
                'success' => true,
                'data' => $stats
            ]);
            break;
            
        case 'settings':
            $settings = DatabaseUtils::getSystemSettings($db);
            jsonResponse([
                'success' => true,
                'data' => $settings
            ]);
            break;
            
        case 'info':
        default:
            jsonResponse([
                'success' => true,
                'message' => 'Student Registration API',
                'version' => '1.0.0',
                'endpoints' => [
                    'POST /api/register.php' => 'Register new student or validate form',
                    'GET /api/register.php?action=colleges' => 'Get all colleges',
                    'GET /api/register.php?action=programs' => 'Get all programs',
                    'GET /api/register.php?action=students' => 'Get all students',
                    'GET /api/register.php?action=student&id=X' => 'Get student by ID',
                    'GET /api/register.php?action=stats' => 'Get registration statistics',
                    'GET /api/register.php?action=settings' => 'Get system settings'
                ],
                'timestamp' => date('c')
            ]);
    }
}

/**
 * Generate unique student ID
 */
function generateStudentId() {
    $year = date('Y');
    $random = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
    return $year . $random;
}

/**
 * Log API request for debugging
 */
function logApiRequest($data) {
    $log_data = [
        'timestamp' => date('c'),
        'method' => $_SERVER['REQUEST_METHOD'],
        'uri' => $_SERVER['REQUEST_URI'],
        'data' => $data,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
    ];
    
    error_log("API Request: " . json_encode($log_data));
}
?>