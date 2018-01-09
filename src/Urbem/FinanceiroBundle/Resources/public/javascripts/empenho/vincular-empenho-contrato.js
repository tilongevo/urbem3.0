var modalLoad = new UrbemModal();
$(function () {
    "use strict";

    $("button[name='btn_update_and_list']").hide();

    $("#addVinculoConvenio").on("click", function() {
        var empenhoURL = '/financeiro/api/search/empenho/consulta-empenho';
        var entidade = $("#" + UrbemSonata.uniqId + "_entidade").val();
        var empenho = $("#select2-chosen-1").html();
        var entidadeText = $("#" + UrbemSonata.uniqId + "_entidadeText").val();

        modalLoad.setTitle('Vincular empenho a um contrato');
        if (empenho == '&nbsp;') {
            modalLoad.setBody('O campo empenho é obrigatório.');
            modalLoad.open();
            return;
        }

        modalLoad.setBody('Aguarde... Carregando os dados do empenho');
        modalLoad.open();

        $.ajax({
            url: empenhoURL,
            data: {
                'entidade': entidade,
                'empenho': $("#select2-chosen-1").html()
            },
            method: "GET",
            dataType: "json",
            success: function (data) {
                if (data.isValid == true) {
                    $("button[name='btn_update_and_list']").show();
                    modalLoad.close();
                    var linha =
                        '<tr>' +
                        '<input name=\"empenhos[]\" type=\"hidden\" value=\"' + entidade + '__' + empenho + '\" />' +
                        '<td>' + entidade + '</td>' +
                        '<td>' + entidadeText + '</td>' +
                        '<td>' + empenho + '</td>' +
                        '<td class=\"remove\"><i class="material-icons blue-text text-darken-4">delete</i></td>' +
                        '</tr>';

                    $('#tableEmpenhoVinculados').append(linha);
                }

                $('#modal-body-' + modalLoad.getUuid()).html('Não existe um empenho para esta entidade.');
            }
        });
    });

    $(".remove").on("click", function() {
        $(this).parent().remove();
    });

    $(document).on('click', '.remove', function () {
        $("button[name='btn_update_and_list']").show();
        $(this).parent().remove();
    });
}());