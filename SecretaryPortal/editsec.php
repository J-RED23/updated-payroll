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
                         <li class="li__report">
                         <a href="../SecretaryPortal/activitylog.php">Activity log</a>
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
            Edit Account
        </div>

        <div class="auto-generated-payroll-attendance">
            <div class="auto-generated-payroll-attendance__header">
                <h1>Secretary Details</h1>
                
            </div>

            <div class="auto-generated-payroll-attendance__content">
                <table>

                    <form method="post">
                    <?php
                    $sql="SELECT * FROM secretary WHERE id = $id;";
                    $stmt = $payroll->con()->prepare($sql);
                    $stmt->execute();
                    $users = $stmt->fetch();
                    echo '<tr>
                        <td><label for="firstname">Firstname:</label></td>
                        <td>'.$users->firstname.'</td>
                        <td><input type="text" name="" id=""></td>
                    </tr>
                    <tr>
                        <td><label for="lastname">Lastname:</label></td>
                        <td>'.$users->lastname.'</td>
                        <td><input type="text" name="lastname" id="lastname"></td>
                    </tr>
                    <tr>
                        <td><label for="contact">Contact:</label></td>
                        <td>'.$users->cpnumber.'</td>
                        <td><input type="text" name="contact" id="contact"></td>
                    </tr>
                    <tr>
                        <td><label for="address">Address:</label></td>
                        <td>'.$users->address.'</td>
                        <td><input type="text" name="address" id="address"></td>
                    </tr>
                    <tr>
                        <td><label for="email">Email:</label></td>
                        <td>'.$users->email.'</td>
                        <td><input type="text" name="email" id="email"></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password:</label></td>
                        <td>TYPE OLD PASSWORD: <input type="text" name="oldpassword" id="password"></td>
                        <td>NEW <input type="text" name="password" id="password"></td>
                    </tr>';
                    ?>
                    </form>
                </table>
            </div>
        </div>
            
          </div>
    </div>
</body>
</html>
