<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Employee.php';

$employee = new Employee();
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $emp = $employee->getEmployeeById($_GET['id']);
            if ($emp) {
                echo json_encode($emp);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Employee not found']);
            }
        } else if (isset($_GET['filter'])) {
            switch($_GET['filter']) {
                case 'active':
                    $employees = $employee->getActiveEmployees();
                    break;
                case 'veterans':
                    $employees = $employee->getVeteranEmployees();
                    break;
                default:
                    $employees = $employee->getAllEmployees();
            }
            echo json_encode($employees);
        } else {
            $employees = $employee->getAllEmployees();
            echo json_encode($employees);
        }
        break;
    
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if ($employee->createEmployee($data)) {
            http_response_code(201);
            echo json_encode(['message' => 'Employee created successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to create employee']);
        }
        break;
    
    case 'PUT':
        if (isset($_GET['id'])) {
            $data = json_decode(file_get_contents('php://input'), true);
            if ($employee->updateEmployee($_GET['id'], $data)) {
                echo json_encode(['message' => 'Employee updated successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to update employee']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Employee ID required']);
        }
        break;
    
    case 'DELETE':
        if (isset($_GET['id'])) {
            if ($employee->deleteEmployee($_GET['id'])) {
                echo json_encode(['message' => 'Employee deleted successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to delete employee']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Employee ID required']);
        }
        break;
    
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
?>
