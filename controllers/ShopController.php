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
        if( $_SESSION["user"] != "guest" ) {
            $data["navListLHS"][Web::root."shop/user"] = "會員中心";
            $data["navListRHS"] = [ Web::root."shop/logout" => "登出"];
        }
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
        if( $_SESSION["user"] != "guest" ) {
            $data["navListLHS"][Web::root."shop/user"] = "會員中心";
            $data["navListRHS"] = [ Web::root."shop/logout" => "登出"];
        }
        $this->view( "shop/cart", $data );
    }

    public function login() {
        if( $_SESSION["user"] != "guest" ) {
            header("Location: ".Web::root."shop/home");
        }

        $data["title"] = "登入";
        $data["pageName"] = "登入";
        $data["navBrand"] = ["link" => Web::root."shop/home",
                            "value" => "GoodBuy"];
        $data["navListLHS"] = [ Web::root."shop/home" => "首頁",
                            Web::root."shop/cart" => "購物車"];
        $data["navListRHS"] = [ Web::root."shop/login" => "登入",
                            Web::root."shop/signup" => "註冊"];
        switch( $_SERVER["REQUEST_METHOD"] ) {
            case "GET":
                $this->view( "shop/login", $data );
                break;
            case "POST":
                $requestData = func_get_arg( 0 );
                $user = $this->model("User");
                $success = $user->load( ["userId", "password"], $requestData["userId"] );

                if( $success ) {
                    if( $user->password == hash("sha256", $requestData["password"])) {
                        $_SESSION["user"] = "user";
                        $_SESSION["userId"] = $requestData["userId"];
                        header("Location: ".Web::root."shop/home");
                        exit;
                    } else {
                        $data["userId"] = $requestData["userId"];
                        $data["feedbacks"] = "輸入的帳號或密碼錯誤";
                    }
                }

                $this->view( "shop/login", $data );
                break;
        }
    }

    public function logout() {
        if( $_SESSION["user"] != "guest" ) {
            session_unset();
        }
        header("Location: ".Web::root."shop/home");
    }

    public function signup() {
        if( $_SESSION["user"] != "guest" ) {
            header("Location: ".Web::root."shop/home");
        }

        $data["title"] = "註冊";
        $data["pageName"] = "註冊";
        $data["navBrand"] = ["link" => Web::root."shop/home",
                            "value" => "GoodBuy"];
        $data["navListLHS"] = [ Web::root."shop/home" => "首頁",
                            Web::root."shop/cart" => "購物車"];
        $data["navListRHS"] = [ Web::root."shop/login" => "登入",
                            Web::root."shop/signup" => "註冊"];
        switch( $_SERVER["REQUEST_METHOD"] ) {
            case "GET":
                $this->view( "shop/signup", $data );
                break;
            case "POST":
                $data["feedbacks"] = [];
                $requestData = func_get_arg( 0 );
                $user = $this->model("User");

                if( $exists = $user->load(["userId"], $requestData["userId"]) ){
                    $data["feedbacks"]["userId"] = "此帳號已被註冊";
                }
                
                if( $requestData["password"] != $requestData["passwordCheck"] ) {
                    $data["feedbacks"]["passwordCheck"] = "再次輸入的密碼必須與上欄密碼相同";
                }

                if( count( $data["feedbacks"]) == 0 ) {
                    $success = $user->create([
                        "userId" => $requestData["userId"],
                        "password" => hash("sha256",$requestData["password"]),
                        "name" => $requestData["name"],
                        "birthDate" => $requestData["birthDate"]?$requestData["birthDate"]:NULL,
                        "phone" => $requestData["phone"],
                        "email" => $requestData["email"]
                    ]);
                    
                    if( $success ) {
                        $_SESSION["user"] = "user";
                        $_SESSION["userId"] = $requestData["userId"];
                        header("Location: ".Web::root."shop/home");
                        exit;
                    }
                }
                $this->view( "shop/signup", $data );
                break;
        }
    }

    public function default() {
        header( "Location: ".Web::root."shop/home" );
    }
}