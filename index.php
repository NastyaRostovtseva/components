<?php
require_once 'Database.php';

$users = Database::getInstance()->query("SELECT * FROM users WHERE username IN (?, ?)", ['Petr', 'Ivan']);

if ($users->error()){
    echo 'we haw an error';
} else {
    foreach ($users->results() as $user) {
        echo $user->username . '<br>';
    }
}

