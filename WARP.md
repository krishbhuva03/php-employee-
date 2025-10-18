## Development Commands

### Running the Application
```bash
# Start PHP built-in development server
php -S localhost:8000

# Access web interface at http://localhost:8000
# Access API at http://localhost:8000/api/employees.php
```

### Testing
```bash
# Run comprehensive test suite
php test.php

# This tests employee data retrieval, veteran detection logic, and business rules
```

### Database Operations
The application automatically handles database setup:
- Primary: MySQL (configure credentials in `config/database.php`)
- Fallback: SQLite (`employees.db` file, auto-created)
- Sample data is inserted automatically on first run

## Architecture Overview

### Core Business Logic
This is a PHP MVC-structured employee management system with a specific business focus: **identifying veteran employees** (active employees with 5+ years of service) through green visual flagging.

### Key Architecture Components

**Database Layer (`config/database.php`)**
- Implements MySQL-first with SQLite fallback pattern
- Automatic table creation and sample data seeding
- PDO-based with prepared statements for security

**Model Layer (`models/Employee.php`)**
- Central business logic for veteran detection algorithm
- `processEmployeeData()` method calculates years of service and veteran status
- Veteran criteria: `is_active = 1` AND `years_of_service >= 5`

**API Layer (`api/employees.php`)**
- RESTful CRUD operations with filtering capabilities
- Special filters: `?filter=active`, `?filter=veterans`
- CORS-enabled for cross-origin requests

**Presentation Layer (`index.php`)**
- Grid-based responsive layout
- CSS classes: `.veteran` for green highlighting, status badges
- Server-side rendering with embedded PHP

### Data Flow Pattern
1. **Database Connection**: MySQL attempt → SQLite fallback → Auto-setup
2. **Data Processing**: Raw DB data → `processEmployeeData()` → Enhanced with business logic
3. **Veteran Detection**: Hire date calculation → Years of service → Veteran flag assignment
4. **UI Rendering**: Veteran status drives CSS class assignment for green highlighting

### Business Rule Implementation
The core business rule (5+ year veteran flagging) is centralized in `Employee::processEmployeeData()`:
- Uses `DateTime::diff()` for accurate year calculations
- Boolean `is_veteran` flag drives both API responses and UI styling
- Separation of concerns: calculation in model, presentation in view

### Testing Strategy
`test.php` provides comprehensive validation:
- Data retrieval testing
- Business rule verification (veteran logic)
- Cross-method consistency checks
- Visual confirmation of flagged employees

## API Endpoints

### Employee Filters
- `GET /api/employees.php` - All employees
- `GET /api/employees.php?filter=active` - Active employees only  
- `GET /api/employees.php?filter=veterans` - 5+ year active employees
- `GET /api/employees.php?id=1` - Single employee

### CRUD Operations
- `POST /api/employees.php` - Create employee
- `PUT /api/employees.php?id=1` - Update employee
- `DELETE /api/employees.php?id=1` - Delete employee

## Development Notes

### Database Schema
Single `employees` table with auto-increment ID, standard employee fields, and boolean `is_active` flag. The `hire_date` field is critical for veteran calculations.

### Styling System
Green veteran highlighting uses `.veteran` CSS class applied conditionally based on `is_veteran` boolean from the model layer.

### Error Handling
Database connection failures automatically fall back to SQLite. API returns appropriate HTTP status codes and JSON error messages.