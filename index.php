<!DOCTYPE html>
<html>
<head>
<title>Global Student Zunnurhaq Dashboard</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<?php

session_start();

//buat ape session, nama ke email, roles
// Set session variables
$_SESSION["default_username"] = "murugan";
$_SESSION["role"] = "aku kan king";

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

// dapakatn record student_programs data dari database

$sql = "SELECT * FROM `student_programs`";
$senarai_students = $conn->query($sql);


?>
<body>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #667eea;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: #667eea;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .hero-section {
            text-align: center;
            color: white;
            margin-bottom: 3rem;
        }
        
        .hero-section h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .hero-section p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card i {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 1rem;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #666;
            font-size: 1rem;
        }
        .section {
            background: rgba(255, 255, 255, 0.95);
            margin: 2rem 0;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .section h3 {
            color: #333;
            border-bottom: 3px solid #667eea;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
            font-size: 1.8rem;
        }
        
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .event-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }
        
        .event-image {
            height: 200px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }
        
        .event-content {
            padding: 1.5rem;
        }
        
        .event-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .event-location {
            color: #667eea;
            font-weight: 500;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .event-description {
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.5;
        }
        
        .event-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        
        .event-date {
            color: #333;
            font-weight: 500;
        }
        
        .event-duration {
            color: #666;
        }
        
        .event-status {
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-open {
            background: #d4edda;
            color: #155724;
        }
        
        .status-closing {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-closed {
            background: #f8d7da;
            color: #721c24;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background: #667eea;
            color: white;
            font-weight: 600;
        }
        
        tr:hover {
            background: #f8f9ff;
        }
        .form-group {
            margin: 1.5rem 0;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }
        
        input, textarea, select {
            width: 100%;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        input[type="checkbox"], input[type="radio"] {
            width: auto;
            margin-right: 0.5rem;
        }
        
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        }
        
        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        
        .infotainment-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 2rem;
            border-radius: 20px;
            margin: 2rem 0;
            text-align: center;
        }
        
        .infotainment-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .info-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }
        
        .info-card h4 {
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }
        
        .quick-stats {
            display: flex;
            justify-content: space-around;
            margin: 2rem 0;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .quick-stat {
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 10px;
            min-width: 120px;
        }
        
        .quick-stat-number {
            font-size: 2rem;
            font-weight: bold;
            display: block;
        }
        
        .quick-stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }
        @media (max-width: 768px) {
            .navbar-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            .nav-links {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .hero-section h1 {
                font-size: 2rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .events-grid {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <i class="fas fa-globe-americas"></i> GlobalEdu Exchange
            </div>
            <ul class="nav-links">
                <li><a href="#dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#events"><i class="fas fa-calendar-alt"></i> Events</a></li>
                <li><a href="#applications"><i class="fas fa-file-alt"></i> Applications</a></li>
                <li><a href="#profile"><i class="fas fa-user"></i> Profile</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- Hero Section -->
        <div class="hero-section">
            <h1><i class="fas fa-graduation-cap"></i> Student Exchange Dashboard</h1>
            <p>Discover amazing overseas opportunities and expand your global horizons</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-globe-asia"></i>
                <div class="stat-number">47</div>
                <div class="stat-label">Countries Available</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-university"></i>
                <div class="stat-number">156</div>
                <div class="stat-label">Partner Universities</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <div class="stat-number">2,847</div>
                <div class="stat-label">Students Placed</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-star"></i>
                <div class="stat-number">4.8</div>
                <div class="stat-label">Average Rating</div>
            </div>
        </div>

        <!-- Infotainment Section -->
        <div class="infotainment-section">
            <h2><i class="fas fa-lightbulb"></i> Did You Know?</h2>
            <div class="quick-stats">
                <div class="quick-stat">
                    <span class="quick-stat-number">89%</span>
                    <span class="quick-stat-label">Career Boost</span>
                </div>
                <div class="quick-stat">
                    <span class="quick-stat-number">3.2x</span>
                    <span class="quick-stat-label">Salary Increase</span>
                </div>
                <div class="quick-stat">
                    <span class="quick-stat-number">95%</span>
                    <span class="quick-stat-label">Satisfaction Rate</span>
                </div>
            </div>
            
            <div class="infotainment-grid">
                <div class="info-card">
                    <h4><i class="fas fa-brain"></i> Cultural Intelligence</h4>
                    <p>Students who study abroad develop 40% higher cultural intelligence, making them more valuable in today's global job market.</p>
                </div>
                <div class="info-card">
                    <h4><i class="fas fa-language"></i> Language Skills</h4>
                    <p>Immersive language learning abroad is 5x more effective than classroom learning, with 78% achieving fluency.</p>
                </div>
                <div class="info-card">
                    <h4><i class="fas fa-network-wired"></i> Global Network</h4>
                    <p>Build lifelong connections with students from 50+ countries, creating opportunities that last a lifetime.</p>
                </div>
            </div>
        </div>

        <!-- Available Events Section -->
        <div class="section" id="events">
            <h3><i class="fas fa-calendar-alt"></i> Available Exchange Programs</h3>
            <div class="events-grid">
                <div class="event-card">
                    <div class="event-image">
                        <i class="fas fa-torii-gate"></i>
                    </div>
                    <div class="event-content">
                        <div class="event-title">Tokyo Tech Innovation Summit</div>
                        <div class="event-location">
                            <i class="fas fa-map-marker-alt"></i> Tokyo, Japan
                        </div>
                        <div class="event-description">
                            Experience cutting-edge technology and innovation in Japan's tech capital. Collaborate with leading universities and tech companies.
                        </div>
                        <div class="event-details">
                            <span class="event-date"><i class="fas fa-calendar"></i> Mar 15 - Jun 15, 2024</span>
                            <span class="event-duration">3 months</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="event-status status-open">Applications Open</span>
                            <button class="btn btn-small">Apply Now</button>
                        </div>
                    </div>
                </div>

                <div class="event-card">
                    <div class="event-image">
                        <i class="fas fa-mountain"></i>
                    </div>
                    <div class="event-content">
                        <div class="event-title">Swiss Alpine Research Program</div>
                        <div class="event-location">
                            <i class="fas fa-map-marker-alt"></i> Zurich, Switzerland
                        </div>
                        <div class="event-description">
                            Conduct environmental research in the Swiss Alps while studying at ETH Zurich. Perfect for environmental science students.
                        </div>
                        <div class="event-details">
                            <span class="event-date"><i class="fas fa-calendar"></i> Sep 1 - Dec 20, 2024</span>
                            <span class="event-duration">4 months</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="event-status status-closing">Closing Soon</span>
                            <button class="btn btn-small">Apply Now</button>
                        </div>
                    </div>
                </div>

                <div class="event-card">
                    <div class="event-image">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <div class="event-content">
                        <div class="event-title">Oxford Academic Excellence</div>
                        <div class="event-location">
                            <i class="fas fa-map-marker-alt"></i> Oxford, United Kingdom
                        </div>
                        <div class="event-description">
                            Study at one of the world's oldest universities. Immerse yourself in centuries of academic tradition and excellence.
                        </div>
                        <div class="event-details">
                            <span class="event-date"><i class="fas fa-calendar"></i> Jan 10 - May 30, 2025</span>
                            <span class="event-duration">5 months</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="event-status status-open">Applications Open</span>
                            <button class="btn btn-small">Apply Now</button>
                        </div>
                    </div>
                </div>

                <div class="event-card">
                    <div class="event-image">
                        <i class="fas fa-space-shuttle"></i>
                    </div>
                    <div class="event-content">
                        <div class="event-title">NASA Space Technology Program</div>
                        <div class="event-location">
                            <i class="fas fa-map-marker-alt"></i> Houston, USA
                        </div>
                        <div class="event-description">
                            Work alongside NASA engineers and scientists on cutting-edge space technology projects. Limited to 20 students worldwide.
                        </div>
                        <div class="event-details">
                            <span class="event-date"><i class="fas fa-calendar"></i> Jun 1 - Aug 31, 2024</span>
                            <span class="event-duration">3 months</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="event-status status-closed">Applications Closed</span>
                            <button class="btn btn-small btn-secondary" disabled>Closed</button>
                        </div>
                    </div>
                </div>

                <div class="event-card">
                    <div class="event-image">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div class="event-content">
                        <div class="event-title">Amazon Rainforest Conservation</div>
                        <div class="event-location">
                            <i class="fas fa-map-marker-alt"></i> Manaus, Brazil
                        </div>
                        <div class="event-description">
                            Join international conservation efforts in the Amazon. Study biodiversity while contributing to environmental protection.
                        </div>
                        <div class="event-details">
                            <span class="event-date"><i class="fas fa-calendar"></i> Jul 15 - Oct 15, 2024</span>
                            <span class="event-duration">3 months</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="event-status status-open">Applications Open</span>
                            <button class="btn btn-small">Apply Now</button>
                        </div>
                    </div>
                </div>

                <div class="event-card">
                    <div class="event-image">
                        <i class="fas fa-dragon"></i>
                    </div>
                    <div class="event-content">
                        <div class="event-title">Beijing Cultural Immersion</div>
                        <div class="event-location">
                            <i class="fas fa-map-marker-alt"></i> Beijing, China
                        </div>
                        <div class="event-description">
                            Experience ancient culture meets modern innovation. Study Mandarin, business, and technology at Tsinghua University.
                        </div>
                        <div class="event-details">
                            <span class="event-date"><i class="fas fa-calendar"></i> Feb 1 - Jul 1, 2024</span>
                            <span class="event-duration">5 months</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="event-status status-closing">Closing Soon</span>
                            <button class="btn btn-small">Apply Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Applications Section -->
        <div class="section" id="applications">
            <h3><i class="fas fa-file-alt"></i> Student Applications Management</h3>
            <div style="margin-bottom: 2rem;">
                <button class="btn" onclick="window.location.href='html2.php'">
                    <i class="fas fa-plus"></i> New Application
                </button>
                <button class="btn btn-secondary">
                    <i class="fas fa-download"></i> Export Data
                </button>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th><i class="fas fa-user"></i> Student Name</th>
                        <th><i class="fas fa-phone"></i> Phone Number</th>
                        <th><i class="fas fa-envelope"></i> Email</th>
                        <th><i class="fas fa-globe"></i> Program</th>
                        <th><i class="fas fa-calendar"></i> Applied Date</th>
                        <th><i class="fas fa-info-circle"></i> Status</th>
                        <th><i class="fas fa-cogs"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Reset the result pointer for reuse
                        $senarai_students->data_seek(0);
                        // condition 
                        if ($senarai_students->num_rows > 0) {
                          // loops 
                          while($row = $senarai_students->fetch_assoc()) {
                            echo 
                            "<tr>
                            <td><strong>". $row["student_name"] ."</strong></td>
                            <td><strong>". $row["phone"] ."</strong></td>
                             <td><strong>". $row["email"] ."</strong></td>
                             <td><strong>". $row["program_title"] ."</strong></td>
                              <td><strong>". $row["application_date"] ."</strong></td>
                              <td><strong>". $row["application_status"] ."</strong></td>
                              <td>
                            <button class='btn btn-small btn-success'>View</button>
                            <button class='btn btn-small'>Edit</button>
                        </td>
                            </tr>";
                          }
                        } else {
                          echo '<option value="">No programs available</option>';
                        }
                        ?>
                   <tr>
                        <td><strong>Ahmad Zulkifli</strong></td>
                        <td>+60 12-345-6789</td>
                        <td>ahmad.zul@student.edu.my</td>
                        <td>Tokyo Tech Innovation Summit</td>
                        <td>Jan 15, 2024</td>
                        <td><span class="event-status status-open">Approved</span></td>
                        <td>
                            <button class="btn btn-small btn-success">View</button>
                            <button class="btn btn-small">Edit</button>
                        </td>
                    </tr>
                     <!-- 
                    <tr>
                        <td><strong>Siti Nurhaliza</strong></td>
                        <td>+60 13-987-6543</td>
                        <td>siti.nur@student.edu.my</td>
                        <td>Swiss Alpine Research Program</td>
                        <td>Jan 20, 2024</td>
                        <td><span class="event-status status-closing">Under Review</span></td>
                        <td>
                            <button class="btn btn-small btn-success">View</button>
                            <button class="btn btn-small">Edit</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Raj Kumar</strong></td>
                        <td>+60 14-555-7890</td>
                        <td>raj.kumar@student.edu.my</td>
                        <td>Oxford Academic Excellence</td>
                        <td>Jan 25, 2024</td>
                        <td><span class="event-status status-open">Approved</span></td>
                        <td>
                            <button class="btn btn-small btn-success">View</button>
                            <button class="btn btn-small">Edit</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Lim Wei Ming</strong></td>
                        <td>+60 16-222-3333</td>
                        <td>lim.wei@student.edu.my</td>
                        <td>Amazon Rainforest Conservation</td>
                        <td>Feb 1, 2024</td>
                        <td><span class="event-status status-closing">Under Review</span></td>
                        <td>
                            <button class="btn btn-small btn-success">View</button>
                            <button class="btn btn-small">Edit</button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Fatimah Abdullah</strong></td>
                        <td>+60 17-888-9999</td>
                        <td>fatimah.abd@student.edu.my</td>
                        <td>Beijing Cultural Immersion</td>
                        <td>Feb 5, 2024</td>
                        <td><span class="event-status status-closed">Rejected</span></td>
                        <td>
                            <button class="btn btn-small btn-success">View</button>
                            <button class="btn btn-small btn-danger">Archive</button>
                        </td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background: rgba(255, 255, 255, 0.95); margin-top: 3rem; padding: 2rem; text-align: center; border-radius: 15px;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <h4 style="color: #667eea; margin-bottom: 1rem;"><i class="fas fa-globe-americas"></i> GlobalEdu Exchange</h4>
                    <p style="color: #666; line-height: 1.6;">Connecting students worldwide through transformative educational experiences and cultural exchange programs.</p>
                </div>
                <div>
                    <h4 style="color: #333; margin-bottom: 1rem;">Quick Links</h4>
                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <a href="#events" style="color: #667eea; text-decoration: none;">Available Programs</a>
                        <a href="#applications" style="color: #667eea; text-decoration: none;">My Applications</a>
                        <a href="html2.php" style="color: #667eea; text-decoration: none;">Apply Now</a>
                        <a href="#" style="color: #667eea; text-decoration: none;">Support</a>
                    </div>
                </div>
                <div>
                    <h4 style="color: #333; margin-bottom: 1rem;">Contact Info</h4>
                    <div style="color: #666;">
                        <p><i class="fas fa-envelope"></i> info@globaledu.edu.my</p>
                        <p><i class="fas fa-phone"></i> +60 3-1234-5678</p>
                        <p><i class="fas fa-map-marker-alt"></i> Kuala Lumpur, Malaysia</p>
                    </div>
                </div>
            </div>
            <hr style="border: none; height: 1px; background: #eee; margin: 2rem 0;">
            <p style="color: #666; margin: 0;">
                © 2024 GlobalEdu Exchange. All rights reserved. | 
                <a href="#" style="color: #667eea; text-decoration: none;">Privacy Policy</a> | 
                <a href="#" style="color: #667eea; text-decoration: none;">Terms of Service</a>
            </p>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add animation to stat cards on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe stat cards and event cards
        document.querySelectorAll('.stat-card, .event-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });

        // Add click handlers for application buttons
        document.querySelectorAll('.event-card .btn').forEach(button => {
            if (!button.disabled) {
                button.addEventListener('click', function() {
                    const eventTitle = this.closest('.event-card').querySelector('.event-title').textContent;
                    alert(`Redirecting to application form for: ${eventTitle}`);
                    // In a real application, this would redirect to the application form
                    window.location.href = 'html2.php?event=' + encodeURIComponent(eventTitle);
                });
            }
        });

        // Add some dynamic content updates
        setInterval(() => {
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            console.log('Dashboard active at:', timeString);
        }, 60000); // Update every minute
    </script>

</body>
</html>