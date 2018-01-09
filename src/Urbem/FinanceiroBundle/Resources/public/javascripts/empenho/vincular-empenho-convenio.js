var modalLoad = new UrbemModal();
$(function () {
    "use strict";

    $("button[name='btn_update_and_list']").hide();

    $("#addVinculoConvenio").on("click", function() {
        var empenhoURL = '/financeiro/api/search/empenho/consulta-empenho';
        var entidade = $("#" + UrbemSonata.uniqId + "_entidade option:selected").val();
        var entidadeText = $("#" + UrbemSonata.uniqId + "_entidade option:selected").text();
        var empenho = $("#select2-chosen-1").html();
        var loadingIcone = '<h3 class="text-center grey-text"><i class="text-shadow-big-icons fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i><br />';
        var warningIcone = '<h3 class="text-center"><i class="text-shadow-big-icons fa fa-exclamation-triangle fa-4x amber-text"></i><br />';

        modalLoad.setTitle('');
        if (empenho == '&nbsp;') {
            modalLoad.setBody(warningIcone + 'O campo empenho é obrigatório.');
            $(".modal-content").addClass('modal-warning');
            modalLoad.open();
            return;
        }

        modalLoad.setBody(loadingIcone + 'Aguarde.. Carregando os dados do empenho');
        modalLoad.open();

        $.ajax({
            url: empenhoURL,
            data: {
                'entidade': $("#" + UrbemSonata.uniqId + "_entidade option:selected").val(),
                'empenho': $("#select2-chosen-1").html()
            },
            method: "GET",
            dataType: "json",
            success: function (data) {
                if (data.isValid == true) {
                    $("button[name='btn_update_and_list']").show();
                    modalLoad.close();
                    var elementos = document.getElementsByClassName('codEmpenho');
                    var registrosEmpenho = new Array();
                    for (var i=0; i < elementos.length; i++) {
                        registrosEmpenho.push(elementos[i].innerText);
                    }
                    if (!registrosEmpenho.includes(empenho)) {
                        var linha =
                            '<tr>' +
                            '<input name=\"empenhos[]\" type=\"hidden\" value=\"' + entidade + '__' + empenho + '\" />' +
                            '<td>' + entidade + '</td>' +
                            '<td>' + entidadeText + '</td>' +
                            '<td class="codEmpenho">' + empenho + '</td>' +
                            '<td class=\"remove\"><i class="material-icons blue-text text-darken-4">delete</i></td>' +
                            '</tr>';

                        $('#tableEmpenhoVinculados').append(linha);
                    }
                }

                $('#modal-body-' + modalLoad.getUuid()).html( warningIcone + 'Não existe um empenho para esta entidade.');
            }
        });
    });

    $(".remove").on("click", function() {
        $(this).parent().remove();
    });

    $(document).on('click', '.remove', function () {
        $(this).parent().remove();
    });
}());