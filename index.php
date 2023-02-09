<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TesteBrasiltec</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js" defer></script>
</head>

<body>
    <form class="wrapper" method="POST" action="processa.php" onsubmit="return validateForm()">
        <div class="content-box">
            <h1>Formulário</h1>
            <div class="content">
                <label>Nome*</label>
                <input type="text" name="nome" id="nome" required>
                <label>Email*</label>
                <input type="email" name="email" id="email" required>
            </div>
            <select name="tipo_pessoa" id="tipo_pessoa" style="width: 237px;">
                    <option selected value="0">Escolha o tipo de pessoa: </option>
                    <option value="cpf">CPF</option>
                    <option value="cnpj">CNPJ</option>
                </select>
            <div id="cpf" class="inline-block" style="margin-left: 31.5px;">
                <label>CPF*</label>
                <input type="number" name="cpf" id="cpf_input">
            </div>
            <div id="cnpj" class="inline-block" style="margin-left: 20px;">
                <label>CNPJ*</label>
                <input type="number" name="cnpj" id="cnpj_input">
            </div>
            <button class="flex" type="submit" value="Submit">Enviar</button>
        </div>
    </form>
</body>

</html>