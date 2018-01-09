var entidade = $("select#" + UrbemSonata.uniqId + "_fkOrcamentoEntidade"),
    codEntidade = $("#" + UrbemSonata.uniqId + "_codEntidade"),
    conta = $("select#" + UrbemSonata.uniqId + "_fkContabilidadePlanoAnalitica"),
    codConta = $("#" + UrbemSonata.uniqId + "_codConta"),
    valor = $("#" + UrbemSonata.uniqId + "_valor"),
    exercicio = $("#" + UrbemSonata.uniqId + "_exercicio"),
    boletim = $("select#" + UrbemSonata.uniqId + "_fkTesourariaBoletim"),
    codBoletim = $("#" + UrbemSonata.uniqId + "_codBoletim"),
    receita = $("select#" + UrbemSonata.uniqId + "_receita"),
    codReceita = $("#" + UrbemSonata.uniqId + "_codReceita"),
    contaDeducao = $("select#" + UrbemSonata.uniqId + "_contaDeducao"),
    codContaDeducao = $("#" + UrbemSonata.uniqId + "_codContaDeducao"),
    valorDeducao = $("#" + UrbemSonata.uniqId + "_valorDeducao"),
    codigoBarrasOptica = $("#" + UrbemSonata.uniqId + "_codigoBarrasOptica"),
    codigoBarras = $("#" + UrbemSonata.uniqId + "_codigoBarras"),
    edit = $("#" + UrbemSonata.uniqId + "_edit");

boletim.empty().append('<option value="">Selecione</option>');
receita.empty().append('<option value="">Selecione</option>');
contaDeducao.empty().append('<option value="">Selecione</option>');

codigoBarrasOptica.attr('disabled', true);
codigoBarras.attr('disabled', true);
receita.attr('disabled', true);
receita.attr('required', true);
conta.attr('disabled', true);
valor.attr('disabled', true);

entidade.on('change', function(){
    carregaBoletins(exercicio.val(), $(this).val());
    carregaReceitas(exercicio.val(), $(this).val());
    carregaContasDeducao(exercicio.val(), $(this).val());
    codEntidade.val($(this).val());
    entidade.attr('disabled', true);
    receita.attr('disabled', false);
    conta.attr('disabled', false);
    valor.attr('disabled', false);
});

if ( (codReceita.val() != '') && (edit.val() == 0) ) {
    permiteAlterarDeducao(false);
} else {
    permiteAlterarDeducao(true);
}
receita.on('change', function() {
    codReceita.val($(this).val());
    if ($(this).val() != '') {
        permiteAlterarDeducao(false);
    } else {
        valorDeducao.val('');
        permiteAlterarDeducao(true);
    }

});

boletim.on('change', function() {
    codBoletim.val($(this).val());
});

contaDeducao.on('change', function() {
    codContaDeducao.val($(this).val());
});

conta.on('change', function() {
    codConta.val($(this).val());
});

function permiteAlterarDeducao(parametro) {
    contaDeducao.attr('disabled', parametro);
    valorDeducao.attr('disabled', parametro);
    if (parametro) {
        contaDeducao.select2("val", "");
    }
}

function carregaBoletins(exercicio, codEntidade) {
    $.ajax({
        url: "/financeiro/tesouraria/arrecadacao/orcamentaria-arrecadacoes/boletim",
        method: "POST",
        data: {exercicio: exercicio, codEntidade: codEntidade},
        dataType: "json",
        success: function (data) {
            boletim.empty();
            var count = Object.keys(data).length;
            var pos = 1;
            var selected = '';
            $.each(data, function (index, value) {
                var situacao = '';
                if ( codBoletim.val() != '' ) {
                    if (value == codBoletim.val()) {
                        situacao = ' selected';
                        selected = value;
                    }
                } else {
                    if ( pos == count ) {
                        situacao = ' selected';
                        selected = value;
                    }
                }
                boletim.append('<option value="' + value + '"' + situacao + '>' + index + '</option>');
                pos++;
            });
            codBoletim.val(selected);
            boletim.select2("val", selected);
        }
    });
}

function carregaReceitas(exercicio, codEntidade) {
    $.ajax({
        url: "/financeiro/tesouraria/arrecadacao/orcamentaria-arrecadacoes/receita",
        method: "POST",
        data: {exercicio: exercicio, codEntidade: codEntidade},
        dataType: "json",
        success: function (data) {
            var selected = '';
            receita.empty().append('<option value="">Selecione</option>');
            $.each(data, function (index, value) {
                var situacao = '';
                if (codReceita.val() == value) {
                    selected = value;
                    situacao = ' selected';
                }
                receita.append('<option value="' + value + '"' + situacao + '>' + index + '</option>');
            });
            receita.select2("val", selected);
        }
    });
}

function carregaContasDeducao(exercicio, codEntidade) {
    $.ajax({
        url: "/financeiro/tesouraria/arrecadacao/orcamentaria-arrecadacoes/conta-deducao",
        method: "POST",
        data: {exercicio: exercicio, codEntidade: codEntidade},
        dataType: "json",
        success: function (data) {
            contaDeducao.empty().append('<option value="">Selecione</option>');
            var selected = '';
            $.each(data, function (index, value) {
                var situacao = '';
                if (codContaDeducao.val() == value) {
                    selected = value;
                    situacao = ' selected';
                }
                contaDeducao.append('<option value="' + value + '"' + situacao + '>' + index + '</option>');
            });
            contaDeducao.select2("val", selected);
        }
    });
}

if (entidade.val() != '') {
    carregaBoletins(exercicio.val(), entidade.val());
    carregaReceitas(exercicio.val(), entidade.val());
    carregaContasDeducao(exercicio.val(), entidade.val());
    entidade.attr('disabled', true);
    if (edit.val() == 0) {
        receita.attr('disabled', false);
        conta.attr('disabled', false);
        valor.attr('disabled', false);
    }
}

$( "form" ).submit(function( event ) {
    entidade.attr('disabled', false);
});