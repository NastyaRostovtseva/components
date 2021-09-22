<?php

class User {
    private $db;
    private $data;
    private $session_name;
    private $isLoggedIn;

    public function __construct($user = null)
    {
        $this->db = Database::getInstance();
        $this->session_name = Config::get('session.user_session');

        if(!$user) {
            if (Session::exists($this->session_name)) {
                $user = Session::get($this->session_name); //id

                if($this->find($user)) {
                    $this->isLoggedIn = true;
                } else {
                    //logout
                }
            }
        }
    }

    public function create($fields = [])
    {
        $this->db->insert('users', $fields);
    }

    public function login($email = null, $password = null, $remember = false)
    {
//если нет емайл и логина и пользователь существет, то записываем ему сессию и авторизовываем его
        if(!$email && !$password && $this->exists()) {
            Session::put($this->session_name, $this->data()->id);
        } else {
            $user = $this->find($email);
//если пользователь есть, то проверяем пароль и записываем сессию
            if($user) {
                if(password_verify($password, $this->data()->password)) {
                    Session::put($this->session_name, $this->data()->id);
//генерация хэша и запись куки
                    if($remember) {
                        $hash = hash('sha256', uniqid());
// проверка,есть ли запись пользователя в базе, методом get вытащили запись
                        $hashCheck = $this->db->get('user_sessions', ['user_id', '=', $this->data()->id]);
//если нет записи, то создаем новую запись, передаем hash
                        if(!$hashCheck->count()) {
                             $this->db->insert('user_sessions', [
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ]);
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->cookieName, $hash, Config::get('cookie.cookie_expiry'));
                    }
                    return true;
                }
            }
        }
        return false;
    }

    public function find($value = null)
    {
        if(is_numeric($value)) {
            $this->data = $this->db->get('users', ['id', '=', $value])->first();
        } else {
            $this->data = $this->db->get('users', ['email', '=', $value])->first();
        }

        if($this->data) {
            return true;
        }
        return false;
    }

    public function data()
    {
        return $this->data;
    }

    public function  isLoggedIn()
    {
        return $this->isLoggedIn;
    }

    public function logout()
    {
        Session::delete($this->session_name);
    }
}