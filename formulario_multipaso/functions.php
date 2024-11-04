<?php

function generateForm(){
    $html = `<form method="post" action="form2.php">
    <input type="text" name="name">
    <input type="text" name="email_address">
    <input type="submit" value="Go To Step 2">
    </form>`;
}