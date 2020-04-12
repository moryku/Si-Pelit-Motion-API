<?php

namespace Litbang\Models;

use Litbang\Systems\Connection;

class KajianModel
{

    public function __construct()
    {
        $this->db = new Connection();
    }

    public function insertKajian($params)
    {
        var_dump($params); die;
        $this->db->query("INSERT INTO kajian(`judul`, `abstrak`, `user_id`, `url_kajian`, `category_id`, `date`, `jumlah_hal`, `image`)
                            VALUES(:judul, :abstrak, :user_id, :url_kajian, :kategori_id, :date, :jumlah_hal, :image)", $params);

        return $this->db->fetch();
    }


    public function getAllKajian()
    {
        $this->db->query("SELECT kajian.id, kajian.judul, kajian.abstrak, kajian.url_kajian, kajian.date, kajian.jumlah_hal,
                kajian.image,
                kategori.nama, user.id, user.name, user.address, user.phone, user.institusi, user.email FROM kajian 
                LEFT JOIN user 
                LEFT JOIN kategori 
                ON kajian.user_id = user.id 
                AND kategori.id = kajian.kategori_id");

        return $this->db->fetchAll();
    }

}

?>