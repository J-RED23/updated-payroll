<?php
require_once('../secclass.php');
$sessionData = $payroll->getSessionSecretaryData();
$payroll->verifyUserAccess($sessionData['access'], $sessionData['fullname'],2);
$fullname = $sessionData['fullname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Released Salaries</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../seccss/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    
                        <li class="li__report">
                            <a href="#">Payroll</a>
                            <ul>
                                <li><a href="../SecretaryPortal/automaticpayroll.php">Salary</a></li>
                            </ul>
                        </li>

                        <li class="li__activities active">
                            <a href="#" class="active">Salary Report</a>
                            <ul>
                                <li><a href="../SecretaryPortal/releasedsalary.php" class="active">Released Salary</a></li>
                                <li><a href="../SecretaryPortal/salaryreport.php">Salary Chart</a></li>
                                <li><a href="../SecretaryPortal/thirteen.php">13 Month Pay</a></li>
                                <li><a href="../SecretaryPortal/contributions.php" >Contributions</a></li>
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

          <div class="page-info-head">
               Released Salaries
          </div>

        <div class="user-info">
                <a href="editsec.php">[ Edit Account ]</a>
                <p><?php echo $fullname; ?></p>
            <div class="user-profile">
                
            </div>
        </div>

          <div class="employee_list">
              <div class="employee_list__header">
                <h1>List of Released Salaries</h1>
                  <form method="post">
                  <a href="filemodal.php"><button type="button"><i class="fa fa-download"></i>&nbsp;Files</button></a>
                        <button type="submit" name="searchreleased">Search</button>
                        <input type="search" name="salary" placeholder="Search">
                  </form>
              </div>


              <div class="employee_list__content">
                  <table>
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Gross</th>
                                <th>Deduction</th>
                                <th>Netpay</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php 
                        if(isset($_POST['searchreleased']))
                        {
                            $payroll->searchreleasedsalary();
                        }else
                        {
                            $payroll->displayreleasedsalary();
                        }
                        ?>
                        </tbody>
                  </table>
              </div>
          </div>
    </div>
    
</body>
</html>