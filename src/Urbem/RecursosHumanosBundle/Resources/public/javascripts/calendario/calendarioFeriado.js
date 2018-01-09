$(document).ready(function () {
    var eventosList = '#' + UrbemSonata.uniqId + '_codFeriado';
    var exercicio = '#' + UrbemSonata.uniqId + '_exercicio';

    var pageURL = $(location).attr("href");
    var data = (pageURL.match(/(\d+)/g) || []);
    var idEdit = data[0];


    if(idEdit == null){
        //anoCorrente
        $(eventosList).prop('disabled', true);
        getExercicioAnoVigente($(exercicio).val());
    }
});

(function () {

    var exercicio = '#' + UrbemSonata.uniqId + '_exercicio';
    var eventos =   '#' + UrbemSonata.uniqId + '_codFeriado';

    $(exercicio).on('change', function () {
        if($(this).val() != 0){
            getExercicioAnoVigente($(this).val());
        }else{
            $("#" + UrbemSonata.uniqId + "_codFeriado").prop('disabled', true);
            return false;
        }
    });

})();

function getExercicioAnoVigente(anoVigente) {
    $.ajax({
        url: "/recursos-humanos/calendario/calendario-cadastro/listar-feriados/" + anoVigente,
        method: "GET",
        dataType: "json",
        success: function (data) {

            $("#" + UrbemSonata.uniqId + "_codFeriado")
                .empty()
                .select2("val", "");
            $("#" + UrbemSonata.uniqId + "_codFeriado").prop('disabled', false);

            $.each(data['feriados'], function (index, value) {
                $("#" + UrbemSonata.uniqId + "_codFeriado")
                    .append("<option value='" + index + "'>" + value + "</option>");
            });

            $("#" + UrbemSonata.uniqId + "_codFeriado").select2();
        }
    });
};
