<?php

require __DIR__ . '/../vendor/autoload.php';

use OTPHP\InternalClock;
use OTPHP\TOTP;

class OTP {
    public function __construct() {
        $this->clock = new InternalClock();
    }

    public function generateSecret() {
        $totp = TOTP::generate($this->clock);
        $totp->setPeriod(30);
        $totp->setDigest('sha256');
        $totp->setDigits(6);
        return $totp->getSecret();
    }

    public static function verifyCode($secret, $code) {
        $totp = TOTP::createFromSecret($secret);
        return $totp->verify($code);
    }
}

$o = new OTP();
$sec = $o->generateSecret();
echo OTP::verifyCode($sec, '123456') ? "Code valide\n" : "Code invalide\n";
?>