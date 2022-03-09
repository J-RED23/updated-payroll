<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once "../PHPMailer/PHPMailer.php";
require_once "../PHPMailer/SMTP.php";
require_once "../PHPMailer/Exception.php";
Class secpayroll{
    private $username = "root";
    private $password = "";

    private $dns = "mysql:host=localhost;dbname=payroll";
    protected $pdo;
    public function con()
    {
        $this->pdo = new PDO($this->dns, $this->username, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $this->pdo;
    }
    public function getDateTime()
    {
        date_default_timezone_set('Asia/Manila'); // set default timezone to manila
        $curr_date = date("Y/m/d"); // date
        $curr_time = date("h:i:sa"); // time

        // return date and time in array
        $_SESSION['datetime'] = array('time' => $curr_time, 'date' => $curr_date);
        return $_SESSION['datetime'];
    }

    public function login(){
        Session_start();
        if(!isset($_SESSION['secattempts'])){
            $_SESSION['secattempts'] = 5;
        }
        if(!isset($_SESSION['secreservedEmail']) && !isset($_SESSION['secreservedPassword'])){
            $_SESSION['secreservedEmail'] = "";
            $_SESSION['secreservedPassword'] = "";
        }
        
        // if attempts hits 2
        if($_SESSION['secattempts'] == 2){
            echo 'Your credentials has been sent to your email<br/>';
            
            echo 'Reserved Email: '.$_SESSION['secreservedEmail'].'<br/>
                  Reserved Password: '.$_SESSION['secreservedPassword'];
            
            // send user credentials
            $this->sendEmail($_SESSION['secreservedEmail'], $_SESSION['secreservedPassword']);
            echo 'No of attempts: '.$_SESSION['secattempts'];
            $_SESSION['secattempts'] -= 1; // decrease 1 attempt to current attempts

        } else if($_SESSION['secattempts'] == 0){ // if attempts bring down to 0
            
            // select username na gumamit ng 5 attempts
            $reservedEmail = $_SESSION['secreservedEmail'];
            $setTimerSql = "SELECT * FROM secretary WHERE email = ?;";
            $stmtTimer = $this->con()->prepare($setTimerSql);
            $stmtTimer->execute([$reservedEmail]);
            $usersTimer = $stmtTimer->fetch();
            $countRowTimer = $stmtTimer->rowCount();

            // kapag may nadetect na ganong username
            if($countRowTimer > 0){
                // get id of that username
                $userId = $usersTimer->id;
                $userAccess = $usersTimer->access;
                $accessSuspended = "suspended";
                

                // update column timer set value to DATENOW - 6HRS
                
                    $updateTimerSql = "UPDATE `secretary` 
                                    SET `timer` = NOW() + INTERVAL 6 HOUR, 
                                        `access` = '$accessSuspended'
                                    WHERE `id` = $userId;
                    
                                    SET GLOBAL event_scheduler='ON';
                                    CREATE EVENT one_time_event
                                    ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 6 HOUR
                                    ON COMPLETION NOT PRESERVE
                                    DO
                                        UPDATE `secretary` 
                                        SET `timer` = NULL, 
                                            `access` = '$userAccess' 
                                        WHERE `id` = $userId;
                                    ";
                $updateTimerStmt = $this->con()->prepare($updateTimerSql);
                $updateTimerStmt->execute();
                $updateCountRow = $updateTimerStmt->rowCount();

                // checking if the column was updated already
                if($updateCountRow > 0){
                    echo 'Account has been locked for 6 hrs';
                    session_destroy(); // destroy all the sessions
                } else {
                    echo 'There was something wrong in the codes';
                    session_destroy();
                }
            } else {
                echo 'Username does not exists';
                session_destroy();
            }
        } else {
            // if user hit login button
            if(isset($_POST['seclogin'])){
                // get input data
                $username = $_POST['secusername'];
                $password = md5($_POST['secpassword']);
    
                // if username and password are empty
                if(empty($username) && empty($password)){
                    echo 'All input fields are required to login.';
                } else {
                    // check if email is exist using a function
                    $checkEmailArray = $this->checkEmailExist($username); // returns an array(true, cho@gmail.com)
                    $passwordArray = $checkEmailArray[1]; // password ni cho

                    // kapag ang unang array ay nag true
                    if($checkEmailArray[0]){

                        $suspendedAccess = 'suspended';
                        

                        // find account that matches the username and password
                        $sql = "SELECT * FROM secretary WHERE email = ? AND password = ?";
                        $stmt = $this->con()->prepare($sql);
                        $stmt->execute([$username, $password]);
                        $users = $stmt->fetch();
                        $countRow = $stmt->rowCount();
        
                        // if account exists
                        if($countRow > 0){

                            if($users->access != $suspendedAccess){
                                $id = $users->id;
                                $fullname = $users->fullname; // create fullname
                                $action = "login"; 
                                    
                                // set timezone and get date and time
                                $datetime = $this->getDateTime(); 
                                $time = $datetime['time'];
                                $date = $datetime['date'];
                
                                // insert mo sa activity log ni admin
                                $actLogSql = "INSERT INTO secretary_log(`sec_id`,`name`, 
                                                                    `action`,
                                                                    `time`,
                                                                    `date`
                                                                    )
                                            VALUES(?,?, ?, ?, ?)";
                                $actLogStmt = $this->con()->prepare($actLogSql);
                                $actLogStmt->execute([$id,$fullname, $action, $time, $date]);
                
                                // create user details using session
                                session_start();
                                $_SESSION['secDetails'] = array('fullname' => $fullname,
                                                'access' => $users->access,
                                                'id' => $users->id
                                                );
                                header('Location: secdashboard.php'); // redirect to dashboard.php
                                return $_SESSION['secDetails']; // after calling the function, return session
                            } else {
                                $dateExpiredArray = $this->formatDateLocked($users->timer);
                                $dateExpired = implode(" ", $dateExpiredArray);
                                
                                echo 'Your account has been locked until</br>'.
                                     'Date: '.$dateExpired;
                            } 
                        } else {

                            $sqlCheckAccess = "SELECT * FROM secretary WHERE email = ?";
                            $stmtCheckAccess = $this->con()->prepare($sqlCheckAccess);
                            $stmtCheckAccess->execute([$username]);
                            $usersCheckAccess = $stmtCheckAccess->fetch();
                            $countCheckAccess = $stmtCheckAccess->rowCount();

                            if($countCheckAccess > 0){
                                if($usersCheckAccess->access == $suspendedAccess){
                                    
                                    $dateExpiredArray2 = $this->formatDateLocked($usersCheckAccess->timer);
                                    $dateExpired2 = implode(" ", $dateExpiredArray2);
                                    
                                    echo 'Your account has been locked until</br>'.
                                        'Date: '.$dateExpired2;
                                } else {
                                    echo "Username and password are not matched <br/>";
                                    echo 'No of attempts: '.$_SESSION['secattempts'];
                                    $_SESSION['secattempts'] -= 1; // decrease 1 attempt to current attempts
                                    $_SESSION['secreservedEmail'] = $username; // blank to kanina, nagkaron na ng laman
                                    $_SESSION['secreservedPassword'] = $passwordArray; // blank to kanina, nagkaron na ng laman
                                }
                            }
                        }
                    } else {
                        echo 'Your email is not exist in our system';
                        session_destroy();
                    }
                }
            }
        }
        
    }
    public function sendEmail($email, $password)
    {
        
        $name = 'JTDV Incorporation';
        $subject = 'subject kunwari';
        $body = "Credentials
                 Your username: $email <br/>
                 Your password: $password
                ";

        if(!empty($email)){

            $mail = new PHPMailer();

            // smtp settings
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "DammiDoe123@gmail.com";  // gmail address
            $mail->Password = "DammiDoe123123";         // gmail password
            $mail->Port = 465;
            $mail->SMTPSecure = "ssl";

            // email settings
            $mail->isHTML(true);
            $mail->setFrom($email, $name);              // Katabi ng user image
            $mail->addAddress($email);                  // gmail address ng pagsesendan
            $mail->Subject = ("$email ($subject)");     // headline
            $mail->Body = $body;                        // textarea

            if($mail->send()){
                $status = "success";
                $response = "Email is sent!";
                echo '<br/>'.$status."<br/>".$response;
            } else {
                $status = "failed";
                $response = "Something is wrong: <br/>". $mail->ErrorInfo;
                echo '<br/>'.$status."<br/>".$response;
            }
        } 
    }
    public function checkEmailExist($email)
    {
        // find email exist in the database
        $sql = "SELECT * FROM secretary WHERE email = ?";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$email]);
        $users = $stmt->fetch();
        $countRow = $stmt->rowCount();

        // kapag may nadetect
        if($countRow > 0){
            return array(true, $users->password); // yung kaakibat na password, return mo
        } else {
            return array(false, ''); // pag walang nakita, return false and null
        }
    }
    public function formatDateLocked($date)
    {
        $dateArray = explode(" ", $date);

        $dateExpired = date("F j Y", strtotime($dateArray[0])); // date
        $timeExpired = date("h:i:s A", strtotime($dateArray[1])); // time
        return array($dateExpired, $timeExpired);
    }
