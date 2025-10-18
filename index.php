<?php
require_once 'config/database.php';
require_once 'models/Employee.php';

$employee = new Employee();
$employees = $employee->getAllEmployees();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .employee-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .employee-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: #fff;
        }
        .employee-card.veteran {
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .employee-name {
            font-weight: bold;
            font-size: 18px;
            color: #333;
        }
        .employee-details {
            margin-top: 10px;
            color: #666;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge.active {
            background-color: #28a745;
            color: white;
        }
        .badge.inactive {
            background-color: #dc3545;
            color: white;
        }
        .badge.veteran {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Employee Management System</h1>
        
        <div class="employee-grid">
            <?php foreach ($employees as $emp): ?>
                <div class="employee-card <?php echo $emp['is_veteran'] ? 'veteran' : ''; ?>">
                    <div class="employee-name"><?php echo htmlspecialchars($emp['name']); ?></div>
                    <div class="employee-details">
                        <p><strong>Employee ID:</strong> <?php echo $emp['id']; ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($emp['email']); ?></p>
                        <p><strong>Department:</strong> <?php echo htmlspecialchars($emp['department']); ?></p>
                        <p><strong>Hire Date:</strong> <?php echo $emp['hire_date']; ?></p>
                        <p><strong>Years of Service:</strong> <?php echo $emp['years_of_service']; ?> years</p>
                        <div>
                            <span class="badge <?php echo $emp['is_active'] ? 'active' : 'inactive'; ?>">
                                <?php echo $emp['is_active'] ? 'Active' : 'Inactive'; ?>
                            </span>
                            <?php if ($emp['is_veteran']): ?>
                                <span class="badge veteran">5+ Years Veteran</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>