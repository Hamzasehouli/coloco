<?php

declare(strict_types=1);

namespace coloco\helpers;

class GenerateJwt
{

    public function generateToken($id)
    {

        
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

       
        $payload = json_encode(['user_id' => $id, 'exp' => (time() + (120 * 60))]);


        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));


        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));


        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $_ENV['JWT_SECURE_KEY'], true);


        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));


        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
        return $jwt;
    }

    public static function verifyToken($jwt){
        $tokenParts = explode('.', $jwt);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signature_provided = $tokenParts[2];

        // check the expiration time - note this will cause an error if there is no 'exp' claim in the jwt
        $expiration = json_decode($payload)->exp;
        $id = json_decode($payload)->user_id;

        // $is_token_expired = ($expiration - time()) < 0;

        if ($expiration - time() < 0) {
            http_response_code(400);
            session_destroy();
            return print_r(json_encode(['status' => 'fail', 'message' => 'Login session is expired, please login again to contine']));
        }

        // build a signature based on the header and payload using the secret
        // Encode Header to Base64Url String {
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        // Encode Payload to Base64Url String
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
        // Create Signature Hash
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $_ENV['JWT_SECURE_KEY'], true);

        // Encode Signature to Base64Url String
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // verify it matches the signature provided in the jwt
        $is_signature_valid = ($base64UrlSignature === $signature_provided);
        return ['istokenValid'=>$is_signature_valid, 'userId'=>$id];

    }
};