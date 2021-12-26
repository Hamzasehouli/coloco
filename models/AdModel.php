<?php

declare(strict_types=1);

namespace coloco\models;

use coloco\config\Database;

$con = Database::connect();

class AdModel
{
    //get ads
    public static function find()
    {

        global $con;
        $query = 'SELECT * FROM ad';
        $stmt = $con->prepare($query);
        $stmt->execute();
        $row = $stmt->rowCount();
        if ($row < 1) {
            http_response_code(404);
            print_r(json_encode(['status' => 'fail', 'message' => 'No ads found']));
            return;
        }
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $results;
    }
    //create an ad
    public static function create($data)
    {
        extract($data);
        global $con;

        if (empty(str_replace(' ', '', $title))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter the title of the ad']));
            return;
        }
        if (empty(str_replace(' ', '', $userId))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'User id is missing']));
            return;
        }
        if (empty(str_replace(' ', '', $shower))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter if there is a shower']));
            return;
        }
        if (empty(str_replace(' ', '', $furnished))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter the lodgment is furnished']));
            return;
        }
        if (empty(str_replace(' ', '', $kitchen))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter if there is a kitchen']));
            return;
        }
        if (empty(str_replace(' ', '', $bathroom))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter if there is a bathroom']));
            return;
        }
        if ($tv === '') {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter if tv is available']));
            return;
        }
        if ($pets_allowed === '') {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter if pets are allowed']));
            return;
        }
        if ($elevator === '') {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter if there is an elevator']));
            return;
        }
        if ($garden === '') {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter if there is a garden']));
            return;
        }
        if ($balcony === '') {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter if there is a balcony']));
            return;
        }
        if ($terrace === '') {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter if there is a terrace']));
            return;
        }
        if ($dishwasher === '') {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter if there is a dishwasher']));
            return;
        }
        if ($wash_machine === '') {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter if there is a wash machine']));
            return;
        }
        // if (empty(str_replace(' ', '', $photos))) {
        //     http_response_code(403);
        //     print_r(json_encode(['status' => 'fail', 'message' => 'Please upload at least three photo']));
        //     return;
        // }
        // if (empty(str_replace(' ', '', $photo))) {
        //     http_response_code(403);
        //     print_r(json_encode(['status' => 'fail', 'message' => 'Please provide a main photo']));
        //     return;
        // }
        if (empty(str_replace(' ', '', $i_am))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter your status']));
            return;
        }
        if ($deposit === '') {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter how much the deposit is, if there is no deposit, write 0']));
            return;
        }
        if (empty(str_replace(' ', '', $description))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please describe your ad']));
            return;
        }
        if (str_replace(' ', '', $price) === '') {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter the total rent']));
            return;
        }
        if (str_replace(' ', '', $parking) === '') {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter if parking is available']));
            return;
        }
        if (str_replace(' ', '', $floor) === '') {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter floor level']));
            return;
        }
        if (empty(str_replace(' ', '', $size))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter the area']));
            return;
        }
        if (empty(str_replace(' ', '', $available_from))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter from when the lodgement is available']));
            return;
        }
        if (empty(str_replace(' ', '', $available_to))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter until when the lodgement is available']));
            return;
        }
        if (empty(str_replace(' ', '', $house_number))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter the house number']));
            return;
        }
        if (empty(str_replace(' ', '', $zip))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter a valid zip code']));
            return;
        }

        if (empty(str_replace(' ', '', $category))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter the category']));
            return;
        }
        if (empty(str_replace(' ', '', $rent_type))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter rent type']));
            return;
        }
        if (empty(str_replace(' ', '', $city))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter the city']));
            return;
        }
        if (empty(str_replace(' ', '', $district))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter the district']));
            return;
        }
        if (empty(str_replace(' ', '', $street))) {
            http_response_code(403);
            print_r(json_encode(['status' => 'fail', 'message' => 'Please enter the street']));
            return;
        }

        $query = 'INSERT INTO ad(title, city, category, rent_type, district, street, house_number, zip, available_from, available_to, size, floor, parking, price,
        deposit, description, i_am,  wash_machine, dishwasher, terrace, balcony, garden, elevator, pets_allowed, tv, bathroom,
        kitchen, furnished, shower, user) VALUES(:title, :city, :category, :rent_type, :district, :street, :house_number, :zip, :available_from, :available_to, :size, :floor, :parking, :price,
        :deposit, :description, :i_am, :wash_machine, :dishwasher, :terrace, :balcony, :garden, :elevator, :pets_allowed, :tv, :bathroom,
        :kitchen, :furnished, :shower, :userId)';
        $stmt = $con->prepare($query);
        foreach ($data as $k => $v):
            $stmt->bindValue(":$k", $v);
        endforeach;

        if ($stmt->execute()) {

            return 'Ad created successfully';
        } else {
            http_response_code(500);
            print_r(json_encode(['status' => 'fail', 'message' => 'Something went wrong']));
            return;
        }
    }
    public static function findOne($data)
    {
        extract($data);
        $keys = array_keys($data);
        global $con;
        $query = 'SELECT * FROM user WHERE ' . implode(',', array_map(function ($k) {
            return "$k=:$k";
        }, $keys));
        $stmt = $con->prepare($query);
        foreach ($data as $k => $v):
            $stmt->bindValue(":$k", $v);
        endforeach;
        $stmt->execute();
        $row = $stmt->rowCount();
        if ($row < 1) {
            http_response_code(404);
            print_r(json_encode(['status' => 'fail', 'message' => 'No user found, or the credentials are incorrect']));
            return;
        }
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $user;
    }

    public static function findById($id)
    {
        global $con;
        $query = 'SELECT * FROM ad WHERE id=:id';
        $stmt = $con->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->rowCount();
        if ($row < 1) {
            http_response_code(404);
            print_r(json_encode(['status' => 'fail', 'message' => 'No ad found with given id']));
            return;
        }
        $ad = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $ad;
    }
    public static function findByIdAndDelete($id)
    {
        global $con;
        $query = 'SELECT * FROM ad WHERE id=:id';
        $stmt1 = $con->prepare($query);
        $stmt1->bindValue(':id', $id);
        $stmt1->execute();
        $row = $stmt1->rowCount();
        if ($row < 1) {
            http_response_code(404);
            print_r(json_encode(['status' => 'fail', 'message' => 'No ad found']));
            return;
        }
        //////////////////7
        $query = 'DELETE FROM ad WHERE id=:id';
        $stmt = $con->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        http_response_code(204);
        print_r(json_encode(['status' => 'success', 'message' => 'ad has been deleted successfully']));
        return;

    }
    public static function findByIdAndUpdate($id, $data)
    {

        global $con;
        $query = 'SELECT * FROM ad WHERE id=:id';
        $stmt1 = $con->prepare($query);
        $stmt1->bindValue(':id', $id);
        $stmt1->execute();
        $row = $stmt1->rowCount();
        if ($row < 1) {
            http_response_code(404);
            print_r(json_encode(['status' => 'fail', 'message' => 'No ad found']));
            return;
        }
        ////////////////////////
        $keys = array_keys($data);
        $str = implode(',', array_map(function ($d) {
            return "$d=:$d";
        }, $keys));
        $query = 'UPDATE ad SET ' . $str . ' WHERE id=:id';
        $stmt = $con->prepare($query);
        foreach ($data as $d => $v):
            $stmt->bindValue(":$d", $v);
        endforeach;
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        http_response_code(200);
        print_r(json_encode(['status' => 'success', 'message' => 'ad has been updated successfully']));
        return;
    }

}