<?php
require_once('secclass.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    table {
        font-family: Arial, Helvetica, sans-serif; 
        border-collapse: collapse; 
        width: 100%;
    }

    table td, th {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 14px;
        text-align: center;
    }

    table > thead > tr:nth-child(even){background-color: #f2f2f2;}

    table > thead > tr:hover {background-color: #ddd;}

    table > thead > tr > th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: center;
        font-size: 10px;
        background-color: #04AA6D;
        color: white;
    }
</style>
<body>  <form method="post">
        <select name='empid'>
        <?php $sql="SELECT * FROM employee";
         $stmt = $payroll->con()->prepare($sql);
         $stmt->execute();
         $rows = $stmt->fetchall();
         $rowss = $stmt->fetch();
         foreach ($rows as $row)
         {
            echo " 
            <option value='$row->empId'>$row->firstname $row->lastname $row->empId</option>";
        }
        ?>
        </select>
        <select name='status'>
        <option value="paid">Paid</option>
        <option value="unpaid">Unpaid</option>
        </select>
        <button type="submit" name="select">Select</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Log</th>
                <th>EmpId</th>
                <th>DateTimeIn</th>
                <th>TimeIn</th>
                <th>DateTimeOut</th>
                <th>TimeOut</th>
                <th>Late</th>
                <th>Accumulated Time</th>
                <th>Overtime</th>
            </tr>
        </thead>
        <?php
        if(isset($_POST['select'])){
            $totallate=0;
            $totalovertime=0;
            $totalaccumulatedtime=0;
            $empid=$_POST['empid'];
            $status=$_POST['status'];
                $sqla="SELECT 
                emp_attendance.*,
                schedule.scheduleTimeIn,
                employee.ratesperDay,
                employee.firstname,
                employee.lastname,
                employee.overtime_rate
            FROM emp_attendance 
            LEFT JOIN schedule
            ON emp_attendance.empId = schedule.empId
            LEFT JOIN employee
            ON emp_attendance.empId = employee.empId
            WHERE emp_attendance.empId= ? AND emp_attendance.salary_status = ?;";
    $stmta = $payroll->con()->prepare($sqla);
    $stmta->execute([$empid,$status]);
    $overtime = "No overtime";
    $userss= $stmta->fetchall();
                    $regholidaybasicpay = 0;
                    $regholiday = 0;
                    $regholidayotpay = 0;
                    $regholidayot = 0;
                    $regholidaypay = 0;
                    $specholidaybasicpay = 0;
                    $specholiday = 0;
                    $specholidayotpay = 0;
                    $specholidayot = 0;
                    $specholidaytotal = 0;
                    $totalaccumulated=0;
                    $valueOvertime=0;
    foreach ($userss as $users) {
        date_default_timezone_set("Asia/Manila");

            $getdateTimeIn = strtotime($users->timeIn);
            $getdateTimeOut = strtotime($users->timeOut);
            $empdatein = date ('F d' , strtotime($users->datetimeIn));
            $empdateout = date ('F d' , strtotime($users->datetimeOut));
            $regular = "regular holiday";
            $special = "special holiday";
            $sql3="SELECT * FROM holidays;";
            $stmthol3 = $payroll->con()->prepare($sql3);
            $stmthol3->execute();
            $usershol3 = $stmthol3->fetchall();
            foreach($usershol3 as $holidate)
            {
                $holidateto = date('F d',strtotime($holidate->date_holiday));
                if(preg_match("/{$empdatein}/i", strtolower($holidateto)) OR preg_match("/{$empdateout}/i", strtolower($holidateto)))
                {   
                    if(preg_match("/{$holidate->type}/i", $regular))
                    {
                        $regholiday += number_format($totalaccumulatedstime);
                        $regholidayot += number_format($valueOvertime);
                        echo "Holiday: $holidate->type $holidate->date_holiday $holidate->name";
                    }else if(preg_match("/{$holidate->type}/i", $special))              //detect holidays
                    {
                        $specholiday += number_format($totalaccumulated);
                        $specholidayot += number_format($valueOvertime);
                        echo "Holiday: $holidate->type $holidate->date_holiday $holidate->name";
                    }else {
                        
                    }
                }
            }

            $diff =  $getdateTimeOut - $getdateTimeIn;
            $interval = $diff / (60*60); 

                $StandardSchedule = date("h:i:s A", strtotime($users->scheduleTimeIn) + 8*60*60); 
                $diff2 = $getdateTimeOut - strtotime($StandardSchedule);

                    if ($interval <= 8) {
                        $valueOvertime = 0;
                        $overtime = 0;
                        $overtimerate = 0;
                    } else {
                        $valueOvertime = floatval($diff2 / (60*60)); 
                        $totalovertime +=$valueOvertime;
                        $overtimerate = 0;
                    }

                    if($valueOvertime) {
                        $overtime = $valueOvertime;
                    }

                $diffAccumulated = strtotime($StandardSchedule) - $getdateTimeIn;
                $valueAccumulatedTime = $diffAccumulated / (60*60);

                    if($valueAccumulatedTime) {
                        $accumulatedtime = $valueAccumulatedTime;
                        $totalaccumulatedtime +=  $accumulatedtime;
                    }

                $diffLate = $getdateTimeIn - strtotime($users->scheduleTimeIn);
                $valueLate = $diffLate / 60; 

                    if ($valueLate == 0) { 
                        $late = 0;
                    } else {
                        $late = $diffLate / 60;
                        $totallate += $late;
                    }

            echo "<tr>
                    <td>$users->id</td>
                    <td>$users->empId</td>
                    <td>$users->datetimeIn</td>
                    <td>$users->timeIn</td>
                    <td>$users->datetimeOut</td>
                    <td>$users->timeOut</td>
                    <td>$late $regholiday</td>
                    <td>".number_format($accumulatedtime,2)."</td>
                    <td>".number_format($overtime,2)."</td>
                <tr>";
    }
            echo "<thead><tr>
                <th>TOTAL</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>$totallate mins</th>
                <th>".number_format($totalaccumulatedtime)." hrs</th>
                <th>".number_format($totalovertime)." hrs</th>
                </tr></thead>";
                $stmta->execute([$empid,$status]);
                $rowss=$stmta->fetch();
            echo "<h3>$rowss->firstname $rowss->lastname <br>
            Rate: $rowss->ratesperDay <br>
            Overtime Rate: $rowss->overtime_rate <br></h3>";
            echo "<h1><tr>Computation for Late:&emsp;&emsp;&emsp;&emsp;"  .$totallate."mins x ".$rowss->ratesperDay / 60 ." = ".($totallate * ($rowss->ratesperDay/60))."</tr><br>
            <tr>Computation for Basic Pay:&emsp;&emsp;"   .number_format($totalaccumulatedtime)."hrs x ".$rowss->ratesperDay." = ".number_format($totalaccumulatedtime) * $rowss->ratesperDay."</tr></br>
            <tr>Computation for Overtime: &emsp;&emsp;".number_format($totalovertime)."hrs x ".$rowss->overtime_rate." = ".number_format($totalovertime) * $rowss->overtime_rate."</tr>";
}
?>
    </table>
    <!-- <form method="post"><button type="submit" name="merge">Merge</button></form> <?php if(isset($_POST['merge'])){ $payroll->mergepdf(); }?> -->
</body>
</html>