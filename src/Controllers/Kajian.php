<?php
/**
 * Commodity Controller
 * @author Robet Atiq Maulana Rifqi
 * JUNI 2019
 */

use Litbang\Config\Constants;
use Litbang\Helpers\Document;
//    use Litbang\Middlewares\Filter;
use Litbang\Models\KajianModel;
use Litbang\Systems\Request;
use Litbang\Systems\Response;

$this->get("/{kajianId}", Kajian::class . ":detail");
$this->get("", Kajian::class . ":getKajians");
$this->post("/search", Kajian::class . ":search");
$this->post("/add", Kajian::class . ":add");
$this->post("/edit", Kajian::class . ":edit");
$this->post("/delete", Kajian::class . ":delete");
$this->post("/document/add", Kajian::class . ":addDocument");
$this->post("/document/delete", Kajian::class . ":deleteDocument");

class Kajian implements Constants
{

    public function __construct()
    {

        // Initialize
        $this->document = new Document();
        $this->kajianModel = new KajianModel();
        $this->request = new Request();
        $this->response = new Response();
    }

    public function add($request, $response, $args)
    {
        $this->request->parse($request);

        $result = ( object )[];

        $upload = $this->_upload();

        if ($upload->code != self::SUCCESS) return $upload;

        $kajian = $this->kajianModel->insertKajian([
            ":user_id" => $this->request->get("user_id"),
            ":date" => date("Y-m-d") . " " . date("H:i:s"),
            ":judul" => $this->request->get("judul"),
            ":abstrak" => $this->request->get("abstrak"),
            ":url_kajian" => $this->request->get("document"),
            ":kategori_id" => $this->request->get("kategori_id")
        ]);

        if ($kajian->codes == self::SUCCESS) {

            // Set Commodity Document
            $kajian->document = $this->image->get("commodity", $kajian->document);
        }

        // Set result code
        $result->code = $kajian->codes;

        // unseting code
        unset ($kajian->codes);

        switch ($result->code) {

            case self::SUCCESS:
                $result->data = $kajian;
                break;

            case self::NOT_FOUND:
                $result->message = "Kajian not found";
                break;

            case self::FORBIDEN:
                $result->message = "Illegal Access!";
                break;
        }

        return $result;

        if ($kajian->code != self::SUCCESS) return $this->response->publish(null, $kajian->message, $kajian->code);

        // Return
        return $this->response->publish($kajian->data, "Success Adding Commodity", self::SUCCESS);
    }


    private function _upload()
    {

        if ($_FILES["document"] != null) {

            // Uploading image
            $upload = $this->document->upload($_FILES['document'], "kajian");

            if ($upload->code != self::SUCCESS) return $upload;

            // Set Images
            $this->request->set("document", $upload->path);
        }

        return ( object )["code" => self::SUCCESS];
    }


    public function getKajians($request, $response, $args)
    {

        // Get Commodity List
        $kajian = ( array )$this->kajianModel->getAllKajian();

        if ($kajian[0] == null) return $this->response->publish(null, "Commodities Not Found", self::NOT_FOUND);

        // Return
        return $this->response->publish($kajian, "Success Get Commodity", self::SUCCESS);
    }
}

?>