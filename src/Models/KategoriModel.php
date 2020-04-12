<?php

namespace Litbang\Models;

use Litbang\Systems\Connection;

class KategoriModel
{

    public function __construct()
    {
        $this->db = new Connection();
    }

    public function insertKategori($params)
    {
        $this->db->query("INSERT INTO kategori(`nama`)
                            VALUES(:nama)", $params);

        return $this->db->fetch();
    }


    public function getAllKategori()
    {
        $this->db->query("SELECT id, nama FROM kategori");

        return $this->db->fetchAll();
    }

}

?>