<?php

require 'OTP.php';

$json = json_decode(file_get_contents("php://input"));

$otp = new OTP();


header('Content-Type: application/json'); // renvoyer le JSON pour le JS
echo json_encode($otp->verifyCode($json->secret,$json->pin));