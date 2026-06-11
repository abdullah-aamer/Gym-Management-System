# Gym Management System

## Project Overview

The Gym Management System is a database-driven web application developed as a Project-Based Learning (PBL) project for the Database Systems course at the National University of Technology (NUTECH), Islamabad, Pakistan.

The objective of this project is to provide a centralized platform for managing gym operations including members, trainers, membership plans, subscriptions, payments, attendance, equipment, workout plans, diet plans, feedback, and reporting.

The project demonstrates the practical implementation of database concepts including database design, EERD modeling, relational schema mapping, SQL implementation, constraints, triggers, views, advanced SQL queries, and CRUD-based web development.

---

## University Information

**University:** National University of Technology (NUTECH)

**Location:** IJP Road, I-12, Islamabad, Pakistan

**Course:** CS160 – Database Systems

**Project Type:** Project-Based Learning (PBL)

**Supervisor:** Ms. Saima Yasmeen

---

## Team Members

| Name                        | Student ID | Role        |
| --------------------------- | ---------- | ----------- |
| Muhammad Abdullah Bin Aamer | F25605346  | Team Lead   |
| Muhammad Kabeer Atif        | F25605350  | Team Member |
| Talha Akhter                | F25605349  | Team Member |
| Haseeb Ullah                | F25605327  | Team Member |
| Hameed Ullah                | F25605307  | Team Member |

---

## Project Features

The Gym Management System provides the following functionality:

### Member Management

* Add Members
* Update Member Information
* Delete Members
* View Member Records

### Trainer Management

* Add Trainers
* Update Trainer Information
* Delete Trainers
* Manage Trainer Specializations

### Membership Plans

* Create Membership Plans
* Manage Duration and Fees
* Display Available Plans

### Subscription Management

* Assign Plans to Members
* Track Membership Status
* Manage Renewals

### Payment Management

* Record Payments
* Payment Tracking
* Revenue Management

### Equipment Management

* Track Equipment Inventory
* Monitor Maintenance Status
* Equipment Availability Reports

### Attendance Management

* Member Attendance Records
* Attendance Reports

### Workout and Diet Plans

* Trainer Assigned Workout Plans
* Trainer Assigned Diet Plans

### Reports and Analytics

* Active Member Reports
* Trainer Workload Reports
* Equipment Usage Reports
* Membership Revenue Reports

---

## Database Concepts Implemented

This project implements the following database concepts:

* Enhanced Entity Relationship Diagram (EERD)
* Relational Schema
* Primary Keys
* Foreign Keys
* Unique Constraints
* Check Constraints
* Default Constraints
* NOT NULL Constraints
* Referential Integrity
* SQL Views
* SQL Triggers
* JOIN Queries
* Aggregate Queries
* Nested Queries
* Filtering Queries
* CRUD Operations

---

## Repository Structure

```text
Gym-Management-WebApp/
│
├── Gym-Management-WebApp/
│   ├── assets/
│   ├── config/
│   ├── includes/
│   ├── index.php
│   ├── login.php
│   ├── dashboard.php
│   ├── members.php
│   ├── trainers.php
│   ├── plans.php
│   ├── subscriptions.php
│   ├── payments.php
│   ├── equipment.php
│   ├── reports.php
│   └── about.php
│
├── Documentation/
│   ├── Gym_Management_System_Report.docx
│   └── Gym_Management_System_Report.pdf
│
├── Database/
│   └── Gym_Management_System_SQL_Server.sql
│
├── Diagrams/
│   ├── EERD.png
│   └── Relational_Schema.png
│
└── README.md
```

---

## Technologies Used

### Frontend

* HTML5
* CSS3
* JavaScript

### Backend

* PHP

### Database

* MySQL / MariaDB
* Microsoft SQL Server

### Development Tools

* XAMPP
* phpMyAdmin
* SQL Server Management Studio (SSMS)
* Visual Studio Code
* GitHub

---

## Installation and Execution Guide

Follow the steps below to run the project on your system.

### Step 1: Install Required Software

Install the following software:

* XAMPP
* SQL Server (optional for SQL implementation review)
* SQL Server Management Studio (SSMS)

---

### Step 2: Copy Project Folder

Locate the project folder:

```text
Gym-Management-WebApp
```

Copy the folder and paste it inside:

```text
C:\xampp\htdocs\
```

The final path should be:

```text
C:\xampp\htdocs\Gym-Management-WebApp
```

---

### Step 3: Start XAMPP Services

Open XAMPP Control Panel.

Start:

```text
Apache
MySQL
```

Ensure both services are running successfully.

---

### Step 4: Create Database

Open:

```text
http://localhost/phpmyadmin
```

Create a database named:

```text
gym_management_system
```

---

### Step 5: Import Database

Navigate to:

```text
Database/
```

Import the provided SQL file into phpMyAdmin.

After successful import, all tables and sample records will be created automatically.

---

### Step 6: Run the Application

Open your browser and visit:

```text
http://localhost/Gym-Management-WebApp
```

The Gym Management System homepage will appear.

---

## Included Documentation

This repository contains:

### Project Report

* DOCX Version
* PDF Version

### Database Files

* SQL Server Database Script

### Diagrams

* Enhanced Entity Relationship Diagram (EERD)
* Relational Schema

### Web Application

* Complete PHP-based Gym Management System

---

## Academic Purpose

This project was developed solely for educational and academic purposes as part of the Database Systems Project-Based Learning (PBL) assignment at NUTECH.

The project demonstrates practical implementation of database design and web application development concepts taught during the course.

---

## Contact Information

For questions, suggestions, or project-related inquiries:

**Muhammad Abdullah Bin Aamer**

Email: [abdullahaamer56@gmail.com](mailto:abdullahaamer56@gmail.com)

---

## Acknowledgement

We would like to express our sincere gratitude to **Ms. Saima Yasmeen** for her guidance, support, and supervision throughout the development of this project. Her valuable feedback and instruction helped us successfully complete this database systems project.

---

## Future Enhancements

Possible future improvements include:

* QR Code Based Attendance
* Biometric Integration
* Online Payment Gateway
* Mobile Application
* Trainer Scheduling System
* Progress Tracking Dashboard
* Email Notifications
* SMS Alerts
* Advanced Analytics and Reporting

---

## License

This project is intended for educational and academic use only.

© 2026 Team Gym Management System – NUTECH
