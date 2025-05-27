# User Registration API - PHP Backend

This project provides a PHP-based backend endpoint that allows users to register by submitting personal details and a profile photo. Data is stored in a MySQL database.

## 🛠 Features

- Handles multipart form submissions (`multipart/form-data`)
- Accepts image uploads (`photo`)
- Validates required fields
- Checks for duplicate NIN (National Identity Number)
- Stores data securely using prepared statements
- Returns JSON responses


---

## 🚀 How to Use

### 📦 Requirements

- PHP >= 7.4
- MySQL Database
- XAMPP or similar LAMP/Local server environment
- Postman or frontend form for testing

### 🔧 Setup

1. Clone or download this project into your `htdocs` folder in XAMPP:

   ```bash
   git clone https://github.com/Oladimeji402/Samcy_endpoint.git
2. Configure your database connection inside db.php:
$conn = new mysqli("localhost", "root", "", "Samcy");

3. Make sure your uploads/ folder has write permissions:
chmod -R 777 uploads/



🧪 Testing the API (with Postman)
Endpoint
POST http://localhost/SAMCY_BE_v1.01/User.php

Content-Type
multipart/form-data
Body Parameters
Field	Type	Required	Description
full_name	text	✅	User’s full name
email	text	✅	Email address
phone	text	✅	Phone number
marital_status	text	❌	Marital status
date_of_birth	date	❌	Date of birth (YYYY-MM-DD)
state_of_origin	text	❌	State of origin
local_government	text	❌	Local government area
residential_address	text	❌	Current address
nationality	text	❌	Nationality
nin	text	✅	National Identification Number
department	text	✅	Department/Unit
gender	text	✅	Gender (e.g., Male, Female)
photo	file	❌	Profile photo
privacy_policy	checkbox	✅ (1)	Must be set to 1 if agreed




