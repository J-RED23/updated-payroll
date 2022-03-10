<?php
require_once('../class.php');

$sql3="SELECT * FROM holidays;";
$stmthol3 = $payroll->con()->prepare($sql3);
$stmthol3->execute();
$usershol3 = $stmthol3->fetchall();
$countRowhol3 =$stmthol3->rowCount();
$empid = 1002;
$specholiday =0;
$regholiday =0;
$sqlgetholiday = "SELECT * FROM emp_attendance WHERE empId = $empid;";
$stmtgetholiday = $payroll->con()->prepare($sqlgetholiday);
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
                    echo "REGULALR ". $regholiday . $holidateto."<br>";

                }else if(preg_match("/{$holidate->type}/i", $special))
                {
                    $specholiday +=  1;
                    echo "SPECIAL". $holidateto;
                }else {
                }

            }
    
    }
}
?>