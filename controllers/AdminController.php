<?php
class AdminController extends Controller {
    public function login() {
        $data["title"] = "管理後臺";
        $data["pageName"] = "管理後臺登入";
        $data["navBrand"] = ["link" => Web::root."admin/login",
                            "value" => "GoodBuy Administrator"];
        $data["navListLHS"] = [ Web::root."admin/product" => "商品管理",
                            Web::root."admin/order" => "訂單管理",
                            Web::root."admin/user" => "會員管理"];
        $data["navListRHS"] = [ "#" => "登出"];
        $this->view( "admin/login", $data );
    }

    public function product() {
        $data["title"] = "商品管理";
        $data["pageName"] = "商品管理";
        $data["navBrand"] = ["link" => Web::root."admin/login",
                            "value" => "GoodBuy Administrator"];
        $data["navListLHS"] = [ Web::root."admin/product" => "商品管理",
                            Web::root."admin/order" => "訂單管理",
                            Web::root."admin/user" => "會員管理"];
        $data["navListRHS"] = [ "#" => "登出"];
        $this->view( "admin/product", $data );
    }

    public function order() {
        $data["title"] = "訂單管理";
        $data["pageName"] = "訂單管理";
        $data["navBrand"] = ["link" => Web::root."admin/login",
                            "value" => "GoodBuy Administrator"];
        $data["navListLHS"] = [ Web::root."admin/product" => "商品管理",
                            Web::root."admin/order" => "訂單管理",
                            Web::root."admin/user" => "會員管理"];
        $data["navListRHS"] = [ "#" => "登出"];
        $this->view( "admin/order", $data );
    }

    public function user() {
        $data["title"] = "會員管理";
        $data["pageName"] = "會員管理";
        $data["navBrand"] = ["link" => Web::root."admin/login",
                            "value" => "GoodBuy Administrator"];
        $data["navListLHS"] = [ Web::root."admin/product" => "商品管理",
                            Web::root."admin/order" => "訂單管理",
                            Web::root."admin/user" => "會員管理"];
        $data["navListRHS"] = [ "#" => "登出"];
        $this->view( "admin/user", $data );
    }

    public function default() {
        header( "Location: ".Web::root."admin/login" );
    }
}