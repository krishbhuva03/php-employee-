<?php
require_once 'config/database.php';
require_once 'models/Employee.php';

echo "=== Employee Management System Test ===\n\n";

$employee = new Employee();

// Test getting all employees
echo "1. Testing getAllEmployees():\n";
$allEmployees = $employee->getAllEmployees();
echo "Total employees: " . count($allEmployees) . "\n\n";

// Test veteran detection
echo "2. Testing veteran detection (5+ years, active):\n";
$veteranCount = 0;
foreach ($allEmployees as $emp) {
    if ($emp['is_veteran']) {
        $veteranCount++;
        echo "   ✓ {$emp['name']} - {$emp['years_of_service']} years - " . 
             ($emp['is_active'] ? 'Active' : 'Inactive') . "\n";
    }
}
echo "Total veterans: $veteranCount\n\n";

// Test active employees
echo "3. Testing getActiveEmployees():\n";
$activeEmployees = $employee->getActiveEmployees();
$activeCount = count($activeEmployees);
echo "Total active employees: $activeCount\n\n";

// Test veteran-specific method
echo "4. Testing getVeteranEmployees():\n";
$veterans = $employee->getVeteranEmployees();
echo "Veterans (via specific method): " . count($veterans) . "\n\n";

// Display summary
echo "=== Summary ===\n";
echo "Total employees: " . count($allEmployees) . "\n";
echo "Active employees: $activeCount\n";
echo "Veteran employees (5+ years, active): " . count($veterans) . "\n";

// Verify business rule
echo "\n=== Business Rule Verification ===\n";
foreach ($allEmployees as $emp) {
    $shouldBeVeteran = ($emp['years_of_service'] >= 5 && $emp['is_active']);
    $isMarkedVeteran = $emp['is_veteran'];
    
    if ($shouldBeVeteran === $isMarkedVeteran) {
        echo "✓ {$emp['name']}: Correct veteran status\n";
    } else {
        echo "✗ {$emp['name']}: Incorrect veteran status\n";
    }
}

echo "\n=== Green Flagging Test (Active 5+ year employees) ===\n";
foreach ($allEmployees as $emp) {
    if ($emp['is_veteran']) {
        echo "🟢 {$emp['name']} - {$emp['department']} - {$emp['years_of_service']} years\n";
    }
}

echo "\nTest completed!\n";
?>