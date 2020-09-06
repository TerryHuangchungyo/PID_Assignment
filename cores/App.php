<?php
require_once "vendor/autoload.php";

class App {
    public function __construct() {
        session_start();

        if( !isset($_GET["url"]) ) {
            $_GET["url"] = "shop/home";
        }

        // 未登入使用者型態為GUEST
        if( !isset($_SESSION["user"]) ) {
            $_SESSION["user"] = "guest";
        }

        $router = new Router( $_GET["url"] );

        $router->add( "/\/?(?P<controller>\w+)(\/(?P<method>\w+))?(\/(?P<param>.+))?/", function( $match, $requestData ){
            $controllerName = "{$match["controller"]}Controller";
            $method = $match["method"] ? $match["method"]: "default";
            $param[] = $requestData; 
            if( isset( $match["param"])) {
                $param = array_merge( $param, explode( "/", $match["param"]));
            } else {
                $param = array_merge( $param, Array());
            }

            @include_once "controllers/$controllerName.php";
            if( class_exists( $controllerName ) ) {
                $controller = new $controllerName;
                if( method_exists( $controller, $method ) ) {
                    call_user_func_array( Array( $controller, $method ), $param );
                }
            } else {
                header( "Location: ".Web::root."shop/home" );
            }
        });

        $router->add( "default", function(){
            header("Location: ".Web::root."shop/home");
        });

        $router->run();
    }
}