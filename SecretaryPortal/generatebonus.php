<?php
require_once('../secclass.php');
$sessionData = $payroll->getSessionSecretaryData();
$payroll->verifyUserAccess($sessionData['access'], $sessionData['fullname'],2);
$fullname = $sessionData['fullname'];
$payroll->createbonus();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>13 Month Pay</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../seccss/main.css">
</head>
<body>
<div class="main-container">
        <div class="modal">
            <form action="" method="post" class=modal__form>
            <div class="modal__form__header1">
                    <h1>Generate 13 Month Pay</h1>
             </div>
                <div class="generate-deduction-table">
                    <div class="generate-deduction-table__header">
                        <h1><?php echo "Year ".date("Y"); ?> </h1>
                        <button type="submit" name="bonus">Generate</button>
                    </div>
                    <div class="generate-deduction-table__content">
                        <table>
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Date Started</th>
                                        <th>Length of Employment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $payroll->displaybonus()  ?>
                                </tbody>
                        </table>
                    </div>
                </div>
                <center><button class="cancel" type="submit" name="cancel">
                    Back
                </button></center>
            </form>
        </div>
</div>
</body>
</html>