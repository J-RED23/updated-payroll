<?php
    require_once('../class.php');
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
    <link rel="stylesheet" type="text/css" href="../css/main.css">
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
                                <li><a href="../SecretaryPortal/manualpayroll.php">Manual</a></li>
                                <li><a href="../SecretaryPortal/automaticpayroll.php" class="active">Automatic</a></li>
                            </ul>
                        </li>

                        <li class="li__report">
                            <a href="#">Salary</a>
                            <ul>
                                <li><a href="../SecretaryPortal/releasedsalary.php">Released Salary</a></li>
                                <li><a href="../SecretaryPortal/salaryreport.php">Salary Report</a></li>
                                <li><a href="../SecretaryPortal/contributions.php">Contributions</a></li>
                            </ul>
                         </li>
                    </ul>
                </nav>
                <div class="sidebar__logout">
                    <div class="li li__logout"><a href="../logout.php">LOGOUT</a></div>
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
                <h1>Employee's Generated Salary</h1>
                <div class="searchbar">
                    <span class="material-icons">
                        search
                    </span>
                    <input type="text" placeholder="Search">
                </div>
            </div>

            <div class="auto-generated-payroll-attendance__content">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Employees</th>
                            <th>Attendance</th>
                            <th>Total Hours</th>
                            <th>Salary</th>
                        </tr>
                    </thead>
          
                    <tbody>
                        <?php 
                            $payroll->displayempattendance($fullname,$id)
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="auto-generated-salaries">
            <div class="auto-generated-salaries__header">
                <h1>Generated Salaries</h1>
                <div class="searchbar">
                  <span class="material-icons">
                      search
                      </span>
                  <input type="text" placeholder="Search">
                </div>
            </div>
            
            <div class="auto-generated-salaries__content">
                  <table>
                      <thead>
                          <tr>
                              <th>Employee ID</th>
                              <th>Location</th>
                              <th>Starting Date</th>
                              <th>End Date</th>
                              <th>Created</th>
                              <th>Action</th>
                          </tr>
                      </thead>
          
                      <tbody>
                          <!--insert php data for table here inside of php tag-->
                          <?php 
                            $payroll->displayAutomaticGeneratedSalary();
                          ?>
                      </tbody>
                  </table>
            </div>
          </div>
    </div>
</body>
</html>
