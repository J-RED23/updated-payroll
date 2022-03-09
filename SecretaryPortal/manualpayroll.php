<?php
require_once('../class.php');
$sessionData = $payroll->getSessionSecretaryData();
$payroll->verifyUserAccess($sessionData['access'], $sessionData['fullname'],2);
$fullname = $sessionData['fullname'];
$access = $sessionData['access'];
$id = $sessionData['id'];
$payroll->generateSalary($id,$fullname);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual Payroll - Secretary</title>
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
                            <a href="../SecretaryPortal/employeelist.php" >Employees</a>
                            <ul>
                                <li><a href="../SecretaryPortal/empschedule.php">Schedule</a></li>
                                <li><a href="../SecretaryPortal/deductions.php">Deductions</a></li>
                                <li><a href="../SecretaryPortal/violations.php">Violations</a></li>
                            </ul>
                        </li>
    
                        <li class="li__report active">
                            <a href="#" class="active">Payroll</a>
                            <ul>
                                <li><a href="../SecretaryPortal/manualpayroll.php" class="active">Manual</a></li>
                                <li><a href="../SecretaryPortal/automaticpayroll.php">Automatic</a></li>
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

          <div class="page-info-head">
               Manual Payroll
          </div>

        <div class="user-info">
                <a href="editsec.php">[ Edit Account ]</a>
                <p><?php echo $fullname; ?></p>
            <div class="user-profile">
            </div>
        </div>

          <div class="payroll-detail_header">
              Details
          </div>

          <div class="payroll-details">
                <div class="payroll-details__form">
                    <form action="" method="post">
                        <div class="detail">
                            <label for="">Employee ID :</label><br>
                            <input type="number">
                            <p>Numeric characters only</p>
                        </div>

                        <div class="detail">
                            <label for="">Location :</label><br>
                            <input type="text">
                            <p>Must not be blank</p>
                        </div>

                        <div class="detail">
                            <label for="">Regular Holiday :</label><br>
                            <input type="number">
                            <p>Numeric characters only</p>
                        </div>

                        <div class="detail">
                            <label for="">Special Holiday :</label><br>
                            <input type="number">
                            <p>Numeric characters only</p>
                        </div>

                        <div class="detail">
                            <label for="">3th Month Pay :</label><br>
                            <input type="number">
                            <p>Numeric characters only</p>
                        </div>

                        <div class="detail">
                            <label for="">Rate Hour :</label><br>   
                            <input type="number">
                            <p>Numeric characters only</p>
                        </div>

                        <div class="detail">
                            <label for="">No. of Days work :</label><br>   
                            <input type="number">
                            <p>Numeric characters only</p>
                        </div>
                    </form>
                </div>
          </div>

          <div class="payroll-deductions_header">
              Deductions
          </div>

          <div class="payroll-deductions">
            <div class="payroll-deductions__form">
                <div class="detail">
                    <label for="">No. of late :</label><br>
                    <input type="number">
                    <p>Numeric characters only</p>
                </div>

                <div class="detail">
                    <label for="">SSS :</label><br>
                    <input type="number">
                    <p>Numeric characters only</p>
                </div>

                <div class="detail">
                    <label for="">Pag-ibig :</label><br>
                    <input type="text" class="location">
                    <p>Numeric characters only</p>
                </div>

                <div class="detail">
                    <label for="">PhilHealth :</label><br>
                    <input type="number" class="location">
                    <p>Numeric characters only</p>
                </div>

                <div class="detail">
                    <label for="">Cash Bond :</label><br>
                    <input type="number" class="location">
                    <p>Numeric characters only</p>
                </div>

                <div class="detail">
                    <label for="">Vale :</label><br>
                    <input type="number" class="location">
                    <p>Numeric characters only</p>
                </div>


                <button type="submit" name="generate">
                    <a href="#">Generate</a>
                </button> 
            </div>
          </div>


          <div class="manual-generated-table-header">
                <h1>Generated Salaries</h1>
                <div class="searchbar">
                    <span class="material-icons">
                        search
                        </span>
                    <input type="text" placeholder="Search">
                </div>
           </div>

          <div class="manual-generated-table">
              
              <div class="manual-generated-salaries__content">
                    <table>
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            <?php $payroll->displayGeneratedSalary();?>
                        </tbody>
                    </table>
              </div>
          </div>
     </div>
</body>
</html>