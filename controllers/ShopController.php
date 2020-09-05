<?php
class ShopController extends Controller {
    public function home() {
        $data["title"] = "購物商城";
        $data["pageName"] = "首頁";
        $data["navBrand"] = ["link" => Web::root."shop/home",
                            "value" => "GoodBuy"];
        $data["navListLHS"] = [ Web::root."shop/home" => "首頁",
                            Web::root."shop/cart" => "購物車"];
        $data["navListRHS"] = [ Web::root."shop/login" => "登入",
                            Web::root."shop/signup" => "註冊"];
        $this->view( "shop/home", $data );
    }

    public function cart() {
        $data["title"] = "購物車";
        $data["pageName"] = "購物車";
        $data["navBrand"] = ["link" => Web::root."shop/home",
                            "value" => "GoodBuy"];
        $data["navListLHS"] = [ Web::root."shop/home" => "首頁",
                            Web::root."shop/cart" => "購物車"];
        $data["navListRHS"] = [ Web::root."shop/login" => "登入",
                            Web::root."shop/signup" => "註冊"];
        $this->view( "shop/cart", $data );
    }

    public function login() {
        $data["title"] = "登入";
        $data["pageName"] = "登入";
        $data["navBrand"] = ["link" => Web::root."shop/home",
                            "value" => "GoodBuy"];
        $data["navListLHS"] = [ Web::root."shop/home" => "首頁",
                            Web::root."shop/cart" => "購物車"];
        $data["navListRHS"] = [ Web::root."shop/login" => "登入",
                            Web::root."shop/signup" => "註冊"];
        $this->view( "shop/login", $data );
    }

    public function signup() {
        $data["title"] = "註冊";
        $data["pageName"] = "註冊";
        $data["navBrand"] = ["link" => Web::root."shop/home",
                            "value" => "GoodBuy"];
        $data["navListLHS"] = [ Web::root."shop/home" => "首頁",
                            Web::root."shop/cart" => "購物車"];
        $data["navListRHS"] = [ Web::root."shop/login" => "登入",
                            Web::root."shop/signup" => "註冊"];
        $this->view( "shop/signup", $data );
    }

    public function default() {
        header( "Location: ".Web::root."shop/home" );
    }
}