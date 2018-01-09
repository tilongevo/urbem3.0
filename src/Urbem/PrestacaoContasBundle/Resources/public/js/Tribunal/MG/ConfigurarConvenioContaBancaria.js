$(document).ready(function() {
    $(".protocolo-numeric").keypress(function() {
        if (parseInt($(this).val()) < 0) {
            $(this).val(0);
        }
    });

    var entidade = $("select#" + UrbemSonata.uniqId + "_entidade");

    entidade.change(function() {
        buscaParametros();
    });

     //ObjectModal
    var modal = $.urbemModal();

    //* Table principal com item a ser manipulados*/
    function renderTableList(data, listClassToColumns) {
        var tableName = "tableContaContabil";

        var table = $("#"+tableName).DataTable();

        table.destroy();
        var table = $("#"+tableName).DataTable( {
            data:           data,
            deferRender:    true,
            scrollY:        400,
            pageLength:     50,
            ordering:       false,
            scrollCollapse: true,
            scroller:       false,
            searching:      false,
            paging:         false,
            autoWidth:      false,
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese-Brasil.json"
            },
            drawCallback: function () { // this gets rid of duplicate headers
                $('.dataTables_scrollBody thead tr').css({ display: 'none' });

                UrbemSonata.DataTablesSetDimensionToHeaderAndBodyCell(tableName, listClassToColumns);
                UrbemSonata.acceptOnlyNumeric($(".protocolo-numeric"));
            },
            initComplete: function( settings, json ) {
                modal.close();
                $('.dataTables_scrollBody thead tr').css({ display: 'none' });
            },
            columnDefs: [{
                'targets': 4,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var codPlano = full[2];
                    var numConvenio = full[4];

                    var $input = $("<input type='text' class='campo-sonata form-control protocolo-numeric' value='"+numConvenio+"' name='numConvenio["+codPlano.trim()+"]'>");

                    return $input.prop("outerHTML");
                }
            },
            {
                'targets': 5,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var codPlano = full[2];
                    var dtAssinatura = full[5];

                    var $input = $("<div class='input-group date' id='dtAssinatura_\"+codPlano.trim()+\"'>" +
                        "<input type='text' class='sonata-medium-datecampo-sonata form-control' data-date-format='DD/MM/YYYY' value='"+dtAssinatura+"' name='dtAssinatura["+codPlano.trim()+"]'  data-toggle='tooltip' data-html='true' title='' data-original-title='' />" +
                        "<span class='input-group-addon'><span class='fa-calendar fa'></span></span></div>");

                    return $input.prop("outerHTML");
                }
            },
                { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2,3,4,5 ] }
            ]
        });
    }

    function buscaParametros() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        $.post(UrlServiceProviderTCE, $("form").serializeArray())
            .success(function (data) {

                var contas = data.content;

                var data = [];

                var contador = 1;
                if (contas) {
                    for (var i = 0; i < contas.length; i++) {
                        data.push(
                            [
                                contador,
                                contas[i].codEstrutural,
                                contas[i].codPlano,
                                contas[i].nomConta,
                                contas[i].numConvenio,
                                contas[i].dtAssinatura
                            ]
                        );
                        contador++;
                    }
                }

                var listClassToColumns = [
                    "dt-cell-1",
                    "dt-cell-2",
                    "dt-cell-1",
                    "dt-cell-4",
                    "dt-cell-2",
                    "dt-cell-2"
                ];

                $(".urbem-modal-body").html("Processando <strong>"+contas.length+"</strong> items para exibição...");
                renderTableList(data, listClassToColumns);
            }
        );
    }

    // Onload
    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", buscaParametros);
}());