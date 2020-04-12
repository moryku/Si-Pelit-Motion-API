<?php
    /**
     * Connection Systems
     * @author Robet Atiq Maulana Rifqi
     * JUN 2019
     */

    namespace Litbang\Systems;

    use \PDO;
    use Litbang\Config\Database;

    class Connection implements Database {

        /**
         * @var PDO
         */
        private $pdo;

        /**
         * @var \PDOStatement
         */
        private $stmt;

        /**
         * 
         */
        public function __construct () {

            // Create Connection
            $this->_create();
        }

        /**
         * Creating connection
         */
        private function _create () {

            // Create Connection
            $pdo = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::DB, self::USER, self::PASS );
            
            // Set PDO Attribute
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            // Save PDO Connection
            $this->pdo = $pdo;
        }

        /**
         * Parsing Data
         * 
         * @return object
         */
        private function _parse ( $object, $data, $i = 0 ) {

            // Check data avaibility
            if ( isset( $data->scalar ) ) return $data;

            // Check single data
            if ( !isset( $data[0] ) ) return $object($data);

            // Parsing Data
            $data[$i] = $object($data[$i]);

            // Make Loop
            if ( $i < sizeof ( $data ) - 1 ) return $this->_parse ( $object, $data, $i + 1 );

            // Return
            return $data;
        }

        /**
         * Fetching data
         *
         * @param array|object
         * @param object
         * @return object
         */
        private function _fetch( $data, $object = null ) {

            // Closing connection
            $this->_close();

            // Parsing data
            $data = $object != null ? $this->_parse ( $object, $data ) : $data;

            // Return
            return ( object ) $data;
        }

        /**
         * Executing Query
         * 
         * @param string
         * @param array
         */
        public function query ( $query, $params = [] ) {

            // Check And Create Connection
            if ( is_null($this->pdo) ) $this->_create();

            // Preparing statement
            $stmt = $this->pdo->prepare ( $query );
            
            // Executing statement
            $stmt->execute($params);
            
            // Save Statement
            $this->stmt = $stmt;
        }

        /**
         * Fetching Single Data
         * 
         * @param object
         * 
         * @return object
         */
        public function fetch ( $object = null ) {

            // Fetching data
            $data = $this->stmt->fetch();

            // Return
            return $this->_fetch($data, $object);
        }

        /**
         * Fetch multiple data
         * 
         * @param object
         * 
         * @return object
         */
        public function fetchAll ( $object = null ) {

            // Fetching data
            $data = $this->stmt->fetchAll();

            // Return
            return $this->_fetch($data, $object);
        }

        /**
         * Get Last Insert Id
         *
         * @return int
         */
        public function lastInsertId() {

            // Getting last insert id
            $id = $this->pdo->lastInsertId();

            // Closing Connection
            $this->_close();

            return $id;
        }

        /**
         * Closing Connection
         */
        private function _close () {

            $this->pdo = null;
            $this->stmt = null;
        }
    }