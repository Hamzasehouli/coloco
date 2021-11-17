<?php

class UserModel
{
    private $id = '';
    private $firstname = '';
    private $lastname = '';
    private $username = '';
    private $email = '';
    private $role = '';
    private $password = '';
    private $created_at = '';

    public function find($con)
    {
        $query = 'SELECT * FROM user';
        $stmt = $con->prepare($query);
        return $stmt;
    }
    public function create($con)
    {
        $query = 'INSERT INTO user() VALUES(:username,:firstname,:lastname,:email,:password)';
        $stmt = $con->prepare($query);
        return $stmt;
    }
    public function findOne($con)
    {
        $query = 'SELECT * FROM user WHERE email=:email';
        $stmt = $con->prepare($query);
        return $stmt;
    }
    public function findById($con)
    {
        $query = 'SELECT * FROM user WHERE id=:id';
        $stmt = $con->prepare($query);
        return $stmt;
    }
    // public function findByIdAndDelete($con)
    // {

    // }
    // public function findByIdAndUpdate($con)
    // {

    // }

}