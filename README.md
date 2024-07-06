# Diabetic Health Care
 EHR With Patient Tracking System For Sri Lanka Diabetic Clinic ( Second Year Final Project)
## Introduction
This project is an Electronic Health Record (EHR) With Patient Tracking System designed specifically for Sri Lankan National Diabetic care. 
This aims to provide a comprehensive platform for healthcare providers and patients to efficiently manage records and improve the quality of care.
In this system there are main 6 users as Doctor, Patient, Lab-Technician, Pharmacist, Reciptionist and Admin. 

## Features
- Patient Record Management: Allows staff users to create, update, and access patient records securely.
- Diabetic Care Tools: Provides specialized tools and features for managing diabetic care, such as glucose monitoring, medication tracking, and treatment plans.
- User Authentication and Authorization: Implements secure user authentication and role-based access control to ensure data privacy and confidentiality.
- Search and Filter Functionality: Enables users to search and filter patient records based on various criteria, such as demographics, medical history, and treatment status.

## Technologies Used
Backend Development: PHP, JavaScript

Database: SQL

Server: XAMPP

Frontend Framework: CSS, Bootstrap,

## Installation
Clone the repository

Navigate to the project directory and locate "ehr_db.sql" file

Export database (Recommend using phpmyadmin's SQL Server)

Initialize proper connection according to "conn.php"
(File path: ehr-final-project -> Final-Project -> data -> conn.php)

Start from preferred login pages using respective sample credentials given in "Login-Info.txt" file
(File Path: ehr-final-project -> Login-Info.txt)

## Usage
### Admin 
- Create and manage staff user accounts
- Manage dietary and activity recommendations plans
- View system audit trails

### Doctor
- Search for a patient using a Patient Health Number(PHN)
- Color-coded risk visualization
- Enter visit records
- View auto-generated charts according to Vital Signs
- Request lab test
- Place prescriptions

### Receptionist 
- Search for a patient using a Patient Health Number(PHN)
- Register a new patient

### Lab-Technician
- View and search for requested lab tests
- Enter result values
- View past lab tests and results
  
### Pharmacist
- View and search for placed prescriptions
- Confirm a prescription's status
- Manage Inventory
- Change the Unavailiablty of a medicine

## Patient
- View patient details, visit records, prescriptions and lab tests
- Access risk-tailored activity and diet plans

## Acknowledgments
This project is a collaborative effort of the following individuals.

- Chethana David: Project Manager, Backend Developer, Database Engineer. Documenter
- Pethum Shaym: UI/UX Designer, Frontend Developer, Documenter
- Nimasha Bandara: Quality Assurance Officer, Documenter
- Janani Kodithuwakku: Quality Assurance Officer, Documenter
- Sakuni Weerasingher: Quality Assurance Officer, Documenter

Special thanks to all the lecturers at ICBT Kandy for their invaluable support and guidance throughout the project.
