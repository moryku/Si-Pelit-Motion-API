<?php
    /**
     * Request Systems
     * @author Robet Atiq Maulana Rifqi
     * JUN 2019
     */

    namespace Litbang\Systems;

    class Request {

        /**
         * Parsing data
         * 
         * @param object
         */
        public function parse ( $data ) {

            $this->params = $data->isPost() ?
                ( object ) $data->getParsedBody() :
                ( object ) $data->getQueryParams();
        }

        /**
         * Set Value
         * 
         * @param string
         * @param any
         */
        public function set ( $key, $value ) {
            $this->params->$key = $value;
        }

        /**
         * Getting value
         * 
         * @param string|null
         * @return string|array|null
         */
        public function get ( $key = null ) {
            
            return $key == null ? $this->params : ( isset ( $this->params->$key ) ? $this->params->$key : "" );
        }

        /**
         * Remove Value
         * 
         * @param string
         */
        public function remove ( $key ) {

            unset ( $this->params->$key );
        }
    }
?>