# FoodSafe (CCDEVAP-S15-3)

FoodSafe is a centralized Food Safety Inspection System designed to bridge the gap between food safety authorities, dining establishments, and the public. The system streamlines how health inspectors log and track safety violations while empowering consumers with transparent, real-time access to restaurant grading history and a direct, anonymous hazard-reporting pipeline.

---

## 🛠️ Tech Stack

*   **Frontend:** HTML, CSS, JavaScript
*   **Backend:** PHP 
*   **Database:** MySQL 
*   **Local Server Environment:** XAMPP

---

## 🚀 Setup & Local Installation

Follow these steps to deploy and run **FoodSafe** on your local machine using XAMPP:

### Prerequisite
Ensure you have **XAMPP** (with PHP 8.x and MySQL) installed and setup on your machine.

---

### Clone or Place the Project in XAMPP
Move your project folder into XAMPP’s local server directory:
*   **Windows Path:** `C:\xampp\htdocs\CCDEVAP-S15-3-FoodSafe`
*   **macOS Path:** `/Applications/XAMPP/xamppfiles/htdocs/CCDEVAP-S15-3-FoodSafe`

---

### Configure and Import the Database
1. Launch the **XAMPP Control Panel**.
2. Start both the **Apache** and **MySQL** modules.
3. Open your web browser and go to: `http://localhost/phpmyadmin`
4. Click on **New** on the left panel to create a new database. Name it exactly: `CCDEVAP-S15-3-FoodSafe.sql` (or check your `/config/db.php` file for your specified database name).
5. Select your newly created database, click the **Import** tab at the top menu.
6. Click **Choose File** and select the SQL backup script provided in your deliverables folder: `CCDEVAP-S15-3-FoodSafe.sql`
7. Scroll to the bottom and click Import to execute the script. 

---

### Verify Database Credentials
Open config/db.php in your text editor and ensure the database connection parameters match your local server's database credentials. Here are the current credentials:
- Host: "localhost:3306";
- Database: "foodsafe_db";
- Username: "root";
- Password: "Dlsu1234!";
  
The configuration file is pre-configured with a default database password. If your local MySQL does not require a password, simply delete the password value (set it to ""). If you use a custom password, change this value to your personal password so the system can connect to your database. 

---

### Configure XAMPP Apache Routing
Because this application uses custom MVC routing, you must configure Apache to treat your project folder as the primary website directory and route all requests through `index.php`.

1. Open the **XAMPP Control Panel**.
2. Next to the **Apache** module, click the **Config** button and select **Apache (httpd.conf)**.
3. In the text file that opens, search (`Ctrl + F`) for the following lines:
   ```
   DocumentRoot "C:\xampp\htdocs"
   <Directory "C:\xampp\htdocs">
   ```
   Change them into:
   ```
   DocumentRoot "location\to\the\folder" (example: DocumentRoot "C:\xampp\htdocs\CCDEVAP-S15-3-FoodSafe)
   <Directory "location\to\the\folder"> (example: <Directory "C:\xampp\htdocs\CCDEVAP-S15-3-FoodSafe">")
   ```
4. In the same file, look for this line
    ```
    #ErrorDocument 404 "/cgi-bin/missing_handler.pl"
    ```
    Change into: 
    ```
    ErrorDocument 404 /index.ph
    ```
    
5. Save and Close the file. Open XAMPP Control Panel, click Stop on the Apache module, then click Start to restart it and apply your changes.
6. You can access the project in your browser via `http://localhost/`
   


  


   


  
