<?php
    require_once('../secclass.php');
    $sessionData = $payroll->getSessionSecretaryData();
    $payroll->verifyUserAccess($sessionData['access'], $sessionData['fullname'],2);
    $fullname = $sessionData['fullname'];
    $access = $sessionData['access'];
    $id = $sessionData['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Salary</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../seccss/main.css">
    <title>Document</title>
</head>
<body>
<div class="cashadvance">
               <div class="cashadvance__header">
                    <h2>Cash Advance</h2>
               </div>
               <form action="" method="post">
                    <div class="cashadvance__form">
                         <div class="detail">
                         <?php $payroll->cashadvance($fullname,$id);?>
                              <label for="">Employee ID :</label>
                              <?php $sql ="SELECT empId,firstname,lastname FROM employee;";$stmt = $payroll->con()->prepare($sql); $stmt->execute(); $row = $stmt->fetchall(); echo "<select id= empid name=empid >"; foreach($row as $rows){echo "<option value=$rows->empId> $rows->empId $rows->firstname $rows->lastname</option>";}; ?><?php echo "</select>"; ?><br/><br/>
                         </div>
                         <div class="detail">
                              <label for="amount">Amount :</label>
                              <input type="number" name="amount" placeholder="Php">
                         </div>
                    </div>

                    <button type="submit" name="add">
                         Add
                    </button>
               </form>
          </div>
</body>
</html>