<?php
    require_once('../secclass.php');
    $sessionData = $payroll->getSessionSecretaryData();
    $payroll->verifyUserAccess($sessionData['access'], $sessionData['fullname'],2);
    $fullname = $sessionData['fullname'];
    $access = $sessionData['access'];
    $id = $sessionData['id'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automatic Payroll</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../seccss/main.css">
</head>
<body>
    <div class="main-container">
       <div class="sidebar">
               <div class="sidebar__logo">
                    <div class="logo"></div>
                    <h3>JDTV</h3>
               </div>

               <nav>
                    <ul>
                        <li class="li__records">
                            <a href="../SecretaryPortal/secdashboard.php">Attendance</a>
                         </li>
                        <li class="li__user">
                            <a href="../SecretaryPortal/employeelist.php">Employees</a>
                            <ul>
                                <li><a href="../SecretaryPortal/empschedule.php">Schedule</a></li>
                                <li><a href="../SecretaryPortal/deductions.php">Deductions</a></li>
                                <li><a href="../SecretaryPortal/violations.php">Violations</a></li>
                            </ul>
                        </li>
    
                        <li class="li__report active">
                            <a href="#" class="active">Payroll</a>
                            <ul>
                                <li><a href="../SecretaryPortal/automaticpayroll.php" class="active">Salary</a></li>
                            </ul>
                        </li>

                        <li class="li__report">
                            <a href="#">Salary Report</a>
                            <ul>
                                <li><a href="../SecretaryPortal/releasedsalary.php">Released Salary</a></li>
                                <li><a href="../SecretaryPortal/salaryreport.php">Salary Chart</a></li>
                                <li><a href="../SecretaryPortal/contributions.php">Contributions</a></li>
                            </ul>
                         </li>
                         <li class="li__report">
                         <a href="../SecretaryPortal/activitylog.php">Activity log</a>
                         </li>
                    </ul>
                </nav>
                <div class="sidebar__logout">
                    <div class="li li__logout"><a href="../seclogout.php">LOGOUT</a></div>
                </div>
            </div>

        <div class="user-info">
                <a href="editsec.php">[ Edit Account ]</a>
                <p><?php echo $fullname; ?></p>
            <div class="user-profile">
            </div>
        </div>

        <div class="page-info-head">
            Automatic Payroll
        </div>

        <div class="auto-generated-payroll-attendance">
            <div class="auto-generated-payroll-attendance__header">
                <h1>Generate Salary</h1>
                <form method="post">
                <div class="searchbar">
                    <span class="material-icons">
                    <button type="submit" name="searchempatt">Search</button>
                    </span>
                    
                    <input type="text" placeholder="Search" name="emp">
                    
                    </form>
                </div>
            </div>
            <div style='display: flex; justify-content: right; margin-right: 100px;'>
                <form method="post">
                    <button type="submit" name="generateall"><a href="createsalary.php">GENERATE ALL</a></button>
                </form>
            </div>


            <div class="auto-generated-payroll-attendance__content">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Employees</th>
                            <th>Attendance</th>
                            <th>Total Hours</th>
                            <th>Standard Hours</td>
                            <th>Overtime Hours</th>
                            <th>Normal Rate</th>
                            <th>OT Rate</th>
                            <th>Gross Pay</th>
                            <th>Standard Pay</th>
                            <th>Overtime Pay</th>
                        </tr>
                    </thead>
          
                    <tbody>
                    <?php
                        // if(isset($_POST['searchempatt'])){
                        //     $payroll->searchempatt($fullname,$id);
                        // }else if (isset($_POST['searchempatt']) && empty($_POST['emp'])){
                        //     $payroll->displayempattendance($fullname,$id);
                        // }else{
                        //     $payroll->displayempattendance($fullname,$id);
                        // }
                        $payroll->displayempattendance($fullname, $id);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
