<?php
function getUsers() {
    return readCSV('csv/users-table.csv');
}
?>