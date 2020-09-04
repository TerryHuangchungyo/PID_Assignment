<?php
abstract class Model {
    private $isLoad;

    public function __set( $name, $value ) {
        $this->$name = $value;
    }

    public function __get( $name ) {
        return $this->$name;
    }
    
    protected abstract function getDatabase();
    protected abstract function getTbName();
    protected abstract function getPidName();

    public function create( $options ) {
        $dblink = $this->getDatabase();
        $tbName = $this->getTbName();
        $colstr = implode( ",", array_keys($options) );
        $prestr = "INSERT INTO $tbName ( $colstr ) VALUES(";

        foreach( $options as $key => $value) {
            $prestr .= ":$key,";
            $this->$key = $value;
        }
        $prestr = rtrim( $prestr, ",");
        $prestr .= ");";
        $stmt = $dblink->prepare($prestr);
        if( $stmt->execute($options) ) {
            $this->isLoad = true;
        } else {
            $this->isLoad = false;
        }
        return $this->isLoad;
    }

    public function load( $columns, $pid ) {
        $dblink = $this->getDatabase();
        $tbName = $this->getTbName();
        $pidName = $this->getPidName();

        $colstr = implode( ",", $columns );
        $prestr = "SELECT $colstr FROM $tbName WHERE $pidName = :$pidName;";

        $stmt = $dblink->prepare( $prestr );
        $stmt->bindParam( ":$pidName", $pid );

        $dblink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $result = $stmt->execute();
            $data = $stmt->fetch( PDO::FETCH_ASSOC );
            if( $data ) {
                foreach( $data as $key => $value ) {
                    $this->$key = $value;
                }
                $this->$pidName = $pid;
                $this->isLoad = true;
            } else {
                $this->isLoad = false;
            }
        } catch( Exception $e ) {
            $this->isLoad = false;
        }
        return $this->isLoad;
    }

    public function save( $columns = [] ) {
        if( $this->isLoad && $columns ) {
            $dblink = $this->getDatabase();
            $tbName = $this->getTbName();
            $pidName = $this->getPidName();

            $updatePrestr = "UPDATE $tbName SET ";
            $params = [];
            foreach( $columns as $column ) {
                $params[] = $this->$column;
                $updatePrestr .= "$column = ?,";
            }
            $params[] = $this->$pidName;
            $updatePrestr = rtrim( $updatePrestr, ",");
            $updatePrestr .= " WHERE $pidName = ?";


            $dblink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try {
                $stmt = $dblink->prepare( $updatePrestr );
                $stmt->execute($params);
                return true;
            } catch( Exception $e ) {
                return false;
            }
        }
    }
}