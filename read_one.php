<?php
$employeeNumber = isset($_GET['employeeNumber']) ? trim($_GET['employeeNumber']) : ''; // Get employee number from query parameter

// Check if employeeNumber is set and valid
if (empty($employeeNumber) || !is_numeric($employeeNumber)) {
    die("Valid employee number is required.");
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'db_ise101_jmr');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM tbl_employee_payroll WHERE Employee_Number = ?");
$stmt->bind_param("s", $employeeNumber);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<h2>Employee Details</h2>";
    echo "Employee Number: " . htmlspecialchars($row['Employee_Number']) . "<br>";
    echo "Last Name: " . htmlspecialchars($row['Last_Name']) . "<br>";
    echo "First Name: " . htmlspecialchars($row['First_Name']) . "<br>";
    echo "Middle Name: " . htmlspecialchars($row['Middle_Name']) . "<br>";
    echo "No. of Hours Work: " . htmlspecialchars($row['No_of_Hours_Work']) . "<br>";
    echo "No. of Hours Overtime: " . htmlspecialchars($row['No_of_Hours_Overtime']) . "<br>";
    echo "No. of Hours Late: " . htmlspecialchars($row['No_of_Hours_Late']) . "<br>";
    echo "Rate Per Hour: " . htmlspecialchars($row['Rate_Per_Hour']) . "<br>";
    echo "Gross Pay: " . htmlspecialchars($row['Gross_Pay']) . "<br>";
    echo "Tax: " . htmlspecialchars($row['Tax']) . "<br>";
    echo "SSS: " . htmlspecialchars($row['SSS']) . "<br>";
    echo "PagIbig: " . htmlspecialchars($row['PagIbig']) . "<br>";
    echo "PhilHealth: " . htmlspecialchars($row['PhilHealth']) . "<br>";
    echo "Total Deduction: " . htmlspecialchars($row['Total_Deduction']) . "<br>";
    echo "Net Pay: " . htmlspecialchars($row['NetPay']) . "<br>";
    
    // View and Edit buttons
    echo "<br>";
    echo "<a href='view.php?employeeNumber=" . htmlspecialchars($row['Employee_Number']) . "'><button>View</button></a> ";
    echo "<a href='edit.php?employeeNumber=" . htmlspecialchars($row['Employee_Number']) . "'><button>Edit</button></a>";
} else {
    echo "No results found for Employee Number: " . htmlspecialchars($employeeNumber);
}

$stmt->close();
$conn->close();
?>
