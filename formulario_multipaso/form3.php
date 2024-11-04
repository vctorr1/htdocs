<?php


session_start();

//now, let's register our session variables
$_SESSION['membership_type'] = 'membership_type';

//finally, let's store our posted values in the session variables
$_SESSION['membership_type'] = $_POST['membership_type'];

?>

<form method="post" action="formFinal.php">
<input type="text" name="name_on_card" value="Nombre en la tarjeta">
<input type="text" name="credit_card_number" value="Numero de tarjeta">
<input type="text" name="credit_card_expiration_date" value="Fecha de caducidad de la tarjeta">
<input type="submit" value="Finish">
</form>