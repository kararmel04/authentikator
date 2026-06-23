<?php

require __DIR__ . '/../vendor/autoload.php';

use OTPHP\TOTP;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class OTP {

    public function generateSecretAndQRCode($username) {

        // Création du TOTP
        $totp = TOTP::create(
            secret: null,
            period: 30,
            digits: 6,
            digest: 'sha256'
        );

        $totp->setLabel($username);        // pseudo du client/vendeur
        $totp->setIssuer("AuthentikATOR"); // j'avais pas d'inspi

        $secret = $totp->getSecret();
        $uri = $totp->getProvisioningUri();

        // Génération du QR Code en base64
        $options = new QROptions([
            'outputType' => 'png', // pour l'affichage sinon EXPLOSION
            'scale' => 5,
        ]);

        $qrcode = (new QRCode($options))->render($uri);

        return [
            'secret' => $secret,
            'qrcode' => $qrcode
        ];
    }

    public static function verifyCode($secret, $code) {
        $totp = TOTP::createFromSecret($secret);
        return $totp->verify($code);
    }
}