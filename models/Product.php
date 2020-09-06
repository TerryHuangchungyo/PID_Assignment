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
}