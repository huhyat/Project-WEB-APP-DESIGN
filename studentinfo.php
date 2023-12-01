<?php
require 'connector.php';
include 'header.php';
include 'menu.php';
?>

<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
			background-color: steelblue;     
			background-image: "background.png";
			background-repeat:no-repeat;
			margin-top: 200px;
			background-size: 100%;
            
        }

        .student-container {
            width: 98%;
            margin: 10px auto;
            background-color: #fff;
            border: 1px solid #ccc;
        	background-color: silver;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 0px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 5px 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }

        button:hover {
            background-color: #45a049;
        }

        .add-button {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body background="background.png">
    <div class="student-container">
		<table width="100%" style="border: 1px solid #000; background-color: white;">
            <tr>
                <td>
        <h2>STUDENTS INFORMATION</h2>
        <table>
            <tr>
                <th>Bil.</th>
                <th>Student ID</th>
                <th>Password</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Semester</th>
                <th>Action</th>
            </tr>
            
            <?php
            $no = 1;
            $data1 = mysqli_query($connect, "SELECT * FROM user WHERE level='STUDENT' ORDER BY name ASC");
            while ($info1 = mysqli_fetch_array($data1)) {
                ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $info1['userid']; ?></td>
                    <td><?php echo $info1['password']; ?></td>
                    <td><?php echo $info1['name']; ?></td>
                    <td><?php echo $info1['course']; ?></td>
                    <td><?php echo $info1['sem']; ?></td>
                    <td>
                        <a href="edit_student.php?userid=<?php echo $info1['userid'];?>"><button>EDIT</button></a>
                        <a href="delete_student.php?userid=<?php echo $info1['userid'];?>"><button>DELETE</button></a>
                        <a href="edit_student_result.php?userid=<?php echo $info1['userid'];?>"><button>EDIT RESULT</button></a>
                    </td>
                </tr>
                <?php $no++;
            } ?>
        </table>
        
        <div class="add-button">
            <a href="add_student.php"><button>ADD STUDENT</button></a>
        </div>
    </div>
</body>
</html>
