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
    <title>Generate Deduction Modal</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../seccss/main.css">
</head>
<body>
<div class="main-containter">
    <div class="modal">
        <form action="" method="post" class=modal__form>
             <div class="modal__form__header1">
                    <h1>Generate Deduction</h1>
             </div>

             <div class="modal__form__content">

                  <div class="modal__form__content__spaces">
                       
                  </div>

                  <div class="modal__form__content__spaces">
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
                                        document.getElementById("deductionname").style.display = "block";
                                        document.getElementById("dedname").style.display = "block";
                                        document.getElementById("deductionname").style.display = "block";
                                        document.getElementById("dedamount").style.display = "block";
                                        document.getElementById("amount").style.display = "block";
                                        }else{
                                        document.getElementById("percentage").style.display = "block";
                                        document.getElementById("percentagelabel").style.display = "block";
                                        document.getElementById("deductionname").style.display = "none";
                                        document.getElementById("dedname").style.display = "none";
                                        document.getElementById("deductionname").style.display = "none";
                                        document.getElementById("dedamount").style.display = "none";
                                        document.getElementById("amount").style.display = "none";
                                        }
                                   }
                                   </script>
                              </select>
                  </div>
                  <?php $payroll->adddeduction($fullname,$id); ?>
                  <div class="modal__form__content__spaces">
                  <label for="percentage" style="display:block" id="percentagelabel">Percentage :</label> <br>
                  <input type="number" step="0.001" id="percentage" name="percentage" style="display:block"> 

                  <label for="deductionname" id="deductionname" style="display:none"> Name :</label> <br>
                  <input type="text" id="dedname" name="name" style="display:none" ><br>
                  <label for="amount" style="display:none" id="dedamount"> Amount :</label> <br>
                  <input type="number" name="amount" placeholder="Php" style="display:none" id="amount">
               
                  </div>

                  <button class="btn_danger" type="submit" name="generatededuction">
                    Generate Deduction
                  </button>

                  <button class="cancel" type="submit" name="cancelded">
                    Cancel
                  </button>
             </div>
        </form>
    </div>
</div>
</body>
</html>
