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
    <title></title>
</head>
<body>
<div class="emp-deductions">
               <div class="emp-deductions__header">
                    <h2>Generate Deductions</h2>
               </div>

               <div class="emp-deductions__form">
                    <form action="" method="post">
                         <div class="detail">
                              <label for="deduction">Deductions :</label> <br>
                              <select name="deduction" id="deduction" onchange="myFunction()">
                                   <option value="">Select Deduction</option>
                                   <option value="SSS">SSS</option>
                                   <option value="Pagibig">Pag-ibig</option>
                                   <option value="Philhealth">Philhealth</option>
                                   <option value="other">Other</option>
                                   <script>
                                   function myFunction() 
                                   {    
                                        var x = document.getElementById("deduction").value;
                                        if (x == "other"){
                                        document.getElementById("percentage").style.display = "none";
                                        document.getElementById("percentagelabel").style.display = "none";
                                        document.getElementById("other").style.display = "block";
                                        }else{
                                        document.getElementById("percentage").style.display = "block";
                                        document.getElementById("percentagelabel").style.display = "block";
                                        document.getElementById("other").style.display = "none";
                                        }
                                   }
                                   </script>
                              </select>
                         </div>

                         <div class="detail">
                              <label for="percentage" style="display:block" id="percentagelabel">Percentage :</label> <br>
                              <input type="number" step="0.001" id="percentage" name="percentage" style="display:block">
                         </div>

                         <div id="other" style="display:none">
                              
                              <div class="detail">
                              <label for="deductionname" id="deductionname"> Name :</label> <br>
                              <input type="text" id="dedname" name="name" ><br>
                              <label for="amount"> Amount :</label> <br>
                              <input type="number" name="amount" placeholder="Php">
                              </div>
                         </div>

                         <button type="submit" name="generatededuction">
                              Generate
                         </button>
                         <?php $payroll->adddeduction($fullname,$id); ?>
                    </form>
               </div>
          </div>
</body>
</html>