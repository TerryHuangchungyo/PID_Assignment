<?php
class ShopController extends Controller {
    public function home() {
        $_SESSION["lastPage"] = "shop/home";

        $data["title"] = "購物商城";
        $data["pageName"] = "首頁";
        $data["navBrand"] = ["link" => Web::root."shop/home",
                            "value" => "GoodBuy"];
        $data["navListLHS"] = [ Web::root."shop/home" => "首頁",
                            Web::root."shop/cart" => "購物車"];
        $data["navListRHS"] = [ Web::root."shop/login" => "登入",
                            Web::root."shop/signup" => "註冊"];
        $data["script"] = [ Web::root."views/script/shop/home.js"];
        if( $_SESSION["user"] != "guest" ) {
            $data["navListLHS"][Web::root."shop/user"] = "會員中心";
            $data["navListRHS"] = [ Web::root."shop/logout" => "登出"];
        }

        $data["products"] = $this->model("Products")->load( ["productId", "name", "productDesc", "price", "image"], null, null, null, 1 );
        $this->view( "shop/home", $data );
    }

    public function cart() {
        $arg_num = func_num_args();
        if( $arg_num == 2 ) {
            $option = func_get_arg(1);
            if( $option == "clear" ) {
                $_SESSION["cart"] = [];
                header( "Location: ".Web::root."shop/cart");
                exit;
            }
        }
        $_SESSION["lastPage"] = "shop/cart";

        $data["title"] = "購物車";
        $data["pageName"] = "購物車";
        $data["navBrand"] = ["link" => Web::root."shop/home",
                            "value" => "GoodBuy"];
        $data["navListLHS"] = [ Web::root."shop/home" => "首頁",
                            Web::root."shop/cart" => "購物車"];
        $data["navListRHS"] = [ Web::root."shop/login" => "登入",
                            Web::root."shop/signup" => "註冊"];
        $data["script"] = [ Web::root."views/script/shop/cart.js"];

        if( $_SESSION["user"] != "guest" ) {
            $data["navListLHS"][Web::root."shop/user"] = "會員中心";
            $data["navListRHS"] = [ Web::root."shop/logout" => "登出"];
        }

        $product = $this->model("Product");

        $data["cart"] = [];
        ksort( $_SESSION["cart"]);
        foreach( $_SESSION["cart"] as $productId => $value ) {
            $product->load(["productId", "name", "price" ], (int)$productId );
            $row = [ "productId" => $product->productId,
                    "name" => $product->name,
                    "price" => $product->price ];
            $data["cart"][] = $row;
        }

        $this->view( "shop/cart", $data );
    }

    public function confirm() {
        if( $_SESSION["user"] == "guest" ) {
            $_SESSION["lastPage"] = "shop/cart";
            header("Location: ".Web::root."shop/login");
            exit;
        }

        if( count($_SESSION["cart"]) == 0 ) {
            header("Location: ".Web::root."shop/cart");
            exit;
        }

        $data["title"] = "購物車";
        $data["pageName"] = "購物車";
        $data["navBrand"] = ["link" => Web::root."shop/home",
                            "value" => "GoodBuy"];
        $data["navListLHS"] = [ Web::root."shop/home" => "首頁",
                            Web::root."shop/cart" => "購物車"];
        $data["navListRHS"] = [ Web::root."shop/login" => "登入",
                            Web::root."shop/signup" => "註冊"];
        $data["script"] = [ Web::root."views/script/shop/cart.js"];
        if( $_SESSION["user"] != "guest" ) {
            $data["navListLHS"][Web::root."shop/user"] = "會員中心";
            $data["navListRHS"] = [ Web::root."shop/logout" => "登出"];
        }

        switch( $_SERVER["REQUEST_METHOD"] ) {
            case "GET":
                $product = $this->model("Product");
                $data["cart"] = [];
                $data["total"] = 0;
                ksort( $_SESSION["cart"]);
                foreach( $_SESSION["cart"] as $productId => $value ) {
                    $product->load(["productId", "name", "price" ], (int)$productId );
                    $row = [ "productId" => $product->productId,
                            "name" => $product->name,
                            "price" => $product->price ];
                    $data["cart"][] = $row;
                    $data["total"] += $product->price * $value;
                }

                $this->view( "shop/confirm", $data );
                break;
            case "POST":
                
                $currentTime = date("Y-m-d H:i:s", mktime(gmdate("H")+8, gmdate("i"), gmdate("s"), gmdate("m"), gmdate("d"), gmdate("Y")) );
                $order = $this->model("Order");
                $order->create([
                    "userId" => $_SESSION["userId"],
                    "date" => $currentTime
                ]);
                $order->loadLastByUserId(["orderId", "userId", "date"], $_SESSION["userId"]);

                $orderDetail = $this->model("OrderDetail");
                foreach( $_SESSION["cart"] as $productId => $value ) {
                    $orderDetail->create([
                        "orderId" =>  $order->orderId,
                        "productId" => (int)$productId,
                        "value" => $value
                    ]);
                }
                $data["orderId"] = $order->orderId;
                $_SESSION["cart"] = [];
                $this->view( "shop/success", $data );
                break;
        }

    }

    public function intro() {
        $productId = func_get_arg(1);

        $data["title"] = "商品介紹";
        $data["pageName"] = "首頁";
        $data["navBrand"] = ["link" => Web::root."shop/home",
                            "value" => "GoodBuy"];
        $data["navListLHS"] = [ Web::root."shop/home" => "首頁",
                            Web::root."shop/cart" => "購物車"];
        $data["navListRHS"] = [ Web::root."shop/login" => "登入",
                            Web::root."shop/signup" => "註冊"];
        $data["script"] = [ Web::root."views/script/shop/intro.js"];
        $data["lastPage"] = $_SESSION["lastPage"];

        $product = $this->model("Product");
        $product->load( ["productId","name","productDesc","image","price","createDate"], $productId );
        $data["product"] = $product;

        if( $_SESSION["user"] != "guest" ) {
            $data["navListLHS"][Web::root."shop/user"] = "會員中心";
            $data["navListRHS"] = [ Web::root."shop/logout" => "登出"];
        }
        $this->view( "shop/intro", $data );
    }

    public function user() {
        if( $_SESSION["user"] == "guest" ) {
            header("Location: ".Web::root."shop/home");
        }

        $data["title"] = "商品介紹";
        $data["pageName"] = "會員中心";
        $data["navBrand"] = ["link" => Web::root."shop/home",
                            "value" => "GoodBuy"];
        $data["navListLHS"] = [ Web::root."shop/home" => "首頁",
                            Web::root."shop/cart" => "購物車",
                            Web::root."shop/user" => "會員中心" ];

        $data["navListRHS"] = [ Web::root."shop/logout" => "登出"];
            
        
        $this->view( "shop/user", $data );
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
                        header("Location: ".Web::root.$_SESSION["lastPage"] );
                        exit;
                    } else {
                        $data["userId"] = $requestData["userId"];
                        $data["feedbacks"] = "輸入的帳號或密碼錯誤";
                    }
                } else {
                    $data["userId"] = $requestData["userId"];
                    $data["feedbacks"] = "輸入的帳號或密碼錯誤";
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