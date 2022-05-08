<?php

require __DIR__ ."/../vendor/autoload.php";

use App\Models\User;

$user = (new User())->findById(6);

if ($user) {
    $user->destroy();
} else {
    var_dump($user);
}