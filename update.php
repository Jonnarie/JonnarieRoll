<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $employeeNumber = $_POST['employeeNumber'];
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $hoursWork = $_POST['hoursWork'];
    $hoursOT = $_POST['hoursOT'];
    $hoursLate = $_POST['hoursLate'];
    $ratePerHour = $_POST['ratePerHour'];

    // Calculations
    $grossPay = (($hoursWork + $hoursOT) - $hoursLate) * $ratePerHour;
    $tax = $grossPay * 0.10;
    $sss = $grossPay * 0.12;
    $pagIbig = $grossPay * 0.14;
    $philHealth = $grossPay * 0.16;
    $totalDeduction = $tax + $sss + $pagIbig + $philHealth;
    $netPay = $grossPay - $totalDeduction;

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'db_ise101_jmr');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update record
    $sql = "UPDATE tbl_employee_payroll SET 
                Last_Name='$lastName', 
                First_Name='$firstName', 
                Middle_Name='$middleName', 
                No_of_Hours_Work=$hoursWork, 
                No_of_Hours_Overtime=$hoursOT, 
                No_of_Hours_Late=$hoursLate, 
                Rate_Per_Hour=$ratePerHour, 
                Gross_Pay=$grossPay, 
                Tax=$tax, 
                SSS=$sss, 
                PagIbig=$pagIbig, 
                PhilHealth=$philHealth, 
                Total_Deduction=$totalDeduction, 
                Net_Pay=$netPay 
            WHERE Employee_Number='$employeeNumber'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
