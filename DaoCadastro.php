<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "cadastro";

$conexao = mysqli_connect($servidor, $usuario, $senha, $dbname);

if (!$conexao) {
    die("Conexão falhou: " . mysqli_connect_error());
}

$nome = filter_input(INPUT_POST, 'nome');
$email = filter_input(INPUT_POST, 'email');
$cpf = filter_input(INPUT_POST, 'cpf');
$cnpj = filter_input(INPUT_POST, 'cnpj');

// Verifica se o CPF ou o CNPJ já existem na tabela
$check_cpf = "SELECT * FROM cadastro WHERE cpf = '$cpf'";
$check_cnpj = "SELECT * FROM cadastro WHERE cnpj = '$cnpj'";
$result_cpf = mysqli_query($conexao, $check_cpf);
$result_cnpj = mysqli_query($conexao, $check_cnpj);

if (!empty($cpf) && empty($cnpj)) {
    if (mysqli_num_rows($result_cpf) > 0) {
        // CPF ou CNPJ já existem na tabela
        $response = array("status" => "error", "message" => "Este CPF já existe no banco de dados");
    } else if (validaCPF($cpf) === true) {    // Insere os dados na tabela
        $cadastro = "INSERT INTO cadastro (nome, email, cpf, cnpj) VALUES ('$nome', '$email', '$cpf', '$cnpj')";
        if (mysqli_query($conexao, $cadastro)) {
            $response = array("status" => "success");
        } else {
            $response = array("status" => "error");
        }
    } else {
        $response = array("status" => "error", "message" => "Insira um CPF válido!");
    }
} else if (!empty($cnpj) && empty($cpf)) {
    if (mysqli_num_rows($result_cnpj) > 0) {
        // CPF ou CNPJ já existem na tabela
        $response = array("status" => "error", "message" => "Este CNPJ já existe no banco de dados");
    } else if (ValidaCnpj($cnpj) === true) {    // Insere os dados na tabela
        $cadastro = "INSERT INTO cadastro (nome, email, cpf, cnpj) VALUES ('$nome', '$email', '$cpf', '$cnpj')";
        if (mysqli_query($conexao, $cadastro)) {
            $response = array("status" => "success");
        } else {
            $response = array("status" => "error");
        }
    } else {
        $response = array("status" => "error", "message" => "Insira um CNPJ válido!");
    }
}

function validaCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    if (strlen($cpf) != 11) {
        return false;
    }

    $digitoA = 0;
    $digitoB = 0;
    for ($i = 0, $x = 10; $i <= 8; $i++, $x--) {
        $digitoA += $cpf[$i] * $x;
    }
    for ($i = 0, $x = 11; $i <= 9; $i++, $x--) {
        if (str_repeat($i, 11) == $cpf) {
            return false;
        }
        $digitoB += $cpf[$i] * $x;
    }

    $somaA = (($digitoA % 11) < 2) ? 0 : 11 - ($digitoA % 11);
    $somaB = (($digitoB % 11) < 2) ? 0 : 11 - ($digitoB % 11);

    if ($somaA != $cpf[9] || $somaB != $cpf[10]) {
        return false;
    }

    return true;
}

function ValidaCnpj(string $document): bool
{
    // Extrai os números
    $cnpj = preg_replace('/[^0-9]/is', '', $document);

    // Valida tamanho
    if (strlen($cnpj) != 14) {
        return false;
    }

    // Verifica sequência de digitos repetidos. Ex: 11.111.111/111-11
    if (preg_match('/(\d)\1{13}/', $cnpj)) {
        return false;
    }

    // Valida dígitos verificadores
    for ($t = 12; $t < 14; $t++) {
        for ($d = 0, $m = ($t - 7), $i = 0; $i < $t; $i++) {
            $d += $cnpj[$i] * $m;
            $m = ($m == 2 ? 9 : --$m);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cnpj[$i] != $d) {
            return false;
        }
    }
    return true;
}


mysqli_close($conexao);

header('Content-Type: application/json');
echo json_encode($response);
