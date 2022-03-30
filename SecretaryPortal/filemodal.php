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
                    <h1>Download Merged Payslip</h1>
             </div>
             <div class="modal__form__content">
                 <div class="generate-deduction_table">
                <table style="box-shadow: 5px 4px 30px rgba(0,0,0,.10);">
                    <thead style="background: linear-gradient(45deg, #614ad3, #e42c64);">
                    <th><h2>Files</h2></th>
                    </thead>
                    <tbody style="padding: 15px 20px;
                    font-size: 20px;
                    font-family:Sans-serif;
                    font-weight: normal;
                    background-color: #F4F6FA;">
                    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
                  <?php
                        $dir = "../SecretaryPortal/merged/";
                        // Open a directory, and read its contents
                        if ($handle = opendir($dir)) {
                            while (false !== ($entry = readdir($handle))) {
                                $dirarray[]=$entry;
                            }
                            $indexCount=count($dirarray);
                            closedir($handle);
                            // rsort($dirarray);
                            for($index=0; $index < $indexCount; $index++) 
                            {
                                if ($dirarray[$index] != "." && $dirarray[$index] != "..") {
                                    $dateniya = date('F j Y',filemtime($dir.$dirarray[$index]));
                                    echo "<tr><td>
                                    <i class='fas fa-file-pdf' style='font-size:19px;'></i> <a href='download.php?file=".$dirarray[$index]."'>".$dirarray[$index]."</a></td></tr>\n";
                                }
                            }
                        }
                ?>
                    </tbody>
                </table>
                    </div>
             </div>
             <center><a href="releasedsalary.php"><button class="cancel" type="button">
               Back</button></a></center>
        </form>
    </div>
</div>
</body>
</html>

