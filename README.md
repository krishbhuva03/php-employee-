# Employee Management System

A PHP-based employee management application that displays all employees and flags active employees with 5+ years of service in green color.

## Features

- **Employee Display**: Shows all employees with their details
- **Veteran Flagging**: Active employees with 5+ years of service are flagged in green
- **Responsive Design**: Clean, grid-based layout that works on all devices
- **REST API**: JSON API endpoints for employee data management
- **Database Support**: Works with MySQL or SQLite (automatic fallback)

## Requirements

- PHP 7.4 or higher
- PDO extension (usually included with PHP)
- MySQL (optional - SQLite used as fallback)
- Web server (Apache, Nginx, or PHP built-in server)

## Installation

1. **Clone or download the project**
   ```bash
   git clone <repository-url>
   cd employee-management-app
   ```

2. **Database Setup**
   
   **Option A: MySQL (Recommended)**
   - Create a MySQL database named `employee_management`
   - Update `config/database.php` with your MySQL credentials
   
   **Option B: SQLite (Automatic)**
   - No setup required - SQLite database will be created automatically
   - Database file: `employees.db`

3. **Start the application**
   
   **Using PHP built-in server:**
   ```bash
   php -S localhost:8000
   ```
   
   **Using Apache/Nginx:**
   - Point document root to the project directory
   - Ensure PHP is properly configured

4. **Access the application**
   - Web Interface: `http://localhost:8000` (or your configured URL)
   - API Endpoint: `http://localhost:8000/api/employees.php`

## Project Structure

```
employee-management-app/
├── index.php              # Main web interface
├── config/
│   └── database.php       # Database configuration and connection
├── models/
│   └── Employee.php       # Employee model with business logic
├── api/
│   └── employees.php      # REST API endpoints
├── test.php               # Test script for functionality verification
├── README.md              # This file
└── employees.db           # SQLite database (auto-created)
```

## Usage

### Web Interface

1. Open `http://localhost:8000` in your browser
2. View all employees in a grid layout
3. **Green-flagged employees** represent active staff with 5+ years of service
4. Each employee card shows:
   - Name, Email, Department
   - Hire date and years of service
   - Active/Inactive status
   - Veteran badge for 5+ year employees

### API Endpoints

**Base URL:** `/api/employees.php`

#### GET - Fetch Employees
```bash
# Get all employees
curl http://localhost:8000/api/employees.php

# Get active employees only
curl http://localhost:8000/api/employees.php?filter=active

# Get veteran employees (5+ years, active)
curl http://localhost:8000/api/employees.php?filter=veterans

# Get specific employee
curl http://localhost:8000/api/employees.php?id=1
```

#### POST - Create Employee
```bash
curl -X POST http://localhost:8000/api/employees.php \\
  -H "Content-Type: application/json" \\
  -d '{
    "name": "New Employee",
    "email": "new@company.com",
    "department": "IT",
    "hire_date": "2023-01-15",
    "is_active": 1
  }'
```

#### PUT - Update Employee
```bash
curl -X PUT http://localhost:8000/api/employees.php?id=1 \\
  -H "Content-Type: application/json" \\
  -d '{
    "name": "Updated Name",
    "email": "updated@company.com",
    "department": "Engineering",
    "hire_date": "2018-03-15",
    "is_active": 1
  }'
```

#### DELETE - Remove Employee
```bash
curl -X DELETE http://localhost:8000/api/employees.php?id=1
```

## Business Logic

### Veteran Employee Criteria
An employee is flagged as a **veteran** (shown in green) if:
1. **Active status**: `is_active = 1`
2. **Service duration**: 5 or more years from hire date
3. **Current date**: Calculation based on current system date

### Sample Data
The application includes 10 sample employees with various hire dates and statuses to demonstrate the flagging functionality.

## Testing

Run the test script to verify functionality:

```bash
php test.php
```

This will:
- Test employee data retrieval
- Verify veteran detection logic
- Check business rule implementation
- Display green-flagged employees

## Database Schema

### employees table
```sql
CREATE TABLE employees (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    department VARCHAR(50) NOT NULL,
    hire_date DATE NOT NULL,
    is_active BOOLEAN DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

## Customization

### Database Configuration
Edit `config/database.php` to modify:
- Database connection settings
- Sample data
- Table structure

### Styling
Modify the CSS in `index.php` to customize:
- Colors and layout
- Green flagging appearance
- Responsive breakpoints

### API Endpoints
Extend `api/employees.php` to add:
- Additional filters
- Bulk operations
- Authentication

## Troubleshooting

### Common Issues

1. **Database Connection Errors**
   - Verify MySQL credentials in `config/database.php`
   - Ensure MySQL server is running
   - Check if SQLite fallback is working

2. **Empty Employee List**
   - Check if sample data was inserted
   - Verify database permissions
   - Run `test.php` to diagnose

3. **Green Flagging Not Working**
   - Verify hire dates in sample data
   - Check system date/timezone
   - Run business logic tests

### Support
For issues or questions:
1. Check the test script output: `php test.php`
2. Review error logs
3. Verify PHP and database configuration

## License

This project is open source and available under the [MIT License](LICENSE).