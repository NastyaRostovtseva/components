<?php
require_once 'Database.php';

////$users = Database::getInstance()->query("SELECT * FROM users WHERE username IN (?, ?)", ['Petr', 'Ivan']);
//$users = Database::getInstance()->get('users', ['password', '=', 'password1']);
//Database::getInstance()->delete('users', ['username', '=', 'Petr']);

Database::getInstance()->insert('users', [
    'username' => 'Lana',
    'password' => 'password3'
]);

//if ($users->error()){
//    echo 'we haw an error';
//} else {
//    foreach ($users->results() as $user) {
//        echo $user->username . '<br>';
//    }
//}

