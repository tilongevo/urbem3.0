(function ($, global, urbem) {
    'use strict';

    var fkCseGrauParentesco = urbem.giveMeBackMyField('fkCseGrauParentesco'),
        dependenteSalFamiliaSim = urbem.giveMeBackMyField('dependenteSalFamilia_0'),
        dependenteSalFamiliaNao = urbem.giveMeBackMyField('dependenteSalFamilia_1'),
        dependenteInvalido = urbem.giveMeBackMyField('dependenteInvalido'),
        dependente = urbem.giveMeBackMyField('fkSwCgmPessoaFisica'),
        dependenteDtNascimento = urbem.giveMeBackMyField('dtNascimento'),
        dtInicioSalFamilia = urbem.giveMeBackMyField('dtInicioSalFamilia'),
        dependenteSexo = urbem.giveMeBackMyField('dependenteSexo');

    dependenteSalFamiliaSim.iCheck('disable');
    urbem.sonataFieldContainerHide('_dependenteInvalido');
    urbem.sonataFieldContainerHide('_dtInicioSalFamilia');
    urbem.sonataFieldContainerHide('_codCid');

    var dependentesDeSalarioFamilia = {
        adotivo: 15,
        enteado: 17,
        outro: 20,
        filho: 4
    };

    fkCseGrauParentesco.on('change', function () {
        var codParentesco = $(this).val();

        if (isDependenteDeSalarioFamilia(codParentesco)) {
            dependenteSalFamiliaSim.iCheck('enable');
        } else {
            dependenteSalFamiliaSim.iCheck('disable');
            dependenteSalFamiliaNao.iCheck('check');
        }
    });

    var isDependenteDeSalarioFamilia = function (codParentesco) {
        var result = false;

        $.each(dependentesDeSalarioFamilia, function (dependente, codDependente) {
            if (codParentesco == codDependente) {
                result = true;
            }
        });

        return result;
    };

    if (dependenteSalFamiliaSim.iCheck('update')[0].checked) {
        dependenteSalFamiliaSim.iCheck('enable');
        urbem.sonataFieldContainerShow('_dependenteInvalido');
    }

    if (dependenteInvalido.iCheck('update')[0].checked) {
        urbem.sonataFieldContainerShow('_codCid');
    }

    dependenteSalFamiliaSim.on('ifChecked' , function () {
        urbem.sonataFieldContainerShow('_dependenteInvalido');
        urbem.sonataFieldContainerShow('_dtInicioSalFamilia');
    });

    dependenteSalFamiliaSim.on('ifUnchecked' , function () {
        urbem.sonataFieldContainerHide('_dependenteInvalido');
        urbem.sonataFieldContainerHide('_codCid');
        urbem.sonataFieldContainerHide('_dtInicioSalFamilia');
        dependenteInvalido.iCheck('uncheck');
    });

    dependenteInvalido.on('ifChecked' , function () {
        urbem.sonataFieldContainerShow('_codCid');
    });

    dependenteInvalido.on('ifUnchecked' , function () {
        urbem.sonataFieldContainerHide('_codCid');
    });

    dependente.on('change', function () {
        var cgm = $(this).val();

        abreModal('Carregando','Aguarde, buscando a dados...');
        recuperarDadosDependente(cgm)
    });

    var recuperarDadosDependente = function (cgm) {
        $.ajax({
            url: '/administrativo/cgm/pessoa-fisica/recupera-dados',
            data: { cgm: cgm },
            method: 'POST',
            dataType: 'json',
        }).success(function (dadosDependente) {
            var dtNascimento = dadosDependente.dtNascimento,
                sexo = dadosDependente.sexo;

            populateDependenteDtNascimento(dtNascimento);
            populateDependenteSexo(sexo);
            fechaModal();
        }).fail(function(data) {
            console.error(data);
            fechaModal();
        });
    };

    var populateDependenteDtNascimento = function (dtNascimento) {
        if (dtNascimento == null) {
            dependenteDtNascimento.val("");
            dependenteDtNascimento.prop('disabled', false);
        } else {
            dependenteDtNascimento.val(dtNascimento);
            dependenteDtNascimento.prop('disabled', true);
        }
    };

    var populateDependenteSexo = function (sexo) {
        if (sexo == null) {
            dependenteSexo.val("Não Informado");
        } else {
            dependenteSexo.val(sexo)
        }
    };

})(jQuery, window, UrbemSonata);
