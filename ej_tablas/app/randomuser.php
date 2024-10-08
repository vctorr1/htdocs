<?php

include_once('functions.php');

//función para cargar un registro aleatorio
function getRandomUser($usersData){
    //Usamos la función array_rand para obtener un elemento aleatorio del array de datos del csv
    $randomUser = array_rand($usersData);
    return $randomUser;
}

//Obtenemos los datos de los archivos CSV
$usersData = getDataFromCSV("../model/users-table.csv");
$postsData = getDataFromCSV("../model/posts-table.csv");

//$randomUser = getRandomUser($usersData);
$randomUser = $usersData[array_rand($usersData)];
//Se ejecuta el método al acceder al script
//Filtramos los posts del usuario seleccionado
$userPosts = array_filter($postsData, function($post) use ($randomUser) {
    return $post['user_id'] == $randomUser['id'];
});

//Si el usuario tiene posts, seleccionamos uno aleatorio
if (!empty($userPosts)) {
    $randomPost = $userPosts[array_rand($userPosts)];
} else {
    $randomPost = null;
}

//$finalRandom = getMarkup($usersData[$randomUser], $postsData[$randomPost]);
//Tenemos que adaptar los datos para getMarkup
$randomUserData = [$randomUser];
$randomUserPosts = $userPosts;
//obtenemos la tabla final, que enviamos al segundo template
$finalRandom = getMarkup($randomUserData, $randomUserPosts);


include "../templates/template2.php";

