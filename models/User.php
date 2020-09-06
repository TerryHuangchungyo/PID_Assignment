<?php
class User extends Model {
    protected function getDatabase() {
        return Database::getDatabase();
    }

    protected function getTbName() {
        return DB::userTbName;
    }

    protected function getPidName() {
        return "userId";
    }
}