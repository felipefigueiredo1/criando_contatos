<?php

require __DIR__."/../vendor/autoload.php";

use CoffeeCode\DataLayer\Connect;

use App\Models\User;

$user = new User();

//List faz uso do método
$list = $user->find()->fetch(true);

foreach ($list as $userItem) {
    var_dump($userItem->sobrenome);
    var_dump($userItem->addresses());
}