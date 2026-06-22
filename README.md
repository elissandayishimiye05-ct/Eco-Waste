Waste Collection & Recycling Management System (WCRMS)
♻️ Project Overview

The Waste Collection & Recycling Management System (WCRMS) is a web-based platform developed to improve the management of waste collection, transportation, and recycling activities within communities. The system provides an efficient way for residents to request waste collection services, allows collectors to manage collection schedules, and enables recycling centers to track recyclable materials.

The system aims to promote environmental sustainability, improve waste management efficiency, and enhance communication between residents, collectors, administrators, and recycling centers.

This project is developed using:

Frontend: HTML5, CSS3, JavaScript
Backend: PHP
Database: MySQL
Web Server: Apache (XAMPP/WAMP)
🎯 Objectives

The main objectives of the system are:

Digitize waste collection operations.
Enable residents to submit waste collection requests online.
Schedule and manage waste collection activities.
Track collection vehicles and assigned collectors.
Monitor recyclable materials and recycling centers.
Improve communication through notifications.
Generate reports for management and decision-making.
🚀 Key Features
1. User Management

The system supports multiple user roles:

Administrator
Manage users.
Approve and monitor collection requests.
Assign collectors and vehicles.
Manage recycling centers.
View reports and statistics.
Send notifications.
Resident
Register and login.
Submit waste collection requests.
Upload waste images.
Track request status.
Receive notifications.
Collector
View assigned schedules.
Update collection progress.
Mark collections as completed.
Recycling Staff
Record recyclable materials.
Manage recycling center operations.
Track recycled quantities.
2. Waste Request Management

Residents can:

Create waste collection requests.
Select waste type.
Provide descriptions.
Upload images.
Specify collection location.

Request statuses include:

Pending
Assigned
In Progress
Completed
Cancelled
3. Collection Scheduling

Administrators can:

Assign requests to collectors.
Allocate collection vehicles.
Set collection date and time.
Define collection areas.

Schedule statuses:

Scheduled
Ongoing
Completed
4. Vehicle Management

The system manages waste collection vehicles including:

Vehicle registration numbers.
Vehicle types.
Capacity information.
Vehicle availability status.

Vehicle statuses:

Available
Assigned
Maintenance
5. Recycling Center Management

Administrators can:

Register recycling centers.
Manage center information.
Track received recyclable materials.
6. Recycled Material Tracking

The system records:

Material type.
Quantity received.
Receiving recycling center.
Collection source.

This helps monitor recycling performance and environmental impact.

7. Notification System

Users receive notifications for:

New assignments.
Collection schedules.
Status updates.
Administrative announcements.

Notification statuses:

Read
Unread
🗄️ Database Design

The system consists of the following main tables:

Table	Description
Users	Stores all system users
Residents	Resident-specific information
Collectors	Collector information
Waste_Requests	Waste collection requests
Collection_Schedules	Collection schedules
Vehicles	Collection vehicles
Recycling_Centers	Recycling center details
Recycled_Materials	Recycled material records
Notifications	System notifications
📊 Entity Relationship Diagram (ERD)

The database structure follows relationships between:

One User → Many Notifications
One Resident → Many Waste Requests
One Collector → Many Collection Schedules
One Vehicle → Many Collection Schedules
One Waste Request → One Collection Schedule
One Recycling Center → Many Recycled Materials

This structure ensures data integrity and efficient system operations.

🏗️ System Architecture
Resident
    │
    ▼
Waste Request
    │
    ▼
Administrator Review
    │
    ▼
Assign Collector & Vehicle
    │
    ▼
Collection Schedule
    │
    ▼
Waste Collection
    │
    ▼
Recycling Center
    │
    ▼
Recycled Materials Tracking
📂 Project Structure
WCRMS/
│
├── css/
│   ├── style.css
│   ├── dashboard.css
│
├── images/
│
├── uploads/
│
├── includes/
│   ├── connection.php
│   ├── header.php
│   └── footer.php
│
├── admin/
│   ├── dashboard.php
│   ├── manage_users.php
│   ├── manage_vehicles.php
│   ├── schedules.php
│
├── resident/
│   ├── request_waste.php
│   ├── my_requests.php
│
├── collector/
│   ├── schedules.php
│
├── recycling/
│   ├── materials.php
│
├── Login.php
├── Register.php
├── Dashboard.php
└── README.md
⚙️ Installation Guide
Step 1: Clone Repository
git clone https://github.com/yourusername/wcrms.git
Step 2: Move Project

Copy the project folder into:

xampp/htdocs/
Step 3: Create Database

Open phpMyAdmin and create:

CREATE DATABASE waste_management;
Step 4: Import SQL File

Import:

database/waste_management.sql
Step 5: Configure Database Connection

Edit:

Connection.php

Update:

$host = "localhost";
$user = "root";
$password = "";
$database = "waste_management";
Step 6: Run Project

Open browser:

http://localhost/WCRMS
🔐 Default Login Accounts
Role	Username	Password
Admin	admin	admin123
Resident	resident1	resident123
Collector	collector1	collector123
Recycling Staff	recycle1	recycle123

Change default passwords after first login.

📈 Benefits of the System
Improves waste collection efficiency.
Reduces manual paperwork.
Enhances environmental sustainability.
Improves service monitoring.
Supports recycling initiatives.
Provides real-time status tracking.
Enhances communication among stakeholders.
🔮 Future Improvements
GPS tracking for vehicles.
Mobile application integration.
SMS and Email notifications.
AI-based waste classification.
Online payment integration.
Data analytics dashboard.
QR code waste tracking.
👨‍💻 Author

Ndayishimiye Elissa

Waste Collection & Recycling Management System (WCRMS)

Developed using HTML, CSS, PHP, MySQL, and JavaScript as an academic and environmental management project.
