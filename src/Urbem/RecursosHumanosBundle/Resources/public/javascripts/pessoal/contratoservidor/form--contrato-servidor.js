(function ($, global, urbem) {
    'use strict';

    var  selectGrade = UrbemSonata.giveMeBackMyField('fkPessoalGradeHorario');

    var recuperaGradeHorario = function (codGrade) {
        $.ajax({
            url: '/recursos-humanos/servidor/contrato/recupera-grade',
            method: 'GET',
            data: {codGrade: codGrade},
            success: function (data) {
                fechaModal();
                $('.gradehorario-items .box-body').html(data);
            },
            error: function (data) {
                console.error(data);
                fechaModal();
            }
        });
    };

    selectGrade.on('change', function () {
        abreModal('Carregando','Aguarde, buscando informações...');
        var codgrade = $(this).val();
        recuperaGradeHorario(codgrade);
    });

})(jQuery, window, UrbemSonata);
