<?php
class Router {
    public function __construct( $url ) {
        $this->url = $url;
        $this->method = $_SERVER["REQUEST_METHOD"];
    }

    public function add( $rule, $callback ) {
        $this->rules[$rule] = $callback;
    }

    public function get( $rule, $callback ) {
        $this->gets[$rule] = $callback;
    }

    public function post( $rule, $callback ) {
        $this->posts[$rule] = $callback;
    }

    public function put( $rule, $callback ) {
        $this->puts[$rule] = $callback;
    }

    public function patch( $rule, $callback ) {
        $this->patchs( $rule, $callback );
    }

    public function delete( $rule, $callback ) {
        $this->deletes( $rule, $callback );
    }

    public function run() {
        $is_match = false;
        switch( $this->method ) {
            case "GET":
            case "POST":
                $request_data = $_REQUEST;
                break;
            case "PUT":
            case "PATCH":
            case "DELETE":
                $arr = parse_str(file_get_contents('php://input'));
                $request_data = ($arr)?$arr:Array();
                break;
        }

        $ruleArr = strtolower( $this->method )."s";
        if( isset( $$ruleArr ) ) {
            foreach( $this->$ruleArr as $rule => $callback ) {

                if( preg_match($rule, $this->url, $match) ) {
                    $is_match = true;
                    $callback( $match, $request_data );
                    break;
                }
            }
        }

        if( !$is_match ) {
            foreach( $this->rules as $rule => $callback ) {
                if( $rule === 'default')
                    continue;

                if( preg_match($rule, $this->url, $match) ) {
                    $is_match = true;
                    $callback( $match, $request_data );
                    break;
                }
            }
        }

        if(!$is_match)
            $this->rules['default']();
    }
}