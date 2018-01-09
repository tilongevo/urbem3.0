$(document).ready(function() {
    //Adiciona a Unidade
    var areaSelectUnidade = $('<div class="form_row col s3 campo-sonata-select" id="sonata-ba-field-container-unidade"></div>');
    var unidade = $('<label class="control-label required" for="unidade">Unidade</label> <select id="unidade" required="required" name="unidade" tabindex="-1" title="Unidade" class="select2-parameters select2-multiple-options-custom" style="display: inline-block;">' +
        '<option value="">Selecione</option></select></div></div>');
    areaSelectUnidade.append(unidade);
    $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_orgao").after(areaSelectUnidade);

    //Adiciona Recursos
    var areaSelectRecursos = $('<div class="form_row col s3 campo-sonata-select" id="sonata-ba-field-container-recursos"></div>');

    var recursos = $('<label class="control-label" for="recursos">Recursos</label> ' +
        '<select id="recursos" name="recursos[]" multiple="multiple" tabindex="-1" title="Recursos" class="select2-parameters select2-multiple-options-custom" style="display: inline-block;"></select>');
    areaSelectRecursos.append(recursos);
    $("#sonata-ba-field-container-unidade").after(areaSelectRecursos);

    // Fields
    var entidadeSelect = $("#" + UrbemSonata.uniqId + "_entidade");
    var orgaoSelect = $("#" + UrbemSonata.uniqId + "_orgao");
    var unidadeSelect = $("#unidade");
    var recursosSelect = $("#recursos");

    var objects = [orgaoSelect, unidadeSelect, recursosSelect];
    disabledSelect(objects);

    function disabledSelect(objects) {
        for(var key = 0; key < objects.length; key++) {
            // Disabled selects
            objects[key].prop('disabled', true);
            objects[key].val('').change();
        }
    }

    function enableSelect($select, content) {
        $select.prop('disabled', false);
    }

    entidadeSelect.on('change', function () {
        if ($(this).val()) {
            orgaoSelect.prop('disabled', false);
        } else {
            disabledSelect(objects);
        }
    });

    orgaoSelect.on('change', function () {
        var parameters = [];
        parameters.push({name: 'orgao', value: $(this).val()});

        if ($(this).val()) {
            UrbemSonata.loadSelectOnAjax(unidadeSelect, 'LoadUnidade', parameters, enableSelect);
        } else {
            var orgaoObjects = [unidadeSelect];
            disabledSelect(orgaoObjects);
        }
    });

    unidadeSelect.on('change', function () {
        var parameters = [];
        parameters.push({name: 'entidade', value: entidadeSelect.val()});
        parameters.push({name: 'orgao', value: orgaoSelect.val()});
        parameters.push({name: 'unidade', value: $(this).val()});

        if ($(this).val()) {
            loadRecursos(recursosSelect, 'LoadRecursos', parameters);
        } else {
            var unidadeObjects = [recursosSelect];
            disabledSelect(unidadeObjects);
        }
    });

    // ObjectModal
    var modal = $.urbemModal();

    function loadRecursos($select, action, parameters) {
        modal.disableBackdrop().setTitle('Aguarde').setBody('Carregando').open();

        parameters.push({name: 'action', value: action});
        $.get(UrlServiceProviderTCE, parameters)
            .success(function (data) {
                if (data.response == true) {
                    var recursosSelect = data.recursosSelect;
                    var recursosSelected = data.recursosSelected;
                    $select.empty();

                    $.each(recursosSelect, function(key, value)
                    {
                        $select.append('<option value=' + key + '>' + value + '</option>');
                    });
                    $select.select2('val', recursosSelected);

                    $select.prop("disabled", false);
                }
                modal.close().remove();
            })
            .error(function (data) {
                modal.close().remove();
            });
    }
}());