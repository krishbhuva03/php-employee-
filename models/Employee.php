<?php

class Employee {
    private $conn;
    private $table_name = "employees";

    public function __construct() {
        global $db;
        $this->conn = $db;
    }

    public function getAllEmployees() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $employees = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $employee = $this->processEmployeeData($row);
            $employees[] = $employee;
        }
        
        return $employees;
    }

    public function getActiveEmployees() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE is_active = 1 ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $employees = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $employee = $this->processEmployeeData($row);
            $employees[] = $employee;
        }
        
        return $employees;
    }

    public function getVeteranEmployees() {
        $employees = $this->getAllEmployees();
        return array_filter($employees, function($emp) {
            return $emp['is_veteran'];
        });
    }

    private function processEmployeeData($row) {
        // Calculate years of service
        $hireDate = new DateTime($row['hire_date']);
        $currentDate = new DateTime();
        $yearsOfService = $currentDate->diff($hireDate)->y;
        
        // Determine if employee is a veteran (5+ years and active)
        $isVeteran = ($yearsOfService >= 5 && $row['is_active'] == 1);
        
        return [
            'id' => $row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'department' => $row['department'],
            'hire_date' => $row['hire_date'],
            'is_active' => (bool)$row['is_active'],
            'years_of_service' => $yearsOfService,
            'is_veteran' => $isVeteran,
            'created_at' => $row['created_at'] ?? null
        ];
    }

    public function createEmployee($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (name, email, department, hire_date, is_active) 
                  VALUES (:name, :email, :department, :hire_date, :is_active)";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'department' => $data['department'],
            'hire_date' => $data['hire_date'],
            'is_active' => $data['is_active'] ?? 1
        ]);
    }

    public function updateEmployee($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                  SET name = :name, email = :email, department = :department, 
                      hire_date = :hire_date, is_active = :is_active 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'email' => $data['email'],
            'department' => $data['department'],
            'hire_date' => $data['hire_date'],
            'is_active' => $data['is_active']
        ]);
    }

    public function deleteEmployee($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

    public function getEmployeeById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $this->processEmployeeData($row);
        }
        
        return null;
    }
}

?>