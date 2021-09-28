<?php
require_once 'init.php';

$user = new User;

$validate = new Validate();
$validate->check($_POST, [
        'current_password' => [
            'required' => true,
            'min' => 3,
        ],
        'new_password' => [
            'required' => true,
            'min' => 3,
        ],
        'new_password_again' => [
            'required' => true,
            'min' => 3,
            'matches' => 'new_password',
        ],
    ]
);

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

        if ($validate->passed()) {
            if(!password_verify(Input::get('current_password'), $user->data()->password)) {
                $user->update(['password' => password_hash(Input::get('new_password'), PASSWORD_DEFAULT)]);
                Session::flash('success', 'Password has been updated');
                Redirect::to('index.php');
            } else {
                echo 'Current password is invalid';
            }

        } else {
            foreach ($validate->errors() as $error) {
                echo $error . '<br>';
            }
        }
    }
}

?>


<form action="" method="post">
    <div class="field">
        <label for="username">Сurrent password</label>
        <input type="text" name="current_password" id="username">
    </div>

    <div class="field">
        <label for="username">New password</label>
        <input type="text" name="new_password" id="username" value="">
    </div>

    <div class="field">
        <label for="username">New password again</label>
        <input type="text" name="new_password_again" id="username">
    </div>

    <div class="field">
        <button type="submit">Submit</button>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
</form>