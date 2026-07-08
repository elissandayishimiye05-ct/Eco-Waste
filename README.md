# Eco-Waste: Waste Collection & Recycling Management System (WCRMS)

> A smart web-based platform that modernizes waste collection, transportation, and recycling management through digital service requests, scheduling, and real-time monitoring.

---

##  Overview

The **Waste Collection & Recycling Management System (WCRMS)** is a web-based application designed to improve the efficiency of waste collection and recycling operations within communities.

The platform connects **residents**, **waste collectors**, **administrators**, and **recycling centers** through a centralized digital system that simplifies waste management processes while promoting environmental sustainability.

The system reduces manual paperwork, improves communication among stakeholders, enables better resource planning, and supports data-driven decision making.

---

# Problem Statement

Many communities still rely on manual methods for waste collection, resulting in:

- Delayed waste collection
- Poor communication between residents and collectors
- Inefficient vehicle scheduling
- Limited monitoring of recycling activities
- Poor reporting and data management
- Environmental pollution caused by unmanaged waste

---

#  Solution

WCRMS provides a centralized digital platform that enables:

- Online waste collection requests
- Smart collection scheduling
- Vehicle assignment
- Collector management
- Recycling center management
- Real-time request tracking
- Notification services
- Reporting and analytics

The system improves service delivery while encouraging sustainable waste management practices.

---

#  Objectives

The main objectives of this project are:

- Digitize waste collection operations
- Improve communication between residents and collectors
- Automate collection scheduling
- Monitor collection vehicles
- Track recyclable materials
- Support recycling initiatives
- Generate management reports
- Promote environmental sustainability

---

#  Features

##  User Management

The platform supports multiple user roles.

### Administrator

- Manage users
- Approve waste requests
- Assign collectors
- Assign vehicles
- Schedule collections
- Manage recycling centers
- Generate reports
- Send notifications

### Resident

- Register and Login
- Submit waste collection requests
- Upload waste images
- Track request status
- Receive notifications

### Collector

- View assigned schedules
- Update collection progress
- Complete collection tasks

### Recycling Staff

- Record recyclable materials
- Manage recycling operations
- Track recycled quantities

---

#  Waste Request Management

Residents can:

- Create waste collection requests
- Select waste category
- Upload images
- Provide descriptions
- Specify pickup location

### Request Status

- Pending
- Assigned
- In Progress
- Completed
- Cancelled

---

#  Collection Scheduling

Administrators can:

- Assign collectors
- Allocate vehicles
- Schedule collection dates
- Define service areas

### Schedule Status

- Scheduled
- Ongoing
- Completed

---

#  Vehicle Management

The system stores:

- Vehicle registration number
- Vehicle type
- Capacity
- Availability status

### Vehicle Status

- Available
- Assigned
- Under Maintenance

---

# Recycling Center Management

Administrators can:

- Register recycling centers
- Update center information
- Monitor received recyclable materials

---

#  Recycled Material Tracking

The system records:

- Material type
- Quantity
- Collection source
- Receiving recycling center
- Collection date

This helps evaluate recycling performance and environmental impact.

---

#  Notification System

Users receive notifications about:

- Collection schedules
- New assignments
- Request status updates
- Administrative announcements

Notification Status:

- Read
- Unread

---

#  Reports & Analytics

The system provides reports on:

- Waste collection requests
- Collection performance
- Vehicle utilization
- Recycling statistics
- User activities

---

# 🗄 Database Design

Main database tables include:

| Table | Description |
|--------|-------------|
| Users | Stores all user accounts |
| Residents | Resident information |
| Collectors | Collector information |
| Waste_Requests | Waste collection requests |
| Collection_Schedules | Collection schedules |
| Vehicles | Collection vehicles |
| Recycling_Centers | Recycling center information |
| Recycled_Materials | Recycled material records |
| Notifications | User notifications |

---

#  Entity Relationships

- One User → Many Notifications
- One Resident → Many Waste Requests
- One Collector → Many Collection Schedules
- One Vehicle → Many Collection Schedules
- One Waste Request → One Collection Schedule
- One Recycling Center → Many Recycled Materials

---

#  System Workflow

```
Resident
     │
     ▼
Submit Waste Request
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
Material Tracking & Reporting
```

