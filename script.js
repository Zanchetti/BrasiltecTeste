$(document).ready(function() {
    $("#cpf").hide();
    $("#cnpj").hide();
    $("#tipo_pessoa").change(function() {
        if ($(this).val() == "0") {
            $("#cpf").hide();
            $("#cnpj").hide();
        }
        if ($(this).val() == "cpf") {
            $("#cnpj").hide();
            $("#cpf").show();
        }
        if ($(this).val() == "cnpj") {
            $("#cpf").hide();
            $("#cnpj").show();
        }
    });
});

const cpf = document.getElementById("cpf_input");
cpf.onchange = function() {
    if (TestaCPF(cpf.value) == true) {
        $("#cpf_input").css("border-color", "green");
    }
    if (TestaCPF(cpf.value) == false) {
        $("#cpf_input").css("border-color", "red");
    }
};

const cnpj = document.getElementById("cnpj_input");
cnpj.onchange = function() {
    if (TestaCNPJ(cnpj.value) == true) {
        $("#cnpj_input").css("border-color", "green");
    }
    if (TestaCNPJ(cnpj.value) == false) {
        $("#cnpj_input").css("border-color", "red");
    }
};

const email = document.getElementById("email");
email.onchange = function() {
    if (TestaEmail(email.value) == true) {
        $("#email").css("border-color", "green");
    }
    if (TestaEmail(email.value) == false) {
        $("#email").css("border-color", "red");
    }
};

const nome = document.getElementById("nome");
nome.onchange = function() {
    if (nome.value !== "" && nome.value !== undefined) {
        $("#nome").css("border-color", "green");
    } else {
        $("#nome").css("border-color", "red");
    }
};

function TestaEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function TestaCPF(strCPF) {
    strCPF = strCPF.replace(/[^\d]+/g, '');
    var Soma;
    var Resto;
    Soma = 0;
    if (strCPF == "00000000000") return false;

    for (i = 1; i <= 9; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10))) return false;

    Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11)) Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11))) return false;
    return true;
}

function TestaCNPJ(cnpj) {

    cnpj = cnpj.replace(/[^\d]+/g, '');

    if (cnpj == '') return false;

    if (cnpj.length != 14)
        return false;

    if (cnpj == "00000000000000" ||
        cnpj == "11111111111111" ||
        cnpj == "22222222222222" ||
        cnpj == "33333333333333" ||
        cnpj == "44444444444444" ||
        cnpj == "55555555555555" ||
        cnpj == "66666666666666" ||
        cnpj == "77777777777777" ||
        cnpj == "88888888888888" ||
        cnpj == "99999999999999")
        return false;

    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0, tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
        return false;

    return true;
}

$('#main_form').on('submit', function() {
    var cpf = document.getElementById("cpf_input").value;
    var cnpj = document.getElementById("cnpj_input").value;

    if (TestaCNPJ(cnpj) === TestaCPF(cpf)) {
        alert("Preencha corretamente todos os campos!");
        return false;
    } else {
        return true;
    }
});