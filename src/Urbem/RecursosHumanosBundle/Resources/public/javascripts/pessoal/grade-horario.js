(function($, UrbemSonata){
    'use strict';

    var idObjectDefault = "_fkPessoalDiasTurno",
        idButtomAddElement = "_fkPessoalFaixaTurnos",
        totalDiasDaSemana = 7,
        arr = [],
        isFormValid = true,
        selects
    ;

    function hideButtonAddElementByCount(totalElements) {
        if (totalElements == totalDiasDaSemana) {
            $('#field_actions_' + UrbemSonata.uniqId + idButtomAddElement).hide();
        }
    }

    $(document).on('sonata.add_element', function () {
       selects = $(document).find("select[id*=" + idObjectDefault + "]");
       hideButtonAddElementByCount(selects.length);
    });

    $("form[role='form']").on("submit", function() {
        $('select:regex(id, (_\\d+_fkPessoalDiasTurno))').each(function (index, elem) {
            arr.push($(elem).val());
        });

        selects = $(document).find("select[id*=" + idObjectDefault + "]");

        if (selects.length == 0) {
            UrbemSonata.setGlobalErrorMessage('Informe no minímo um dia da semana na grade de turnos!');
            isFormValid = false;
        } else {
            UrbemSonata.setGlobalErrorMessage(null);
        }

        if (UrbemSonata.uniqueCollection(arr).length > 0) {
            UrbemSonata.setGlobalErrorMessage('Não pode adicionar dias da semana repetidos');
            arr = [];
            isFormValid = false;
        } else {
            UrbemSonata.setGlobalErrorMessage(null);
            arr = [];
        }

        $("#field_widget_" + UrbemSonata.uniqId + "_fkPessoalFaixaTurnos > table > tbody > tr").each(function (index, elem) {
            var horaEntrada_hora = $("#" + UrbemSonata.uniqId + "_fkPessoalFaixaTurnos_" + index + "_horaEntrada_hour").val(),
                horaEntrada_minuto = $("#" + UrbemSonata.uniqId + "_fkPessoalFaixaTurnos_" + index + "_horaEntrada_minute").val(),
                horaEntrada,
                horaEntrada2_hora = $("#" + UrbemSonata.uniqId + "_fkPessoalFaixaTurnos_" + index + "_horaEntrada2_hour").val(),
                horaEntrada2_minuto = $("#" + UrbemSonata.uniqId + "_fkPessoalFaixaTurnos_" + index + "_horaEntrada2_minute").val(),
                horaEntrada2,
                horaSaida_hora = $("#" + UrbemSonata.uniqId + "_fkPessoalFaixaTurnos_" + index + "_horaSaida_hour").val(),
                horaSaida_minuto = $("#" + UrbemSonata.uniqId + "_fkPessoalFaixaTurnos_" + index + "_horaSaida_minute").val(),
                horaSaida,
                horaSaida2_hora = $("#" + UrbemSonata.uniqId + "_fkPessoalFaixaTurnos_" + index + "_horaSaida2_hour").val(),
                horaSaida2_minuto = $("#" + UrbemSonata.uniqId + "_fkPessoalFaixaTurnos_" + index + "_horaSaida2_minute").val(),
                horaSaida2
            ;

            horaEntrada = moment(S(horaEntrada_hora).padLeft(2, '0').s + ":" + S(horaEntrada_minuto).padLeft(2, '0').s, "h:mma");
            horaSaida = moment(S(horaSaida_hora).padLeft(2, '0').s + ":" + S(horaSaida_minuto).padLeft(2, '0').s, "h:mma");
            horaEntrada2 = moment(S(horaEntrada2_hora).padLeft(2, '0').s + ":" + S(horaEntrada2_minuto).padLeft(2, '0').s, "h:mma");
            horaSaida2 = moment(S(horaSaida2_hora).padLeft(2, '0').s + ":" + S(horaSaida2_minuto).padLeft(2, '0').s, "h:mma");

            if (horaSaida.isBefore(horaEntrada) === true || horaEntrada.isSame(horaSaida)) {
                UrbemSonata.setGlobalErrorMessage('Campo Hora Entrada 1 deve ser inferior a Hora Saída 1!');
                isFormValid = false;
            } else {
                UrbemSonata.setGlobalErrorMessage(null);
            }

            if (horaEntrada2_hora != '' && horaEntrada2_minuto != '') {
                if (horaEntrada2.isBefore(horaSaida) === true || horaEntrada2.isSame(horaSaida)) {
                    UrbemSonata.setGlobalErrorMessage('Campo Hora Saída 1 deve ser inferior a Hora Entrada 2!');
                    isFormValid = false;
                } else {
                    UrbemSonata.setGlobalErrorMessage(null);
                }

                if (horaSaida2.isBefore(horaEntrada2) === true || horaSaida2.isSame(horaEntrada2)) {
                    UrbemSonata.setGlobalErrorMessage('Campo Hora Entrada 2 deve ser inferior a Hora Saída 2!');
                    isFormValid = false;
                } else {
                    UrbemSonata.setGlobalErrorMessage(null);
                }
            } else {
                if (horaEntrada2_hora != '' || horaEntrada2_minuto != '') {
                    UrbemSonata.setGlobalErrorMessage('Preencha o campo Hora Entrada 2 corretamente!');
                    isFormValid = false;
                }
            }
        });

        if (isFormValid == true) {
            return true;
        } else {
            isFormValid = true;
            window.scrollTo(0, 0);
            return false;
        }
    });
})(jQuery, UrbemSonata);
