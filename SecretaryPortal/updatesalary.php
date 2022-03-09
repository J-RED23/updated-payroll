<?php
require_once('../class.php');
$sessionData = $payroll->getSessionSecretaryData();
$payroll->verifyUserAccess($sessionData['access'], $sessionData['fullname'],2);
$fullname = $sessionData['fullname'];
$access = $sessionData['access'];
$id = $sessionData['id'];
$log=$_GET['logid'];
$payroll->updateSalary($id,$fullname);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Salary</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
    <div class="main-container">
        <div class="modal">
            <form action="" method="post" class="modal__form">
                <div class="modal__form__header1">
                    <h1>Update Salary</h1>
                </div>

                <div class="modal__form__content__spaces">
                    <label for="" class="user">Employee ID :</label>
                    <?php $sql ="SELECT * FROM employee INNER JOIN generated_salary ON employee.empId = generated_salary.emp_id WHERE generated_salary.log = ?;";
                    $stmt = $payroll->con()->prepare($sql); $stmt->execute([$log]); 
                    $rows = $stmt->fetch(); 
                    echo "<select id= select-state name=empid placeholder= Pick a state...><option value=$rows->empId> $rows->empId $rows->firstname $rows->lastname</option></select>";?>
                </div>

                <div class="modal__form__content__spaces">
                    <label for="" class="user">Name :</label>
                    <input type="text">
                </div>

                <div class="modal__form__content__spaces">
                    <label for="" class="user">Name :</label>
                    <input type="text">
                </div>

                <div class="modal__form__content__spaces">
                    <label for="" class="user">Name :</label>
                    <input type="text">
                </div>

                <div class="modal__form__content__spaces">
                    <label for="" class="user">Name :</label>
                    <input type="text">
                </div>
            </form>
        </div>
    </div>
</body>
</html>