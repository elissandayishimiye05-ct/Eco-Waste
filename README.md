# ♻️ Eco-Waste: Waste Collection & Recycling Management System (WCRMS)

> **A smart web-based platform that modernizes waste collection, transportation, recycling, and payment management through digital service requests, intelligent scheduling, and real-time monitoring.**

---

## 📌 Table of Contents

* Overview
* Problem Statement
* Solution
* Objectives
* Key Features
* Payment Management
* Invoice Management
* Business Model
* Technology Stack
* System Architecture
* Database Design
* Project Structure
* Installation Guide
* Default Login Accounts
* Security Features
* Reports & Analytics
* Future Roadmap
* Benefits
* Screenshots
* Contributing
* License
* Author

---

# 🌍 Overview

The **Eco-Waste Waste Collection & Recycling Management System (WCRMS)** is a web-based application designed to improve waste collection and recycling operations within communities.

The platform connects residents, waste collectors, recycling centers, and administrators through one centralized system that simplifies waste management, improves operational efficiency, and promotes environmental sustainability.

The application digitizes the entire waste management process—from requesting waste collection to recycling and reporting—while reducing paperwork and improving communication among stakeholders.

---

# ❗ Problem Statement

Many communities continue to rely on manual waste collection processes that result in:

* Delayed waste collection
* Poor communication between residents and collectors
* Lack of collection scheduling
* Inefficient vehicle utilization
* Poor monitoring of recyclable materials
* Limited reporting and analytics
* Environmental pollution
* Low recycling efficiency

These challenges increase operational costs while negatively affecting public health and environmental sustainability.

---

# 💡 Solution

Eco-Waste provides an integrated digital platform that enables organizations and communities to:

* Request waste collection online
* Schedule waste collection efficiently
* Assign vehicles and collectors
* Track collection progress
* Monitor recycling activities
* Process online payments
* Generate invoices
* Produce management reports
* Improve communication through notifications

The system improves operational efficiency while encouraging sustainable waste management.

---

# 🎯 Objectives

The project aims to:

* Digitize waste collection services
* Improve communication among stakeholders
* Automate collection scheduling
* Track waste collection vehicles
* Monitor recyclable materials
* Support recycling initiatives
* Generate real-time reports
* Reduce operational costs
* Promote environmental sustainability

---

# 🚀 Key Features

## 👥 User Management

The system supports multiple user roles.

### Administrator

* Manage users
* Manage collectors
* Manage recycling centers
* Assign vehicles
* Assign collectors
* Approve waste requests
* Manage schedules
* View reports
* Send notifications

### Resident

* Register account
* Login securely
* Submit waste collection requests
* Upload waste images
* Track request status
* View payment history
* Receive notifications

### Collector

* View assigned schedules
* Update collection progress
* Complete collection tasks
* Record collected waste

### Recycling Staff

* Record recyclable materials
* Update recycling information
* Monitor recycling quantities
* Generate recycling statistics

---

# ♻ Waste Collection Management

Residents can:

* Submit collection requests
* Select waste category
* Upload images
* Specify collection location
* Add additional notes

### Request Status

* Pending
* Approved
* Assigned
* In Progress
* Completed
* Cancelled

---

# 🚛 Collection Scheduling

Administrators can:

* Assign collectors
* Assign vehicles
* Schedule collection dates
* Define collection areas
* Monitor progress

### Schedule Status

* Scheduled
* Ongoing
* Completed

---

# 🚚 Vehicle Management

The system stores:

* Vehicle registration number
* Vehicle type
* Capacity
* Availability
* Maintenance status

Vehicle Status

* Available
* Assigned
* Under Maintenance

---

# 🏭 Recycling Center Management

The platform allows administrators to:

* Register recycling centers
* Update center information
* Track recyclable materials
* Generate recycling reports

---

# 📦 Recycled Material Tracking

The system records:

* Material type
* Quantity
* Collection source
* Receiving recycling center
* Collection date

This enables better monitoring of recycling performance.

---

# 🔔 Notification System

Users receive notifications for:

* Collection schedules
* Assignment updates
* Request approval
* Payment confirmation
* Administrative announcements

Notification Status

* Read
* Unread

---

# 💳 Payment Management

The system supports secure digital payments for waste collection services.

### Features

* Service fee calculation
* Online payment processing
* Digital receipts
* Payment verification
* Payment history
* Invoice generation
* Payment tracking

### Supported Payment Methods

* MTN Mobile Money
* Airtel Money
* Bank Transfer
* Debit/Credit Cards (Future Integration)

### Payment Status

* Pending
* Paid
* Failed
* Refunded

---

# 🧾 Invoice Management

After every successful payment, the system automatically generates invoices.

Invoice Features

