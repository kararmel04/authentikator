<?php

require 'OTP.php';

//print_r($_POST);

$otp = new OTP();
$data = $otp->generateSecretAndQRCode("toto"); // à stocker en BDD

header('Content-Type: application/json'); // renvoyer le JSON pour le JS
echo json_encode($data);