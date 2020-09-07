<?php
class OrderDetail extends Model {
    protected function getDatabase() {
        return Database::getDatabase();
    }

    protected function getTbName() {
        return DB::orderDetailTbName;
    }

    protected function getPidName() {
        return "orderId";
    }
}