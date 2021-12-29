<?php

declare(strict_types=1);

namespace coloco\controllers;

use coloco\models\Admodel;
use coloco\helpers\ErrorHandler;
class AdControllers
{
    public static function getAds()
    {
        $ads = Admodel::find();
        if (!isset($ads)) {
            ErrorHandler::run(statusCode:400, message:'No ads found');
        }
        http_response_code(200);
        echo(json_encode(['status' => 'success', 'results' => count($ads), 'data' => $ads]));
    }

    public static function createAd()
    {
        $userArray = AuthControllers::isLoggedin();
       
        if (!empty($_FILES['image']['tmp_name'])) {
            $generateImageName = function ($num) {
                $chars = '1234567890QWERTZUIOPLKJHGFDSAYXCVBNMqwertzuioplkjhgfdsayxcvbnm';
                $imageName = $chars[3];
                $charsLen = strlen($chars);
                // echo $randoNum;
                for ($i = 0; $i <= $num; $i++) {
                    $randoNum = rand(1, $charsLen);
                    $imageName .= $chars[$randoNum];
                }
                return $imageName;
            };
    
            $imageName = $generateImageName(20);
    
            move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . '/public/ads/images/' . $imageName . '.png');
        }else{
            ErrorHandler::run(statusCode:400, message:'Please upload cover image');
        }
        

        $body = json_decode(file_get_contents('php://input', true), true);
        if(!$body){
            ErrorHandler::run(statusCode:400, message:'Please fill the required fields');
        }

        extract($body);

        if (!isset($description) || !is_string($description) || empty(str_replace(' ', '', $description) )) {
            ErrorHandler::run(statusCode:400, message:'Please describe your ad');
        }

        if (!isset($title) || !is_string($title) || empty(str_replace(' ', '', $title))) {
            ErrorHandler::run(statusCode:400, message:'Please enter the title of the ad');
        }
        if (!isset($city) || !is_string($city) || empty(str_replace(' ', '', $city))) {
            ErrorHandler::run(statusCode:400, message:'Please enter the city of the ad');
        }
        if (!isset($district) || !is_string($district) || empty(str_replace(' ', '', $district))) {
            ErrorHandler::run(statusCode:400, message:'Please enter the district of the ad');
        }
        if (!isset($street) || !is_string($street) || empty(str_replace(' ', '', $street))) {
            ErrorHandler::run(statusCode:400, message:'Please enter the street of the ad');
        }
        // if (!isset($image) || !is_string($image) || empty(str_replace(' ', '', $image))) {
        //     ErrorHandler::run(statusCode:400, message:'Please enter the image of the ad');
        // }

        if (!isset($furnished)|| !is_bool($furnished)) {
            ErrorHandler::run(statusCode:400, message:'Please enter the lodgement is furnished');
        }

        if (!isset($deposit) || !is_int($deposit)) {
            ErrorHandler::run(statusCode:400, message:'Please enter how much the deposit is, if there is no deposit, write 0');
        }
        if (!isset($price) || !is_int($price)) {
            ErrorHandler::run(statusCode:400, message:'Please enter the rent price');
        }
        if (!isset($floor) || !is_int($floor)) {
            ErrorHandler::run(statusCode:400, message:'Please enter floor level');
        }
        if (!isset($size) || !is_int($size)) {
            ErrorHandler::run(statusCode:400, message:'Please enter the area size');
        }
        if (!isset($house_number) || !is_int($house_number)) {
            ErrorHandler::run(statusCode:400, message:'Please enter the house number');
        }
        if (!isset($zip) || !is_int($zip)) {
            ErrorHandler::run(statusCode:400, message:'Please enter the area size');
        }
        if (!isset($available_from) || !is_string($available_from) || empty(str_replace(' ', '', $available_from))) {
            ErrorHandler::run(statusCode:400, message:'Please enter from when the lodgement is available');
        }
        if (!isset($available_to) || !is_string($available_to) || empty(str_replace(' ', '', $available_to))) {
            ErrorHandler::run(statusCode:400, message:'Please enter until whene the lodgement is available');
        }
        if (isset($data['user'])) {
            ErrorHandler::run(statusCode:400, message:'something went wrong');
        }
        

        $data = ['title' => $body['title'],
            'city' => $body['city'],
            // 'category' => $body['category'],
            // 'rent_type' => $body['rent_type'],
            'district' => $body['district'],
            'street' => $body['street'],
            'house_number' => $body['house_number'],
            'zip' => $body['zip'],
            'available_from' => $body['available_from'],
            'available_to' => $body['available_to'],
            'size' => $body['size'],
            'floor' => $body['floor'],
            'price' => $body['price'],
            'deposit' => $body['deposit'],
            'description' => $body['description'],
            // 'i_am' => $body['i_am'],
            // 'wash_machine' => $body['wash_machine'],
            // 'dishwasher' => $body['dishwasher'],
            // 'terrace' => $body['terrace'],
            // 'tv' => $body['tv'],
            // 'parking' => $body['parking'],
            // 'balcony' => $body['balcony'],
            // 'garden' => $body['garden'],
            'elevator' => $body['elevator'],
            // 'pets_allowed' => $body['pets_allowed'],
            // 'bathroom' => $body['bathroom'],
            // 'kitchen' => $body['kitchen'],
            'furnished' => $body['furnished'],
            'image' => $imageName,
            // 'shower' => $body['shower'],
        ];
        $data['user'] = $userArray['id'];
        AdModel::create($data);
        

    }
    public static function getAd()
    {
        extract($_GET);
        if (!isset($id)) {
            ErrorHandler::run(statusCode:404, message:'Id of the ad is missing');
        }
        $ad = AdModel::findById((string) $id);
        if (!isset($ad)) {
            ErrorHandler::run(statusCode:404, message:'No ad found with that id');
        }

        http_response_code(200);
        echo(json_encode(['status' => 'success', 'data' => $ad]));
    }
    public static function updateAd()
    {
        $user = AuthControllers::isLoggedin();
        $body = json_decode(json_encode(json_decode(file_get_contents('php://input', true))), true);
        extract($_GET);
        if (!isset($id)) {
            ErrorHandler::run(statusCode:404, message:'Id of the ad is missing');
        }
        if (!$body) {
            ErrorHandler::run(statusCode:404, message:'Please fill all the required fields');
        }
        AdModel::findByIdAndUpdate($id, $body, $user);
    }
    public static function deleteAd()
    {
        $user = AuthControllers::isLoggedin();
        extract($_GET);
        if (!isset($id)) {
            ErrorHandler::run(statusCode:404, message:'Id of the ad is missing');
        }
        AdModel::findByIdAndDelete($id, $user);
    }
}