<?php
require_once 'Database.php';
require_once 'Config.php';
require_once 'Validate.php';
require_once 'Input.php';

$GLOBALS['config'] = [
    'mysql' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'database' => 'test',
        'something' => [
            'no' => [
                'foo' => [
                    'bar' => 'baz'
                ]
            ],
        ]
    ],

    'config_my' => []

];


if (Input::exists()) {
    $validate = new Validate();

    $validation = $validate->check($_POST, [
        'username' => [
            'required' => true,
            'min' => 2,
            'max' => 15,
            'unique' => 'users'
        ],
        'password' => [
            'required' => true,
            'min' => 3
        ],
        'password_again' => [
            'required' => true,
            'matches' => 'password'
        ]
    ]);


    if ($validation->passed()) {
        echo 'passed';
    } else {
        foreach ($validation->errors() as $error) {
            echo $error . "<br>";
        }
    }
}


?>

<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo Input::get('username')?>">
    </div>

    <div class="field">
        <label for="">Password</label>
        <input type="text" name="password">
    </div>

    <div class="field">
        <label for="">Password Again</label>
        <input type="text" name="password_again">
    </div>

    <div class="field">
        <button type="submit">Submit</button>
    </div>
</form>



