<?php
// Start the session first
session_start();

if ($_SESSION['level'] == "ADMIN") {
    // If the user is an ADMIN, display the ADMIN menu
    echo '<style>
            .nav-menu {
                font-family: Arial, sans-serif;
                background-color: white;
                color: #000; 
                z-index: 1000;
                margin: 0 auto;
                border-width: 5px; 
                border-color: #000; 
                border-style: solid; 
            }

            .nav-menu a {
                color: #000; 
                text-decoration: none; 
            }

            .nav-menu a:hover {
                color: #ff0000; 
            }
          </style>
          
          <table class="nav-menu" width="100%">
            <center>
                <tr>
                    <td width="13%">
                        <a href="index1.php">Home</a>
                    </td>

                    <!-- Link for Student Information -->
                    <td width="13%">
                        <a href="studentinfo.php">Student Information</a>
                    </td>

                    <!-- Link for Course Management -->
                    <td width="13%">
                        <a href="course_management.php">Course Management</a>
                    </td>

                    <!-- Link for Financial Management -->
                    <td width="13%">
                        <a href="financial_management.php">Financial Management</a>
                    </td>

                    <td width="13%">
                        <a href="logout.php">LOGOUT</a> 
                    </td>
                </tr>
            </center>
          </table>';
} else {
    // If the user is a STUDENT, display the STUDENT menu
    echo '<style>
            .nav-menu {
                display: flex;
                justify-content: center; 
                align-items: center; 
                background-color: white;
                color: #fff;
                z-index: 1000;
            }

            .nav-menu a {
                margin: 0 60px; 
                text-decoration: none;
                color: #fff;
            }
          </style>
          
          <table class="nav-menu" style="border: 5px solid #000; width="100%">
            <tr>
                <td width="13%">
                    <a href="index1.php">
                        <img src="home.jpg" alt="Home" width="100" height="100">
                    </a>
                </td>

                <td width="13%">
                    <a href="profile.php">
                        <img src="profile.jpg" alt="Profile" width="100" height="100">
                    </a>
                </td>

                <td width="13%">
                    <a href="academic.php">
                        <img src="academic.jpg" alt="Academic" width="100" height="100">
                    </a>
                </td>

                <td width="13%">
                    <a href="finance.php">
                        <img src="finance.jpg" alt="Finance" width="100" height="100">
                    </a>
                </td>

                <td width="13%">
                    <a href="logout.php">
                        <img src="logout.png" alt="Logout" width="100" height="100">
                    </a>
                </td>
            </tr>
          </table>';
}
?>
