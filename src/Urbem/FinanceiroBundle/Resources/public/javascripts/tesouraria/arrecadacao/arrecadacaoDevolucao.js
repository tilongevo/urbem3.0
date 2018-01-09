var entidade = $("select#" + UrbemSonata.uniqId + "_fkOrcamentoEntidade"),
    codEntidade = $("#" + UrbemSonata.uniqId + "_codEntidade"),
    conta = $("select#" + UrbemSonata.uniqId + "_fkContabilidadePlanoAnalitica"),
    codConta = $("#" + UrbemSonata.uniqId + "_codConta"),
    valor = $("#" + UrbemSonata.uniqId + "_valor"),
    exercicio = $("#" + UrbemSonata.uniqId + "_exercicio"),
    boletim = $("select#" + UrbemSonata.uniqId + "_fkTesourariaBoletim"),
    codBoletim = $("#" + UrbemSonata.uniqId + "_codBoletim"),
    receita = $("select#" + UrbemSonata.uniqId + "_receita"),
    codReceita = $("#" + UrbemSonata.uniqId + "_codReceita");

boletim.empty().append('<option value="">Selecione</option>');
receita.empty().append('<option value="">Selecione</option>');

receita.attr('disabled', true);
receita.attr('required', true);
conta.attr('disabled', true);
valor.attr('disabled', true);

entidade.on('change', function(){
    carregaBoletins(exercicio.val(), $(this).val());
    carregaReceitas(exercicio.val(), $(this).val());
    codEntidade.val($(this).val());
    entidade.attr('disabled', true);
    receita.attr('disabled', false);
    conta.attr('disabled', false);
    valor.attr('disabled', false);
});

receita.on('change', function() {
    codReceita.val($(this).val());
});

boletim.on('change', function() {
    codBoletim.val($(this).val());
});

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

if (entidade.val() != '') {
    carregaBoletins(exercicio.val(), entidade.val());
    carregaReceitas(exercicio.val(), entidade.val());
    entidade.attr('disabled', true);
    receita.attr('disabled', false);
    conta.attr('disabled', false);
    valor.attr('disabled', false);
}

$( "form" ).submit(function( event ) {
    entidade.attr('disabled', false);
});