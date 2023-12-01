<?php
require 'connector.php';
include 'header.php';
include 'menu.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $date = $_POST['date'];
    $reference = $_POST['reference'];
    $description = $_POST['description'];
    $debit = $_POST['debit'];
    $course = $_POST['course'];
    $session = $_POST['session'];
    $sem = $_POST['sem'];

    // Insert the financial data into the database
    $insertFinancialQuery = "INSERT INTO financial_data (date, reference, description, debit, course, session, sem) 
                             VALUES ('$date', '$reference', '$description', '$debit', '$course', '$session', '$sem')";
    $result = mysqli_query($connect, $insertFinancialQuery);

    if ($result) {
        echo "<p>Financial data added successfully!</p>";
    } else {
        echo "<p>Error adding financial data: " . mysqli_error($connect) . "</p>";
    }
}

// Fetch courses from the 'course' table
$courseQuery = "SELECT course_id FROM courses";
$courseResult = mysqli_query($connect, $courseQuery);

// Fetch distinct sessions and semesters from the 'user' table
$sessionQuery = "SELECT DISTINCT session FROM user";
$sessionResult = mysqli_query($connect, $sessionQuery);

$semesterQuery = "SELECT DISTINCT sem FROM user";
$semesterResult = mysqli_query($connect, $semesterQuery);

// Display added financial data
$displayQuery = "SELECT * FROM financial_data ORDER BY date DESC";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $displayQuery = "SELECT * FROM financial_data 
                    WHERE date BETWEEN '$start_date' AND '$end_date' 
                    ORDER BY date DESC";
}
$displayResult = mysqli_query($connect, $displayQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .financial-container {
            padding: 10px;
            margin: 10px auto;
            width: 98%;
            border: 1px solid white;
            background-color: silver;
        }

        body {
            font-family: sans-serif;
			background-color: steelblue;     
			background-image: "background.png";
			background-repeat:no-repeat;
			margin-top: 200px;
			background-size: 100%;
        }

        .financial-info {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .financial-details,
        .display-data {
            width: 100%;
            margin-bottom: 20px;
        }

        .display-data table {
            width: 100%;
            border-collapse: collapse;
        }

        .display-data th,
        .display-data td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .display-data th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body background="background.png">
    <div class="financial-container">
        <table width="100%" style="border: 1px solid #000; background-color: white;">
            <tr>
                <td>
                    <h2>FINANCIAL MANAGEMENT</h2>
                    <div class="financial-info">
                        <div class="financial-details">
                            <form method="post" action="">
                                <label for='course'>Course:</label>
                                <select id='course' name='course' required>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($courseResult)) {
                                        echo "<option value='{$row['course_id']}'>{$row['course_id']}</option>";
                                    }
                                    ?>
                                </select><br>

                                <label for='session'>Session:</label>
                                <select id='session' name='session' required>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($sessionResult)) {
                                        echo "<option value='{$row['session']}'>{$row['session']}</option>";
                                    }
                                    ?>
                                </select><br>

                                <label for='sem'>Semester:</label>
                                <select id='sem' name='sem' required>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($semesterResult)) {
                                        echo "<option value='{$row['sem']}'>{$row['sem']}</option>";
                                    }
                                    ?>
                                </select><br>

                                <label for='date'>Date:</label>
                                <input type='date' id='date' name='date' required><br>

                                <label for='reference'>Reference No:</label>
                                <input type='text' id='reference' name='reference' required><br>

                                <label for='description'>Description:</label>
                                <input type='text' id='description' name='description' required><br>

                                <label for='debit'>Debit:</label>
                                <input type='decimal' id='debit' name='debit' required><br>

                                <button type="submit">Add Financial Data</button>
                            </form>
                        </div>
                    </div>
                    <div class="display-data">
                        <h3>Added Financial Data</h3>
                        <form method="post" action="">
                            <label for="start_date">Start Date:</label>
                            <input type="date" id="start_date" name="start_date" required>
                            <label for="end_date">End Date:</label>
                            <input type="date" id="end_date" name="end_date" required>
                            <button type="submit">Filter</button>
                        </form>
                        <table>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Reference</th>
                                <th>Debit</th>
                                <th>Course</th>
                                <th>Session</th>
                                <th>Semester</th>
                            </tr>
                            <?php
                            while ($row = mysqli_fetch_assoc($displayResult)) {
                                echo "<tr>";
                                echo "<td>{$row['date']}</td>";
                                echo "<td>{$row['description']}</td>";
                                echo "<td>{$row['reference']}</td>";
                                echo "<td>{$row['debit']}</td>";
                                echo "<td>{$row['course']}</td>";
                                echo "<td>{$row['session']}</td>";
                                echo "<td>{$row['sem']}</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