public function displayAttendance()
{
        $sql ="SELECT employee_info.emp_id, employee_info.firstname, employee_info.lastname, 
                        emp_attendance.company, emp_attendance.timein, emp_attendance.date_timein,
                        emp_attendance.timeout, emp_attendance.date_timeout,
                        emp_attendance.status
        FROM employee_info
        INNER JOIN emp_attendance ON employee_info.emp_id = emp_attendance.emp_id
        ORDER BY emp_attendance.timein ASC;";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            while($row = $stmt->fetch()){
            echo "<tr>
            <td>$row->emp_id</td>
            <td>$row->firstname</td>
            <td>$row->lastname</td>
            <td>$row->company</td>
            <td>$row->timein</td>
            <td>$row->date_timein</td>
            <td>$row->timeout</td>
            <td>$row->date_timeout</td>
            <td>$row->status</td>
            <tr/>";   
            }
    }
    public function displayGeneratedSalary()
    {
        $sql ="SELECT log, emp_id, location, date
        FROM generated_salary ORDER BY date ASC;";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            while($row = $stmt->fetch()){
            echo "<tr>
            <td>$row->emp_id</td>
            <td>$row->location</td>
            <td>$row->date</td>
            <td><a href='viewsalary.php?logid=$row->log'>View </a><a href='updatesalary.php?logid=$row->log'>Update  </a><a href='deletesalary.php?logid=$row->log'>Delete </a></td>
            <tr/>";
            $this->deleteSalary($row->log);
            }
    }
    public function deleteSalary($logid)
    {
        if(isset($_POST['delete'])){
        $sessionData = $this->getSessionData();
        $fullname = $sessionData['fullname'];
        $secid = $sessionData['id'];
        $datetime = $this->getDateTime();
        $time = $datetime['time'];
        $date = $datetime['date'];
        $empid=$logid;
        $sql= "DELETE FROM generated_salary WHERE log = ?;";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$empid]);
        $countrow = $stmt->rowCount();
        if($countrow > 0) {
            $action = "Delete Salary";
            $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                VALUES(?, ?, ?, ?, ?)";
            $stmtSecLog = $this->con()->prepare($sqlSecLog);
            $stmtSecLog->execute([$secid,$fullname, $action, $time, $date]);
            $countRowSecLog = $stmtSecLog->rowCount();
                if($countRowSecLog > 0){
                    echo 'pumasok na sa act log';
                    header('location:manualpayroll.php');
                } else {
                    echo 'di pumasok sa act log';
                    header('location:manualpayroll.php');
                }
            } else {
                echo 'Error in deleting salary!';
            }
        }
        else if(isset($_POST['cancel'])){
            header('location: manualpayroll.php');
        }else{
        }

    }
    public function search()
    {
        if(isset($_POST['bsearch']))
            $search = strtolower($_POST['search']);
    
            if(!empty($search)){
                $sql ="SELECT employee_info.emp_id, employee_info.firstname, employee_info.lastname, 
                emp_attendance.company, emp_attendance.timein, emp_attendance.date_timein, 
                emp_attendance.timeout, emp_attendance.date_timeout,
                emp_attendance.status
    FROM employee_info
    INNER JOIN emp_attendance ON employee_info.emp_id = emp_attendance.emp_id;";
    $found=false;
                $stmt = $this->con()->prepare($sql);
                $stmt->execute();
                $users = $stmt->fetchAll();
                $countRow = $stmt->rowCount();
                foreach($users as $user){
                $lfirstname = strtolower($user->firstname);
                $llastname = strtolower($user->lastname);
                $lcompany = strtolower($user->company);
                $lstatus = strtolower($user->status);
                if(preg_match("/{$search}/i", $lfirstname) || preg_match("/{$search}/i", $llastname) || preg_match("/{$search}/i", $lcompany) || preg_match("/{$search}/i", $lstatus) || preg_match("/{$search}/i", $user->timein) || preg_match("/{$search}/i", $user->date_timein) || preg_match("/{$search}/i", $user->timeout) ||preg_match("/{$search}/i", $user->date_timeout)){
                    echo "<tr>
                    <td>$user->emp_id</td>
                    <td>$user->firstname</td>
                    <td>$user->lastname</td>
                    <td>$user->company</td>
                    <td>$user->timein</td>
                    <td>$user->date_timein</td>
                    <td>$user->timeout</td>
                    <td>$user->date_timeout</td>
                    <td>$user->status</td>
                                <tr/>";
                    $found=true;
                }
                }
                if($found!==true){
                    echo"No Record Found!";
                    $this->displayAttendance();
                }
                }else{
                echo "Please Input Fields!";
                $this->displayAttendance();
                }
    }
    public function generateSalary($id,$fullname)
    {
        if(isset($_POST['generate']))
        {
            if( isset($_POST['empid']) &&
            isset($_POST['rate']) &&
            isset($_POST['hrsduty']) &&
            isset($_POST['location']) &&
            isset($_POST['noofdayswork']) &&
            isset($_POST['regholiday']) &&
            isset($_POST['daylate']) &&
            isset($_POST['minlate']) &&
            isset($_POST['dayabsent']) &&
            isset($_POST['sss']) &&
            isset($_POST['cashbond']) &&
            isset($_POST['specialholiday']) &&
            isset($_POST['thirteenmonth']) &&
            isset($_POST['cvale']))
            {
                if( empty($_POST['rate']) &&
                    empty($_POST['rate'])
                ) {
                    echo "All inputs are required";
                }else{
                $empid=$_POST['empid'];
                $rate=(int)$_POST['rate'];
                $hrsduty=(int)$_POST['hrsduty'];
                $location = $_POST['location'];
                $noofdayswork = (int)$_POST['noofdayswork'];
                $regholiday = $_POST['regholiday'];
                $daylate=$_POST['daylate'];
                $minlate=$_POST['minlate'];
                $dayabsent=$_POST['dayabsent'];
                $sss=$_POST['sss'];
                $cashbond=$_POST['cashbond'];
                $specialholiday=$_POST['specialholiday'];
                $thirteenmonth=$_POST['thirteenmonth'];
                $netpay="";
                $vale=$_POST['cvale'];
                $totaldaysalary = $hrsduty * $rate ; // sahod sa isang araw depende sa duty at rate

                $totalregholidayhour = $hrsduty * (float)$regholiday; 
                $totalregholidayhoursalary = $totalregholidayhour * $rate;
                $totalregholidaysalary = $totalregholidayhoursalary * 2;                        // sahod pag regular holiday

                $specialholidayhour = $hrsduty * (float)$specialholiday;
                $totalspecialholidayhoursalary = $specialholidayhour * $rate;
                $totalspecialholidayhoursalarypercent = $totalspecialholidayhoursalary * 0.03;
                $totalspecialholidaysalary = $totalspecialholidayhoursalarypercent + $totalspecialholidayhoursalary;
                
                $totalhrs = $hrsduty * $noofdayswork; // oras ng trabaho
                $totalsalaryfortotalhours = $totalhrs * $rate;  // sahod sa oras nang tinrabaho

                $totalholidaysalary = (float)$totalregholidaysalary + (float)$totalspecialholidaysalary;
                $totg = (float)$totalholidaysalary + (float)$thirteenmonth;
                $totalgross = (float)$totalsalaryfortotalhours + (float)$totg;

                $totalhourfordayabsent = (int)$dayabsent * $hrsduty; // total hours ng absent
                $totaldaysalaryfordayabsent = $totalhourfordayabsent * $rate; //sahod absent

                $totalsalaryforlate = (float)$minlate * 0.992;
                $totaldeduction = (float)$vale + (float)$cashbond + (float)$sss + (float)$totaldaysalaryfordayabsent + (float)$totalsalaryforlate;

                $netpay = $totalgross - $totaldeduction;
            // set timezone and get date and time
            $datetime = $this->getDateTime();
            $time = $datetime['time'];
            $date = $datetime['date']; 
            $sql = "INSERT INTO generated_salary (emp_id,
                                            location,
                                            rate_hour,
                                            date,
                                            hours_duty,
                                            regular_holiday,
                                            special_holiday,
                                            day_late,
                                            min_late,
                                            day_absent,
                                            hours_absent,
                                            no_of_work,
                                            sss,
                                            cashbond,
                                            vale,
                                            thirteenmonth,
                                            total_hours,
                                            regular_pay,
                                            regular_holiday_pay,
                                            special_holiday_pay,
                                            absent_pay,
                                            total_deduction,
                                            total_gross,
                                            total_netpay,
                                            dateandtime_created
                                            )
                    VALUES(?, ?, ?, ?,?, ?, ?, ?,?, ?,?, ?, ?,?,?,?,?,?,? ,?,?, ?, ?, ?,?);";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute([$empid, $location, $rate, $date, $hrsduty,$regholiday, $specialholiday, $daylate, $minlate, $dayabsent, $totalhourfordayabsent, $noofdayswork, $sss, $cashbond, $vale, $thirteenmonth,$totalhrs, $totalsalaryfortotalhours, $totalregholidaysalary, $totalspecialholidaysalary, $totaldaysalaryfordayabsent, $totaldeduction,$totalgross,$netpay, $time]);
            $users = $stmt->fetch();
            $countRow = $stmt->rowCount();

            if($countRow > 0){
                echo 'Added';

                $action = "Add Salary";

                $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                VALUES(?, ?, ?, ?, ?)";
                $stmtSecLog = $this->con()->prepare($sqlSecLog);
                $stmtSecLog->execute([$id,$fullname, $action, $time, $date]);
                $countRowSecLog = $stmtSecLog->rowCount();

                if($countRowSecLog > 0){
                    echo 'pumasok na sa act log';
                } else {
                    echo 'di pumasok sa act log';
                }

            } else {
                echo 'Error in adding salary!';
            }
        }
            } else {
            echo "All inputs are required!";
            
        }

    }
    }
    public function showSpecificSalary()
    {
        if(isset($_GET['empid'])){
            $id = $_GET['empid'];
            $sql = "SELECT * FROM generated_salary WHERE emp_id = ?";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute([$id]);
            $user = $stmt->fetch();
            $countRow = $stmt->rowCount();

            if($countRow > 0){
                $empid = $user->emp_id;
                $location = $user->location;
                $date = $user->date;
                $late = $user->day_late; 
                $absent = $user->day_absent;
                $noofdayswork = $user->no_of_work; 
                $sss= $user->sss;
                $cashbond = $user->cashbond;
                $vale = $user->vale;
                $thirteenmonth = $user->thirteenmonth;
                $gross = $user->total_gross;
                $netpay = $user->total_netpay;
                $time = $user->dateandtime_created;
                echo"location ".$location;
            }
        }
    }
    
