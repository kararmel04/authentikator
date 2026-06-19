<?php

require __DIR__ . '/../vendor/autoload.php';

use OTPHP\InternalClock;
use OTPHP\TOTP;

$clock = new InternalClock();
$otp  = TOTP::generate($clock);
echo "The OTP secret is: {$otp->getSecret()}\n";

?>