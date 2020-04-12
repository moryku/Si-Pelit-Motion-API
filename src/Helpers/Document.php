<?php

/**
 * Document Helper
 * @author Robet Atiq Maulana Rifqi
 * JUN 2019
 */

namespace Litbang\Helpers;

use Litbang\Config\Constants;

class Document implements Constants
{

    /**
     * Defining private component
     */
    private $type = ["/pdf"];

    private $path = "../../storage/";
    private $uri = "storage/";


    public function upload($document, $path)
    {
        $error =  $document['error'];
        $type = $document['type'];
        $documentName = $document['name'];
        $tmp = $document['tmp_name'];

        /** Returning error when error is found */
        if ($error) return ( object ) [ "code" => self::ERROR, "message" => "Error uploading image"];

        /**
         * Generating image name
         * Generating image dir
         */
        $exploder = explode(".", $documentName);
        $name = hash( "sha256", date ( "YmdHis" ) . $exploder[0] ) . "." . $exploder[1];

        /**
         * Checking image path
         * if path doesn't exist it will create that path
         */
        if ( !file_exists( $this->path )) mkdir($this->path);
        if ( !file_exists($this->path . $path) ) mkdir( $this->path . $path );

        /** Uploading image */
        move_uploaded_file($tmp, $this->path . $path . "/" . $name );

        /** Checking single data */
        if ( !is_array($document['name'])) return ( object ) [ "code" => self::SUCCESS, "path" => $name];

        /** Pushing image name to result */
        $result = $name;

        /** Returning result json */
        return ( object ) [ "code" => self::SUCCESS, "path" => json_encode($result)];
    }

    /**
     * Get Uploaded Document
     *
     * @param $path
     * @param $name
     * @param $isDetail
     * @return mixed
     */
    public function get($path, $name, $isDetail = false)
    {

        // Decoding Document as JSON Objects
        $images = json_decode($name) != null ? json_decode($name) : $name;

        // Arraying image images
        return is_array($images) ? $this->_getFullPath($path, $images, $isDetail) : $this->_getFullPath($path, [$images], $isDetail)[0];
    }

    /**
     * Get Full Document Path
     * @param $path
     * @param $name
     * @param bool $isDetail
     * @param int $i
     * @return mixed
     */
    private function _getFullPath($path, $name, $isDetail = false, $i = 0)
    {
        $dir = $this->path . $path . "/" . $name[$i];

        // Check Document Exists
        if ($name[$i] != "" && file_exists($dir)) {

            // Get Document Dimensions
            list($width, $height) = getimagesize($dir);

            // Set Object
            $name[$i] = $isDetail ? [
                "path" => $this->uri . $path . "/" . $name[$i],
                "width" => $width,
                "height" => $height,
                "colorTone" => "#EFEFEF"
            ] : $this->uri . $path . "/" . $name[$i];

        } else {

            if ( $isDetail ) {
                $name[$i] = ( object )$this->defaultImages;
                $name[$i]->path = $this->uri . $path . "/al.png";
            } else $name[$i] = $this->uri . $path . "/al.png";
        }

        // Make Loop
        if ($i < sizeof($name) - 1) return $name = $this->_getFullPath($path, $name, $isDetail, $i + 1);

        // Return
        return $name;
    }
}