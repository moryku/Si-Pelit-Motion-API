<?php
    /**
     * Constants Value
     * @author Robet Atiq Maulana Rifqi
     * JUN 2019
     */

    namespace Litbang\Config;

    interface Constants {
        
        /**
         * App Description
         */
        const APP = "Remap Litbang API v1.0";
        const VERSION = "1";
        const DESC = "Authentication is needed to access api.";

        /**
         * Path Configuration
         */
        const CONTROLLER_PATH = "/Controllers/";
        const STORAGE_PATH = "../../storage/";
        const STORAGE_URI = "storage/";

        /**
         * Status code
         */
        const SUCCESS = 200;
        const FORBIDEN = 403;
        const NOT_FOUND = 404;
        const ERROR = 500;

        /**
         * Encryption configuration
         */
        const ENC_KEY = "pamer";
        const DEF_MAX_PIN = 6;

        /**
         * Maps Configuration
         */
        const MAPS_URL = "https://maps.googleapis.com/maps/api/geocode/json";
        const MAPS_SENSOR = true;
        const MAPS_KEY = "AIzaSyAFUe4bnf6Yr7S97t3YhLR5FVNN3oBR7nA";

        /**
         * Action Configuration
         */
        const ACTION_CREATE = 0;
        const ACTION_READ = 1;
        const ACTION_UPDATE = 2;
        const ACTION_DELETE = 3;

        /**
         * Status Configuration
         */
        const CART_STATUS = 0;
        const BUY_STATUS = 1;
    }