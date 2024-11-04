<?php

//comienza la sesión
session_start();

//now, let's register our session variables
$_SESSION['musculo'] = 'musculo';
$_SESSION['repeticiones'] = 'repeticiones';

//finally, let's store our posted values in the session variables
$_SESSION['musculo'] = $_POST['musculo'];
$_SESSION['repeticiones'] = $_POST['repeticiones'];

?>
<form method="post" action="form3.php">
    <label for="">Free</label>
    <label for="">Normal</label>
    <label for="">Deluxe</label>
    <input type="radio" name="membership_type" value="Free">
    <input type="radio" name="membership_type" value="Normal">
    <input type="radio" name="membership_type" value="Deluxe">
    <input type="checkbox" name="terms_and_conditions">
    <input type="submit" value="Siguiente">
</form>