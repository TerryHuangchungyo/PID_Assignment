<?php
class Order extends Model {
    protected function getDatabase() {
        return Database::getDatabase();
    }

    protected function getTbName() {
        return DB::orderTbName;
    }

    protected function getPidName() {
        return "orderId";
    }

    public function loadLastByUserId( $columns, $userId ) {
        $dblink = $this->getDatabase();
        $tbName = $this->getTbName();
        $pidName = $this->getPidName();

        $stmt = $dblink->prepare("SELECT MAX($pidName) as lastId FROM $tbName WHERE userId = :userId;" );
        $stmt->bindParam( ":userId", $userId );
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $lastId = $data["lastId"];

        $this->load( $columns, $lastId );
    }
}