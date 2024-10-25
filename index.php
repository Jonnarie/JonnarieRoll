<!DOCTYPE html>
<html>
<head>
    <title>Employee Form</title>
    <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>

<div data-role="page" id="employeeForm">
    <div data-role="header">
        <h1>Employee Input</h1>
    </div>

    <div data-role="content">
        <form id="empForm" action="create.php" method="POST">
            <label for="employeeNumber">Employee Number:</label>
            <input type="text" name="employeeNumber" id="employeeNumber" required>
            
            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" id="lastName" required>

            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" id="firstName" required>

            <label for="middleName">Middle Name:</label>
            <input type="text" name="middleName" id="middleName">

            <label for="hoursWork">No. of Hours Work:</label>
            <input type="number" name="hoursWork" id="hoursWork" required>

            <label for="hoursOT">No. of Hours Overtime:</label>
            <input type="number" name="hoursOT" id="hoursOT" required>

            <label for="hoursLate">No. of Hours Late:</label>
            <input type="number" name="hoursLate" id="hoursLate" required>

            <label for="ratePerHour">Rate Per Hour:</label>
            <input type="number" name="ratePerHour" id="ratePerHour" required>

            <input type="submit" value="Submit">
        </form>

        <h2>Existing Employees</h2>
        <div id="employeeRecords">
            <?php
            // Database connection
            $conn = new mysqli('localhost', 'root', '', 'db_ise101_jmr');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM tbl_employee_payroll";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div>";
                    echo "Employee Number: " . htmlspecialchars($row['Employee_Number']) . "<br>";
                    echo "Last Name: " . htmlspecialchars($row['Last_Name']) . "<br>";
                    echo "First Name: " . htmlspecialchars($row['First_Name']) . "<br>";
                    echo "Middle Name: " . htmlspecialchars($row['Middle_Name']) . "<br>";
                    echo "No. of Hours Work: " . htmlspecialchars($row['No_of_Hours_Work']) . "<br>";
                    echo "No. of Hours Overtime: " . htmlspecialchars($row['No_of_Hours_Overtime']) . "<br>";
                    echo "No. of Hours Late: " . htmlspecialchars($row['No_of_Hours_Late']) . "<br>";
                    echo "Rate Per Hour: " . htmlspecialchars($row['Rate_Per_Hour']) . "<br>";
                    echo "<a href='create.php?employeeNumber=" . htmlspecialchars($row['Employee_Number']) . "'><button>Update</button></a>";
                    echo "</div><hr>";
                }
            } else {
                echo "No employee records found.";
            }

            $conn->close();
            ?>
        </div>

        <div data-role="footer" data-position="fixed">
            <center><small>Jonnarie M. Roll Copyright &copy; 2024</small></center>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Handle form submission
    $('#empForm').submit(function(event) {
        event.preventDefault(); // Prevent default form submission
        $.ajax({
            type: 'POST',
            url: 'create.php',
            data: $(this).serialize(),
            success: function(response) {
                // Clear form inputs
                $('#empForm')[0].reset();
                // Optionally, you can provide feedback to the user here
            },
            error: function() {
                alert('Error saving data. Please try again.');
            }
        });
    });
});
</script>

</body>
</html>
