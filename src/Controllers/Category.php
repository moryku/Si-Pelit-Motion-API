<?php
/**
 * Commodity Controller
 * @author Robet Atiq Maulana Rifqi
 * JUNI 2019
 */

use Litbang\Config\Constants;
use Litbang\Helpers\Document;
use Litbang\Models\KategoriModel;
use Litbang\Systems\Request;
use Litbang\Systems\Response;

$this->get("", Kajian::class . ":getCategory");
$this->post("/add", Kajian::class . ":add");

class Category implements Constants
{

    public function __construct()
    {

        // Initialize
        $this->kategoriModel = new KategoriModel();
        $this->request = new Request();
        $this->response = new Response();
    }

    public function add($request, $response, $args)
    {
        $this->request->parse($request);

        $result = ( object )[];

        $upload = $this->_upload();

        if ($upload->code != self::SUCCESS) return $upload;

        $category = $this->kategoriModel->insertKategori([
            ":nama" => $this->request->get("category")
        ]);


        if ($category->code != self::SUCCESS) return $this->response->publish(null, $category->message, $category->code);

        // Return
        return $this->response->publish($category->data, "Success Adding Commodity", self::SUCCESS);
    }



    public function getCategory($request, $response, $args)
    {

        // Get Commodity List
        $kajian = ( array )$this->kategoriModel->getAllKategori();

        if ($kajian[0] == null) return $this->response->publish(null, "Category Not Found", self::NOT_FOUND);

        // Return
        return $this->response->publish($kajian, "Success Get Category", self::SUCCESS);
    }
}

?>