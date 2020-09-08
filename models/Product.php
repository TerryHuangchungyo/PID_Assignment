<?php
class Product extends Model {
    protected function getDatabase() {
        return Database::getDatabase();
    }

    protected function getTbName() {
        return DB::productTbName;
    }

    protected function getPidName() {
        return "productId";
    }

    public function getLastId() {
        $dblink = $this->getDatabase();
        $tbName = $this->getTbName();
        $pidName = $this->getPidName();

        $result = $dblink->query("SELECT MAX($pidName) as lastId FROM $tbName;", PDO::FETCH_ASSOC);
        $data = $result->fetch();
        $lastId = $data["lastId"];

        return $lastId;
    }
}