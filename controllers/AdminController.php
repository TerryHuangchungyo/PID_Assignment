<?php
class AdminController extends Controller {
    public function intro() {
        $productId = func_get_arg(1);

        if( $_SESSION["user"] != "admin") {
            header( "Location: ".Web::root."shop/home");
            exit;
        }

        $data["title"] = "商品管理";
        $data["pageName"] = "商品管理";
        $data["navBrand"] = ["link" => Web::root."admin/login",
                            "value" => "GoodBuy Administrator"];
        $data["navListLHS"] = [ Web::root."admin/product" => "商品管理",
                            Web::root."admin/order" => "訂單管理",
                            Web::root."admin/user" => "會員管理"];
        $data["navListRHS"] = [ Web::root."admin/logout" => "登出"];

        $product = $this->model("Product");
        $product->load( ["productId","name","productDesc","image","price","createDate"], $productId );
        $data["product"] = $product;
        $this->view( "admin/intro", $data );
    }

    public function login() {
        switch( $_SESSION["user"] ) {
            case "admin":
                header( "Location: ".Web::root."admin/product");
                break;
            case "user":
                header( "Location: ".Web::root."shop/home");
                break;
        }
        
        $data["title"] = "管理後臺";
        $data["pageName"] = "管理後臺登入";
        $data["navBrand"] = ["link" => Web::root."admin/login",
                            "value" => "GoodBuy Administrator"];
        switch( $_SERVER["REQUEST_METHOD"] ) {
            case "GET":
                $this->view( "admin/login", $data );
                break;
            case "POST":
                $requestData = func_get_arg( 0 );
                $user = $this->model("User");
                $success = $user->load( ["userId", "password", "type"], $requestData["userId"] );

                if( $success && $user->type == 1 ) {
                    if( $user->password == hash("sha256", $requestData["password"])) {
                        $_SESSION["user"] = "admin";
                        $_SESSION["userId"] = $requestData["userId"];
                        header("Location: ".Web::root."admin/product" );
                        exit;
                    } else {
                        $data["userId"] = $requestData["userId"];
                        $data["feedbacks"] = "輸入的帳號或密碼錯誤";
                    }
                } else {
                    $data["userId"] = $requestData["userId"];
                    $data["feedbacks"] = "輸入的帳號或密碼錯誤";
                }

                $this->view( "admin/login", $data );
                break;
        }
    }

    public function logout() {
        if( $_SESSION["user"] != "guest" ) {
            session_unset();
        }
        header("Location: ".Web::root."admin/login");
    }

    public function product() {
        if( $_SESSION["user"] != "admin") {
            header( "Location: ".Web::root."shop/home");
            exit;
        }

        $data["title"] = "商品管理";
        $data["pageName"] = "商品管理";
        $data["navBrand"] = ["link" => Web::root."admin/login",
                            "value" => "GoodBuy Administrator"];
        $data["navListLHS"] = [ Web::root."admin/product" => "商品管理",
                            Web::root."admin/order" => "訂單管理",
                            Web::root."admin/user" => "會員管理"];
        $data["navListRHS"] = [ Web::root."admin/logout" => "登出"];

        $data["products"] = $this->model("Products")->load( ["productId", "name", "price", "createDate"], null, null, null, 2 );
        $this->view( "admin/product", $data );
    }

    public function order() {
        if( $_SESSION["user"] != "admin") {
            header( "Location: ".Web::root."shop/home");
            exit;
        }

        $data["title"] = "訂單管理";
        $data["pageName"] = "訂單管理";
        $data["navBrand"] = ["link" => Web::root."admin/login",
                            "value" => "GoodBuy Administrator"];
        $data["navListLHS"] = [ Web::root."admin/product" => "商品管理",
                            Web::root."admin/order" => "訂單管理",
                            Web::root."admin/user" => "會員管理"];
        $data["navListRHS"] = [ Web::root."admin/logout" => "登出"];


        $userId = (func_num_args() == 2) ?  func_get_arg(1) : null;
        

        $data["orders"] = $this->model("Orders")->getOrdersByUserId(["orderId","date"], $userId ,null, null );
        $this->view( "admin/order", $data );
    }

    public function orderDetail() {
        if( $_SESSION["user"] != "admin") {
            header( "Location: ".Web::root."shop/home");
            exit;
        }

        $data["title"] = "訂單管理";
        $data["pageName"] = "訂單管理";
        $data["navBrand"] = ["link" => Web::root."admin/login",
                            "value" => "GoodBuy Administrator"];
        $data["navListLHS"] = [ Web::root."admin/product" => "商品管理",
                            Web::root."admin/order" => "訂單管理",
                            Web::root."admin/user" => "會員管理"];
        $data["navListRHS"] = [ Web::root."admin/logout" => "登出"];
        $orderId = func_get_arg( 1 );
        $order = $this->model("Order");
        $order->load([ "orderId", "userId", "date" ], $orderId );
        $data["orderDetail"] = $this->model("OrderDetails")->getOrderDetailsByOrderId($order->orderId);
        $data["total"] = 0;
        foreach( $data["orderDetail"] as $item ) {
            $data["total"] += $item["price"] * $item["value"];
        }
        $this->view("admin/orderDetail", $data);
    }

    public function user() {
        if( $_SESSION["user"] != "admin") {
            header( "Location: ".Web::root."shop/home");
            exit;
        }

        $data["title"] = "會員管理";
        $data["pageName"] = "會員管理";
        $data["navBrand"] = ["link" => Web::root."admin/login",
                            "value" => "GoodBuy Administrator"];
        $data["navListLHS"] = [ Web::root."admin/product" => "商品管理",
                            Web::root."admin/order" => "訂單管理",
                            Web::root."admin/user" => "會員管理"];
        $data["navListRHS"] = [ Web::root."admin/logout" => "登出"];
        $data["users"] = $this->model("users")->getUsers( ["userId", "name", "phone", "email", "active"], 2 );
        $this->view( "admin/user", $data );
    }

    public function ban() {
        if( $_SESSION["user"] != "admin") {
            header( "Location: ".Web::root."shop/home");
            exit;
        }

        $userId = func_get_arg(1);
        $user = $this->model("User");
        $user->load(["active"], $userId );
        $user->active = 0;
        $user->save(["active"]);

        header( "Location: ".Web::root."admin/user");
        exit;
    }

    public function unban() {
        if( $_SESSION["user"] != "admin") {
            header( "Location: ".Web::root."shop/home");
            exit;
        }

        $userId = func_get_arg(1);
        $user = $this->model("User");
        $user->load(["active"], $userId );
        $user->active = 1;
        $user->save(["active"]);

        header( "Location: ".Web::root."admin/user");
        exit;
    }

    public function default() {
        header( "Location: ".Web::root."admin/login" );
    }
}