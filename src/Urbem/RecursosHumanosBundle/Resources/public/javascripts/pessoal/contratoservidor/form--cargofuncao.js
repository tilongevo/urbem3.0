(function ($, global, urbem) {
    'use strict';

    var modal,
        horasMensaisPadrao,
        UrbemSearch = urbem.UrbemSearch,
        fkPessoalRegime = urbem.giveMeBackMyField('fkPessoalRegime'),
        codSubDivisao = urbem.giveMeBackMyField('codSubDivisao'),
        codCargo = urbem.giveMeBackMyField('codCargo'),
        codEspecialidade = urbem.giveMeBackMyField('codEspecialidade'),
        codRegimeFuncao = urbem.giveMeBackMyField('codRegimeFuncao'),
        codSubDivisaoFuncao = urbem.giveMeBackMyField('codSubDivisaoFuncao'),
        codCargoFuncao = urbem.giveMeBackMyField('codCargoFuncao'),
        codEspecialidadeFuncao = urbem.giveMeBackMyField('codEspecialidadeFuncao'),
        horasMensais = urbem.giveMeBackMyField('horasMensais'),
        codPadrao = urbem.giveMeBackMyField('codPadrao'),
        salario = urbem.giveMeBackMyField('salario'),
        numcgmSindicato = urbem.giveMeBackMyField('numcgmSindicato'),
        dtDatabase = urbem.giveMeBackMyField('dtDatabase')
    ;

    if (urbem.isFunction($.urbemModal)) {
        modal = $.urbemModal();
    }

    function consultaSubDivisaoRegimeAction( source, target, target2 = false ) {
        modal.disableBackdrop()
            .setBody('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, Buscando SubDivisões...</h4>')
            .open();
        $.post('/recursos-humanos/servidor/contrato/consulta-subdivisao-regime', {
            codRegime: source.val()
        }).success(function (data) {
            urbem.populateSelect(target, data, {value: 'id', label: 'descricao'});
            if (target2) {
                urbem.populateSelect(target2, data, {value: 'id', label: 'descricao'});
            }
            modal.close();
        });
    }

    function consultaCargoSubDivisao( source, target, target2 = false ) {
        modal.disableBackdrop()
            .setBody('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, Buscando Cargos...</h4>')
            .open();
        $.post('/recursos-humanos/servidor/contrato/consulta-cargo-subdivisao', {
            codSubDivisao: source.val()
        }).success(function (data) {
            urbem.populateSelect(target, data, {value: 'cod_cargo', label: 'descricao'});
            if (target2) {
                urbem.populateSelect(target2, data, {value: 'cod_cargo', label: 'descricao'});
            }
            modal.close();
        });
    }

    function consultaEspecialidadeCargoSubDivisao( source, target, codSubDivisao, target2 = false) {
        modal.disableBackdrop()
            .setBody('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, Buscando Especialidade...</h4>')
            .open();
        $.post('/recursos-humanos/servidor/contrato/consulta-especialidade-cargo-subdivisao', {
            codSubDivisao: codSubDivisao.val(),
            codCargo: source.val()
        }).success(function (data) {
            urbem.populateSelect(target, data, {value: 'cod_especialidade', label: 'descricao_especialidade'});
            if (target2) {
                urbem.populateSelect(target2, data, {value: 'cod_especialidade', label: 'descricao_especialidade'});
            }
            modal.close();
        });
    }

    function consultaInformacoesSalariais( codCargo ) {
        $.post('/recursos-humanos/servidor/contrato/consulta-informacoes-salariais', {
            codCargo: codCargo.val()
        }).success(function (data) {
            var horasMensais = urbem.giveMeBackMyField('horasMensais'),
                horasSemanais = urbem.giveMeBackMyField('horasSemanais'),
                codPadrao = urbem.giveMeBackMyField('codPadrao')
            ;
            if (data) {
                horasMensais.val(urbem.convertFloatToMoney(data.horas_mensais));
                horasSemanais.val(urbem.convertFloatToMoney(data.horas_semanais));
                codPadrao.val(data.cod_padrao).trigger("change");
            } else {
                horasMensais.val('');
                horasSemanais.val('');
                codPadrao.val('').trigger("change");
            }
        });
    }

    function calculaSalario() {
        $.post('/recursos-humanos/servidor/contrato/calcula-salario', {
            horasMensais: urbem.convertMoneyToFloat(horasMensais.val()),
            codPadrao: codPadrao.val()
        }).success(function (data) {
            salario.val(data);
        });
    }

    fkPessoalRegime.on('change', function () {
        if ($(this).val() != '') {
            consultaSubDivisaoRegimeAction( $(this), codSubDivisao, codSubDivisaoFuncao );
            codRegimeFuncao.select2('val', $(this).val());
        }
    });

    codSubDivisao.on('change', function () {
        if ($(this).val() != '') {
            consultaCargoSubDivisao( $(this), codCargo, codCargoFuncao );
            codSubDivisaoFuncao.select2('val', $(this).val());
        }
    });

    codCargo.on('change', function () {
        if ($(this).val() != '') {
            consultaEspecialidadeCargoSubDivisao( $(this), codEspecialidade, codSubDivisao, codEspecialidadeFuncao );
            consultaInformacoesSalariais( $(this) );
            codCargoFuncao.select2('val', $(this).val());
        }
    });

    codRegimeFuncao.on('change', function () {
        if ($(this).val() != '') {
            consultaSubDivisaoRegimeAction( $(this), codSubDivisaoFuncao );
        }
    });

    codSubDivisaoFuncao.on('change', function () {
        if ($(this).val() != '') {
            consultaCargoSubDivisao( $(this), codCargoFuncao );
        }
    });

    codCargoFuncao.on('change', function () {
        if ($(this).val() != '') {
            consultaEspecialidadeCargoSubDivisao( $(this), codEspecialidadeFuncao, codSubDivisaoFuncao );
            consultaInformacoesSalariais( $(this) );
        }
    });

    codEspecialidade.on('change', function () {
        consultaInformacoesSalariais( $(this) );
        codEspecialidadeFuncao.select2('val', $(this).val());
    });

    horasMensais.on('blur', function() {
        calculaSalario();
    });

    codPadrao.on('change', function() {
        calculaSalario();
    });

    numcgmSindicato.on('change', function() {
        dtDatabase.val($(this).find(':selected').data('dtdatabase'));
    });
})(jQuery, window, UrbemSonata);
