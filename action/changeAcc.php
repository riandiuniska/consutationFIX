<?php 

require "../db/Acceptance.php";

$accId = $_POST['acc_id'];

$acc = new Acceptance;

$acc->updateStatus($accId);

echo 'sukses';


?>