<?php

require __DIR__."/../vendor/autoload.php";

use App\Models\User;

$user = new User();
$user->nome = "Pedross";
$user->sobrenome = "Brião";
$user->cpf = "99920131";
$user->telefone = "5521999830221";
$user->email = "pedro@hotmails.com";
$user->save();

var_dump($user);