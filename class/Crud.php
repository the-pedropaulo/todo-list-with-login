<?php 

require_once('database.php');

abstract class Crud extends Database {
    protected string $table;

    abstract public function insert();
    abstract public function update($id);

    public function find($id) {
        $sql = "SELECT * FROM $this->table WHERE id=?";
        $sql = Database::queryPrepare($sql);
        $sql->execute(array($id));
        $value = $sql->fetch();
        return $value;
    }

    public function findAll() {
        $sql = "SELECT * FROM $this->table";
        $sql = Database::queryPrepare($sql);
        $sql->execute();
        $value = $sql->fetch();
        return $value;
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE id=?";
        $sql = Database::queryPrepare($sql);
        return $sql->execute(array($id));
    }
}