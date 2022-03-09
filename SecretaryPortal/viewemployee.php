<?php
require_once('../class.php');
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
    <title>Document</title>
<style>
     * {
    box-sizing: border-box;
        }
table { border: 3px solid gray; border-collapse:collapse; }
table td { border-left: 1px solid #000; }
table td { border-bottom: 1px solid #000; }
table td:first-child { border-left: none; }
table th { border-bottom: 2px solid #000; }
table tr:nth-child(even){ background-color: #f2f2f2 }
.sidebar{
    float: left;
    width: 20%;
    height: 100%;
}
.emppicture{
    position:absolute;
    border: 2px solid black;
    right: 500px;
    top: 120px;

    width: 10%;
    height: 20%;
    padding: 10px 60px;
    margin-top: 7px;
}
.attendance_monitoring{
    position: absolute;
    right: 100px;
    top:0px;
    width: auto;
    border: 1px solid BLACK;
    padding: 100px;
}
@media only screen and (max-width:800px) {
    /* For tablets: */
    .main {
        width: 80%;
        padding: 0;
    }
    .right {
        width: 100%;
    }
    }
    @media only screen and (max-width:500px) {
    /* For mobile phones: */
    .menu, .main, .right {
        width: 100%;
    }
    }
</style>
</head>
<body>

</body>
<div class="main-container">
        <!--SIDENAV START-->
        <div class="sidebar">
            <div class="sidebar__logo">
                <div class="logo"></div>
                <h3>JDTV</h3>
            </div>
            <nav>
                <ul>
                    <li class="li__records active">
                        <a href="secdashboard.php" class="active">ATTENDANCE</a>
                    </li>
                    <li>
                        <a href="employeelist.php" class ="active">EMPLOYEES</a>
                        <ul>
                            <li><a href="employeelist.php">List of Employees</a></li>
                            <li><a href="empschedule.php">Schedules</a></li>
                            <li><a href="deductions.php">Deductions</a></li>
                            <li><a href="violations.php">Violations</a></li>
                        </ul>
                    </li>

                    <li class="li__report" class ="active">
                        <a href="">Payroll</a>
                        <ul>
                            <li><a href="manualpayroll.php">Manual</a></li>
                            <li><a href="automaticpayroll.php">Automatic</a></li>
                        </ul>
                        <a href="">Salary</a>
                        <ul>
                            <li><a href="releasedsalary.php">Released Salary</a></li>
                            <li><a href="salaryreport.php">Salary Report</a></li>
                            <li><a href="contributions.php">Contributions</a></li>
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

        <div class="employee_profile">
            <div class="employee_profile__header">
                <h1>Employee Profile</h1>
                <button class="btn_primary">
                    <span class="material-icons"></span>
                </button>
            </div>

            <div class="card">
                <div class="card__content">
                    <table>
                    <tr><td><h3>&emsp;Name:&emsp;</h3> </td><td>&emsp;Red Jude V. Cadornigara&emsp; </td></tr>
                    <tr><td><h3>&emsp;Email:&emsp;</h3> </td><td>&emsp;Red@gmail.com&emsp; </td></tr>
                    <tr><td><h3>&emsp;Contact:&emsp;</h3> </td><td>&emsp;09195660525&emsp; </td></tr>
                    <tr><td><h3>&emsp;Address:&emsp;</h3> </td><td>&emsp;Gedli&emsp; </td></tr>
                    <tr><td><h3>&emsp;Position:&emsp;</h3> </td><td>&emsp;Security Officer&emsp; </td></tr>
                    <tr><td><h3>&emsp;Schedule:&emsp;</h3> </td><td>&emsp;awdawdawdawdawdawdawd&emsp; </td></tr>
                    <tr><td><h3>&emsp;Company:&emsp;</h3> </td><td>&emsp;MCDO&emsp; </td></tr>
                    <tr><td><h3>&emsp;Attendance:&emsp;</h3> </td><td>&emsp;Security Officer&emsp; </td></tr>

                    </table>
                    <div class="emppicture">
                
                </div>
                </div>
            </div>
        </div>
</div>
</html>
