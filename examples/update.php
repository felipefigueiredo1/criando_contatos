<?php

require __DIR__ ."/../vendor/autoload.php";

use App\Models\User;

$user = (new User())->findById(10);
$user->nome = "Lucas";
$user->save();
var_dump($user);