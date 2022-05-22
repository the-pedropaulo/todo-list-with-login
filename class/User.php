<?php

require_once('Crud.php');

class User extends Crud {
    protected string $table = 'usuarios';

    function __construct(
        public string $name,
        private string $email,
        private string $password,
        private string $repeat_password="",
        private string $token="",
        private string $confirm_code="",
        private string $status = "",
        public array $error = []
    ){}

    public function setRepetition($repeat_password) {
        $this->repeat_password = $repeat_password;
    }

    public function validateRegistration() {
        $string_validate = "/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ'\s]+$/";
        if (!preg_match($string_validate, $this->name)) {
            $this->error["name_error"] = "Por favor, informe um nome válido";
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->error["email_error"] = "Por favor, informe um e-mail válido";
        }

        if(strlen($this->password) < 6) {
            $this->error["password_error"] = "Sua senha deve ter 6 ou mais caracteres!";
        }

        if($this->password !== $this->repeat_password) {
            $this->error["repeat_password_error"] = "Senha e repetição de senha diferentes";

        }
    }

    public function insert() {
        $sql = "SELECT * FROM $this->table WHERE email=? LIMIT 1";
        $sql = Database::queryPrepare($sql);
        $sql->execute(array($this->email));
        $user = $sql->fetch();

        if(!$user) {
            $date_now = date('d/m/Y');
            $encrypted_pass = sha1($this->password);

            $sql = "INSERT INTO $this->table VALUES(null, ?,?,?,?,?,?,?,?)";
            $sql = Database::queryPrepare($sql);
            $sql->execute(array(
                $this->name, 
                $this->email,
                $encrypted_pass, 
                $encrypted_pass,
                $this->token, 
                $this->confirm_code,
                $this->status, 
                $date_now
            ));
        } else {
            $this->error["general_error"] = "Usuário já cadastrado!";
        }
    }

    public function update($id) {
        $sql = "UPDATE $this->table SET token=? WHERE id=?";
        $sql = Database::queryPrepare($sql);
        return $sql->execute(array($this->token, $id));
    }
}