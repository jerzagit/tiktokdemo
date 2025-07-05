<!DOCTYPE html>
<html lang="en">
<?php


session_start();
// remove all session variables


// 1. connect ke database
$servername = "localhost"; //datatbase localhost, kita takde 
$username = "root";
$password = ""; //kosong
$database_name = "demotiktok";

// Create connection
$conn = new mysqli($servername, $username, $password,  $database_name);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// dapakatn record institution data dari database

$sql = "SELECT * FROM `institution`";
$senarai_institution = $conn->query($sql);

// dapakatn record institution data dari database

$sql = "SELECT * FROM `class_program`";
$senarai_class = $conn->query($sql);

?>

<head>
    <title>Professional Student Registration Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 2.2em;
            font-weight: 300;
        }

        .tech-stack {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            text-align: center;
            font-size: 1.1em;
            letter-spacing: 2px;
        }

        .form-container {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.95em;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e8ed;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        select:focus {
            outline: none;
            border-color: #4facfe;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        button {
            flex: 1;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-ok {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .btn-ok:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
        }

        .btn-cancel {
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
            color: white;
        }

        .btn-cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
        }

        .demo-section {
            background: #f8f9fa;
            padding: 30px;
            border-top: 1px solid #e9ecef;
        }

        .demo-section h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }

        #demo {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
            font-size: 1.1em;
            color: #495057;
            border-left: 4px solid #4facfe;
        }

        .demo-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-demo {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-demo:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.3);
        }

        .required {
            color: #e74c3c;
        }

        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 10px;
            }
            
            .form-container {
                padding: 20px;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            button {
                width: 100%;
            }
        }
    </style>
</head>

JAVA , PHP , Python , C++, Ruby, 

