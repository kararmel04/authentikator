<?php

require __DIR__ . '/../vendor/autoload.php';

use OTPHP\TOTP;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use OTPHP\InternalClock;

class OTP {

    static private $clock;

    public function generateSecretAndQRCode($username) {

        $clock = (new InternalClock());

        // Création du TOTP
        $totp = TOTP::create(
            secret: null,
            period: 30,
            digits: 6,
            digest: 'sha256',
            clock: $clock,
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
        try{
            $totp = TOTP::createFromSecret($secret, $clock);
            //return $totp->verify($code, null, 10);
            return [$totp->now(), $code, $totp->verify($code, null, 20), $clock];
        }
        catch(InvalidParameterException $e) {
            return $e->getMessage();
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }
}