<?php

class User {
    private $db;
    private $data;
    private $session_name;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->session_name = Config::get('session.user_session');
    }

    public function create($fields = [])
    {
        $this->db->insert('users', $fields);
    }

    public function login($email = null, $password = null)
    {
        if($email) {

            $user = $this->find($email);

            if($user) {
                if(password_verify($password, $this->data()->password)) {
                    Session::put($this->session_name, $this->data()->id);
                    return true;
                }
            }
        }
        return false;
    }

    public function find($email = null)
    {
        if($email) {
            $this->data = $this->db->get('users', ['email', '=', $email])->first();
            return true;
        }
        return false;
    }

    public function data()
    {
        return $this->data;
    }
}