* Invoice number
* Customer details
* Service details
* Payment receipt
* PDF download
* Payment history
* Outstanding balance tracking

---

# 💰 Business Model

Eco-Waste generates revenue through several channels.

### Subscription Plans

Municipalities and waste management companies subscribe monthly or annually.

### Collection Service Fees

Residents pay electronically for waste collection services.

### Premium Analytics

Organizations pay for advanced reporting and analytics.

### Government Partnerships

Local governments can adopt the platform for smart city initiatives.

### Recycling Partnerships

Recycling companies subscribe for recyclable material tracking and management.

---

# 📊 Reports & Analytics

The system provides:

* Collection reports
* Vehicle utilization reports
* Waste category reports
* Recycling performance reports
* User activity reports
* Revenue reports
* Payment reports

---

# 🔒 Security Features

The application implements:

* Secure Authentication
* Password Hashing
* Role-Based Access Control
* Session Management
* SQL Injection Protection
* Input Validation
* File Upload Validation
* Secure Database Access

---

# 🛠 Technology Stack

## Frontend

* HTML5
* CSS3
* JavaScript

## Backend

* PHP

## Database

* MySQL

## Web Server

* Apache (XAMPP/WAMP)

---

# 🏗 System Architecture

```text
Residents
      │
      ▼
Frontend (HTML • CSS • JavaScript)
      │
      ▼
PHP Backend
      │
      ▼
MySQL Database
      │
      ▼
Reports • Notifications • Payments • Recycling
```

---

# 🗄 Database Design

| Table                | Description                  |
| -------------------- | ---------------------------- |
| Users                | Stores system users          |
| Residents            | Resident information         |
| Collectors           | Collector information        |
| Waste_Requests       | Waste collection requests    |
| Collection_Schedules | Collection schedules         |
| Vehicles             | Collection vehicles          |
| Recycling_Centers    | Recycling center information |
| Recycled_Materials   | Recycling records            |
| Notifications        | User notifications           |
| Payments             | Payment records              |
| Invoices             | Generated invoices           |

---

# 📂 Project Structure

```text
WCRMS/

├── admin/
├── collector/
├── resident/
├── recycling/
├── css/
├── images/
├── uploads/
├── includes/
├── database/
├── Login.php
├── Register.php
├── Dashboard.php
└── README.md
```

---

# ⚙ Installation Guide

## Clone Repository

```bash
git clone https://github.com/elissandayishimiye05-ct/Eco-Waste.git
```

## Move Project

Copy the project folder into:

```text
xampp/htdocs/
```

## Create Database

```sql
CREATE DATABASE waste_management;
```

## Import Database

Import:

```text
database/waste_management.sql
```

## Configure Database

Edit:

```php
includes/connection.php
```

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "waste_management";
```

## Start Services

Start Apache and MySQL using XAMPP.

## Run Application

```text
http://localhost/WCRMS
```

---

# 🔑 Default Login Accounts

| Role            | Username   | Password     |
| --------------- | ---------- | ------------ |
| Administrator   | admin      | admin123     |
| Resident        | resident1  | resident123  |
| Collector       | collector1 | collector123 |
| Recycling Staff | recycle1   | recycle123   |

> **Important:** Change all default passwords after the first login.

---

# 📈 Benefits

* Faster waste collection
* Reduced paperwork
* Improved communication
* Better recycling management
* Digital payments
* Automated invoicing
* Better reporting
* Real-time tracking
* Environmental sustainability
* Increased operational efficiency

---

# 🛣 Future Roadmap

* GPS Vehicle Tracking
* AI Waste Classification
* Smart Route Optimization
* QR Code Waste Bin Tracking
* Mobile Application
* SMS Notifications
* Email Notifications
* Google Maps Integration
* Carbon Footprint Monitoring
* Business Intelligence Dashboard
* IoT Smart Waste Bins

---

# 📸 Screenshots

Add screenshots of:

* Home Page
* Login Page
* Resident Dashboard
* Administrator Dashboard
* Waste Request Form
* Collection Schedule
* Payment Page
* Reports Dashboard

---

# 🤝 Contributing

Contributions are welcome.

1. Fork the repository.
2. Create a new feature branch.
3. Commit your changes.
4. Push to your branch.
5. Open a Pull Request.

---

# 📄 License

This project is intended for academic, research, and environmental sustainability purposes.

---

# 👨‍💻 Author

**Ndayishimiye Elissa**

Software Developer

**Email:** [elissandayishimiye05@gmail.com](mailto:elissandayishimiye05@gmail.com)

**GitHub:** https://github.com/elissandayishimiye05-ct

---

# 🌱 Vision

**Building Smart Solutions for Cleaner, Greener, and More Sustainable Communities.**

If you find this project useful, please **⭐ Star the repository** and share your feedback.


