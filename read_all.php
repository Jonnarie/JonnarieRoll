<!DOCTYPE html>
<html>
<head>
    <title>Employee Form</title>
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 20px; }
        table { width: auto; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 4px 6px; text-align: left; }
        th { background: #4CAF50; color: white; }
        tr:nth-child(even) { background: #f2f2f2; }
        button { padding: 4px 8px; margin: 2px; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; }
        .view { background: #2196F3; }
        .edit { background: #ffa500; }
        .delete { background: #f44336; }
        .add, .update { background: #4CAF50; }
    </style>
</head>
<body>

<?php
$conn = new mysqli('localhost', 'root', '', 'db_ise101_jmr');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$result = $conn->query("SELECT Employee_Number, CONCAT(Last_Name, ', ', First_Name, ' ', Middle_Name) AS Full_Name, NetPay FROM tbl_employee_payroll");
if ($result->num_rows > 0) {
    echo "<table><thead><tr><th>Emp No</th><th>Full Name</th><th>Net Pay</th><th>Actions</th></tr></thead><tbody>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['Employee_Number']}</td>
                <td>{$row['Full_Name']}</td>
                <td>{$row['NetPay']}</td>
                <td>
                    <button class='view' onclick=\"location.href='view.php?id={$row['Employee_Number']}'\">View</button>
                    <button class='edit' onclick=\"location.href='edit.php?id={$row['Employee_Number']}'\">Edit</button>
                    <button class='update' onclick=\"location.href='update.php?id={$row['Employee_Number']}'\">Update</button>
                    <button class='delete' onclick=\"if(confirm('Delete this record?')) location.href='delete.php?id={$row['Employee_Number']}'\">Delete</button>
                </td>
              </tr>";
    }
    echo "</tbody></table>";
    echo "<button class='add' onclick=\"location.href='add.php'\">Add Employee</button>";
} else {
    echo "<p>No records found.</p>";
}

$conn->close();
?>

</body>
</html>
