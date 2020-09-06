<?php
class ProductsController extends Controller {
    public function getActive( $search, $offsets, $limits ) {
        $data = $this->model( "Products" )
                    ->load( ["productId", "name", "productDesc", "price", "image"],$search, $offsets, $limits, 1 );
        $this->view("api/JsonArrAPI", $data);
    }

    public function countActive( $search ) {
        $data = $this->model( "Products" )
                    ->count( $search, 1 );
        $this->view("api/JsonAPI", $data);
    }
}