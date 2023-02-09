<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "cadastro";

$conexao = mysqli_connect($servidor, $usuario, $senha, $dbname);

$nome = filter_input(INPUT_POST, 'nome');
$email = filter_input(INPUT_POST, 'email');
$cpf = filter_input(INPUT_POST, 'cpf');
$cnpj = filter_input(INPUT_POST, 'cnpj');

$result_usuario = "INSERT INTO cadastro (nome, email, cpf, cnpj) VALUES ('$nome', '$email', '$cpf', '$cnpj')";
$resultado_usuario = mysqli_query($conexao, $result_usuario);