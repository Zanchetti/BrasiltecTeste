<!DOCTYPE html>
<html lang="pt-BR">

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
    <form class="wrapper" method="POST" action="DaoCadastro.php" id="main_form">
        <div class=" content-box">
            <h1>Formulário</h1>
            <div class="content">
                <div>
                    <label>Nome*</label>
                    <input type="text" name="nome" id="nome" required>
                </div>
                <div>
                    <label>Email*</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <select name="tipo_pessoa" id="tipo_pessoa">
                    <option selected value="0">Escolha o tipo de pessoa: </option>
                    <option value="cpf">CPF</option>
                    <option value="cnpj">CNPJ</option>
                </select>
                <div id="cpf" class="inline-block" style="width: 220.46px">
                    <label>CPF*</label>
                    <input type="text" name="cpf" id="cpf_input" maxlength="14" onkeyup="mascara_cpf()">
                </div>
                <div id="cnpj" class="inline-block">
                    <label>CNPJ*</label>
                    <input type="text" name="cnpj" id="cnpj_input" maxlength="18" onkeyup="mascara_cnpj()">
                </div>
            </div>
            <div><button type="submit" value="Submit">Enviar</button></div>
            <label id="result" class="result"></label>
        </div>
    </form>
</body>
<script>
    $("#result").hide();
    $(document).ready(function() {
        $("#main_form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "DaoCadastro.php",
                data: $("#main_form").serialize(),
                success: function(response) {
                    if (response.status == "success") {
                        $("#result").show();
                        $("#result").css("color", "green");
                        $("#result").html("Os dados foram cadastrados com sucesso!");
                    } else {
                        $("#result").show();
                        $("#result").css("color", "red");
                        $("#result").html(response.message);
                    }
                }
            });
        });
    });

    function mascara_cpf() {
        var cpf = document.getElementById("cpf_input");
        if (cpf.value.length === 3 || cpf.value.length === 7) {
            cpf.value += "."
        } else if (cpf.value.length === 11) {
            cpf.value += "-"
        }
    }

    function mascara_cnpj() {
        var cnpj = document.getElementById("cnpj_input");
        if (cnpj.value.length === 2 || cnpj.value.length === 6) {
            cnpj.value += "."
        } else if (cnpj.value.length === 10) {
            cnpj.value += "/"
        } else if (cnpj.value.length === 15) {
            cnpj.value += "-"
        }
    }


    document.addEventListener("DOMContentLoaded", function() {
        const tipoPessoa = document.getElementById("tipo_pessoa");
        tipoPessoa.addEventListener("change", function() {
            if (this.value === "cpf") {
                document.getElementById("cnpj_input").value = "";
            } else if (this.value === "cnpj") {
                document.getElementById("cpf_input").value = "";
            }
        });
    });
</script>

</html>