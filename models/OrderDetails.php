<?php
class OrderDetails {
    public function getOrderDetailsByOrderId( $orderId ) {
        $dblink = Database::getDatabase();
        $orderDetailTbName = DB::orderDetailTbName;
        $productTbName = DB::productTbName;
        $pidName = "orderId";

        $preStmt = <<< STR
            SELECT  p.productId, p.name, p.price, od.value FROM $orderDetailTbName od JOIN
             $productTbName p ON od.productId = p.productId WHERE od.orderId = :orderId
        STR;

        $stmt = $dblink->prepare( $preStmt );

        $stmt->bindParam( ":orderId", $orderId );

        if($stmt->execute()) {
            return $stmt->fetchAll( PDO::FETCH_ASSOC ); 
        } else {
            var_dump($stmt->errorInfo());
            return [];
        }
    }
}