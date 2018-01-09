$(function () {
    "use strict";

    var selectModalidade = $("select[name='modalidades']");
    var selectParcelas = $("select[name='parcelas']");

    init();

    function init() {
        $("input[name='dtVencimento']").datetimepicker({"pickTime":false,"useCurrent":true,"minDate":"1\/1\/1900","maxDate":null,"showToday":true,"language":"pt_BR","disabledDates":[],"enabledDates":[],"icons":{"time":"fa fa-clock-o","date":"fa fa-calendar","up":"fa fa-chevron-up","down":"fa fa-chevron-down"},"useStrict":false,"sideBySide":false,"daysOfWeekDisabled":[],"collapse":true,"calendarWeeks":false,"viewMode":"days","defaultDate":"27\/07\/2017","useSeconds":false});

        $("#filter_fkSwCgm_value_autocomplete_input").prop('required', 'required');

        selectParcelas.attr('disabled', true);

        selectModalidade.on('select2-selecting', function(e) {
            loadNumParcela(e.choice.id);
        });

        if (selectModalidade && selectModalidade.val()) {
            loadNumParcela(selectModalidade.val());
        }
    }

    function loadNumParcela(modalidade) {
        selectParcelas.attr('disabled', true);
        selectParcelas.empty().trigger("change");
        var totalParcela = 0;
        $.ajax({
            url: "carrega-parcelas",
            method: "POST",
            data: {
                codModalidade: modalidade,
            },
            dataType: "json",
            success: function (data) {
                totalParcela = data.items;
                var numParcela;
                var selected;
                for (numParcela = 1; numParcela <= totalParcela; numParcela++) {
                    selected = '';
                    if (numParcela==1) {
                        selected = 'selected';
                    }
                    selectParcelas.append("<option " + selected + ">" + numParcela + "</option>");
                }

                selectParcelas.val('1').trigger('change');
                selectParcelas.attr('disabled', false);
            }
        });
    }

});
