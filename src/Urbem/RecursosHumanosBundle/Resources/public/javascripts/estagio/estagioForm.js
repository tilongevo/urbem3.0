(function ($, global, urbem) {
    'use strict';

    var UrbemSearch = UrbemSonata.UrbemSearch,
        intermediadoraEstagios= urbem.giveMeBackMyField('intermediadoraEstagios'),
        vinculoEstagio = urbem.giveMeBackMyField('vinculoEstagio'),
        instituicaoEnsino = urbem.giveMeBackMyField('instituicaoEnsino'),
        curso = urbem.giveMeBackMyField('curso'),
        grauCurso = urbem.giveMeBackMyField('grauCurso'),
        valorBolsa = urbem.giveMeBackMyField('valorBolsa'),
        mesAvaliacao = urbem.giveMeBackMyField('mesAvaliacao'),
        grade = urbem.giveMeBackMyField('fkPessoalGradeHorario'),
        codEstagio = urbem.giveMeBackMyField('codEstagio'),
        agencia = urbem.giveMeBackMyField('agencia'),
        codBancoField = UrbemSonata.giveMeBackMyField("codBanco"),
        codAgenciaField = UrbemSonata.giveMeBackMyField("codAgencia"),
        numContaField = UrbemSonata.giveMeBackMyField("numConta");

    var populateSelect = function (select, data, prop) {
        var firstOption = select.find('option:first-child'),
            selectedOption = select.find('option:selected');

        select.empty().append(firstOption);

        $.each(data, function (index, item) {
            var attrs = {
                value: item[prop.value],
                text: item[prop.text]
            };

            if (selectedOption.val() == item[prop.value]) {
                attrs.selected = true;
            }

            select.append($('<option>', attrs));
        });

        select.select2();
    };

    var populateAgenciaField = function (fieldBanco) {
        var codBanco = fieldBanco.val();

        UrbemSearch
            .findAgenciasByBanco(codBanco)
            .success(function (data) {
                populateSelect(codAgenciaField, data, {value: 'codAgencia', text: 'nomAgencia'});

                if (data.length > 0) {
                    codAgenciaField.prop('disabled', false);
                }
            });
    };

    var populateNumContaField = function (fieldBanco, fieldAgencia) {
        var codAgencia = fieldAgencia.val(),
            codBanco = fieldBanco.val();

        UrbemSonata.UrbemSearch
            .findContasCorrenteByAgencia(codBanco, codAgencia)
            .success(function (data) {
                populateSelect(numContaField, data, {value: 'numContaCorrente', text: 'numContaCorrente'});

                if (data.length > 0) {
                    numContaField.prop('disabled', false);
                }
            });
    };

    // Se o field de Banco estiver vazio
    if (!codBancoField.val().trim()) {
        codAgenciaField.prop('disabled', true);
        numContaField.prop('disabled', true);
    } else {
        populateAgenciaField(codBancoField);
        populateNumContaField(codBancoField, codAgenciaField);
    }

    codBancoField.on('change', function (elem) {
        elem.stopPropagation();

        populateAgenciaField($(this));
    });

    codAgenciaField.on('change', function (elem) {
        elem.stopPropagation();

        populateNumContaField(codBancoField, $(this));
    });

    var limpaFormEstagio = function () {
        intermediadoraEstagios.select2('val','');
        vinculoEstagio.select2('val','');
        instituicaoEnsino.select2('val','');
        curso.select2('val','');
        grauCurso.select2('val','');
        valorBolsa.val('');
        mesAvaliacao.val('');
    };

    var recuperarInstituicoes = function (numcmg) {
        var data = {'numcgm' : numcmg};

        $.ajax({
            url: "/recursos-humanos/estagio/estagiario-estagio/preencher-instituicao",
            method: "POST",
            dataType: "json",
            data: data,
            success: function (data) {
                var options = "";
                curso.parent().find('div').find('span').first().html('Selecione');
                if (data != null) {
                    curso.find('option').remove();
                    options += '<option value="">' + 'Selecione' + '</option>';
                    $.each(data, function (val, item) {
                        options += '<option value="' + item.numcgm + '" >' + item.nom_cgm + '</option>';
                        instituicaoEnsino.html(options);
                    });
                }
                fechaModal();
            },
            fail: function () {
                fechaModal();
            }
        });
    };

    vinculoEstagio.on('ifChecked', function (event){
        if (event.target.value == "e") {
            intermediadoraEstagios.select2('readonly',false);
        } else {
            limpaFormEstagio();
            intermediadoraEstagios.select2('readonly',true);
            grauCurso.prop('readonly', true);
            curso.prop('readonly', true);
            recuperarInstituicoes();
        }
    });

    intermediadoraEstagios.prop('readonly', true);
    grauCurso.prop('readonly', true);
    curso.prop('readonly', true);
    mesAvaliacao.prop('readonly', true);

    var loadTable = function (codGrade) {

        $.get('/recursos-humanos/estagio/estagiario-estagio/monta-recupera-grade', {
            codGrade: codGrade,
        })
        .success(function (data) {
            $('.gradehorario-items .box-body').html(data);
            fechaModal();
        });
    };

    var recuperarCursos = function (id) {
        $.ajax({
            url: "/recursos-humanos/estagio/estagiario-estagio/preencher-grau",
            method: "POST",
            dataType: "json",
            data: {
                id: id
            },
            success: function (data) {
                var options = "";
                grauCurso.parent().find('div').find('span').first().html('Selecione');
                if (data != null) {
                    grauCurso.find('option').remove();
                    options += '<option value="">' + 'Selecione' + '</option>';
                    $.each(data, function (val, item) {
                        options += '<option value="' + item.cod_grau + '">' + item.descricao + '</option>';
                        grauCurso.html(options);
                    });
                }
                grauCurso.select2('readonly',false);
                fechaModal();
            },
            fail: function () {
                fechaModal();
            }
        });
    }

    intermediadoraEstagios.on('change', function () {
        abreModal('Carregando','Aguarde, buscando informações...');
        instituicaoEnsino.children().remove()

        if ($(this).val() == "") {
            recuperarInstituicoes();
        } else {
            instituicaoEnsino.select2('val','');
            recuperarInstituicoes($(this).val());
        }
    })

    instituicaoEnsino.on('change', function(){
        var id = $(this).val();

        if (id != "") {
            abreModal('Carregando','Aguarde, buscando informações...');
            recuperarCursos(id);
        } else {
            valorBolsa.val('');
            curso.select2('val','');
            grauCurso.select2('val','');
            curso.select2('readonly',true);
            grauCurso.select2('readonly',true);
        }
    });

    grauCurso.on('change', function(){
        var numCgmInstituicao = instituicaoEnsino.val(),
            codGrau = $(this).val();

        if (codGrau != "") {
            abreModal('Carregando','Aguarde, buscando informações...');
            $.ajax({
                url: "/recursos-humanos/estagio/estagiario-estagio/preencher-curso",
                method: "POST",
                dataType: "json",
                data: {
                    numCgmInstituicao : numCgmInstituicao,
                    codGrau : codGrau
                },
                success: function (data) {

                    var options = "";
                    curso.parent().find('div').find('span').first().html('Selecione');
                    if (data != null) {
                        curso.find('option').remove();
                        options += '<option value="">' + 'Selecione' + '</option>';
                        $.each(data, function (val, item) {
                            options += '<option value="' + item.cod_curso + '" ' +
                                'data-bolsa="' + item.vl_bolsa + '" ' +
                                'data-mes="'+ item.nom_mes + '">' + item.nom_curso + '</option>';
                            curso.html(options);
                        });
                    }
                    curso.select2('readonly',false);
                    fechaModal();
                },
                fail: function () {
                    curso.select2('readonly',false);
                    fechaModal();
                }
            });
        } else {
            valorBolsa.val('');
            curso.select2('val','');
            curso.select2('readonly',true);
        }
    });

    curso.on('change', function (){
        var bolsa = $('option:selected', this).data('bolsa'),
            mes = $('option:selected', this).data('mes');

        if (bolsa == undefined) {
            valorBolsa.val('');
            mesAvaliacao.val('');
        } else {
            valorBolsa.val(bolsa);
            mesAvaliacao.val(mes);
        }

    });

    grade.on('change', function (){
        abreModal('Carregando','Aguarde, buscando informações...');
        loadTable(grade.val());
    });

    $(document).ready(function() {
        abreModal('Carregando','Aguarde, buscando informações...');
        if (grade.val()) {
            loadTable(grade.val());
        }

        if (codEstagio.val()) {
            vinculoEstagio.iCheck('disable');
            instituicaoEnsino.select2('readonly',true);

            if (codBancoField.val() && codAgenciaField.val() && numContaField.val()) {
                codBancoField.select2('readonly',true);
                codAgenciaField.select2('readonly',true);
                numContaField.select2('readonly',true);
            }
        }

        if (instituicaoEnsino.val() == "") {
            recuperarInstituicoes();
        }
    });

})(jQuery, window, UrbemSonata);
