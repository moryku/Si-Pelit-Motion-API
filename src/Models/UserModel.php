<?php

namespace Litbang\Models;

use Litbang\Systems\Connection;

class UserModel
{

    public function __construct()
    {
        $this->db = new Connection();
    }

    public function insertUser($params)
    {
        $this->db->query("INSERT INTO user(`name`, `address`, `phone`, `institusi`, `email`, `token`, `password`) 
                            VALUES(:name, :address, :phone, :institusi, :email, :token, :password)", $params);

        return $this->db->fetch();
    }


    public function getAllUser()
    {

        $this->db->query("SELECT id, name, address, phone, institusi, email, token FROM user");

        return $this->db->fetchAll();
    }

}

?>