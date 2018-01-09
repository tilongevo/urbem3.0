$(document).ready(function() {
    /*botão mágico para consulta assíncrona*/
    var areaButton = $('<div class="form_row col s3 campo-sonata"></div>');
    var buttonSearch = $('<label class="control-label">&nbsp;</label><div class="sonata-ba-field "><button type="button" class="white-text blue darken-4 btn btn-success save" name="btnSearch" id="btnSearch"><i class="material-icons left">zoom_in</i>Buscar</button></div>');
    areaButton.append(buttonSearch);

    /*Adiciona o Botão, após o Mes*/
    var containerFields = $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_periodo");
    containerFields.after(areaButton);

    $(':input[type=submit]').prop('disabled', true);

    /*Escuta botão de busca*/
    $("#btnSearch").on("click", function() {
        buscaParametros();
        $(':input[type=submit]').prop('disabled', false);
    });

    /*Escuta os eventos caso haja alguma mudança nos valores força uma nova search*/
    $("select").change(function() {
        $(':input[type=submit]').prop('disabled', true);
    });

     //ObjectModal
    var modal = $.urbemModal();

    //* Table principal com item a ser manipulados*/
    function renderTableList(data, listClassToColumns) {
        var tableName = "tableListConsideracoes";

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
            },
            initComplete: function( settings, json ) {
                modal.close();
                $('.dataTables_scrollBody thead tr').css({ display: 'none' });
            },
            columnDefs: [{
                'targets': 2,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var descricao = full[2];
                    var arquivo = full[1];
                    arquivo = arquivo.split("-")[0];

                    var $textarea = $("<textarea maxlength='3000' name='arquivo["+arquivo.trim()+"]'>"+descricao+"</textarea>", {
                        "id": full[0]+"start",
                        "name": "arquivo["+arquivo.trim()+"]"
                    });

                    return $textarea.prop("outerHTML");
                }
            },
            { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2 ] }
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
                    var arquivos = data.arquivos;

                    var data = [];

                    var contador = 1;
                    if (arquivos) {
                        for (var i = 0; i < arquivos.length; i++) {
                            data.push(
                                [
                                    contador,
                                    arquivos[i].codArquivo + " - " + arquivos[i].nomArquivo,
                                    arquivos[i].descricao
                                ]
                            );
                            contador++;

                        }
                    }

                    var listClassToColumns = [
                        "dt-cell-1",
                        "dt-cell-4",
                        "dt-cell-7"
                    ];

                     renderTableList(data, listClassToColumns);
                }
            );
    }
}());