<?php
class Users {
    public function getUsers( $columns, $active ) {
        $dblink = Database::getDatabase();
        $tbName = DB::userTbName;
        $pidName = "userId";


        $colstr = implode( ",", $columns );
        $preStmt = "SELECT $colstr FROM $tbName WHERE type = 0 ";

        if( $active == 1 ) {
            $preStmt .= "AND active = 1";
        } else if( $active == 0)  {
            $preStmt .= "AND active = 0";
        }

        $preStmt .= "ORDER BY $pidName";

        $stmt = $dblink->prepare( $preStmt );
        if($stmt->execute()) {
            return $stmt->fetchAll( PDO::FETCH_ASSOC ); 
        } else {
            return [];
        }
    }
}