<body>
    <div class="container">
        <div class="header">
            <h1>🌍 Overseas Exchange Application</h1>
            <p>GlobalEdu Exchange Program Registration</p>
        </div>

        <div class="tech-stack">
            Study Abroad • Cultural Exchange • Academic Excellence • Global Network
        </div>

        <div class="form-container">
            <p style="text-align: center; color: #6c757d; margin-bottom: 30px;">
                <em>Apply for life-changing overseas educational experiences</em>
            </p>
            
            <form id="studentForm">
                <div class="form-group">
                    <label for="fname">First Name <span class="required">*</span></label>
                    <input type="text" id="fname" name="fname" placeholder="Enter your first name" required>
                </div>

                <div class="form-group">
                    <label for="lname">Last Name <span class="required">*</span></label>
                    <input type="text" id="lname" name="lname" placeholder="Masukkan Nama Akhir" 
                    value="<?php echo $_SESSION['default_username']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email" placeholder="student@university.edu" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number <span class="required">*</span></label>
                    <input type="tel" id="phone" name="phone" placeholder="+60 12-345 6789" required>
                </div>

                <div class="form-group">
                    <label for="student-id">Student ID <span class="required">*</span></label>
                    <input type="text" id="student-id" name="student-id" placeholder="e.g., 2024001234" required>
                </div>

                <div class="form-group">
                    <label for="college">Current College/University <span class="required">*</span></label>
                    <select id="college" name="college" required>
                        <option value="">Select your current institution</option>
                        <?php
                        // condition 
                        if ($senarai_institution->num_rows > 0) {
                          // loops 
                          while($row = $senarai_institution->fetch_assoc()) {
                            echo '<option value="' . $row["id"] . '">' . $row["institutional_name"] . '</option>';
                          }
                        } else {
                          echo '<option value="">No institutions available</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="class">Current Program/Major <span class="required">*</span></label>
                    <select id="class" name="class" required>
                        <option value="">Select your current program</option>
                        <?php
                        // Reset the result pointer for reuse
                        $senarai_class->data_seek(0);
                        // condition 
                        if ($senarai_class->num_rows > 0) {
                          // loops 
                          while($row = $senarai_class->fetch_assoc()) {
                            echo '<option value="' . $row["id"] . '">' . $row["class_name"] . '</option>';
                          }
                        } else {
                          echo '<option value="">No programs available</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="exchange-program">Preferred Exchange Program <span class="required">*</span></label>
                    <select id="exchange-program" name="exchange-program" required>
                        <option value="">Select exchange program</option>
                        <option value="tokyo-tech">Tokyo Tech Innovation Summit - Japan</option>
                        <option value="swiss-alpine">Swiss Alpine Research Program - Switzerland</option>
                        <option value="oxford-academic">Oxford Academic Excellence - United Kingdom</option>
                        <option value="nasa-space">NASA Space Technology Program - USA</option>
                        <option value="amazon-conservation">Amazon Rainforest Conservation - Brazil</option>
                        <option value="beijing-cultural">Beijing Cultural Immersion - China</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="gpa">Current GPA <span class="required">*</span></label>
                    <input type="text" id="gpa" name="gpa" placeholder="e.g., 3.75" required>
                </div>

                <div class="form-group">
                    <label for="language-proficiency">Language Proficiency</label>
                    <select id="language-proficiency" name="language-proficiency">
                        <option value="">Select your language level</option>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                        <option value="native">Native/Fluent</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="motivation">Why do you want to join this program? <span class="required">*</span></label>
                    <textarea id="motivation" name="motivation" rows="4" placeholder="Describe your motivation and goals for this exchange program..." required style="width: 100%; padding: 12px 15px; border: 2px solid #e1e8ed; border-radius: 8px; font-size: 16px; font-family: inherit; resize: vertical;"></textarea>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn-submit">Submit Application</button>
                    <button type="button" class="btn-ok" onclick="validateForm()">Validate Form</button>
                    <button type="button" class="btn-cancel" onclick="resetForm()">Clear Form</button>
                    <button type="button" class="btn-cancel" onclick="window.location.href='index.php'" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%);">Back to Dashboard</button>
                </div>
            </form>
        </div>

        <div class="demo-section">
            <h2>🌟 Application Status</h2>
            <p id="demo">Ready to start your global education journey! Complete the form above to apply.</p>
            
            <div class="demo-buttons">
                <button type="button" class="btn-demo" onclick='document.getElementById("demo").innerHTML = "🎓 Your application will open doors to amazing opportunities worldwide!"'>Inspire Me!</button>
                <button type="button" class="btn-demo" onclick='changeBackground("linear-gradient(135deg, #667eea 0%, #764ba2 100%)")'>Default Theme</button>
                <button type="button" class="btn-demo" onclick='changeBackground("linear-gradient(135deg, #11998e 0%, #38ef7d 100%)")'>Success Theme</button>
            </div>
        </div>
    </div>

    <script>
        // JAVASCRIPT is a programming language that adds interactivity to your website.
        // It allows you to create dynamic and interactive web pages, such as games,
        // calculators, and more. With JavaScript, you can manipulate the content of
        // your webpage in response to user actions like clicks, mouse movements, key presses,
        // and form submissions.

        // Enhanced background change function
        function changeBackground(gradient) {
            document.body.style.background = gradient;
        }

        // Form validation function
        function validateForm() {
            const form = document.getElementById('studentForm');
            const formData = new FormData(form);
            let isValid = true;
            let message = "Form Validation Results:\n\n";

            // Check required fields
            const requiredFields = ['fname', 'lname', 'email', 'phone', 'student-id', 'college', 'class', 'exchange-program', 'gpa', 'motivation'];
            
            requiredFields.forEach(field => {
                const value = formData.get(field);
                if (!value || value.trim() === '') {
                    isValid = false;
                    message += `❌ ${field.replace('-', ' ').toUpperCase()}: Required field is empty\n`;
                } else {
                    message += `✅ ${field.replace('-', ' ').toUpperCase()}: ${value}\n`;
                }
            });

            // Email validation
            const email = formData.get('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email && !emailRegex.test(email)) {
                isValid = false;
                message += "❌ EMAIL: Invalid email format\n";
            }

            if (isValid) {
                document.getElementById('demo').innerHTML = "✅ All fields are valid! Ready to submit.";
                document.getElementById('demo').style.borderLeftColor = "#28a745";
            } else {
                document.getElementById('demo').innerHTML = "❌ Please check the form for errors.";
                document.getElementById('demo').style.borderLeftColor = "#dc3545";
            }

            alert(message);
        }

        // Reset form function
        function resetForm() {
            document.getElementById('studentForm').reset();
            document.getElementById('demo').innerHTML = "Form has been cleared. Ready for new exchange application!";
            document.getElementById('demo').style.borderLeftColor = "#4facfe";
        }

        // Form submission handler
        document.getElementById('studentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            let submissionData = "Registration Submitted Successfully!\n\n";
            
            for (let [key, value] of formData.entries()) {
                if (value.trim() !== '') {
                    submissionData += `${key.replace('-', ' ').toUpperCase()}: ${value}\n`;
                }
            }
            
            alert(submissionData);
            document.getElementById('demo').innerHTML = "🎉 Registration submitted successfully! Welcome to our academic community!";
            document.getElementById('demo').style.borderLeftColor = "#28a745";
        });

        // Add some interactive effects
        document.querySelectorAll('input, select').forEach(element => {
            element.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.parentElement.style.transition = 'transform 0.2s ease';
            });
            
            element.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>