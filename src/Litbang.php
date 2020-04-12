<?php

    namespace Litbang;

    use Slim\App;
    use Litbang\Config\Constants;

    class Litbang implements Constants {
        /**
         * @var App
         */
        private $app;

        /**
         * Create Application
         */
        public function __construct () {

            // Set Efault Timezone
            date_default_timezone_set('Asia/Jakarta');
        }

        /**
         * Routing
         */
        private function _route ( $files, $i = 0 ) {

            // Check files
            if ( sizeof ( $files ) == 0 ) return;

            // Get Path
            $_SESSION['path'] = $files[$i];

            // Get Controller Name
            $exploder = explode(".", $_SESSION['path']);
            $controller = $exploder[0];

            // Make Routing Group
            $this->app->group ( '/' . strtolower ( $controller ), function (){

                // Get Path
                $path = __DIR__ . self::CONTROLLER_PATH . $_SESSION['path'];

                // Requiring Controller
                if ( file_exists($path) ) require_once ( $path );
            });

            // Make Loop
            if ( $i < sizeof ( $files ) - 1 ) return $this->_route ( $files, $i + 1 );
        }

        /**
         * Running Rest Api
         */
        public function run () {

            // Settings configuration
            $configuration = [
                'settings' => [
                    'displayErrorDetails' => true
                ]
            ];

            // Call Slim framework
            $this->app = new App($configuration);

            // Check Framework
            $this->app->map ( ['GET', 'POST'], '/', function ( $request, $response, $args ) {

                return $response->withJSON([
                    "name"          => self::APP,
                    "version"       => self::VERSION,
                    "description"   => self::DESC,
                ]);
            });

            // Get Controllers Path
            $controllers = scandir ( __DIR__ . self::CONTROLLER_PATH );
            $controllers = array_splice ( $controllers, 2, 10 );

            // Routing
            $this->_route( $controllers );

            // Cors Setup
            $this->app->add(function( $request, $response, $next ) {
                
                $return = $next ( $request, $response );

                return $return
                    ->withHeader ( 'Access-Control-Allow-Heaers', 'X-Requested-With, Content-Type, Accept, Authorization')
                    ->withHeader ( 'Content-Type', 'application/json; charset=utf-8');
            });

            // Running app
            return $this->app->run();
        }
    }