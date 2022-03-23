<?php
    require_once('../secclass.php');
    $sessionData = $payroll->getSessionSecretaryData();
    $payroll->verifyUserAccess($sessionData['access'], $sessionData['fullname'],2);
    $fullname = $sessionData['fullname'];
    $access = $sessionData['access'];
    $id = $sessionData['id'];
?>


<html lang="en">
     <head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Change Password</title>
          <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
          <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
          <link rel="stylesheet" type="text/css" href="../seccss/main.css">
      </head>
<body>
     <div class="main-container">

          <div class="sidebar">
               <div class="sidebar__logo">
                   <div class="logo"></div>
                   <h3>JDTV</h3>
               </div>
                    <nav>
                         <ul>
                              <li class="li__records">
                                   <a href="../SecretaryPortal/secdashboard.php" class="">DASHBOARD</a>
                              </li>
                              <li class="li__user">
                                   <a href="" class="active">User Profile</a>
                                   <ul>
                                        <li><a href="../SecretaryPortal/editsec.php" class="">Edit Profile</a></li>
                                        <li><a href="../SecretaryPortal/editsecpass.php" class="active">Change Password</a></li>
                                   </ul>
                              </li>
                         </ul>
                    </nav>
               <div class="sidebar__logout">
                   <div class="li li__logout"><a href="#">LOGOUT</a></div>
               </div>
          </div>

          <div class="page-info-head">
               User Profile
          </div>

          <div class="user-info">
               <p>Profile Name</p>
               <div class="user-profile">
               </div>
          </div>

          <div class="user_edit_profile_header">
               <h1>Change Password</h1>
          </div>

          <div class="changepassword-card">
               <div class="changepassword-card__form">
                    <label for="" >Username: </label>
                    <input type="text">

                    <label for="" name="">Old Password : </label>
                    <input type="text">

                    <label for="">New Password : </label>
                    <input type="text">

                    <label for="" >Confirm Password : </label>
                    <input type="text">

                    <p>Password must contains atleast 6 to 8 characters, Including Uppercase, Lowercase and Numbers.</p>

                    <button class="btn_primary">
                         <span class="material-icons"> description</span>
                         Save Password
                    </button>
               </div>
              <div class="changepassword-card__svg">
                   <object data="../SVG/changepass-svg.svg" type=""></object>
              </div>
          </div>
     </div>
</body>
</html>