---

# 🛠 Technology Stack

### Frontend

- HTML5
- CSS3
- JavaScript

### Backend

- PHP

### Database

- MySQL

### Web Server

- Apache (XAMPP / WAMP)

---

# 📂 Project Structure

```
WCRMS/

│
├── admin/
├── collector/
├── resident/
├── recycling/
├── css/
├── images/
├── uploads/
├── includes/
│
├── Login.php
├── Register.php
├── Dashboard.php
├── README.md
│
└── database/
```

---

# ⚙ Installation

## 1 Clone Repository

```bash
git clone https://github.com/yourusername/WCRMS.git
```

---

## 2 Move Project

Copy the project folder into

```
xampp/htdocs/
```

---

## 3 Create Database

```sql
CREATE DATABASE waste_management;
```

---

## 4 Import Database

Import

```
database/waste_management.sql
```

---

## 5 Configure Database

Open

```
includes/connection.php
```

Update

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "waste_management";
```

---

## 6 Start Apache & MySQL

Open XAMPP Control Panel

Start

- Apache
- MySQL

---

## 7 Run Application

```
http://localhost/WCRMS
```

---

# 🔑 Default Accounts

| Role | Username | Password |
|------|----------|----------|
| Administrator | admin | admin123 |
| Resident | resident1 | resident123 |
| Collector | collector1 | collector123 |
| Recycling Staff | recycle1 | recycle123 |

> **Important:** Change the default passwords after first login.

---

#  Benefits

- Digital waste collection management
- Improved operational efficiency
- Better communication
- Real-time request tracking
- Environmental sustainability
- Reduced paperwork
- Better reporting
- Improved recycling performance

---

#  Future Improvements

- GPS Vehicle Tracking
- Mobile Application
- SMS Notifications
- Email Notifications
- AI Waste Classification
- QR Code Waste Tracking
- Online Payments
- Business Intelligence Dashboard
- Google Maps Integration

---

#  Screenshots

> Add screenshots here

Example:

```
Home Page

Dashboard

Admin Panel

Waste Request Form

Collection Schedule

Reports Dashboard
```

---

#  Contributing

Contributions are welcome.

If you would like to improve this project:

1. Fork the repository
2. Create your feature branch

```bash
git checkout -b feature/NewFeature
```

3. Commit your changes

```bash
git commit -m "Add new feature"
```

4. Push to your branch

```bash
git push origin feature/NewFeature
```

5. Open a Pull Request

---

#  License

This project is developed for academic purposes and environmental sustainability initiatives.

---

# Author

## Ndayishimiye Elissa

Software Developer

 Email: elissandayishimiye05@gmail.com

GitHub:
https://github.com/elissandayishimiye05-ct

---

#  Support

If you found this project helpful,

Please  Star this repository.

It helps others discover the project and motivates future development.

---
# 💳 Payment Management

The system includes a secure payment module that enables residents and organizations to pay for waste collection services electronically.

### Features

- Service fee calculation
- Online payment requests
- Payment verification
- Digital payment receipts
- Payment history
- Invoice generation
- Payment status tracking

### Supported Payment Methods

- Mobile Money (MTN MoMo)
- Airtel Money
- Bank Transfer
- Debit/Credit Cards (Future Integration)

### Payment Status

- Pending
- Paid
- Failed
- Refunded

---

# 💰 Business Model

The Waste Collection & Recycling Management System generates revenue through multiple streams:

### 1. Subscription Plans

Municipalities, waste collection companies, and recycling centers subscribe to the platform on a monthly or annual basis.

### 2. Collection Service Fees

Residents pay digitally when requesting waste collection services.

### 3. Premium Analytics

Organizations can access advanced reports and analytics through premium subscriptions.

### 4. Government Partnerships

The platform can be adopted by local governments for smart city waste management initiatives.

### 5. Recycling Partnerships

Recycling companies pay for access to recyclable material tracking and supply management.

---

# 🧾 Invoice Management

The system automatically generates invoices after successful service requests.

Features include:

- Automatic invoice generation
- PDF invoice download
- Payment receipt generation
- Payment history
- Outstanding balance tracking

## 🌱 "Clean Environment, Smart Communities."
