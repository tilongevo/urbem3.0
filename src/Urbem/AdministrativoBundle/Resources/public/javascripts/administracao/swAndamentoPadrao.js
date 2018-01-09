(function() {
    'use strict';

    var config = {
        classificacao : jQuery("select#" + UrbemSonata.uniqId + "_fkSwClassificacao"),
        assunto : jQuery("select#" + UrbemSonata.uniqId + "_fakeAssunto"),
        codAssunto: jQuery("#" + UrbemSonata.uniqId + "_codAssunto"),
        filterClassificacao : jQuery("select#filter_codClassificacao_value"),
        filterAssunto : jQuery("select#filter_codAssunto_value"),
    };

    config.assunto.on("change", function() {
        config.codAssunto.val($(this).val());
    });

    var filterClassificacao =  config.filterClassificacao.val();
    if (filterClassificacao == "") {
        limpaAssuntos(config.filterAssunto, false)
    } else {
        consultaAssuntos(filterClassificacao, config.filterAssunto, false);
    }

    config.filterClassificacao.on("change", function() {
        consultaAssuntos($(this).val(), config.filterAssunto, false);
    });

    var codClassificacao =  config.classificacao.val();
    if (codClassificacao == "") {
        limpaAssuntos(config.assunto, true)
    } else if (config.classificacao.attr('disabled') == false) {
        consultaAssuntos(codClassificacao, config.assunto, true);
    }

    config.classificacao.on("change", function() {
        consultaAssuntos($(this).val(), config.assunto, true);
    });

    function consultaAssuntos(codClassificacao, field, append) {
        if (codClassificacao != "") {
            $.ajax({
                url: '/administrativo/protocolo/tramite-processo/consultar-assunto',
                method: 'POST',
                data: {
                    codClassificacao: codClassificacao
                },
                dataType: 'json',
                success: function (data) {
                    var selected = field.val();
                    limpaAssuntos(field, append);
                    $.each(data, function (index, value) {
                        if (value == selected) {
                            field.append("<option value=" + value + " selected>" + index + "</option>");
                        } else {
                            field.append("<option value=" + value + ">" + index + "</option>");
                        }
                    });
                    field.select2("val", selected);
                }
            });
        }
    }

    function limpaAssuntos(field, append) {
        field.empty();
        if (append) {
            field.append("<option value=\"\">Selecione</option>");
        }
    }

    var modulo = $('form').attr('name');
    if (typeof(modulo) == "undefined") {
        modulo = UrbemSonata.uniqId;
    }

    function cascadeOrganograma() {
        $(".orgao-dinamico").each(function() {
            var selectId = $(this).attr('id');
            var nclass = $(this).attr('class');
            var match = nclass.search(/nivel-(\d+)/g);
            var nivel = parseInt(nclass.substr((match + 6), 1));
            var selectedVal = $(this).val();

            if ($(this).hasClass( "first" )) {
                $(this).attr('required', 'required');
                getOrgaos(nivel, selectId, selectedVal);
            }

            $(this).on("change", function() {
                var orgao = $(this).val();
                var campo = modulo + '_orgao_' + (nivel + 1);

                if ($("select#" + campo).length) {
                    selectedVal = $("select#" + campo).val();
                    getSubOrgaos(nivel, campo, orgao, selectedVal);
                }
            });
        });
    }

    function getOrgaos(nivel, selectId, selectedVal) {
        $.ajax({
            url: "/administrativo/organograma/orgao/consultar-orgaos",
            method: "POST",
            data: {
                nivel: nivel,
                codOrganograma: $("#" + UrbemSonata.uniqId + "_codOrganograma").val(),
            },
            dataType: "json",
            success: function (data) {
                $("select#" + selectId)
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                $.each(data, function (index, value) {
                    if (selectedVal == index) {
                        $("select#" + selectId).append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        $("select#" + selectId).append("<option value=" + index + ">" + value + "</option>");
                    }
                });

                $("select#" + selectId).select2("val", selectedVal);
            }
        });
    }

    function getSubOrgaos(nivel, campo, orgao, selectedVal) {
        if (orgao != '') {
            $.ajax({
                url: "/administrativo/organograma/orgao/consultar-sub-orgaos",
                method: "POST",
                data: {orgao: orgao},
                dataType: "json",
                success: function (data) {
                    $("select#" + campo)
                        .empty()
                        .append("<option value=\"\">Selecione</option>");

                    $.each(data, function (index, value) {
                        var selectedOption = '';
                        if (selectedVal == index) {
                            selectedOption = 'selected';
                        }
                        $("select#" + campo)
                            .append("<option value=" + index + " " + selectedOption + ">" + value + "</option>");
                    });

                    $("select#" + campo).select2("val", selectedVal);
                }
            });
        } else {
            $("select#" + campo)
                .empty()
                .append("<option value=\"\">Selecione</option>")
                .select2("val", "")
                .trigger("change");
        }
        return false;
    }

    cascadeOrganograma();
    $("#" + UrbemSonata.uniqId + "_codOrganograma").on("change", function() {
        cascadeOrganograma();
    });

}());