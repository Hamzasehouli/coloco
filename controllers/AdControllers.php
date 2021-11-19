<?php

namespace coloco\controllers;

use coloco\models\Admodel;

class AdControllers
{
    public static function getAds()
    {
        $ads = Admodel::find();
        if (!isset($ads)) {
            return;
        }

        http_response_code(200);
        print_r(json_encode(['status' => 'success', 'results' => count($ads), 'data' => $ads]));
    }
    public static function createAd()
    {$user = AuthControllers::isLoggedin();
        $body = json_decode(file_get_contents('php://input', true), true);
        $data = ['title' => $body['title'],
            'city' => $body['city'],
            'category' => $body['category'],
            'rent_type' => $body['rent_type'],
            'district' => $body['district'],
            'street' => $body['street'],
            'house_number' => $body['house_number'],
            'zip' => $body['zip'],
            'available_from' => $body['available_from'],
            'available_to' => $body['available_to'],
            'size' => $body['size'],
            'floor' => $body['floor'],
            'price' => $body['price'],
            'deposit' => $body['parking'],
            'description' => $body['description'],
            'i_am' => $body['i_am'],
            'wash_machine' => $body['wash_machine'],
            'dishwasher' => $body['dishwasher'],
            'terrace' => $body['terrace'],
            'tv' => $body['tv'],
            'parking' => $body['parking'],
            'balcony' => $body['balcony'],
            'garden' => $body['garden'],
            'elevator' => $body['elevator'],
            'pets_allowed' => $body['pets_allowed'],
            'bathroom' => $body['bathroom'],
            'kitchen' => $body['kitchen'],
            'furnished' => $body['furnished'],
            'shower' => $body['shower'],
        ];
        $data['userId'] = $user['id'];
        $ad = AdModel::create($data);
        if (!isset($ad)) {
            return;
        }

        http_response_code(201);
        print_r(json_encode(['status' => 'success', 'data' => $ad]));

    }
    public static function getAd()
    {
        extract($_GET);
        if (!isset($id)) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Id of the ad is missing']));
            return;
        }
        $ad = AdModel::findById($id);
        if (!isset($ad)) {
            return;
        }

        http_response_code(200);
        print_r(json_encode(['status' => 'success', 'data' => $ad]));
    }
    public static function updateAd()
    {
        AuthControllers::isLoggedin();
        $body = json_decode(json_encode(json_decode(file_get_contents('php://input', true))), true);
        extract($_GET);
        if (!isset($id)) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Id of the ad is missing']));
            return;
        }
        if (!isset($body)) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'No input has been entered']));
            return;
        }
        AdModel::findByIdAndUpdate($id, $body);
    }
    public static function deleteAd()
    {AuthControllers::isLoggedin();
        extract($_GET);
        if (!isset($id)) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Id of the ad is missing']));
            return;
        }
        AdModel::findByIdAndDelete($id);
    }
}