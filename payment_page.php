<?php
require 'connector.php'; // Ensure this file connects to your database
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_SESSION['userid'])) {
    $studentId = $_SESSION['userid'];

    // Retrieve student details
    $studentQuery = "SELECT * FROM user WHERE userid = '$studentId'";
    $studentResult = mysqli_query($connect, $studentQuery);

    if ($studentResult && mysqli_num_rows($studentResult) > 0) {
        $studentDetails = mysqli_fetch_assoc($studentResult);
        $studentName = $studentDetails['name'];
        $studentCourse = $studentDetails['course'];
        $studentSession = $studentDetails['session'];
        $studentSemester = $studentDetails['sem'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Page</title>
</head>
<body>
    <h1>Student Details</h1>
    <p>Name: <?php echo $studentName; ?></p>
    <p>Course: <?php echo $studentCourse; ?></p>
    <p>Session: <?php echo $studentSession; ?></p>
    <p>Semester: <?php echo $studentSemester; ?></p>

    <h2>Make Payment</h2>
    <form action="payment_page.php" method="POST">
        <label for="amount">Amount to be Paid:</label>
        <input type="number" id="amount" name="amount" required>
        <input type="submit" value="Pay">
    </form>
</body>
</html>

<?php
    } else {
        // Unable to retrieve student information
        echo "Error: Student information not found.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['userid'])) {
    $studentId = $_SESSION['userid'];
    $paymentDate = date('Y-m-d'); // Current date
    $paymentDescription = "Payment";
    $referenceNumber = mt_rand(100000, 999999); // Generate a random reference number
    $amountPaid = $_POST['amount'];

    $courseQuery = "SELECT course, session, sem FROM user WHERE userid = '$studentId'";
    $courseResult = mysqli_query($connect, $courseQuery);

    if ($courseResult && mysqli_num_rows($courseResult) > 0) {
        $courseRow = mysqli_fetch_assoc($courseResult);
        $studentCourse = $courseRow['course'];
        $studentSession = $courseRow['session'];
        $studentSemester = $courseRow['sem'];

        // Insert payment data into the database
        $insertPaymentQuery = "INSERT INTO financial_data (date, description, reference, course, session, sem, amount) VALUES ('$paymentDate', '$paymentDescription', '$referenceNumber', '$studentCourse', '$studentSession', '$studentSemester', '$amountPaid')";
        $insertPaymentResult = mysqli_query($connect, $insertPaymentQuery);

        if ($insertPaymentResult) {
            // Payment data inserted successfully
            echo "<script>alert('Payment recorded successfully with reference number: " . $referenceNumber . "');</script>";
        } else {
            // Failed to insert payment data
            echo "Error: Unable to record payment.";
        }
    } else {
        // Unable to retrieve student information
        echo "Error: Student information not found.";
    }
} else {
    // Redirect if accessed without proper method or session
    header("Location: index.php");
    exit();
}
?>