public function getSessionData()

    {
        session_start();
        if($_SESSION['secDetails']){
            return $_SESSION['secDetails'];
        }
    }

    public function verifyUserAccess($access, $fullname)
    {
        $message = 'You are not allowed to enter the system';
        if($access == 'user'){
            header("Location: loginsecretary.php?message=$message");
        } else if($access == 'secretary'){
            echo 'Welcome '.$fullname;
        } else {
            header("Location: loginsecretary.php?message=$message");
        }
    }
        public function updateSalary($id,$fullname){
        if(isset($_POST['edit']))
        {
            if( isset($_POST['empid']) &&
            isset($_POST['rate']) &&
            isset($_POST['hrsduty']) &&
            isset($_POST['location']) &&
            isset($_POST['noofdayswork']) &&
            isset($_POST['regholiday']) &&
            isset($_POST['daylate']) &&
            isset($_POST['minlate']) &&
            isset($_POST['dayabsent']) &&
            isset($_POST['sss']) &&
            isset($_POST['cashbond']) &&
            isset($_POST['specialholiday']) &&
            isset($_POST['thirteenmonth']) &&
            isset($_POST['cvale']))
            {
                $empid=$_POST['empid'];
                $rate=(int)$_POST['rate'];
                $hrsduty=(int)$_POST['hrsduty'];
                $location = $_POST['location'];
                $noofdayswork = (int)$_POST['noofdayswork'];
                $regholiday = $_POST['regholiday'];
                $daylate=$_POST['daylate'];
                $minlate=$_POST['minlate'];
                $dayabsent=$_POST['dayabsent'];
                $sss=$_POST['sss'];
                $cashbond=$_POST['cashbond'];
                $specialholiday=$_POST['specialholiday'];
                $thirteenmonth=$_POST['thirteenmonth'];
                $netpay="";
                $vale=$_POST['cvale'];
                $logid=$_GET['logid'];
                $totaldaysalary = $hrsduty * $rate ; // sahod sa isang araw depende sa duty at rate

                $totalregholidayhour = $hrsduty * $regholiday; 
                $totalregholidayhoursalary = $totalregholidayhour * $rate;
                $totalregholidaysalary = $totalregholidayhoursalary * 2;                        // sahod pag regular holiday

                $specialholidayhour = $hrsduty * $specialholiday;
                $totalspecialholidayhoursalary = $specialholidayhour * $rate;
                $totalspecialholidayhoursalarypercent = $totalspecialholidayhoursalary * 0.03;
                $totalspecialholidaysalary = $totalspecialholidayhoursalarypercent + $totalspecialholidayhoursalary;
                
                $totalhrs = $hrsduty * $noofdayswork; // oras ng trabaho
                $totalsalaryfortotalhours = $totalhrs * $rate;  // sahod sa oras nang tinrabaho

                $totalholidaysalary = $totalregholidaysalary + $totalspecialholidaysalary;
                $totg = $totalholidaysalary + $thirteenmonth;
                $totalgross = $totalsalaryfortotalhours + $totg;

                $totalhourfordayabsent = $dayabsent * $hrsduty; // total hours ng absent
                $totaldaysalaryfordayabsent = $totalhourfordayabsent * $rate; //sahod absent

                $totalsalaryforlate = $minlate * 0.992;
                $totaldeduction = $vale + $cashbond + $sss + $totaldaysalaryfordayabsent + $totalsalaryforlate;

                $netpay = $totalgross - $totaldeduction;
            // else if (!empty($empid) &&
            // !empty($location)&&
            // !empty($noofdayswork) &&
            // !empty($cashbond) &&
            // !empty($hrsduty) &&
            // !empty($sss) &&
            // !empty($rate) &&
            // !empty($vale) &&
            // !empty($daylate) &&
            // !empty($hrslate) &&
            // !empty($dayabsent) &&
            // !empty($hrsabsent) &&
            // !empty($thirteenmonth)
            // ){
            // set timezone and get date and time
            $datetime = $this->getDateTime();
            $time = $datetime['time'];
            $date = $datetime['date']; 
        $sql = "UPDATE generated_salary SET emp_id = ?,
        location = ?,
        rate_hour = ?,
        date = ?,
        hours_duty = ?,
        regular_holiday = ?,
        special_holiday = ?,
        day_late = ?,
        min_late = ?,
        day_absent = ?,
        hours_absent = ?,
        no_of_work = ?,
        sss = ?,
        cashbond = ?,
        vale = ?,
        thirteenmonth = ?,
        total_hours = ?,
        regular_pay = ?,
        regular_holiday_pay = ?,
        special_holiday_pay = ?,
        absent_pay = ?,
        total_deduction = ?,
        total_gross = ?,
        total_netpay = ?,
        dateandtime_created = ?
        WHERE log = $logid;";
$stmt = $this->con()->prepare($sql);
$stmt->execute([$empid, $location, $rate, $date,$hrsduty,$regholiday,$specialholiday,$daylate, $minlate, $dayabsent,$totalhourfordayabsent, $noofdayswork, $sss, $cashbond, $vale, $thirteenmonth ,$totalhrs ,$totalsalaryfortotalhours,$totalregholidaysalary,$totalspecialholidaysalary,$totaldaysalaryfordayabsent,$totaldeduction,$totalgross,$netpay ,$time]);
$users = $stmt->fetch();
$countRow = $stmt->rowCount();

if($countRow > 0){
    echo 'Updated';

    $action = "Edit Salary";

    $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                    VALUES(?, ?, ?, ?, ?)";
    $stmtSecLog = $this->con()->prepare($sqlSecLog);
    $stmtSecLog->execute([$id,$fullname, $action, $time, $date]);
    $countRowSecLog = $stmtSecLog->rowCount();

    if($countRowSecLog > 0){
        echo 'pumasok na sa act log';
        header('location: manualpayroll.php');
    } else {
        echo 'di pumasok sa act log';
    }

} else {
    echo 'Error in updating salary!';
}
}else {
echo "All inputs are required!";
}

}


    }
}
$secpayroll = new secpayroll;

?>