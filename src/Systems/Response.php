<?php
    /**
     * Response Systems
     * @author Robet Atiq Maulana Rifqi
     * JUN 2019
     */
    namespace Litbang\Systems;

    use Litbang\Config\Constants;

    class Response implements Constants {

        /**
         * Publishing data
         * 
         * @param array
         * @param string
         * @param int
         */
        public function publish ( $data = null, $message = "", $code = self::SUCCESS ) {

            $result = ( object ) [];

            $result->status = $code == self::SUCCESS;
            $result->message = $message;
            $result->code = $code;
            $result->data = $data;

            // Return
            return json_encode( (array) $result );
        }
    }
?>