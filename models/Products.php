<?php
class Products {
    public function load( $columns, $search, $offsets, $limits, $active ) {
        $dblink = Database::getDatabase();
        $tbName = DB::productTbName;
        $pidName = "productId";

        $colstr = implode( ",", $columns );
        $preStmt = "SELECT $colstr FROM $tbName ";

        if( $active === 1 ) {
            $preStmt .= "WHERE active = 1";
        } else if( $active === 0 ) {
            $preStmt .= "WHERE active = 0";
        }

        if( $search ) {
            $name = '%'.$search.'%';
            $preStmt .= " AND name LIKE :NAME ";
        }

        if( $limits ) {
            if( $offsets ) {
                $preStmt .= "ORDER BY date DESC limit :offsets, :limits";
            } else {
                $preStmt .= "ORDER BY date DESC limit :limits";
            }
        }

        $stmt = $dblink->prepare( $preStmt );

        $search ? $stmt->bindParam( ":NAME", $name ): "";
        $limits ? $stmt->bindParam( ":limits", $limits, PDO::PARAM_INT):"";
        if( $limits )
            $offsets ? $stmt->bindParam( ":offsets", $offsets, PDO::PARAM_INT):"";
        if($stmt->execute()) {
            return $stmt->fetchAll( PDO::FETCH_ASSOC ); 
        } else {
            return [];
        }
    }

    public function count( $search, $active ) {
        $dblink = Database::getDatabase();
        $tbName = DB::productTbName;
        $pidName = "productId";

        $preStmt = "SELECT COUNT($pidName) as productCount FROM $tbName ";

        if( $active === 1 ) {
            $preStmt .= "WHERE active = 1";
        } else if( $active === 0 ) {
            $preStmt .= "WHERE active = 0";
        }

        if( $search ) {
            $name = '%'.$search.'%';
            $preStmt .= " AND name LIKE :NAME ";
        }

        $stmt = $dblink->prepare( $preStmt );

        $search ? $stmt->bindParam( ":NAME", $name ): "";

        if($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        } else {
            return [];
        }
    }
}