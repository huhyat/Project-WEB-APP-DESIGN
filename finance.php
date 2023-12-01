<?php
require 'connector.php';
include 'header.php';
include 'menu.php';

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$studentId = $_SESSION['userid'];

$courseQuery = "SELECT course FROM user WHERE userid = '$studentId'";
$courseResult = mysqli_query($connect, $courseQuery);

if ($courseRow = mysqli_fetch_assoc($courseResult)) {
    $studentCourse = $courseRow['course'];

    $displayQuery = "SELECT * FROM financial_data 
                     WHERE course = (SELECT course FROM user WHERE userid = '$studentId') 
                     AND sem = (SELECT sem FROM user WHERE userid = '$studentId')
                     ORDER BY date DESC";
    $displayResult = mysqli_query($connect, $displayQuery);

    $financialData = []; // Initialize an array to store the data
    $totalDebit = 0; // Initialize a variable to hold the total debit
    
    if ($displayResult) {
        while ($row = mysqli_fetch_assoc($displayResult)) {
            $financialData[] = $row; // Store each row in the array
            $totalDebit += $row['debit']; // Calculate the total debit
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: steelblue;     
            background-image: url('background.png'); /* Updated background image */
            background-repeat: no-repeat;
            margin-top: 200px;
            background-size: 100%;
        }


        .financial-container {
            padding: 10px;
            margin: 10px auto;
            width: 98%;
            border: 1px solid white;
            background-color: white;
        }

        .display-data table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .display-data th, .display-data td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .display-data th {
            background-color: #f2f2f2;
        }
		
		.payment-button {
            text-align: center;
            margin-top: 20px;
        }

        
        .payment-button form {
            display: inline-block;
        }

        .payment-button button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            transition-duration: 0.4s;
            cursor: pointer;
        }

        .payment-button button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body background="background.png">
    <div class="financial-container">
        <h2>FINANCIAL INFORMATION</h2>
        <h3>Financial Data for <?php echo $studentCourse; ?></h3>
        <div class="display-data">
            <table>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Reference</th>
                    <th>Course</th>
                    <th>Session</th>
                    <th>Semester</th>
                    <th>RM</th>
                </tr>
                <?php
                foreach ($financialData as $row) {
                    echo "<tr>";
                    echo "<td>{$row['date']}</td>";
                    echo "<td>{$row['description']}</td>";
                    echo "<td>{$row['reference']}</td>";
                    echo "<td>{$row['course']}</td>";
                    echo "<td>{$row['session']}</td>";
                    echo "<td>{$row['sem']}</td>";
                    echo "<td>{$row['debit']}</td>";
                    echo "</tr>";
                }
                ?>
                <tr>
                    <td colspan="6"><strong>Total</strong></td>
                    <td><strong><?php echo $totalDebit; ?></strong></td>
                </tr>
            </table>
        </div>
		
    </div>
</body>
</html>

<?php
}
// Else block if there's no associated course for the student.
?>
