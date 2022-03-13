<?php
// required to para makapag send ng email
use PHPMailer\PHPMailer\PHPMailer;
use Dompdf\Dompdf;
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

require 'vendor/autoload.php';

Class Payroll
{
    private $username = "root";
    private $password = "";

    private $dns = "mysql:host=localhost;dbname=newpayroll";
    protected $pdo;


    public function con()
    {
        $this->pdo = new PDO($this->dns, $this->username, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $this->pdo;
    }


    // used to set timezone and get date and time
    public function getDateTime()
    {
        date_default_timezone_set('Asia/Manila'); // set default timezone to manila
        $curr_date = date("Y/m/d"); // date
        $curr_time = date("h:i:s A"); // time

        // return date and time in array
        $_SESSION['datetime'] = array('time' => $curr_time, 'date' => $curr_date);
        return $_SESSION['datetime'];
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
            $mail->Username =  "sicnarfarerreh@gmail.com";  // gmail address
            $mail->Password = "sicnarf123";  // gmail password

            $mail->Port = 587;
            $mail->SMTPSecure = "tls";
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // email settings
            $mail->isHTML(true);
            $mail->setFrom($email, $name);              // Katabi ng user image
            $mail->addAddress($email);                  // gmail address ng pagsesendan
            $mail->Subject = ("$email ($subject)");     // headline
            $mail->Body = $body;                        // textarea

            if($mail->send()){
                // $status = "success";
                $response = "Your credentials has been sent to your email";
                echo '<br/>'.$response;
            } else {
                $status = "failed";
                $response = "Something is wrong: <br/>". $mail->ErrorInfo;
                echo '<br/>'.$status."<br/>".$response;
            }
        } 
    }


    public function login()
    {
        // set 5 attempts
        session_start();
        if(!isset($_SESSION['attempts'])){
            $_SESSION['attempts'] = 5;
        }

        // create email and password using session
        if(!isset($_SESSION['reservedEmail']) && !isset($_SESSION['reservedPassword'])){
            $_SESSION['reservedEmail'] = "";
            $_SESSION['reservedPassword'] = "";
        }


        // if attempts hits 2
        if($_SESSION['attempts'] == 2){
            echo 'Your credentials has been sent to your email<br/>';
            
            echo 'Reserved Email: '.$_SESSION['reservedEmail'].'<br/>
                  Reserved Password: '.$_SESSION['reservedPassword'];
            
            // send user credentials
            $this->sendEmail($_SESSION['reservedEmail'], $_SESSION['reservedPassword']);
            // echo 'No of attempts: '.$_SESSION['attempts'];
            $_SESSION['attempts'] -= 1; // decrease 1 attempt to current attempts

        } else if($_SESSION['attempts'] == 0){ // if attempts bring down to 0
            
            // select username na gumamit ng 5 attempts
            $reservedEmail = $_SESSION['reservedEmail'];
            $setTimerSql = "SELECT * FROM super_admin WHERE username = ?";
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
                
                $updateTimerSql = "UPDATE `super_admin` 
                                   SET `timer` = NOW() + INTERVAL 6 HOUR, 
                                       `access` = '$accessSuspended'
                                   WHERE `id` = $userId;
                
                                   SET GLOBAL event_scheduler='ON';
                                   CREATE EVENT one_time_event
                                   ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 6 HOUR
                                   ON COMPLETION NOT PRESERVE
                                   DO
                                      UPDATE `super_admin` 
                                      SET `timer` = NULL, 
                                          `access` = '$userAccess' 
                                      WHERE `id` = $userId;
                                  ";
                $updateTimerStmt = $this->con()->prepare($updateTimerSql);
                $updateTimerStmt->execute();
                $updateCountRow = $updateTimerStmt->rowCount();

                // checking if the column was updated already
                if($updateCountRow > 0){
                    echo 'System has been locked for 6 hrs';
                    session_destroy(); // destroy all the sessions
                } else {
                    echo 'There was something wrong in the codes';
                    session_destroy();
                }
            } else {
                $_SESSION['message'] = 'Username does not exist';
            }

        } else {
            // if user hit login button
            if(isset($_POST['login'])){

                // get input data
                $username = $_POST['username'];
                $password = md5($_POST['password']);
    
                // if username and password are empty
                if(empty($username) && empty($password)){
                    $_SESSION['message'] = 'All input fields are required to login.';
                } else {
                    // check if email is exist using a function
                    $checkEmailArray = $this->checkEmailExist($username); // returns an array(true, cho@gmail.com)
                    $passwordArray = $checkEmailArray[1]; // password ni cho

                    // kapag ang unang array ay nag true
                    if($checkEmailArray[0]){

                        $suspendedAccess = 'suspended';
                        

                        // find account that matches the username and password
                        $sql = "SELECT * FROM super_admin WHERE username = ? AND password = ?";
                        $stmt = $this->con()->prepare($sql);
                        $stmt->execute([$username, $password]);
                        $users = $stmt->fetch();
                        $countRow = $stmt->rowCount();
        
                        // if account exists
                        if($countRow > 0){

                            if($users->access != $suspendedAccess){
                                $fullname = $users->firstname." ".$users->lastname; // create fullname
                                $action = "login"; 
                                    
                                // set timezone and get date and time
                                $datetime = $this->getDateTime(); 
                                $time = $datetime['time'];
                                $date = $datetime['date'];
                
                                // insert mo sa activity log ni admin
                                $actLogSql = "INSERT INTO admin_log(`name`, 
                                                                    `action`,
                                                                    `time`,
                                                                    `date`
                                                                    )
                                            VALUES(?, ?, ?, ?)";
                                $actLogStmt = $this->con()->prepare($actLogSql);
                                $actLogStmt->execute([$fullname, $action, $time, $date]);
                
                                // create user details using session
                                session_start();
                                $_SESSION['adminDetails'] = array('fullname' => $fullname,
                                                                  'access' => $users->access,
                                                                  'id' => $users->id
                                                                  );
                                header('Location: dashboard.php'); // redirect to dashboard.php
                                return $_SESSION['adminDetails']; // after calling the function, return session
                            } else {
                                $dateExpiredArray = $this->formatDateLocked($users->timer);
                                $dateExpired = implode(" ", $dateExpiredArray);
                                
                                echo 'Your account has been locked until</br>'.
                                     'Date: '.$dateExpired;
                            } 
                        } else {

                            $sqlCheckAccess = "SELECT * FROM super_admin WHERE username = ?";
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
                                    $_SESSION['message'] = "Username and password are not matched <br/>";
                                    // echo 'No of attempts: '.$_SESSION['attempts'];
                                    $_SESSION['attempts'] -= 1; // decrease 1 attempt to current attempts
                                    $_SESSION['reservedEmail'] = $username; // blank to kanina, nagkaron na ng laman
                                    $_SESSION['reservedPassword'] = $passwordArray; // blank to kanina, nagkaron na ng laman
                                }
                            }
                        }
                    } else {
                        // echo 'Your email is not exist in our system';
                        
                        // check if email is exist using a function
                            $checkEmailArray = $this->checkEmailExistEmployee($username); // returns an array(true, cho@gmail.com)
                            $passwordArray = $checkEmailArray[1]; // password ni cho

                            // kapag ang unang array ay nag true
                            if($checkEmailArray[0]) {

                                $suspendedAccess = 'suspended';
                                $position = 'Officer in Chief';
                                

                                // find account that matches the username and password
                                $sql = "SELECT * FROM emp_info WHERE email = ? AND password = ? AND position = ?";
                                $stmt = $this->con()->prepare($sql);
                                $stmt->execute([$username, $password, $position]);
                                $users = $stmt->fetch();
                                $countRow = $stmt->rowCount();
                
                                // if account exists
                                if($countRow > 0){

                                    if($users->access != $suspendedAccess){
                                        $fullname = $users->firstname ." ". $users->lastname; // create fullname
                                        // $action = "login"; 
                                            
                                        // // set timezone and get date and time
                                        // $datetime = $this->getDateTime(); 
                                        // $time = $datetime['time'];
                                        // $date = $datetime['date'];
                        
                                        // // insert mo sa activity log ni admin
                                        // $actLogSql = "INSERT INTO admin_log(`name`, 
                                        //                                     `action`,
                                        //                                     `time`,
                                        //                                     `date`
                                        //                                     )
                                        //             VALUES(?, ?, ?, ?)";
                                        // $actLogStmt = $this->con()->prepare($actLogSql);
                                        // $actLogStmt->execute([$fullname, $action, $time, $date]);
                        
                                        // // create user details using session
                                        session_start();
                                        $_SESSION['OICDetails'] = array('fullname' => $fullname,
                                                                          'access' => $users->access,
                                                                          'position' => $users->position,
                                                                          'id' => $users->id,
                                                                          'empId' => $users->empId,
                                                                          'scheduleTimeIn' => $users->scheduleTimeIn,
                                                                          'scheduleTimeOut' => $users->scheduleTimeOut,
                                                                          'datetimeIn' => $users->datetimeIn
                                                                          );
                                        header('Location: employee/OIC.php'); // redirect to dashboard.php
                                        return $_SESSION['OICDetails']; // after calling the function, return session
                                    } else {
                                        $dateExpiredArray = $this->formatDateLocked($users->timer);
                                        $dateExpired = implode(" ", $dateExpiredArray);
                                        
                                        echo 'Your account has been locked until</br>'.
                                            'Date: '.$dateExpired;
                                    } 
                                } else {

                                    $sqlCheckAccess = "SELECT * FROM emp_info WHERE email = ?";
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
                                            $_SESSION['message'] = "Username and password are not matched <br/>";
                                            // echo 'No of attempts: '.$_SESSION['attempts'];
                                            $_SESSION['attempts'] -= 1; // decrease 1 attempt to current attempts
                                            $_SESSION['reservedEmail'] = $username; // blank to kanina, nagkaron na ng laman
                                            $_SESSION['reservedPassword'] = $passwordArray; // blank to kanina, nagkaron na ng laman
                                        }
                                    }
                                }
                    } else {
                        // echo 'Your email is not exist in our system';
                        
                        // check if email is exist using a function
                        $checkEmailArray = $this->checkEmailExistSecretary($username); // returns an array(true, cho@gmail.com)
                        $passwordArray = $checkEmailArray[1]; // password ni cho

                        // kapag ang unang array ay nag true
                        if($checkEmailArray[0]) {

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
                                    $fullname = $users->firstname ." ". $users->lastname; // create fullname
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
                                                VALUES(?, ?, ?, ?, ?)";
                                    $actLogStmt = $this->con()->prepare($actLogSql);
                                    $actLogStmt->execute([$id,$fullname, $action, $time, $date]);
                    
                                    // // create user details using session
                                    session_start();
                                    $_SESSION['SecretaryDetails'] = array('fullname' => $fullname,
                                                                        'access' => $users->access,
                                                                        'position' => $users->position,
                                                                        'id' => $users->id,
                                                                        'empId' => $users->empId,
                                                                        'scheduleTimeIn' => $users->scheduleTimeIn,
                                                                        'scheduleTimeOut' => $users->scheduleTimeOut,
                                                                        'datetimeIn' => $users->datetimeIn
                                                                        );
                                    header('Location: SecretaryPortal/secdashboard.php'); // redirect to dashboard.php
                                    return $_SESSION['SecretaryDetails']; // after calling the function, return session
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
                                        $_SESSION['message'] = "Username and password are not matched <br/>";
                                        // echo 'No of attempts: '.$_SESSION['attempts'];
                                        $_SESSION['attempts'] -= 1; // decrease 1 attempt to current attempts
                                        $_SESSION['reservedEmail'] = $username; // blank to kanina, nagkaron na ng laman
                                        $_SESSION['reservedPassword'] = $passwordArray; // blank to kanina, nagkaron na ng laman
                                    }
                                }
                            }
                        } else {
                            $_SESSION['message'] = 'Your email does not exist in our system';
                        }
                    }//eto
                }
            }
        }
        }
    }


    
    public function formatDateLocked($date)
    {
        $dateArray = explode(" ", $date);

        $dateExpired = date("F j Y", strtotime($dateArray[0])); // date
        $timeExpired = date("h:i:s A", strtotime($dateArray[1])); // time
        return array($dateExpired, $timeExpired);
    }
    

    public function checkAccountTimer($id)
    {
        $sql = "SELECT * FROM super_admin WHERE id = ?";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$id]);
        $users = $stmt->fetch();
        $countRow = $stmt->rowCount();

        if($countRow > 0){
            if($users->timer != NULL){
                return true;
            } else {
                return false;
            }
        }

    }


    public function checkEmailExist($email)
    {
        // find email exist in the database
        $sql = "SELECT * FROM super_admin WHERE username = ?";
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

    
    public function checkEmailExistEmployee($email)
    {
        // find email exist in the database
        $sql = "SELECT * FROM emp_info WHERE email = ?";
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

    public function checkEmailExistSecretary($email)
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
    public function logout()
    {   
        session_start();
        session_destroy();
        $this->pdo = null;
        header('Location: login.php');
    }

    // get login session
    public function getSessionData()
    {
        session_start();
        if($_SESSION['adminDetails']){
            return $_SESSION['adminDetails'];
        }

    }
        // get login session: Secretary
    public function getSessionSecretaryData()
    {
        session_start();
        if($_SESSION['SecretaryDetails']){
            return $_SESSION['SecretaryDetails'];
        }
    }

    public function verifyUserAccess($access, $fullname, $level)
    {
        $message = 'You are not allowed to enter the system';
        if($level == 2){
            $level = '../';
            
            if($access == 'super administrator'){
                return;
            } elseif($access == 'secretary'){
            } else {
                header("Location: ".$level."login.php?message=$message");
            }
        } else {
            if($access == 'super administrator'){
                return;
            } elseif($access == 'secretary'){
                // red
            } else {
                header("Location: login.php?message=$message");
            }
        }
    }

    public function generatedPassword($fullname)
    {
        $keyword = "%15@!#Fa4%#@kE";
        $generatedPassword = md5($fullname.$keyword);
        return array($generatedPassword, $fullname.$keyword);
    }

    // for secretary table only
    public function checkSecEmailExist($email)
    {
        // find email exist in the database
        $sql = "SELECT * FROM secretary WHERE email = ?";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$email]);
        $users = $stmt->fetch();
        $countRow = $stmt->rowCount();

        // kapag may nadetect
        if($countRow > 0){
            return true; 
        } else {
            return false; 
        }
    }

    // ========================================= RED'S PROPERTY ==============================================

    public function displayAttendance()
    {
            $sql ="SELECT employee.empId, employee.firstname, employee.lastname,emp_attendance.company, emp_attendance.timeIn, emp_attendance.datetimeIn,
            emp_attendance.timeOut, emp_attendance.datetimeOut,
            emp_attendance.status, emp_attendance.id
            FROM employee
            INNER JOIN emp_attendance ON employee.empId = emp_attendance.empId WHERE emp_attendance.salary_status != 'paid'
            ORDER BY emp_attendance.datetimeIn DESC;";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            while($row = $stmt->fetch()){
            echo "<tr>
            <td>&nbsp;$row->empId&nbsp;</td>
            <td>&nbsp;$row->firstname&nbsp;</td>
            <td>&nbsp;$row->lastname&nbsp;</td>
            <td>&nbsp;$row->company&nbsp;</td>
            <td>&nbsp;$row->timeIn&nbsp;</td>
            <td>&nbsp;",date('F j, Y', strtotime($row->datetimeIn)),"&nbsp;</td>
            <td>&nbsp;$row->timeOut&nbsp;</td>
            <td>&nbsp;",date('F j, Y', strtotime($row->datetimeOut)),"&nbsp;</td>
            <td>&nbsp;$row->status&nbsp;</td>
            </tr>";   
                                        }
    }
    public function displayGeneratedSalary()
    {
        $sql ="SELECT log, generated_salary.emp_id, employee.firstname, employee.lastname, generated_salary.location, generated_salary.date
        FROM generated_salary INNER JOIN employee WHERE generated_salary.emp_id = employee.empId ORDER BY date ASC;";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            while($row = $stmt->fetch()){
            echo "<tr>
            <td>$row->emp_id</td>
            <td>$row->firstname $row->lastname</td>
            <td>$row->location</td>
            <td>$row->date</td>
            <td class='td-action'>
                    <div class='ic ic__add'>
                        <a href='viewsalary.php?logid=$row->log' class='td-view'>
                            <span class='material-icons'>visibility</span>
                        </a>
                    </div>

                    <div class='ic ic__edit'>
                        <a href='updatesalary.php?logid=$row->log' class='td-edit'>
                            <span class='material-icons'>edit</span>
                        </a>
                    </div>

                    <div class='ic ic__delete'>
                        <a href='deletesalary.php?logid=$row->log' class='td-delete'>
                            <span class='material-icons'>delete</span>
                        </a>
                    </div>
            </td>
            </tr>";
            $this->deleteSalary($row->log);
                                        }
    }
    public function deleteSalary($logid)
    {
        if(isset($_POST['delete']))
        {
        $sessionData = $this->getSessionSecretaryData();
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
        if($countrow > 0) 
        {
            $action = "Delete Salary";
            $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                VALUES(?, ?, ?, ?, ?)";
            $stmtSecLog = $this->con()->prepare($sqlSecLog);
            $stmtSecLog->execute([$secid,$fullname, $action, $time, $date]);
            $countRowSecLog = $stmtSecLog->rowCount();
                if($countRowSecLog > 0)
                {
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
    
            if(!empty($search))
            {
                $sql ="SELECT employee.empId, employee.firstname, employee.lastname, 
                emp_attendance.company, emp_attendance.timeIn, emp_attendance.datetimeIn, 
                emp_attendance.timeOut, emp_attendance.datetimeOut,
                emp_attendance.status
                FROM employee
                INNER JOIN emp_attendance ON employee.empId = emp_attendance.empId WHERE emp_attendance.salary_status != 'paid';";
                $found=false;
                $stmt = $this->con()->prepare($sql);
                $stmt->execute();
                $users = $stmt->fetchAll();
                $countRow = $stmt->rowCount();
                foreach($users as $user){
                $lfirstname = strtolower($user->firstname);
                $llastname  = strtolower($user->lastname);
                $lcompany   = strtolower($user->company);
                $lstatus    = strtolower($user->status);
                $timeIn     = strtolower($user->timeIn);
                $timeOut    = strtolower($user->timeOut);
                if(preg_match("/{$search}/i", $lfirstname) || preg_match("/{$search}/i", $llastname) || preg_match("/{$search}/i", $lcompany) || preg_match("/{$search}/i", $lstatus) || preg_match("/{$search}/i", $timeIn) || preg_match("/{$search}/i", $user->datetimeIn) || preg_match("/{$search}/i", $timeOut) ||preg_match("/{$search}/i", $user->datetimeOut)){
                    echo "<tr>
                    <td>&nbsp;$user->empId&nbsp;</td>
                    <td>&nbsp;$user->firstname&nbsp;</td>
                    <td>&nbsp;$user->lastname&nbsp;</td>
                    <td>&nbsp;$user->company&nbsp;</td>
                    <td>&nbsp;$user->timeIn&nbsp;</td>
                    <td>&nbsp;$user->datetimeIn&nbsp;</td>
                    <td>&nbsp;$user->timeOut&nbsp;</td>
                    <td>&nbsp;$user->datetimeOut&nbsp;</td>
                    <td>&nbsp;$user->status&nbsp;</td>
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
            if( !empty($_POST['empid']) &&
            !empty($_POST['rate']) &&
            !empty($_POST['hrsduty']) &&
            !empty($_POST['location']) &&
            !empty($_POST['noofdayswork']) &&
            !empty($_POST['regholiday']) &&
            !empty($_POST['hrslate']) &&
            !empty($_POST['sss']) &&
            !empty($_POST['pagibig']) &&
            !empty($_POST['philhealth']) &&
            !empty($_POST['cashbond']) &&
            !empty($_POST['specialholiday']) &&
            !empty($_POST['thirteenmonth']) &&
            !empty($_POST['cvale']))
            {
                if( empty($_POST['rate']) &&
                    empty($_POST['rate'])) 
                    {
                    echo "All inputs are required rate";
                    }else{
                    $empid=$_POST['empid'];
                    $rate=(int)$_POST['rate'];
                    $hrsduty=(int)$_POST['hrsduty'];
                    $location = $_POST['location'];
                    $noofdayswork = (int)$_POST['noofdayswork'];
                    $regholiday = $_POST['regholiday'];
                    $daylate=$_POST['daylate'];
                    $hrslate=$_POST['hrslate'];
                    $sss=$_POST['sss'];
                    $pagibig=$_POST['pagibig'];
                    $philhealth=$_POST['philhealth'];
                    $cashbond=$_POST['cashbond'];
                    $specialholiday=$_POST['specialholiday'];
                    $thirteenmonth=$_POST['thirteenmonth'];
                    $netpay="";
                    $vale=$_POST['cvale'];
                    $totaldaysalary = $hrsduty * $rate ; // sahod sa isang araw depende sa duty at rate 

                    $totalregholidayhoursalary = $regholiday * $rate;
                    $totalregholidaysalary = $totalregholidayhoursalary;                        // sahod pag regular holiday

                    $totalspecialholidayhoursalary = $specialholiday * $rate;
                    $totalspecialholidayhoursalarypercent = $totalspecialholidayhoursalary * 0.30;
                    $totalspecialholidaysalary = $totalspecialholidayhoursalarypercent + $totalspecialholidayhoursalary;
                    
                    $totalhrs = $hrsduty * $noofdayswork; // oras ng trabaho
                    $totalsalaryfortotalhours = $totalhrs * $rate;  // sahod sa oras nang tinrabaho

                    $totalholidaysalary = (float)$totalregholidaysalary + (float)$totalspecialholidaysalary;
                    $totg = (float)$totalholidaysalary + (float)$thirteenmonth;
                    $totalgross = (float)$totalsalaryfortotalhours + (float)$totg;

                    $totalsalaryforlate = (float)$hrslate * $rate;
                    $totaldeduction = (float)$vale + (float)$cashbond + (float)$sss + (float)$pagibig + (float)$philhealth + (float)$totalsalaryforlate;

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
                                                hrs_late,
                                                no_of_work,
                                                sss,
                                                pagibig,
                                                philhealth,
                                                cashbond,
                                                vale,
                                                thirteenmonth,
                                                total_hours,
                                                regular_pay,
                                                regular_holiday_pay,
                                                special_holiday_pay,
                                                total_deduction,
                                                total_gross,
                                                total_netpay,
                                                dateandtime_created
                                                )
                                                VALUES(?, ?, ?, ?,?, ?,?, ?,?, ?, ?,?,?,?,?,?,?,?,? ,?, ?, ?, ?,?);";
                $stmt = $this->con()->prepare($sql);
                $stmt->execute([$empid, $location, $rate, $date, $hrsduty,$regholiday, $specialholiday, $daylate, $hrslate,  $noofdayswork, $sss,$pagibig,$philhealth, $cashbond, $vale, $thirteenmonth,$totalhrs, $totalsalaryfortotalhours, $totalregholidaysalary, $totalspecialholidaysalary, $totaldeduction,$totalgross,$netpay, $time]);
                $users = $stmt->fetch();
                $countRow = $stmt->rowCount();

                if($countRow > 0)
                {
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
    public function updateSalary($id,$fullname)
    {
        if(isset($_POST['edit']))
        {
            // if( isset($_POST['empid']) &&
            // !isset($_POST['rate']) &&
            // isset($_POST['hrsduty']) &&
            // isset($_POST['location']) &&
            // isset($_POST['noofdayswork']) &&
            // isset($_POST['regholiday']) &&
            // isset($_POST['daylate']) &&
            // isset($_POST['minlate']) &&
            // isset($_POST['dayabsent']) &&
            // isset($_POST['sss']) &&
            // isset($_POST['cashbond']) &&
            // isset($_POST['specialholiday']) &&
            // isset($_POST['thirteenmonth']) &&
            // isset($_POST['cvale']))
            // {
                $empid=$_POST['empid'];
                $rate=(int)$_POST['rate'];
                $hrsduty=(int)$_POST['hrsduty'];
                $location = $_POST['location'];
                $noofdayswork = (int)$_POST['noofdayswork'];
                $regholiday = $_POST['regholiday'];
                $daylate=$_POST['daylate'];
                $minlate=$_POST['hrslate'];
                // $dayabsent=$_POST['dayabsent'];
                $sss=$_POST['sss'];
                $pagibig=$_POST['pagibig'];
                $philhealth = $_POST['philhealth'];
                $cashbond=$_POST['cashbond'];
                $specialholiday=$_POST['specialholiday'];
                $thirteenmonth=$_POST['thirteenmonth'];
                $netpay="";
                $vale=$_POST['cvale'];
                $logid=$_GET['logid'];
                $totaldaysalary = $hrsduty * $rate ; // sahod sa isang araw depende sa duty at rate
 
                $totalregholidayhoursalary = $regholiday * $rate;
                $totalregholidaysalary = $totalregholidayhoursalary;                        // sahod pag regular holiday

                $totalspecialholidayhoursalary = $specialholiday * $rate;
                $totalspecialholidayhoursalarypercent = $totalspecialholidayhoursalary * 0.30;
                $totalspecialholidaysalary = $totalspecialholidayhoursalarypercent;
                
                $totalhrs = $hrsduty * $noofdayswork; // oras ng trabaho
                $totalsalaryfortotalhours = $totalhrs * $rate;  // sahod sa oras nang tinrabaho

                $totalholidaysalary = $totalregholidaysalary + $totalspecialholidaysalary;
                $totg = $totalholidaysalary + $thirteenmonth;
                $totalgross = $totalsalaryfortotalhours + $totg;

                // $totalhourfordayabsent = $dayabsent * $hrsduty; // total hours ng absent
                // $totaldaysalaryfordayabsent = $totalhourfordayabsent * $rate; //sahod absent

                $totalsalaryforlate = $minlate * 59.523;
                $totaldeduction = (float)$vale + (float)$cashbond + (float)$sss + (float)$pagibig + (float)$philhealth + (float)$totalsalaryforlate;

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
                    hrs_late = ?,
                    -- day_absent = ?,
                    -- hours_absent = ?,
                    no_of_work = ?,
                    sss = ?,
                    cashbond = ?,
                    vale = ?,
                    thirteenmonth = ?,
                    total_hours = ?,
                    regular_pay = ?,
                    regular_holiday_pay = ?,
                    special_holiday_pay = ?,
                    total_deduction = ?,
                    total_gross = ?,
                    total_netpay = ?,
                    dateandtime_created = ?
                    WHERE log = $logid;";
                    $stmt = $this->con()->prepare($sql);
                    $stmt->execute([$empid, $location, $rate, $date,$hrsduty,$regholiday,$specialholiday,$daylate, $minlate, $noofdayswork, $sss, $cashbond, $vale, $thirteenmonth ,$totalhrs ,$totalsalaryfortotalhours,$totalregholidaysalary,$totalspecialholidaysalary,$totaldeduction,$totalgross,$netpay ,$time]);
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
            // } else {
            // echo "All inputs are required!";
            // }
        }
    }
    public function employeeList()
    {
        $sql ="SELECT * FROM employee";
        $stmt = $this->con()->prepare($sql);
                    $stmt->execute();
                    $users = $stmt->fetchall();
                    foreach($users as $user){
                        echo "<tr>
                        <td>$user->empId</td>
                        <td>$user->firstname</td>
                        <td>$user->lastname</td>
                        <td>$user->address</td>
                        <td>$user->cpnumber</td>
                        <td>$user->position</td>
                        <td>$user->availability</td>
                        <td class='td-action'>
                            <div class='ic ic__add'>
                                <a href='viewemployee.php?empId=$user->empId' class='td-view'>
                                    <span class='material-icons'>visibility</span>
                                </a>
                            </div>
                        </td>
                        </tr>";
                    }
    }
    public function searchEmployee()
    {
            if(isset($_POST['empsearch'])){
                $search = strtolower($_POST['employeesearch']);
        
                if(!empty($search)){
                    $sql ="SELECT empId, firstname, lastname, address, cpnumber, position, availability
        FROM employee;";
        $found=false;
                    $stmt = $this->con()->prepare($sql);
                    $stmt->execute();
                    $users = $stmt->fetchAll();
                    $countRow = $stmt->rowCount();
                    foreach($users as $user){
                    $lfirstname = strtolower($user->firstname);
                    $llastname = strtolower($user->lastname);
                    $laddress = strtolower($user->address);
                    $lavailability = strtolower($user->availability);
                    $lposition = strtolower($user->position);
                    if(preg_match("/{$search}/i", $lfirstname) || preg_match("/{$search}/i", $llastname) || preg_match("/{$search}/i", $laddress) || preg_match("/{$search}/i", $lavailability) || preg_match("/{$search}/i", $lposition)){
                        echo "<tr>
                                <td>&nbsp;$user->empId&nbsp;</td>
                                <td>&nbsp;$user->firstname&nbsp;</td>
                                <td>&nbsp;$user->lastname&nbsp;</td>
                                <td>&nbsp;$user->address&nbsp;</td>
                                <td>&nbsp;$user->cpnumber&nbsp;</td>
                                <td>&nbsp;$user->position&nbsp;</td>
                                <td>&nbsp;$user->availability&nbsp;</td>
                                <td class='td-action'>
                                    <div class='ic ic__add'>
                                        <a href='viewemployee.php?empId=$user->empId' class='td-view'>
                                            <span class='material-icons'>visibility</span>
                                        </a>
                                    </div>
                                </td>
                             <tr/>";
                        $found=true;
                    }
                    }
                    if($found!==true){
                        echo"No Record Found!";
                        $this->employeeList();
                    }
                    }else{
                    echo "Please Input Fields!";
                    $this->employeeList();
                    }
        }
    }
    public function automaticGenerateSalary($fullname,$id)
    {
        if(isset($_POST['createsalary']))
        {
            $sqlall="SELECT * FROM schedule";
            $stmtall = $this->con()->prepare($sqlall);
            $stmtall->execute();
            $usersall = $stmtall->fetchAll();
            foreach($usersall as $all){
            $empid = $all->empid;
            $regholiday = 0;
            $specholiday = 0;
            $hoursduty = 0;
            $sql="SELECT emp_attendance.timeIn, emp_attendance.timeOut, employee.ratesperDay
            FROM emp_attendance INNER JOIN employee ON emp_attendance.empId = employee.empId WHERE emp_attendance.empId = ? AND emp_attendance.salary_status != 'paid';";
                $stmt = $this->con()->prepare($sql);
                $stmt->execute([$empid]);
                $users = $stmt->fetchAll();
                $countRow = $stmt->rowCount();

                $sqlsched = "SELECT * FROM schedule WHERE empId = ?";
                $stmtsched = $this->con()->prepare($sqlsched);
                $stmtsched->execute([$empid]);
                $usersched = $stmtsched->fetch();
                $countRowsched = $stmtsched->rowCount();
                $hoursduty = $usersched->shift_span;
                $schedtimein = date('h:i:s',strtotime($usersched->scheduleTimeIn));
                $schedtimeout = date('h:i:s',strtotime($usersched->scheduleTimeOut));
                $late=0;
                if($countRowsched > 0) {
                    if($countRow >= 1){
                    $tothrs = 0;
                    foreach ($users as $user){
                        $rate = $user->ratesperDay;
                        $timein= date('H:i:s',strtotime($user->timeIn));
                        $timeout= date('H:i:s',strtotime($user->timeOut));
                        $tothrs += abs(strtotime($timein) - strtotime($timeout)) /3600 ;
                        if($schedtimein < $timein){
                             $late += abs((float)$schedtimein - (float)$timein) ;
                        }
                    }
                $sql0="SELECT emp_attendance.timeIn, emp_attendance.timeOut, employee.ratesperDay, emp_attendance.datetimeIn, emp_attendance.datetimeOut, employee.position
                FROM emp_attendance INNER JOIN employee ON emp_attendance.empId = employee.empId WHERE emp_attendance.empId = ?;";
                $stmt0 = $this->con()->prepare($sql0);
                $stmt0->execute([$empid]);
                $users0 = $stmt0->fetch();
                $countRow0 = $stmt0->rowCount();                 //modify pag ayos na sched table
                if($countRow0 >= 1)
                {
                    $getin=$countRow0;
                    while($countRow0 >= $getin)
                    {
                        $start = $users0->datetimeIn;
                        $getin++;
                    }
                        $end = $start;
                        $users01 = $stmt0->fetchall();                        //get start date and end date
                    foreach($users01 as $user0)
                    {
                            $end = $user0->datetimeOut;
                    }
                            $sql1="SELECT * FROM cashadvance WHERE empId = ?;";
                            $stmt1 = $this->con()->prepare($sql1);
                            $stmt1->execute([$empid]);
                            $users1 = $stmt1->fetchall();
                            $countRow1 = $stmt1->rowCount();
                            $vale = 0;
                    foreach($users1 as $cadv)
                    {
                            $vale = $vale + $cadv->amount;
                    }
                            $position = $users0->position; //get the position of selected employee

            }
                // $sqlv="SELECT * FROM violationsandremark WHERE empId = ?";
                // $stmtv = $this->con()->prepare($sqlv);
                // $stmtv->execute([$empid]);
                // $rowsv = $stmtv->fetch();
                // $countRowv =$stmtv->rowCount();
                // if($countRowv>0){
                    
                // if(strtolower($rowsv->violation) == "uniform") {
                //     $violation = $countRowv;
                //     $remarks = $rowsv->remarks;
                // }
                // }



                $sqlded="SELECT * FROM deductions";
                $stmtded = $this->con()->prepare($sqlded);
                $stmtded->execute();
                $usersded = $stmtded->fetchall();
                $countRowded =$stmtded->rowCount();
                foreach($usersded as $ded)
                {
                    if(strtolower($ded->deduction)=="sss"){
                        $msc = ($rate * 8) * 31;
                        $sss = $msc * $ded->percentage;
                    }
                    else if (strtolower($ded->deduction)=="pagibig"){
                        $msc = ($rate * 8) * 31;
                        $pagibig = $msc * $ded->percentage;
                    }
                    else if (strtolower($ded->deduction)=="philhealth"){
                        $msc = ($rate * 8) * 31;
                        $philhealth = $msc * $ded->percentage;
                    
                    }else if(strtolower($ded->deduction)=="cash bond"){
                        $cashbond = $ded->amount;
                    }else{
                        $other .= $ded->deduction."<br>";
                        $otheramount+=$ded->amount;
                    }
                }


                $sql3="SELECT * FROM holidays;";
                $stmthol3 = $this->con()->prepare($sql3);
                $stmthol3->execute();
                $usershol3 = $stmthol3->fetchall();
                $countRowhol3 =$stmthol3->rowCount();
                $specholiday =0;
                $regholiday =0;
                $sqlgetholiday = "SELECT * FROM emp_attendance WHERE empId = $empid;";
                $stmtgetholiday = $this->con()->prepare($sqlgetholiday);
                $stmtgetholiday->execute();
                $getholiday = $stmtgetholiday->fetchall();
                $regular = "regular holiday";
                $special = "special holiday";
                foreach($getholiday as $count0)
                {
                    $empdatein = date ('F j' , strtotime($count0->datetimeIn));
                    $empdateout = date ('F j' , strtotime($count0->datetimeOut));
                    foreach($usershol3 as $holidate)
                    {
                            $holidateto = date('F j',strtotime($holidate->date_holiday));
                            if(preg_match("/{$empdatein}/i", strtolower($holidateto)) OR preg_match("/{$empdateout}/i", strtolower($holidateto)))
                            {   
                                if(preg_match("/{$holidate->type}/i", $regular))
                                {
                                    $regholiday +=  1;
                                }else if(preg_match("/{$holidate->type}/i", $special))
                                {
                                    $specholiday +=  1;
                                }else {
                                    
                                }
                            }
                        }
                }

                    $standardpay = (float)$tothrs * (float)$rate;
                    $regholiday = $regholiday * $hoursduty;
                    $regholidaypay = ($regholiday * $rate);
                    $specholiday = $specholiday * $hoursduty;
                    $specrate = $specholiday * $rate;
                    $specpercent = $specrate * 0.30;
                    $specholidaypay = $specpercent;
                    $thirteenmonth = 0;
                    $total_hours_late = $late;                                      //sa attendance ni vonne to
                    $totalgross = ($standardpay + $regholidaypay + $specholidaypay + $thirteenmonth);
                    $totaldeduction = ($sss + $pagibig + $philhealth + $otheramount + $cashbond + $vale);
                    $totalnetpay = $totalgross - $totaldeduction;
                            if($totalnetpay < 0)
                            {
                                $forrelease = "*Not for Release!";
                            }else
                            {
                                $forrelease="For Release";
                            }
                    date_default_timezone_set('Asia/Manila');
                    $date = date('F j, Y h:i:s A');
                if($countRow > 0 ){
                    $sql1="INSERT INTO `automatic_generated_salary`(`emp_id`, `total_hours`,`standard_pay`, `regular_holiday`, 
                    `regular_holiday_pay`, `special_holiday`, `special_holiday_pay`, `thirteenmonth`, `sss`,`pagibig`,`philhealth`, `cashbond`, `other`,
                    `other_amount`,`vale`, `total_hours_late`, `total_gross`, `total_deduction`, `total_netpay` ,`start`,`end`,`for_release`,`date_created`,`process_by`) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
                    $stmt1 = $this->con()->prepare($sql1);
                    $stmt1->execute([$empid,$tothrs,$standardpay,$regholiday,$regholidaypay,$specholiday,$specholidaypay,$thirteenmonth,$sss,$pagibig,$philhealth,$cashbond,$other,$otheramount,$vale,$total_hours_late,$totalgross,$totaldeduction,$totalnetpay,$start,$end,$forrelease,$date,$id]);
                    $CountRow01 = $stmt1 ->rowCount();
                                if($CountRow01>0)
                                {
                                 $number+= 1;
                                }
                                        
                }else 
                    {
                        echo "The selected employee is less than or equal to 5 attendance only, can't generate salary";
                    }
                }else 
                {
                    $Message = urlencode("Selected employee has no attendance");
                    header("Location:automaticpayroll.php?Message=".$Message);
                }

                } else 
                {
                    $Message = urlencode("Selected employee has no schedule ");
                    header("Location:automaticpayroll.php?Message=".$Message);
                }

            } //sabay sabay
                header("Location:automaticpayroll.php?Message=".$Message);
            $this->releaseSalary($fullname,$id);
                } else if(isset($_POST['cancel'])) //isset to
                {
                header('location: automaticpayroll.php');
                }     
    }
    public function displayAutomaticGeneratedSalary()
    {
        $sql ="SELECT log, automatic_generated_salary.emp_id, automatic_generated_salary.start, automatic_generated_salary.end, employee.firstname, employee.lastname, automatic_generated_salary.date_created
        FROM automatic_generated_salary INNER JOIN employee WHERE automatic_generated_salary.emp_id = employee.empId AND for_release !='released'  ORDER BY date_created DESC;";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute();
            while($row = $stmt->fetch()){
            echo "<tr>
            <td>$row->emp_id</td>
            <td>$row->firstname $row->lastname</td>
            <td>",date('M j, Y',strtotime($row->start)),"</td>
            <td>",date('M j, Y',strtotime($row->end)),"</td>
            <td>",date('M j, Y',strtotime($row->date_created)),"</td>
            <td><a href='viewautomatedsalary.php?logid=$row->log'>View </a><a href='deleteautomatedsalary.php?logid=$row->log'>Delete </a></td>
            </tr>";
            // $this->deleteSalary($row->log);
            }
    }
    public function searchAutomaticGeneratedSalary()
    {
            if(isset($_POST['agssearch'])){
                $agssearch = strtolower($_POST['searchsalary']);
                if(!empty($agssearch)){
                    $sql ="SELECT * FROM automatic_generated_salary INNER JOIN employee WHERE for_release = 'released';";
                    $found=false;
                    $stmt = $this->con()->prepare($sql);
                    $stmt->execute();
                    $users = $stmt->fetchAll();
                    $countRow = $stmt->rowCount();
                    foreach($users as $user){
                    $lempid=strtolower($user->empId);
                    $lfirstname = strtolower($user->firstname);
                    $llastname = strtolower($user->lastname);
                    if(preg_match("/{$agssearch}/i", $lfirstname) || preg_match("/{$agssearch}/i", $llastname) || preg_match("/{$agssearch}/i", $lempid)){
                        echo "<tr>
                        <td>&nbsp;$user->empId&nbsp;</td>
                        <td>&nbsp;$user->firstname&nbsp;</td>
                        <td>&nbsp;$user->lastname&nbsp;</td>
                        <td>&nbsp;$user->total_gross&nbsp;</td>
                        <td>&nbsp;$user->total_deduction&nbsp;</td>
                        <td>&nbsp;$user->total_netpay&nbsp;</td>
                        <td>&nbsp;$user->date_released&nbsp;</td>
                        <td>&nbsp;<a href='viewemployee.php?empId=$user->empId'>View </a>&nbsp;</td>
                        <tr/>";
                        $found=true;
                    }
                    }
                    if($found!==true){
                        echo"No Record Found!";
                        $this->displayreleasedsalary(); 
                    }
                    }else{
                    echo "Please Input Fields!";
                    $this->displayreleasedsalary();
                    }
        }
    }
    public function releaseSalary($fullname,$id)
    {
            $sqlall="SELECT * FROM automatic_generated_salary;";
            $stmtall = $this->con()->prepare($sqlall);
            $stmtall->execute();
            $userall=$stmtall->fetchall();
            foreach($userall as $all){
            $logid=$all->log;
            $sql = "SELECT * FROM automatic_generated_salary WHERE log = ?;";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute([$logid]);
            $user=$stmt->fetch();
            $end = date('F',strtotime($user->end));
            $totnetpay = $user->total_netpay;
            $currsss = $user->sss;
            $currpagibig =$user->pagibig;
            $currphilhealth =$user->philhealth;
            $currcashbond =$user->cashbond;
            if(strtolower($user->for_release)=='**not for release!')
            {
                echo "Not for release";
                header('location: automaticpayroll.php');
            }else{
                $sql1="UPDATE automatic_generated_salary SET for_release = 'released', date_released=CURRENT_TIMESTAMP() WHERE log = $logid;";
                $stmt1 = $this->con()->prepare($sql1);
                $stmt1->execute();
                $CountRow01 = $stmt1 ->rowCount();
            if($CountRow01>0){
                $status='unpaid';
                $sql2="UPDATE emp_attendance SET salary_status = 'paid' WHERE empId = ? AND salary_status = ?;";
                $stmt2 = $this->con()->prepare($sql2);
                $stmt2->execute([$user->emp_id,$status]);
                $CountRow02 = $stmt2 ->rowCount();
            if($CountRow02>0){
                header('automaticpayroll.php');
                $sql3="DELETE FROM cashadvance WHERE empId = $user->emp_id;";
                $stmt3 = $this->con()->prepare($sql3);
                $stmt3->execute();

                $sqlcheckifhas="SELECT * FROM contributions WHERE empId = $user->emp_id;";
                $stmtcheck = $this->con()->prepare($sqlcheckifhas);
                $stmtcheck->execute();
                $CountRowcheck = $stmtcheck ->rowCount();
            if($CountRowcheck > 0 ){
                $sql4="UPDATE contributions SET sss = sss + $currsss, pagibig = pagibig + $currpagibig, 
                philhealth =  philhealth + $currphilhealth , cashbond = cashbond + $currcashbond, 
                date = CURRENT_TIMESTAMP() WHERE empId = $user->emp_id;";
                $stmt4 = $this->con()->prepare($sql4);
                $stmt4->execute();
            }elseif($CountRowcheck == 0) {
                $sql5="INSERT INTO contributions (empId,sss,pagibig,philhealth,cashbond,date) VALUES (?,?,?,?,?,CURRENT_TIMESTAMP());";
                $stmt5 = $this->con()->prepare($sql5);
                $stmt5->execute([$user->emp_id,$user->sss,$user->pagibig,$user->philhealth,$user->cashbond]);
            }else{
                echo "error";
            }   

                }
                }
                $sqlreport="SELECT * FROM salary_report WHERE empId = ?"; //salary report
                $stmtreport = $this->con()->prepare($sqlreport);
                $stmtreport->execute([$user->emp_id]);
                $ureport=$stmtreport->fetch();
                $CountRowreport = $stmtreport ->rowCount();
                $jan = 'january';
                $feb = 'february';
                $mar = 'march';
                $apr = 'april';
                $may = 'may';
                $jun = 'june';
                $jul = 'july';
                $aug = 'august';
                $sep = 'september';
                $oct = 'october';
                $nov = 'november';
                $dec = 'december';
                if($CountRowreport > 0)
                {   
                    if(preg_match("/{$end}/i", $jan))
                    {
                        $sqlupdate="UPDATE salary_report SET $jan = $jan + $totnetpay WHERE empId = ?";
                        $stmtupdate = $this->con()->prepare($sqlupdate);
                        $stmtupdate->execute([$user->emp_id]);
                    } else if (preg_match("/{$end}/i", $feb)){
                        $sqlupdate="UPDATE salary_report SET $feb = $feb + $totnetpay WHERE empId = ?";
                        $stmtupdate = $this->con()->prepare($sqlupdate);
                        $stmtupdate->execute([$user->emp_id]);
                    } else if (preg_match("/{$end}/i", $mar)){
                        $sqlupdate="UPDATE salary_report SET $mar = $mar + $totnetpay WHERE empId = ?";
                        $stmtupdate = $this->con()->prepare($sqlupdate);
                        $stmtupdate->execute([$user->emp_id]);
                    } else if (preg_match("/{$end}/i", $apr)){
                        $sqlupdate="UPDATE salary_report SET $apr = $apr + $totnetpay WHERE empId = ?";
                        $stmtupdate = $this->con()->prepare($sqlupdate);
                        $stmtupdate->execute([$user->emp_id]);
                    } else if (preg_match("/{$end}/i", $may)){
                        $sqlupdate="UPDATE salary_report SET $may = $may + $totnetpay WHERE empId = ?";
                        $stmtupdate = $this->con()->prepare($sqlupdate);
                        $stmtupdate->execute([$user->emp_id]);
                    } else if (preg_match("/{$end}/i", $jun)){
                        $sqlupdate="UPDATE salary_report SET $jun = $jun + $totnetpay WHERE empId = ?";
                        $stmtupdate = $this->con()->prepare($sqlupdate);
                        $stmtupdate->execute([$user->emp_id]);
                    } else if (preg_match("/{$end}/i", $jul)){
                        $sqlupdate="UPDATE salary_report SET $jul = $jul + $totnetpay WHERE empId = ?";
                        $stmtupdate = $this->con()->prepare($sqlupdate);
                        $stmtupdate->execute([$user->emp_id]);
                    } else if (preg_match("/{$end}/i", $aug)){
                        $sqlupdate="UPDATE salary_report SET $aug = $aug + $totnetpay WHERE empId = ?";
                        $stmtupdate = $this->con()->prepare($sqlupdate);
                        $stmtupdate->execute([$user->emp_id]);
                    } else if (preg_match("/{$end}/i", $sep)){
                        $sqlupdate="UPDATE salary_report SET $sep = $sep + $totnetpay WHERE empId = ?";
                        $stmtupdate = $this->con()->prepare($sqlupdate);
                        $stmtupdate->execute([$user->emp_id]);
                    } else if (preg_match("/{$end}/i", $oct)){
                        $sqlupdate="UPDATE salary_report SET $oct = $oct + $totnetpay WHERE empId = ?";
                        $stmtupdate = $this->con()->prepare($sqlupdate);
                        $stmtupdate->execute([$user->emp_id]);
                    } else if (preg_match("/{$end}/i", $nov)){
                        $sqlupdate="UPDATE salary_report SET $nov = $nov + $totnetpay WHERE empId = ?";
                        $stmtupdate = $this->con()->prepare($sqlupdate);
                        $stmtupdate->execute([$user->emp_id]);
                    } else if (preg_match("/{$end}/i", $dec)){
                        $sqlupdate="UPDATE salary_report SET $dec = $dec + $totnetpay WHERE empId = ?";
                        $stmtupdate = $this->con()->prepare($sqlupdate);
                        $stmtupdate->execute([$user->emp_id]);
                    } else {

                    } 
                } else {
                    if(preg_match("/{$end}/i", $jan))
                    {
                        $sqlinsert="INSERT INTO salary_report (empId, $jan) VALUES ($user->emp_id, $totnetpay);";
                        $stmtinsert = $this->con()->prepare($sqlinsert);
                        $stmtinsert->execute();
                    } else if (preg_match("/{$end}/i", $feb)){
                        $sqlinsert="INSERT INTO salary_report (empId, $feb) VALUES ($user->emp_id, $totnetpay);";
                        $stmtinsert = $this->con()->prepare($sqlinsert);
                        $stmtinsert->execute();
                    } else if (preg_match("/{$end}/i", $mar)){
                        $sqlinsert="INSERT INTO salary_report (empId, $mar) VALUES ($user->emp_id, $totnetpay);";
                        $stmtinsert = $this->con()->prepare($sqlinsert);
                        $stmtinsert->execute();
                    } else if (preg_match("/{$end}/i", $apr)){
                        $sqlinsert="INSERT INTO salary_report (empId, $apr) VALUES ($user->emp_id, $totnetpay);";
                        $stmtinsert = $this->con()->prepare($sqlinsert);
                        $stmtinsert->execute();
                    } else if (preg_match("/{$end}/i", $may)){
                        $sqlinsert="INSERT INTO salary_report (empId, $may) VALUES ($user->emp_id, $totnetpay);";
                        $stmtinsert = $this->con()->prepare($sqlinsert);
                        $stmtinsert->execute();
                    } else if (preg_match("/{$end}/i", $jun)){
                        $sqlinsert="INSERT INTO salary_report (empId, $jun) VALUES ($user->emp_id, $totnetpay);";
                        $stmtinsert = $this->con()->prepare($sqlinsert);
                        $stmtinsert->execute();
                    } else if (preg_match("/{$end}/i", $jul)){
                        $sqlinsert="INSERT INTO salary_report (empId, $july) VALUES ($user->emp_id, $jtotnetpay);";
                        $stmtinsert = $this->con()->prepare($sqlinsert);
                        $stmtinsert->execute();
                    } else if (preg_match("/{$end}/i", $aug)){
                        $sqlinsert="INSERT INTO salary_report (empId, $aug) VALUES ($user->emp_id, $totnetpay);";
                        $stmtinsert = $this->con()->prepare($sqlinsert);
                        $stmtinsert->execute();
                    } else if (preg_match("/{$end}/i", $sep)){
                        $sqlinsert="INSERT INTO salary_report (empId, $sep) VALUES ($user->emp_id, $totnetpay);";
                        $stmtinsert = $this->con()->prepare($sqlinsert);
                        $stmtinsert->execute();
                    } else if (preg_match("/{$end}/i", $oct)){
                        $sqlinsert="INSERT INTO salary_report (empId, $oct) VALUES ($user->emp_id, $totnetpay);";
                        $stmtinsert = $this->con()->prepare($sqlinsert);
                        $stmtinsert->execute();
                    } else if (preg_match("/{$end}/i", $nov)){
                        $sqlinsert="INSERT INTO salary_report (empId, $nov) VALUES ($user->emp_id, $totnetpay);";
                        $stmtinsert = $this->con()->prepare($sqlinsert);
                        $stmtinsert->execute();
                    } else if (preg_match("/{$end}/i", $dec)){
                        $sqlinsert="INSERT INTO salary_report (empId, $dec) VALUES ($user->emp_id, $totnetpay);";
                        $stmtinsert = $this->con()->prepare($sqlinsert);
                        $stmtinsert->execute();
                    } else {
                    } 
                }
                $this->emailpdf($logid);
                }
                $number += 1;
                }//all
                $action = "Generate ".$number." Salary";
                $secdatetime = $this->getDateTime();
                $sectime = $secdatetime['time'];
                $secdate = $secdatetime['date'];
                $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                VALUES(?, ?, ?, ?, ?)";
                $stmtSecLog = $this->con()->prepare($sqlSecLog);
                $stmtSecLog->execute([$id,$fullname, $action, $sectime, $secdate]);
                $countRowSecLog = $stmtSecLog->rowCount();
                if($countRowSecLog > 0){
                        header('Location: releasedsalary.php?msg=Succesfully%20Released');
                    } else {
                        echo 'di pumasok sa act log';
                    }
    }
    public function deleteautomatedsalary($logid)
    {
        if(isset($_POST['deleteauto'])){
        $sql = "DELETE FROM automatic_generated_salary WHERE log = ?;";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$logid]);
        $countrow = $stmt->rowCount();
        if($countrow > 0) {
        $action = "Delete Automated Salary";
        $sessionData = $this->getSessionSecretaryData();
        $fullname = $sessionData['fullname'];
        $secid = $sessionData['id'];
        $datetime = $this->getDateTime();
        $time = $datetime['time'];
        $date = $datetime['date'];
            $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                VALUES(?, ?, ?, ?, ?)";
            $stmtSecLog = $this->con()->prepare($sqlSecLog);
            $stmtSecLog->execute([$secid,$fullname, $action, $time, $date]);
            $countRowSecLog = $stmtSecLog->rowCount();
                if($countRowSecLog > 0){
                    echo 'pumasok na sa act log';
                    header('location:automaticpayroll.php');
                } else {
                    echo 'di pumasok sa act log';
                    header('location:automaticpayroll.php');
                }
            } else {
                echo 'Error in deleting !';
            }
        }
        else if(isset($_POST['cancel'])){
            header('location: automaticpayroll.php');
        }else{
        }
    }
    public function adddeduction($fullname,$id)
    {
            if(isset($_POST['generatededuction'])){
                $countrow = 0;
                $deduction = $_POST['deduction'];
                if($deduction == 'other'){
                    $name = $_POST['name'];
                    $amount = $_POST['amount'];
                    $sqla="INSERT INTO  deductions (`deduction`,`amount`) VALUES (?,?);";
                    $stmta = $this->con()->prepare($sqla);
                    $stmta->execute([$name,$amount]);
                    $countrowa = $stmta->rowCount();
                }
                else 
                {
                    $percentage = (float)$_POST['percentage'];
                    $sql="INSERT INTO  deductions (`deduction`,`percentage`) VALUES (?,?);";
                    $stmt = $this->con()->prepare($sql);
                    $stmt->execute([$deduction,$percentage]);
                    $countrow = $stmt->rowCount();
                }
                    if($countrow > 0 || $countrowa > 0) {
                    $action = "Add Deduction";
                    $datetime = $this->getDateTime();
                    $time = $datetime['time'];
                    $date = $datetime['date'];
                    $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                        VALUES(?, ?, ?, ?, ?)";
                    $stmtSecLog = $this->con()->prepare($sqlSecLog);
                    $stmtSecLog->execute([$id,$fullname, $action, $time, $date]);
                    $countRowSecLog = $stmtSecLog->rowCount();
                    if($countRowSecLog > 0){
                        echo 'pumasok na sa act log';
                    } else {
                        echo 'di pumasok sa act log';
                        header('location:deductions.php');
                    }
                }
            }//isset
    }
    public function deletededuction($logid)
    {
        if(isset($_POST['deletededuction'])){
        $sql = "DELETE FROM deductions WHERE id = ?;";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$logid]);
        $countrow = $stmt->rowCount();
        if($countrow > 0) {
        $action = "Delete Deduction";
        $sessionData = $this->getSessionSecretaryData();
        $fullname = $sessionData['fullname'];
        $secid = $sessionData['id'];
        $datetime = $this->getDateTime();
        $time = $datetime['time'];
        $date = $datetime['date'];
            $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                VALUES(?, ?, ?, ?, ?)";
            $stmtSecLog = $this->con()->prepare($sqlSecLog);
            $stmtSecLog->execute([$secid,$fullname, $action, $time, $date]);
            $countRowSecLog = $stmtSecLog->rowCount();
                if($countRowSecLog > 0){
                    echo 'pumasok na sa act log';
                    header('location:deductions.php');
                } else {
                    echo 'di pumasok sa act log';
                    header('location:deductions.php');
                }
            } else {
                echo 'Error in deleting deduction!';
            }
        }
        else if(isset($_POST['cancel'])){
            header('location: deductions.php');
        }else{

        }

    }
    public function displaydeduction()
    {
        $sql="SELECT * FROM deductions;";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchall();
        $count=$stmt->rowCount();

        foreach($rows as $row){

            echo "<tr>
            <td>$row->deduction</td>
            <td>$row->amount</td>
            <td>$row->percentage </td>
            <td></td>
            <td class='td-action'>
                <div class='ic ic__delete'>
                    <a href='deletededuction.php?logid=$row->id' class='td-delete'>
                        <span class='material-icons'>delete</span>
                    </a>
                </div>
            </td>
            </tr>";
            $this->deletededuction($row->id);
    }
    }
    public function cashadvance($fullname,$id)
    {
        if(isset($_POST['add'])){
        if(!empty($_POST['amount'])){
        $empid = $_POST['empid'];
        $amount = $_POST['amount'];
        date_default_timezone_set('Asia/Manila');
        $date = date('F j, Y');
        $sql1="SELECT * FROM cashadvance WHERE empId = ?;";
        $stmt1 = $this->con()->prepare($sql1);
        $stmt1->execute([$empid]);
        $users1=$stmt1->fetchall();
        $totadv=0;
        foreach($users1 as $user){
        $totadv+= $user->amount;
        }
        $totadv=$totadv + $amount;
        if($amount <= 3000){
        if($totadv<=3000){
            $sql="INSERT INTO cashadvance (`empId`,`date`,`amount`) VALUES (?,?,?);";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute([$empid,$date,$amount]);
            $countrow = $stmt->rowCount();
        if($countrow > 0) {
        $action = "Add Cash Advance";
        $datetime = $this->getDateTime();
        $time = $datetime['time'];
        $date = $datetime['date'];
            $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                VALUES(?, ?, ?, ?, ?)";
            $stmtSecLog = $this->con()->prepare($sqlSecLog);
            $stmtSecLog->execute([$id,$fullname, $action, $time, $date]);
            $countRowSecLog = $stmtSecLog->rowCount();
                if($countRowSecLog > 0){
                    echo 'pumasok na sa act log'.$totadv;
                } else {
                    echo 'di pumasok sa act log';
                    header('location:deductions.php');
                }
            }
        }else {
            echo "Maximum Cash Advance: 3,000 only";
        }
        } else{
            echo "Maximum Cash Advance: 3,000 only";
        }  
        }//empty
        }//isset
    }
    public function deletecashadv($logid)
    {
        if(isset($_POST['deletecashadv'])){
        $sql = "DELETE FROM cashadvance WHERE id = ?;";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$logid]);
        $countrow = $stmt->rowCount();
        if($countrow > 0) {
        $action = "Delete Cash Advance";
        $sessionData = $this->getSessionSecretaryData();
        $fullname = $sessionData['fullname'];
        $secid = $sessionData['id'];
        $datetime = $this->getDateTime();
        $time = $datetime['time'];
        $date = $datetime['date'];
            $sqlSecLog = "INSERT INTO secretary_log (sec_id, name, action, time, date)
                                VALUES(?, ?, ?, ?, ?)";
            $stmtSecLog = $this->con()->prepare($sqlSecLog);
            $stmtSecLog->execute([$secid,$fullname, $action, $time, $date]);
            $countRowSecLog = $stmtSecLog->rowCount();
                if($countRowSecLog > 0){
                    echo 'pumasok na sa act log';
                    header('location:deductions.php');
                } else {
                    echo 'di pumasok sa act log';
                    header('location:deductions.php');
                }
            } else {
                echo 'Error in deleting cash advance!';
            }
        }
        else if(isset($_POST['cancel'])){
            header('location: deductions.php');
        }else{
        }
    }
    public function displaycashadvance()
    {
        $sql="SELECT cashadvance.id, cashadvance.date, cashadvance.amount, employee.firstname, employee.lastname FROM cashadvance INNER JOIN employee ON cashadvance.empId = employee.empId;";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute();
        while($row = $stmt->fetch()){
        echo "<tr>
        <td>$row->firstname $row->lastname</td>
        <td>$row->date</td>
        <td>$row->amount</td>
        <td class='td-action'>
            <div class='ic ic__delete'>
                <a href='deletecashadv.php?logid=$row->id' class='td-delete'>
                    <span class='material-icons'>delete</span>
                </a>
            </div>
        </td>
        </tr>";
        $this->deletecashadv($row->id);
        }
    }
    public function displayschedule()
    {
        $sql="SELECT * FROM schedule INNER JOIN employee WHERE employee.empId = schedule.empId;";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute();
        while($row = $stmt->fetch()){
            echo "<tr>
            <td>$row->empId</td>
            <td>$row->firstname</td>
            <td>$row->lastname</td>
            <td>$row->company</td>
            <td>$row->scheduleTimeIn</td>
            <td>$row->scheduleTimeOut</td>
            <td>$row->expiration_date</td>
            </tr>";
            }
    }
    public function displayviolations()
    {
        $sql="SELECT * FROM violationsandremarks INNER JOIN employee WHERE employee.empId = violationsandremarks.empId;";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute();
        while($row = $stmt->fetch()){
            echo "<tr>
            <td>$row->empId</td>
            <td>$row->firstname</td>
            <td>$row->lastname</td>
            <td>$row->violation</td>
            <td>$row->remark</td>
            <td>$row->date_created</td>
            </tr>";
        }
    }
    public function displayreleasedsalary()
    {
        $sql="SELECT * FROM automatic_generated_salary INNER JOIN employee WHERE automatic_generated_salary.emp_id = employee.empId 
        AND automatic_generated_salary.for_release = 'released';";
        $stmt=$this->con()->prepare($sql);
        $stmt->execute();
        while($row = $stmt->fetch()){
            echo "<tr>
            <td>$row->empId</td>
            <td>$row->firstname</td>
            <td>$row->lastname</td>
            <td>",number_format($row->total_gross),"</td>
            <td>",number_format($row->total_deduction),"</td>
            <td>",number_format($row->total_netpay),"</td>
            <td>$row->date_released</td>
            <td><a href='viewautomatedsalary.php?logid=$row->log'>View</td>
            </tr>";
        }

    }
    public function salaryreport()
    {
        $sql="SELECT * FROM salary_report INNER JOIN employee WHERE salary_report.empId = employee.empId;";
        $stmt=$this->con()->prepare($sql);
        $stmt->execute();
        while($row = $stmt->fetch()){
            echo "<tr>
                <td>$row->firstname $row->lastname</td>
                <td>".number_format($row->january)."</td>
                <td>".number_format($row->february)."</td>
                <td>".number_format($row->march)."</td>
                <td>".number_format($row->april)."</td>
                <td>".number_format($row->may)."</td>
                <td>".number_format($row->june)."</td>
                <td>".number_format($row->july)."</td>
                <td>".number_format($row->august)."</td>
                <td>".number_format($row->september)."</td>
                <td>".number_format($row->october)."</td>
                <td>".number_format($row->november)."</td>
                <td>".number_format($row->december)."</td>";
        }
    }
    public function displaycontributions()
    {
        $sql="SELECT * FROM contributions INNER JOIN employee WHERE contributions.empId = employee.empId;";
        $stmt=$this->con()->prepare($sql);
        $stmt->execute();

        while($row = $stmt->fetch()){
            echo "<tr>
            <td>$row->firstname $row->lastname</td>
            <td>$row->sss</td>
            <td>$row->pagibig</td>
            <td>$row->philhealth</td>
            <td>$row->cashbond</td>
            </tr>";
        }
    }
    public function searchcontribution()
    {
        if(isset($_POST['searchcon']) && !empty($_POST['emp']))
        {   
            $found=false;
            $emp=$_POST['emp'];
            $sql="SELECT * FROM contributions INNER JOIN employee ON contributions.empId = employee.empId;";
            $stmt=$this->con()->prepare($sql);
            $stmt->execute();
            while($users=$stmt->fetch())
            {
                if(preg_match("/{$emp}/i", $users->empId) || preg_match("/{$emp}/i", $users->firstname) ||
                preg_match("/{$emp}/i", $users->lastname))
                {
                    $found=true;
                    $sqls="SELECT * FROM contributions INNER JOIN employee ON contributions.empId = employee.empId WHERE contributions.empId = $users->empId;";
                    $stmts=$this->con()->prepare($sqls);
                    $stmts->execute();
                    $users=$stmts->fetchall();
                    foreach($users as $row){
                        echo "<tr>
                        <td>$row->firstname $row->lastname</td>
                        <td>$row->sss</td>
                        <td>$row->pagibig</td>
                        <td>$row->philhealth</td>
                        <td>$row->cashbond</td>
                        </tr>";
                    }

                }
            }
            if($found == false){
                echo "No Record Found!";
                $this->displaycontributions();
            }
        } else {
            echo "Please Input fields";
            $this->displaycontributions();
        }
    }
    public function displayempattendance($fullname,$id){
                $sql="SELECT * FROM employee;";
                $stmt=$this->con()->prepare($sql);
                $stmt->execute();
                while($user=$stmt->fetch())
                {   
                    $has=false;
                    $tothrs=0;              // ex may 4 attendance siya
                    $sql1="SELECT * FROM emp_attendance WHERE empId = $user->empId AND salary_status != 'paid';";
                    $stmt1=$this->con()->prepare($sql1);
                    $stmt1->execute();
                    $countattendance=$stmt1->rowCount();
                    if($countattendance > 0){
                    $has=true;
                    }else{
                    $has=false;
                    }
                    $users1=$stmt1->fetchall();
                    foreach($users1 as $users){
                    $timein= date('H:i:s',strtotime($users->timeIn));
                    $timeout= date('H:i:s',strtotime($users->timeOut));
                    $tothrs += abs(strtotime($timein) - strtotime($timeout)) / 3600 ;
                }
                    if($has){
                    $tothrs=number_format($tothrs,2);
                    $tothrs = sprintf('%02d:%02d', (int) $tothrs, fmod($tothrs   , 1) * 60);
                    echo "<tr>
                    <td>$user->empId</td>
                    <td>$user->firstname $user->lastname</td>
                    <td>$countattendance</td>
                    <td>$tothrs</td>
                    <td></td>
                    </tr>";
                    }else{

                    }
            }


    }
    public function searchempatt($fullname,$id){  //generateauto
        if(isset($_POST['searchempatt']) && !empty($_POST['emp']))
        {   
            $found=false;
            $emp=$_POST['emp'];
            $sqls="SELECT * FROM employee;";
            $stmts=$this->con()->prepare($sqls);
            $stmts->execute();
            while($users=$stmts->fetch())
            {            // ex may 4 attendance siya
                if(preg_match("/{$emp}/i", $users->empId) || preg_match("/{$emp}/i", $users->firstname) ||
                preg_match("/{$emp}/i", $users->lastname))
                {   
                    $found=true;
                    $tothrss=0;
                    $foundempid=$users->empId;
                    $foundname= $users->firstname." ".$users->lastname;
                    $sql1s="SELECT * FROM emp_attendance WHERE empId = $users->empId AND salary_status != 'paid';";
                    $stmt1s=$this->con()->prepare($sql1s);
                    $stmt1s->execute();
                    $countattendances=$stmt1s->rowCount();
                    $users1s=$stmt1s->fetchall();
                    foreach($users1s as $userss)
                    {
                        $timeins= date('H:i:s',strtotime($userss->timeIn));
                        $timeouts= date('H:i:s',strtotime($userss->timeOut));
                        $tothrss += abs(strtotime($timeins) - strtotime($timeouts)) / 3600 ;
                    }
                }
            }   

                
                if($found){
                    $tothrss=number_format($tothrss,2);
                    $tothrss = sprintf('%02d:%02d', (int) $tothrss, fmod($tothrss   , 1) * 60);
                echo "<tr>
                <td>$foundempid</td>
                <td>$foundname</td>
                <td>$countattendances</td>
                <td>$tothrss</td>
                <td> <a href='createsalary.php?empid=$foundempid'>Generate</a></td>
                </tr>";
                }else if($found==false){
                    echo "No Record Found!";
                    $this->displayempattendance($fullname,$id);
                }
        }else{
            $this->displayempattendance($fullname,$id);
        }
    }
    public function generatepdf($id){
        if(isset($_POST['download'])){
        $sql = "SELECT *
        FROM automatic_generated_salary
        INNER JOIN employee ON automatic_generated_salary.emp_id = employee.empId
        WHERE automatic_generated_salary.log = ?;";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$id]);
        $rows = $stmt->fetch();

        $dompdf = new Dompdf();
        $path = '../img/icon.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $payslip = "<!DOCTYPE html>
        <html>
        <head>
        
        <style>
        * {
          box-sizing: border-box;
        }
        body{
                    background:#F2F2F2;
                    border: 1px solid black;
                }
        
        .row {
          margin-left:-5px;
          margin-right:-5px;
        }
          
        .column {
          float: left;
          width: 48.5%;
          padding: 5px;
        }
        .row::after {
          content: '';
          clear: both;
          display: table;
        }
        
        table {
          border-collapse: collapse;
          border-spacing: 0;
          width: 100%;
          border: 2px solid #ddd;
        }
        
        th, td {
          text-align: left;
          padding: 10px;
        }
        
        tr:nth-child(even) {
          background-color: #f8f9f9;
        }
        
        /* Responsive layout - makes the two columns stack on top of each other instead of next to each other on screens that are smaller than 600 px */
        @media screen and (max-width: 600px) {
          .column {
            width: 100%;
          }
        }
        </style>
        </head>
        <body><img src='$base64' type='' class='viewautomatedsalary-logo' width='100' height='100'
        style='float:right; margin-left:-200px; margin-right: 70px; margin-top: 20px'></img>
        <center><h2>JTDV SECURITY AGENCY</h2>
        <p><u>400 Gem Bldg.,Gen T De Leon Ave.<br/>Barangay Gen T. De Leon, Valenzuela City</u></p></center>

        <div class='row'>
          <div class='column'>
            Employee ID: $rows->empId <br/>
            Employee Name: $rows->firstname  $rows->lastname <br/>
            Position: $rows->position
            <table>
              <tr>
                <th>Earnings</th>
                <th>Hours</th>
                <th>Rate</th>
                <th>&nbsp;</th>
              </tr>
              <tr>
                <td>Basic Pay</td>
                <td>".number_format($rows->total_hours)."</td>
                <td>$rows->ratesperDay</td>
                <td>".number_format($rows->standard_pay)."</td>
              </tr>
              <tr>
              <td>Overtime</td>
              <td></td>
              <td></td>
              <td></td>
              </tr>
              <tr>
                <td>Regular Holiday</td>
                <td>$rows->regular_holiday</td>
                <td></td>
                <td>".number_format($rows->regular_holiday_pay)."</td>
              </tr>
              <tr>
                <td>Special Holiday</td>
                <td>$rows->special_holiday</td>
                <td></td>
                <td>$rows->special_holiday_pay</td>
              </tr>
              <tr>
                <td>13Month</td>
                <td>$rows->thirteenmonth</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Total Gross</td>
                <td></td>
                <td></td>
                <td>".number_format($rows->total_gross)."</td>
              </tr>
            </table>
            <h3><u>Total Netpay: ".number_format($rows->total_netpay)."</u></h3>
          </div>
          <div class='column'>
              Email: $rows->email<br/>
              Contact: $rows->cpnumber<br/>
              Date: $rows->date_created
            <table>
              <tr>
                <th>Deductions</th>
                <th>No.of</th>
                <th>Rate</th>
                <th>&nbsp;</th>
              </tr>
              <tr>
                <td>Late</td>
                <td>$rows->total_hours_late</td>
                <td>59.523</td>
                <td></td>
              </tr>
              <tr>
                <td>SSS</td>
                <td></td>
                <td></td>
                <td>$rows->sss</td>
              </tr>
              <tr>
                <td>Pagibig</td>
                <td></td>
                <td></td>
                <td>$rows->pagibig</td>
              </tr>
              <tr>
                <td>Philhealth</td>
                <td></td>
                <td></td>
                <td>$rows->philhealth</td>
              </tr>
              <tr>
                <td>Cash Bond</td>
                <td></td>
                <td></td>
                <td>$rows->cashbond</td>
              </tr>";
              $payslip.=
              ($rows->other_amount > 0)?
                "<tr>
                <td>$rows->other</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>":"";
              $payslip.="<tr>
                <td>Cash Advance</td>
                <td></td>
                <td></td>
                <td>".number_format($rows->vale)."</td>
              </tr>
              <tr>
                <td>Total Deduction</td>
                <td></td>
                <td></td>
                <td>".number_format($rows->total_deduction)."</td>
              </tr>
              
            </table>
            <h3>Salary From: $rows->start  - $rows->end </h3>
          </div>
        </div>
        </body>
        </html>
        ";
        $pdfname = $rows->firstname .' '. $rows->lastname;
        $dompdf->loadHtml($payslip);
        $dompdf->set_option('isRemoteEnabled', TRUE);
        // (Optional) Setup the paper size and orientation
        $customPaper = array(0,0,1000,600);
        $dompdf->set_paper($customPaper);
        
        $dompdf->render();
        ob_end_clean();
        $file = $dompdf->output();
        $dompdf->stream($pdfname);
        }
    }
    public function emailpdf($logid){
        $sql = "SELECT *
        FROM automatic_generated_salary
        INNER JOIN employee ON automatic_generated_salary.emp_id = employee.empId
        WHERE automatic_generated_salary.log = ?;";
        $stmt = $this->con()->prepare($sql);
        $stmt->execute([$logid]);
        $rows = $stmt->fetch();
        $dompdf = new Dompdf();
        $path = '../img/icon.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $payslip = "<!DOCTYPE html>
        <html>
        <head>
        
        <style>
        * {
          box-sizing: border-box;
        }
        body{
                    background:#F2F2F2;
                    border: 1px solid black;
                }
        
        .row {
          margin-left:-5px;
          margin-right:-5px;
        }
          
        .column {
          float: left;
          width: 48.5%;
          padding: 5px;
        }
        .row::after {
          content: '';
          clear: both;
          display: table;
        }
        
        table {
          border-collapse: collapse;
          border-spacing: 0;
          width: 100%;
          border: 2px solid #ddd;
        }
        
        th, td {
          text-align: left;
          padding: 10px;
        }
        
        tr:nth-child(even) {
          background-color: #f8f9f9;
        }
        
        /* Responsive layout - makes the two columns stack on top of each other instead of next to each other on screens that are smaller than 600 px */
        @media screen and (max-width: 600px) {
          .column {
            width: 100%;
          }
        }
        </style>
        </head>
        <body><img src='$base64' type='' class='viewautomatedsalary-logo' width='100' height='100'
        style='float:right; margin-left:-200px; margin-right: 70px; margin-top: 20px'></img>
        <center><h2>JTDV SECURITY AGENCY</h2>
        <p><u>400 Gem Bldg.,Gen T De Leon Ave.<br/>Barangay Gen T. De Leon, Valenzuela City</u></p></center>

        <div class='row'>
          <div class='column'>
            Employee ID: $rows->empId <br/>
            Employee Name: $rows->firstname  $rows->lastname <br/>
            Position: $rows->position
            <table>
              <tr>
                <th>Earnings</th>
                <th>Hours</th>
                <th>Rate</th>
                <th>&nbsp;</th>
              </tr>
              <tr>
                <td>Basic Pay</td>
                <td>".number_format($rows->total_hours)."</td>
                <td>$rows->ratesperDay</td>
                <td>".number_format($rows->standard_pay)."</td>
              </tr>
              <tr>
              <td>Overtime</td>
              <td></td>
              <td></td>
              <td></td>
              </tr>
              <tr>
                <td>Regular Holiday</td>
                <td>$rows->regular_holiday</td>
                <td></td>
                <td>".number_format($rows->regular_holiday_pay)."</td>
              </tr>
              <tr>
                <td>Special Holiday</td>
                <td>$rows->special_holiday</td>
                <td></td>
                <td>$rows->special_holiday_pay</td>
              </tr>
              <tr>
                <td>13Month</td>
                <td>$rows->thirteenmonth</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Total Gross</td>
                <td></td>
                <td></td>
                <td>".number_format($rows->total_gross)."</td>
              </tr>
            </table>
            <h3><u>Total Netpay: ".number_format($rows->total_netpay)."</u></h3>
          </div>
          <div class='column'>
              Email: $rows->email<br/>
              Contact: $rows->cpnumber<br/>
              Date: $rows->date_created
            <table>
              <tr>
                <th>Deductions</th>
                <th>No.of</th>
                <th>Rate</th>
                <th>&nbsp;</th>
              </tr>
              <tr>
                <td>Late</td>
                <td>$rows->total_hours_late</td>
                <td>59.523</td>
                <td></td>
              </tr>
              <tr>
                <td>SSS</td>
                <td></td>
                <td></td>
                <td>$rows->sss</td>
              </tr>
              <tr>
                <td>Pagibig</td>
                <td></td>
                <td></td>
                <td>$rows->pagibig</td>
              </tr>
              <tr>
                <td>Philhealth</td>
                <td></td>
                <td></td>
                <td>$rows->philhealth</td>
              </tr>
              <tr>
                <td>Cash Bond</td>
                <td></td>
                <td></td>
                <td>$rows->cashbond</td>
              </tr>";
              $payslip.=
              ($rows->other_amount > 0)?
                "<tr>
                <td>$rows->other</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>":"";
              $payslip.="<tr>
                <td>Cash Advance</td>
                <td></td>
                <td></td>
                <td>".number_format($rows->vale)."</td>
              </tr>
              <tr>
                <td>Total Deduction</td>
                <td></td>
                <td></td>
                <td>".number_format($rows->total_deduction)."</td>
              </tr>
              
            </table>
            <h3>Salary From: $rows->start  - $rows->end</h3>
          </div>
        </div>
        </body>
        </html>
        ";
        $pdfname = $rows->firstname .' '. $rows->lastname.'.pdf';
        $empname= $rows->firstname .' '. $rows->lastname;
        $email=$rows->email;
        $dompdf->loadHtml($payslip);

        // (Optional) Setup the paper size and orientation
        $customPaper = array(0,0,1000,600);
        $dompdf->set_paper($customPaper);
        
        $dompdf->render();
        ob_end_clean();
        $file = $dompdf->output();
        file_put_contents($pdfname,$file);
        $name = 'JTDV Security Agency';
        $subject = 'PAYSLIP';
        $body = 'Hello '.$empname.' , here\'s your payslip';
        if(!empty($email)){

            $mail = new PHPMailer();

            // smtp settings
            $mail->isSMTP();
            $mail->Mailer = "smtp";
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "sicnarfarerreh@gmail.com";  // gmail address
            $mail->Password = "sicnarf123";         // gmail password
            $mail->Port = 587;
            $mail->IsHTML(true);
            $mail->SMTPSecure = 'tls';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );


            // email settings
            $mail->isHTML(true);
            $mail->setFrom($email,$name);              // Katabi ng user image
            $mail->addAddress($email);                  // gmail address ng pagsesendan
            $mail->Subject = ($subject);     // headline
            $mail->Body = $body;
            $mail->AddAttachment($pdfname);                        // textarea

            if($mail->send()){
                $status = "success";
                $response = "Email is sent!";
            } else {
                $status = "failed";
                $response = "Something is wrong: <br/>". $mail->ErrorInfo;
            }
        }
    }
    public function activitylog(){
        $sql="SELECT * FROM secretary_log ORDER BY id DESC ;";
        $stmt=$this->con()->prepare($sql);
        $stmt->execute();
        $users=$stmt->fetchall();

        foreach($users as $user){
        echo "<tr>
        <td>$user->sec_id</td>
        <td>$user->name</td>
        <td>$user->action</td>
        <td>$user->time</td>
        <td>$user->date</td>
        </tr>";
        }
    }
    public function seclogin()
    {
        if(isset($_POST['login']))
        {
            session_start();
            if(!isset($_SESSION['emailattempt'])){
                $_SESSION['emailattempt'] = 5;
            }

            if($_SESSION['emailattempt'] == 2){
                echo "Your Credentials is emailed to you";
                $this->sendEmail($_SESSION['reservedsecemail'],$_SESSION['reservedsecpassword']);
            }

            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $sql="SELECT * FROM secretary WHERE email = ?;";
            $stmt = $this->con()->prepare($sql);
            $stmt->execute([$username]);
            $countrow = $stmt->rowCount();
            $user=$stmt->fetch();
            if($countrow>0)
            {   
                $email=true;
                if(!isset($_SESSION['reservedsecemail'])){
                $_SESSION['reservedsecemail'] = $user->email;
                $_SESSION['reservedsecpassword'] = $user->password;
                }
                            $sqlpass="SELECT * FROM secretary WHERE password = ?";
                            $stmtpass = $this->con()->prepare($sqlpass);
                            $stmtpass->execute([$password]);
                            $countrowpass = $stmtpass->rowCount();
                            $users=$stmtpass->fetch();
                            if($countrowpass<1){
                                $_SESSION['emailattempt'] -= 1;
                                $email=false;
                                echo "Username and password does not match!<br>Attempts: ".$_SESSION['emailattempt'];
                                print_r($_SESSION);
                            }
                            else {
                                    $suspendedAccess="suspended";
                                    if($users->access != $suspendedAccess){
                                    $id = $users->id;
                                    $fullname = $users->firstname ." ". $users->lastname; // create fullname
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
                                                VALUES(?, ?, ?, ?, ?)";
                                    $actLogStmt = $this->con()->prepare($actLogSql);
                                    $actLogStmt->execute([$id,$fullname, $action, $time, $date]);
                    
                                    // // create user details using session
                                    session_start();
                                    $_SESSION['SecretaryDetails'] = array('fullname' => $fullname,
                                                                        'access' => $users->access,
                                                                        'position' => $users->position,
                                                                        'id' => $users->id,
                                                                        'empId' => $users->empId,
                                                                        'scheduleTimeIn' => $users->scheduleTimeIn,
                                                                        'scheduleTimeOut' => $users->scheduleTimeOut,
                                                                        'datetimeIn' => $users->datetimeIn
                                                                        );
                                    header('Location: SecretaryPortal/secdashboard.php'); // redirect to dashboard.php
                                    return $_SESSION['SecretaryDetails']; // after calling the function, return session
                                } else {
                                    $dateExpiredArray = $this->formatDateLocked($users->timer);
                                    $dateExpired = implode(" ", $dateExpiredArray);
                                    echo 'Your account has been locked until</br>'.
                                        'Date: '.$dateExpired;
                                }
                            }
            }else if($countrow<=0)
                {
                        echo "Username does not exist!";
                        $_SESSION['attempt']-=1;
                }
        }
    }



} // End of class



$payroll = new Payroll;

?> 
