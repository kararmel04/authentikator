<?php

require __DIR__ . '/../vendor/autoload.php';

use OTPHP\TOTP;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use OTPHP\InternalClock;

class OTP {

    static private $clock;

    public function generateSecretAndQRCode($username) {

        // Création du TOTP
        $totp = TOTP::create(
            secret: null,
            period: 30,
            digits: 6,
            digest: 'sha256',
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
            $totp = TOTP::create( // on doit mettre exactement les mêmes params qu'à la création
                secret: $secret,
                period: 30,
                digits: 6,
                digest: 'sha256'
            );
            return [$totp->now(), $code, $totp->verify($code, null, 1), $clock]; // window à 1 pour la tolérance
        }
        catch(InvalidParameterException $e) {
            return $e->getMessage();
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }
}