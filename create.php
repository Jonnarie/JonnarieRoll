<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'db_ise101_jmr');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input data
    $employeeNumber = trim($_POST['employeeNumber']);
    $lastName = trim($_POST['lastName']);
    $firstName = trim($_POST['firstName']);
    $middleName = trim($_POST['middleName']);
    $hoursWork = intval($_POST['hoursWork']);
    $hoursOT = intval($_POST['hoursOT']);
    $hoursLate = intval($_POST['hoursLate']);
    $ratePerHour = floatval($_POST['ratePerHour']);

    // Check for duplicate employee number
    $checkSql = "SELECT * FROM tbl_employee_payroll WHERE Employee_Number = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("s", $employeeNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Error: Employee number already exists.";
    } else {
        // Insert new employee record
        $insertSql = "INSERT INTO tbl_employee_payroll (Employee_Number, Last_Name, First_Name, Middle_Name, No_of_Hours_Work, No_of_Hours_Overtime, No_of_Hours_Late, Rate_Per_Hour) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("ssssiiii", $employeeNumber, $lastName, $firstName, $middleName, $hoursWork, $hoursOT, $hoursLate, $ratePerHour);

        if ($insertStmt->execute()) {
            echo "New employee record created successfully.";
        } else {
            echo "Error: " . $insertStmt->error;
        }
        
        $insertStmt->close();
    }

    $stmt->close();
}

$conn->close();
?>
