<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'employee_management';
    private $username = 'root';
    private $password = '196170303023';
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            // If MySQL connection fails, use SQLite as fallback
            try {
                $this->conn = new PDO("sqlite:employees.db");
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->createTables();
            } catch(PDOException $e) {
                echo "Connection error: " . $e->getMessage();
            }
        }

        return $this->conn;
    }

    private function createTables() {
        $sql = "CREATE TABLE IF NOT EXISTS employees (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            department VARCHAR(50) NOT NULL,
            hire_date DATE NOT NULL,
            is_active BOOLEAN DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )";

        $this->conn->exec($sql);
        
        // Check if we need to add sample data
        $count = $this->conn->query("SELECT COUNT(*) FROM employees")->fetchColumn();
        if ($count == 0) {
            $this->insertSampleData();
        }
    }

    private function insertSampleData() {
        $sampleData = [
            ['John Doe', 'john.doe@company.com', 'Engineering', '2015-03-15', 1],
            ['Jane Smith', 'jane.smith@company.com', 'Marketing', '2018-07-22', 1],
            ['Mike Johnson', 'mike.johnson@company.com', 'HR', '2019-01-10', 1],
            ['Sarah Wilson', 'sarah.wilson@company.com', 'Finance', '2014-05-30', 1],
            ['David Brown', 'david.brown@company.com', 'Engineering', '2020-09-14', 1],
            ['Lisa Davis', 'lisa.davis@company.com', 'Sales', '2016-11-08', 0],
            ['Chris Miller', 'chris.miller@company.com', 'Operations', '2013-02-20', 1],
            ['Amy Garcia', 'amy.garcia@company.com', 'Marketing', '2021-04-12', 1],
            ['Robert Taylor', 'robert.taylor@company.com', 'Engineering', '2017-08-05', 1],
            ['Emma Anderson', 'emma.anderson@company.com', 'HR', '2012-12-03', 1]
        ];

        $stmt = $this->conn->prepare(
            "INSERT INTO employees (name, email, department, hire_date, is_active) 
             VALUES (?, ?, ?, ?, ?)"
        );

        foreach ($sampleData as $data) {
            $stmt->execute($data);
        }
    }
}

// Initialize database connection
$database = new Database();
$db = $database->getConnection();
?>