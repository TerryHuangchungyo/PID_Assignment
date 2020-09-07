<?php
class Orders {
    public function getOrdersByUserId( $columns, $userId, $offsets, $limits ) {
        $dblink = Database::getDatabase();
        $tbName = DB::orderTbName;
        $pidName = "orderId";

        $colstr = implode( ",", $columns );
        $preStmt = "SELECT $colstr FROM $tbName ";

        if( $userId ) {
            $preStmt .= "WHERE userId = :userId ";
        }

        if( $limits ) {
            if( $offsets ) {
                $preStmt .= "ORDER BY date DESC limit :offsets, :limits";
            } else {
                $preStmt .= "ORDER BY date DESC limit :limits";
            }
        } else {
            $preStmt .= "ORDER BY date DESC";
        }

        $stmt = $dblink->prepare( $preStmt );

        $userId ? $stmt->bindParam( ":userId", $userId ): "";
        $limits ? $stmt->bindParam( ":limits", $limits, PDO::PARAM_INT):"";
        if( $limits )
            $offsets ? $stmt->bindParam( ":offsets", $offsets, PDO::PARAM_INT):"";
        if($stmt->execute()) {
            return $stmt->fetchAll( PDO::FETCH_ASSOC ); 
        } else {
            var_dump($stmt->errorInfo());
            return [];
        }
    }
}