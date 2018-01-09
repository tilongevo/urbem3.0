(function ($, global, urbem) {
    'use strict';

    var UrbemSearch = UrbemSonata.UrbemSearch,
        agencia = urbem.giveMeBackMyField('agencia'),
        codBancoField = UrbemSonata.giveMeBackMyField("codBanco"),
        codAgenciaField = UrbemSonata.giveMeBackMyField("codAgencia"),
        numContaField = UrbemSonata.giveMeBackMyField("numConta"),
        choiceValFunc = UrbemSonata.giveMeBackMyField("choiceValFunc"),
        funcao = UrbemSonata.giveMeBackMyField("funcao"),
        funcaoDefault = UrbemSonata.giveMeBackMyField("funcaoDefault"),
        responsavelChoice = UrbemSonata.giveMeBackMyField("responsavelChoice"),
        responsavelConta = UrbemSonata.giveMeBackMyField("responsavelConta"),
        responsavelEnderecoTable = UrbemSonata.giveMeBackMyField("responsavelEnderecoTable"),
        valor = UrbemSonata.giveMeBackMyField("valor");

    var populateAgenciaField = function (fieldBanco) {
        var codBanco = fieldBanco.val();

        abreModal('Carregando','Aguarde, buscando a dados...');

        UrbemSearch
            .findAgenciasByBanco(codBanco)
            .success(function (data) {
                numContaField.select2('val','')
                UrbemSonata.populateSelect(codAgenciaField, data, {
                    value: 'codAgencia',
                    label: 'nomAgencia'
                });

                fechaModal();

                if (data.length > 0) {
                    codAgenciaField.prop('disabled', false);
                }
            });
    };

    var consultarFuncaoPadrao = function(field) {
        $.ajax({
            url: "/administrativo/administracao/gerador-calculo/funcao/consultar-funcao-padrao",
            method: "GET",
            success: function (data) {

                UrbemSonata.populateSelect(field,data, {
                    value: 'id',
                    label: 'label'
                });
            },
            fail: function (data) {
                console.log(data)
            }
        });
    };

    var recuperaEnderecoResponsavel = function(cgm) {
        $.ajax({
            url: '/administrativo/cgm/pessoa-fisica/recupera-endereco',
            data: { cgm: cgm },
            method: 'POST',
            dataType: 'json',
        }).success(function (enderecoResponsavel) {
            createCamposEnderecoResponsavel(enderecoResponsavel);
        }).fail(function(data) {
            console.log(data);
        });
    };

    var createCamposEnderecoResponsavel = function(enderecoResponsavel) {
        var tabelaCriada = $('#table-endereco-responsavel');

        var table = "<div id='table-endereco-responsavel' class='form_row col s12 campo-sonata '>";
        table += "<table class='bordered highlight table-striped'>";
        table += "<tbody>";
        table += "<tr>";
        table += "<td style='width: 25%'>Endereço: </td>";
        table += "<td style='text-align: left'>" + enderecoResponsavel.logradouro + " ";
        table += enderecoResponsavel.numero;
        table += "</td>";
        table += "</tr>";
        table += "<tr>";
        table += "<td style='width: 25%'>Cep: </td>";
        table += "<td style='text-align: left'>";
        table += enderecoResponsavel.cep;
        table += "</td>";
        table += "</tr>";
        table += "<tr>";
        table += "<td style='width: 25%'>Telefone: </td>";
        table += "<td style='text-align: left'>";
        table += enderecoResponsavel.telefone;
        table += "</td>";
        table += "</tr>";
        table += "</tbody>";
        table += "</table>";
        table += "</div>";

        if (tabelaCriada.length == 0) {
            responsavelEnderecoTable.replaceWith(table);
        } else {
            tabelaCriada.replaceWith(table);
        }

        fechaModal();
    };

    funcao.select2('readonly', true);
    responsavelConta.select2('readonly', true);

    // Se o field de Banco estiver vazio
    if (!codBancoField.val().trim()) {
        codAgenciaField.prop('disabled', true);
        numContaField.prop('disabled', true);
    }

    choiceValFunc.on('change', function (event) {
        if (event.val == "V") {
            valor.prop('readonly', false);
            funcao.select2('readonly', true);

            consultarFuncaoPadrao(funcao);
        } else {
            valor.prop('readonly', true);
            funcao.select2('readonly', false);
        }
    });

    responsavelChoice.on('change', function (event) {
      if($(this).val() != '') {
        var responsavelSelecionado = event.val,
            dependenteChoice = "D";

        var tabelaCriada = $('#table-endereco-responsavel');

        if (responsavelSelecionado == dependenteChoice) {
            responsavelConta.select2('readonly', true);
            responsavelConta.select2('val', '');
            if (tabelaCriada.length > 0) {
                tabelaCriada.hide();
            }
        } else {
            responsavelConta.select2('readonly', false);
        }
      }
    });

    codBancoField.on('select2-close', function (elem) {
        var campo = $(this);

        if (campo.val() != "") {
            elem.stopPropagation();
            populateAgenciaField(campo);
        }
    });

    codAgenciaField.on('select2-close', function (elem) {
        elem.stopPropagation();
        numContaField.prop('disabled', false);
    });

    responsavelConta.on('change', function(){
        var cgm = $(this).val();
        abreModal('Carregando','Aguarde, buscando a dados...');

        if (cgm) {
            recuperaEnderecoResponsavel(cgm);
        }
    });

    if (responsavelConta.val()) {
        abreModal('Carregando','Aguarde, buscando a dados...');
        recuperaEnderecoResponsavel(responsavelConta.val());
    }

    if (choiceValFunc.val() == 'F') {
        funcao.select2('readonly', false)
        valor.prop('readonly', true)
    } else {
        funcao.select2('readonly', true)
        valor.prop('readonly', false)
    }

    if (responsavelChoice.val() == 'R') {
        responsavelConta.select2('readonly', false);
    } else {
        responsavelConta.select2('readonly', true);
    }
})(jQuery, window, UrbemSonata);
