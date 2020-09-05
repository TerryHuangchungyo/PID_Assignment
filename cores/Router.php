<?php
class Router {
    public function __construct( $url ) {
        $this->url = $url;
        $this->method = $_SERVER["REQUEST_METHOD"];
    }

    public function on( $rule, $callback ) {
        $this->rules[$rule] = $callback;
    }

    public function run() {
        $is_match = false;

        foreach( $this->rules as $rule => $callback ) {
            if( $rule === 'default')
                continue;

            if( preg_match($rule, $this->url, $match) ) {
                $is_match = true;
                $callback( $match );
                break;
            }
        }

        if(!$is_match)
            $this->rules['default']();
    }
}