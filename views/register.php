<?php

use app\core\form\Form;

?>

<h1>Register</h1>
<?php $form = Form::begin('/register','post'); ?>
<table>
<?php 
    echo $form->filed($model, 'firstname', 'First Name'); 
    echo $form->filed($model, 'lastname', 'Last Name');
    echo $form->filed($model, 'email', 'Email')->emailField();
    echo $form->filed($model, 'password', 'Password')->passwordField();
    echo $form->filed($model, 'confirmPassword', 'Confirm Password')->passwordField();
?>
</table>
<button>Submit</button>
<?php $form->end(); ?>