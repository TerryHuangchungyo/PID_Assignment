<?php
class ShopController extends Controller {
    public function home() {
        if( $_SESSION["user"] == "guest" ) {
            $_SESSION["lastPage"] = "shop/home";
        }

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
        
        $data["products"] = $this->model("Products")->load( ["productId", "name", "productDesc", "price", "image", "active"], null, null, null, 1 );
        $this->view( "shop/home", $data );
    }

    public function cart() {
        if( $_SESSION["user"] == "guest" ) {
            $_SESSION["lastPage"] = "shop/cart";
        }

        $arg_num = func_num_args();
        if( $arg_num == 2 ) {
            $option = func_get_arg(1);
            if( $option == "clear" ) {
                $_SESSION["cart"] = [];
                header( "Location: ".Web::root."shop/cart");
                exit;
            }
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

    public function buy() {
        if( func_num_args() == 2 ) {
            $productId = func_get_arg(1);
        } else {
            header("Location: ".Web::root."shop/home");
            exit;
        }

        if( $_SESSION["user"] == "guest" ) {
            $_SESSION["lastPage"] = "shop/buy/".$productId;
            header("Location: ".Web::root."shop/login");
            exit;
        }

        $data["title"] = "購買";
        $data["pageName"] = "購物車";
        $data["navBrand"] = ["link" => Web::root."shop/home",
                            "value" => "GoodBuy"];
        $data["navListLHS"] = [ Web::root."shop/home" => "首頁",
                            Web::root."shop/cart" => "購物車"];
        $data["navListRHS"] = [ Web::root."shop/logout" => "登出"];

        switch( $_SERVER["REQUEST_METHOD"] ) {
            case "GET":
                $product = $this->model("Product");
                $product->load(["productId","name","price"], $productId);
                $data["product"] = [ "productId" => $product->productId,
                                    "name" => $product->name,
                                    "price" => $product->price ];
                $data["script"] = [ Web::root."views/script/shop/buy.js",
                                    Web::root."views/script/shop/back.js" ];
                $data["confirm"] = false;
                
                $this->view( "shop/buy", $data );
                break;
            case "POST":
                
                $product = $this->model("Product");
                $product->load(["productId","name","price"], $productId);
                $data["product"] = [ "productId" => $product->productId,
                                    "name" => $product->name,
                                    "price" => $product->price,
                                    "value" => (int)$_POST["value"],
                                    "total" => (int)$_POST["value"] * $product->price ];
                $data["script"] = [ Web::root."views/script/shop/back.js" ];
                $data["confirm"] = true;
                
                $this->view( "shop/buy", $data );
                break;
        }
    }

    public function commit() {
        if( $_SESSION["user"] == "guest" ) {
            $_SESSION["lastPage"] = "shop/home";
            header("Location: ".Web::root."shop/login");
            exit;
        }

        if( !isset($_POST["productId"]) || !isset($_POST["value"]) ){
            header("Location: ".Web::root."shop/home");
            exit;
        }


        $data["title"] = "購物車";
        $data["pageName"] = "購物車";
        $data["navBrand"] = ["link" => Web::root."shop/home",
                            "value" => "GoodBuy"];
        $data["navListLHS"] = [ Web::root."shop/home" => "首頁",
                            Web::root."shop/cart" => "購物車",
                            Web::root."shop/user" => "會員中心"];
        $data["navListRHS"] = [ Web::root."shop/logout" => "登出"];
        $data["script"] = [ Web::root."views/script/shop/confirm.js"];
        

        switch( $_SERVER["REQUEST_METHOD"] ) {
            case "POST":
                $currentTime = date("Y-m-d H:i:s", mktime(gmdate("H")+8, gmdate("i"), gmdate("s"), gmdate("m"), gmdate("d"), gmdate("Y")) );
                $order = $this->model("Order");
                $order->create([
                    "userId" => $_SESSION["userId"],
                    "date" => $currentTime
                ]);
                $order->loadLastByUserId(["orderId", "userId", "date"], $_SESSION["userId"]);

                $orderDetail = $this->model("OrderDetail");
                $orderDetail->create([
                    "orderId" =>  $order->orderId,
                    "productId" => (int)$_POST["productId"],
                    "value" => (int)$_POST["value"]
                ]);
                $data["orderId"] = $order->orderId;
                $_SESSION["cart"] = [];
                $this->view( "shop/success", $data );
                break;
        }  
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
        $data["script"] = [ Web::root."views/script/shop/back.js"];
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
        $data["script"] = [ Web::root."views/script/shop/intro.js",
                            Web::root."views/script/shop/back.js"];

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

        $data["css"] = [Web::root."views/css/customNavPill.css"];
        $data["title"] = "會員中心";
        $data["pageName"] = "會員中心";
        $data["navBrand"] = ["link" => Web::root."shop/home",
                            "value" => "GoodBuy"];
        $data["navListLHS"] = [ Web::root."shop/home" => "首頁",
                            Web::root."shop/cart" => "購物車",
                            Web::root."shop/user" => "會員中心" ];

        $data["navListRHS"] = [ Web::root."shop/logout" => "登出"];
        $data["script"] = [ Web::root."views/script/shop/user.js" ];

        $data["orders"] = $this->model("Orders")->getOrdersByUserId(["orderId","date"], $_SESSION["userId"],null, null );

        $user = $this->model("User");
        $user->load([ "name", "birthDate", "phone", "email" ], $_SESSION["userId"]);
        $data["user"] = $user;
        $this->view( "shop/user", $data );
    }

    public function changePassword() {
        if( $_SESSION["user"] == "guest" ) {
            header("Location: ".Web::root."shop/home");
        }

        $result = [];

        if( $_POST["changedPassword"] == "" ) {
            $result["changedPassword"] = "此欄位不能留空";  
        } else {
            if( $_POST["changedPassword"] != $_POST["changedPasswordCheck"] ) {
                $result["changedPasswordCheck"] = "此欄位必須與上欄輸入的密碼相同"; 
            }
        }

        if( $_POST["changedPasswordCheck"] == "" ) {
            $result["changedPasswordCheck"] = "此欄位不能留空";
        }

        if( $_POST["password"] == "" ) {
            $result["password"] = "此欄位不能留空";  
        } else {
            if( $_POST["password"] != $_POST["passwordCheck"] ) {
                $result["passwordCheck"] = "此欄位必須與上欄輸入的密碼相同"; 
            }
        }

        if( $_POST["passwordCheck"] == "" ) 
            $result["passwordCheck"] = "此欄位不能留空";
        
        if( count($result) == 0 ) {
            $user = $this->model("User");
            $user->load(["password"], $_SESSION["userId"] );
            if( hash( "sha256", $_POST["password"]) == $user->password )  {
                $user->password = hash( "sha256", $_POST["changedPassword"]);
                $user->save(["password"],  $_SESSION["userId"]);
                $result["success"] = true;
            } else {
                $result["password"] = "密碼錯誤"; 
                $result["success"] = false;
            }
        } else {
            $result["success"] = false;
        }

        $this->view("api/JsonAPI", $result);
    }

    public function setting() {
        if( $_SESSION["user"] == "guest" ) {
            header("Location: ".Web::root."shop/home");
        }

        $result = [];
        foreach( $_POST as $key => $value ) {
            if( $value == "" ) {
                $result[$key] = "此欄位不能留空";
            }
        }

        if(isset( $result["email"] ) && $result["email"] != "") {
            if( preg_match("/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/",$result["email"])) {
                $result["email"] = "此欄位不能留空";
            }
        }
        
        $this->view("api/JsonAPI", $result);
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
                $success = $user->load( ["userId", "password", "active"], $requestData["userId"] );

                if( $success ) {
                    if( $user->active == 0 ) {
                        $this->view( "shop/banned", $data );
                        exit;
                    }

                    if( $user->password == hash("sha256", $requestData["password"])) {
                        $_SESSION["user"] = "user";
                        $_SESSION["userId"] = $requestData["userId"];
                        if( isset($_SESSION["lastPage"]))
                            header("Location: ".Web::root.$_SESSION["lastPage"] );
                        else
                            header("Location: ".Web::root."shop/home" );
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

    public function order() {
        if( func_num_args() != 2 || $_SESSION["user"] == "guest") {
            header( "Location: ".Web::root."shop/home" );
            exit;
        }

        
        $orderId = func_get_arg( 1 );
        $order = $this->model("Order");
        $order->load([ "orderId", "userId", "date" ], $orderId );
        if( $order->userId != $_SESSION["userId"] ) {
            header( "Location: ".Web::root."shop/home" );
            exit;
        }

        $data["title"] = "商品介紹";
        $data["pageName"] = "會員中心";
        $data["navBrand"] = ["link" => Web::root."shop/home",
                            "value" => "GoodBuy"];
        $data["navListLHS"] = [ Web::root."shop/home" => "首頁",
                            Web::root."shop/cart" => "購物車",
                            Web::root."shop/user" => "會員中心" ];
        $data["script"] = [ Web::root."views/script/shop/back.js"];
        $data["navListRHS"] = [ Web::root."shop/logout" => "登出"];
        $data["orderDetail"] = $this->model("OrderDetails")->getOrderDetailsByOrderId($order->orderId);
        $data["total"] = 0;
        foreach( $data["orderDetail"] as $item ) {
            $data["total"] += $item["price"] * $item["value"];
        }
        $this->view("shop/orderDetail", $data);
    }
    
    public function default() {
        header( "Location: ".Web::root."shop/home" );
    }
}