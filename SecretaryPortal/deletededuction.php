<?php
require_once('../class.php');
$id=$_GET['logid'];
$payroll->deletededuction($id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Deduction</title>
</head>
<body>
<div class="main-containter">
    <div class="modal">
        <form method="post" class="modal__delete">
            <div class="modal__delete__header1">
                <h1>Delete Deduction</h1>
            </div>

            <div class="modal__delete__content">
                <h1>Are you sure you want to delete this Deduction?</h1>
                <button class="btn_danger" type="submit" name="deletededuction">
                    Delete
                </button>
            </div>

            <div class="modal__delete__content">
                <button class="cancel" type="submit" name="cancel">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
