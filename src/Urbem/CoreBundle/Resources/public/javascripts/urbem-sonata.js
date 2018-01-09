var UrbemSonata = UrbemSonata || {};

UrbemSonata = {
    uniqId: $('meta[name="uniqid"]').attr("content"),
    checkModule: function (modulo) {
        var regex = new RegExp("(" + modulo + ")");
        return regex.test($("form").attr("action"));
    },
    sonataFieldContainerHide: function (field) {
        var containerPrefix = "sonata-ba-field-container-" + this.uniqId;
        $("#" + containerPrefix + field).hide();
        $("#" + containerPrefix + field)
            .find('input, select, textarea')
            .each(function () {
                if ($("label[for='" + UrbemSonata.uniqId + field + "']").hasClass("required")) {
                    $(this).removeAttr('required');
                }
            });
    },
    sonataFieldContainerShow: function (field, required) {
        required = typeof(required) !== 'undefined' ? required : false;

        var containerPrefix = "sonata-ba-field-container-" + this.uniqId;

        $("#" + containerPrefix + field).show();

        $("#" + containerPrefix + field)
            .find('input, select, textarea')
            .not('.select2-input, .select2-focusser')
            .each(function () {
                if (required) {
                    if ($("label[for='" + UrbemSonata.uniqId + field + "']").hasClass("required")) {
                        $(this).attr('required', true);
                    }
                } else {
                    $(this).attr('required', false);
                }
            });
    },
    sonataFieldFilterHide: function (field) {
        var containerPrefix = "filter-" + this.uniqId + "-" + field;

        $("#" + containerPrefix).hide();
    },
    sonataFieldFilterShow: function (field) {
        var containerPrefix = "filter-" + this.uniqId + "-" + field;

        $("#" + containerPrefix).show();
    },
    sonataPanelHide: function (field, required) {
        required = typeof required === undefined ? true : false;

        var containerPrefix = "sonata-ba-field-container-" + this.uniqId;

        $("#" + containerPrefix + field)
            .parent()
            .parent()
            .parent()
            .css({"display": "none"})
            .find('input, select, textarea')
            .each(function () {
            if ($("label[for='" + UrbemSonata.uniqId + field + "']").hasClass("required")) {
                $(this).removeAttr('required');
            }
        });
    },
    sonataPanelShow: function (field, required) {
        required = typeof required === undefined ? true : false;

        var containerPrefix = "sonata-ba-field-container-" + this.uniqId;

        $("#" + containerPrefix + field)
            .parent()
            .parent()
            .parent()
            .css({"display": "block"})
            .find('input, select, textarea')
            .not('.select2-input, .select2-focusser, .select2-offscreen')
            .each(function () {
                if (required) {
                  if ($("label[for='" + UrbemSonata.uniqId + field + "']").hasClass("required")) {
                      $(this).attr('required', true);
                  }
                } else {
                    $(this).attr('required', false);
                }
            });
    },
    convertMoneyToFloat: function (valor) {
      if (valor === "") {
          valor = 0;
      } else {
    	  while(valor.indexOf('.') >= 0) {
    		  valor = valor.replace(".", "");
          }
          valor = valor.replace(",", ".");
          valor = parseFloat(valor);
      }
      return valor;
    },
    convertFloatToMoney: function (valor) {
        formatter = new Intl.NumberFormat('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        return formatter.format(valor);
    },
    giveMeBackMyField: function (fieldName, filter = false) {
        if (jQuery('#' + fieldName).length > 0) {
            return jQuery('#' + fieldName);
        }

        if (filter) {
            fieldName = 'filter_' + fieldName + '_value';
        } else {
            fieldName = String(UrbemSonata.uniqId).concat('_').concat(fieldName);
        }

        var field = jQuery('#' + fieldName);

        if (field.length == 0) {
            field = jQuery('#' + fieldName.concat('_autocomplete_input'));
        } else {
        }

        return field.length > 0 ? field : undefined;
    },
    populateSelect: function (select, data, prop, selectedOption) {
        var firstOption = select.find('option:first-child');
        select.empty().append(firstOption);

        $.each(data, function (index, item) {
            var option = $('<option>', {value: item[prop.value], text: item[prop.label]});
            select.append(option);
        });

        if (selectedOption !== undefined || selectedOption !== "") {
            select.val(selectedOption).trigger('change');
        } else {
            select.val('').trigger('change');
        }
    },
    populateMultiSelect: function (select, data, prop, selectedOptions) {
        select.find('option').each(function () {
            $(this).remove();
        });

        $.each(data, function (index, item) {
            var option = $('<option>', {value: item[prop.value], text: item[prop.label]});
            select.append(option);
        });

        select.val(selectedOptions).trigger('change');
    },
    giveMeBackMyFieldContainer: function (fieldName) {
        var field = $('#field_container_' + String(UrbemSonata.uniqId).concat('_' + fieldName));

        if (field.length == 0) {
            field = $('#field_container_' + String(UrbemSonata.uniqId).concat('_' + fieldName.concat('_autocomplete_input')));
        }

        return field.length > 0 ? field : undefined;
    },
    setFieldErrorMessage: function (suggestedId, message, appendIn) {
        var errorMessageElement
          , fieldContainer;

        errorMessageElement = '<div class="help-block sonata-ba-field-error-messages">';
        errorMessageElement += '<span class="close-help-block" style="float: right;"><i class="fa fa-times-circle" aria-hidden="true"></i></span>';
        errorMessageElement += '<script>$(\'.close-help-block\').click(function(){ $(\'.sonata-ba-field-error-messages\').hide(); });</script>';
        errorMessageElement += '<ul class="list-unstyled"><li>';
        errorMessageElement += '<i class="fa fa-exclamation-circle"></i>&nbsp;';
        errorMessageElement += message;
        errorMessageElement += '</li></ul>';
        errorMessageElement += '</div>';

        fieldContainer = appendIn;
        fieldContainer.append(errorMessageElement);
        fieldContainer.addClass('sonata-ba-field-error').parent().addClass('has-error');

        return errorMessageElement;
    },
    setGlobalErrorMessage: function(message) {
        if (message != null) {
            $("#alert").load("/bundles/core/javascripts/templates/alert_danger.html", null, function() {
                $(this).find("span").html(message);
            });
        } else {
            $('#alert').empty();
        }
    },
    isEditPage: function () {
        var hasCurrentRequestId = ( !( typeof currentRequestId === 'undefined' || !currentRequestId > 0 ) );

        if (! hasCurrentRequestId) {
          return false;
        }

        return ( hasForm = $('form').length && $('.campo-sonata').length );
    },
    uniqueCollection: function (collection) {
        return collection.reduce(function(acc, el, i, arr) {
          if (arr.indexOf(el) !== i && acc.indexOf(el) < 0) acc.push(el); return acc;
        }, []);
    },
    isFunction: function (functionToCheck) {
         var getType = {};
         return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]';
    },
    UrbemSearch: {
      findAgenciasByBanco: function (codBanco) {
          return $.get('/recursos-humanos/api/search/agencias', {
              cod_banco: codBanco
          });
      },
      findContasCorrenteByAgencia: function (codBanco, codAgencia) {
          return $.get('/recursos-humanos/api/search/conta-corrente', {
              cod_banco: codBanco,
              cod_agencia: codAgencia
          });
      },
      findClassificacaoByCatalogo: function (codCatalogo) {
        return $.get('/patrimonial/api/search/catalogo-classificacao', {
            cod_catalogo: codCatalogo
        });
      }
    },
    backDynamicItems: function (fields) {
        $.each(fields, function( k, field ) {
            $.each(field, function( i, objectField ) {
                var getObjectField = UrbemSonata.giveMeBackMyField(objectField.name);
                switch(objectField.type) {
                    case 1:
                        if (objectField.id != '' && objectField.label != '') {
                            getObjectField.select2('data', {
                                id: objectField.id,
                                label: objectField.label
                            });
                            $(getObjectField).parent().find("input:hidden").val(objectField.id);
                        }
                        break;
                    default:
                        $(getObjectField).val(objectField.content);
                }
            });
        });
    },
    waitForFunctionToBeAvailableAndExecute: function (variableExists, functionCallback) {
        var waitUrlService = setInterval(function() {
            if (typeof variableExists !== 'undefined' && variableExists != "") {
                functionCallback();
                clearInterval(waitUrlService);
            }
        }, 1000);
    },
    acceptOnlyNumeric: function (element) {
        element.keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    },
    /**
     * @param $select object
     * @param action string
     * @param parameters array
     * @param functionCallback function
     */
    loadSelectOnAjax : function($select, action, parameters, functionCallback) {
        // ObjectModal
        var modal = $.urbemModal();
        modal.disableBackdrop().setTitle('Aguarde').setBody('Carregando').open();

        parameters.push({name: 'action', value: action});
        $.get(UrlServiceProviderTCE, parameters)
            .success(function (data) {
                //Mandatory parameters for Response AJAX - response, content
                if (data.response == true) {
                    var content = data.content;
                    $select.empty();
                    $select.append("<option value=''>Selecione</option>");
                    $select.val('').change();

                    $.each(content,function(key, value)
                    {
                        $select.append('<option value=' + key + '>' + value + '</option>');
                    });

                    if (typeof functionCallback === 'function') {
                        functionCallback($select, content);
                    }

                }
                modal.close().remove();
            })
            .error(function (data) {
                modal.close().remove();
            });
    },
    /**
     * Esta função é usada para corrigir altura dos elementos com base nos campos dos Sonata, por conta de não ter um
     * padrão que diferencia os objetos um do outro, impactando diretamente em seus containers
     *
     * Esta função está duplicada, o conteúdo dela deve ser replicado em:
     * src/Urbem/CoreBundle/Resources/public/javascripts/dropdown-menu-action-custom.js
     * */
    fixClassNameContainerInputType: function () {
        if (!parseInt($('form').length) > 0) {
            return;
        }

        $("input[type=text].select2-focusser.select2-offscreen").each(function() {
            $(this).parents(".campo-sonata").first().toggleClass("campo-sonata campo-sonata-select");
        });

        $("input[type=text].campo-sonata.form-control").each(function() {
            $(this).parents(".campo-sonata").first().toggleClass("campo-sonata campo-sonata-input-text");
        });

        $("input[type=number].campo-sonata.form-control").each(function() {
            $(this).parents(".campo-sonata").first().toggleClass("campo-sonata campo-sonata-input-number");
        });

        $("input[type=file]").each(function() {
            $(this).parents(".campo-sonata").first().toggleClass("campo-sonata campo-sonata-input-file");
        });

        $("input[type=text].sonata-medium-datecampo-sonata.form-control").each(function() {
            $(this).parents(".campo-sonata").first().toggleClass("campo-sonata campo-sonata-datecampo");
        });
    },
    LoadAutoCompleteInput: function (inputClass, inputNameSearch, urlToSend, minimumInputLength, parameters = {}) {
        $(inputClass).each(function(key, tipo) {
            var autocompleteInput = $(this);
            autocompleteInput.prop('required',true);

            autocompleteInput.select2({
                placeholder: 'Buscar dados',
                allowClear: true,
                enable: 'true',
                required: true,
                minimumInputLength: minimumInputLength,
                dropdownAutoWidth: true,
                containerCssClass: 'select2-v4-parameters form-control',
                ajax: {
                    url:  urlToSend,
                    dataType: 'json',
                    quietMillis: 100,
                    data: function (term, page) {
                        var search = parameters;
                        search[inputNameSearch] = term;

                        return search;
                    },
                    results: function (data, page) {
                        return {results: data.items};
                    }
                },
                formatResult: function (item) {
                    return '<div>'+item.label+'<\/div>';
                },
                formatSelection: function (item) {
                    return item.label;
                },
                escapeMarkup: function (m) { return m; }
            });

            autocompleteInput.on('change', function(e) {
                var currentInputName = $(this).attr("id");
                if (undefined !== e.removed && null !== e.removed) {
                    var removedItems = e.removed;
                    $('#' + currentInputName).val('');
                }

                var el = null;
                if (undefined !== e.added) {
                    var addedItems = e.added;
                    $('#' + currentInputName).val(addedItems.id);
                }
            });

            var data = [];
            data = {id: autocompleteInput.attr("data-value"), label: autocompleteInput.attr("data-label")};

            if (undefined == data.length || 0<data.length) {
                autocompleteInput.select2('data', data);
            }
        });
    },

    DataTablesSetDimensionToHeaderAndBodyCell: function (tableName, listClassToColumns) {
        var tableHeaderCell = $("#"+tableName+"_wrapper .dataTables_scrollHead table thead tr th");
        var tableBodyCell = $("#"+tableName+"_wrapper .dataTables_scrollBody table tbody tr:first td");

        for (var position = 0; position < listClassToColumns.length; position++) {
            /*Linha de títulos*/
            tableHeaderCell.eq(position).addClass(
                listClassToColumns[position]
            );

            /*Linhas de valores da tabela*/
            tableBodyCell.eq(position).addClass(
                listClassToColumns[position]
            );
        }
    }
};

$(function () {
    $("select[multiple='multiple']").each(function () {
        if ($("label[for='" + $(this).attr("id") + "']").hasClass("required")) {
            $("select[multiple='multiple']").attr("required", true);
        }
    });
    $("select[multiple='multiple']").on("change", function () {
        if ($("label[for='" + $(this).attr("id") + "']").hasClass("required")) {
            if ($(this).val()) {
                if (Object.keys($(this).val()).length > 0) {
                    $(this).removeAttr("required");
                } else {
                    $(this).attr("required", true);
                }
            } else {
                $(this).attr("required", true);
            }
        }
    });

    $("select[name='_exercicio']").off('change').blur().on("change", function() {
        if ($(this).val() != '') {
            $.ajax({
                url: "/exercicio",
                method: "POST",
                dataType: "json",
                data: {
                    exercicio: $(this).val()
                },
                success: function (data) {
                    location.reload();
                }
            });
        }
    });

    $(".readonly").on("focus", function(e) {
        $(this).blur();
    });

    $(".readonly").on('keydown paste', function(e){
        e.preventDefault();
    });

    /**
     * Por algum motivo desconhecido, o select2 passou a mostrar o input e select.
     * Esse fix remove o select e arruma o tamanho do container desse campo
     */
    $(".select2-v4-parameters").siblings('select').remove();

    $(document).ready(function (e) {
        $('select.select2-parameters').show();
    });
});

/**
 * @param selector if searching by id, use #fieldName
 *          if searching by name, just use the fieldName
 * @param inputType input|select|textarea
 * @param options  if you want to prepend some text before the
 *          UrbemSonata.uniqId, for exemple:
 *          $("#dp_" + UrbemSonata.uniqId + "_periodoFinal")
 *          Because datepicker use db_ to prepend on id
 * @returns {*|jQuery|HTMLElement}
 */
$.sonataField = function (selector, inputType, options) {
  inputType = (undefined == inputType) ? 'input' : inputType;
  if (undefined == options) {
    options = {};
  }
  var prepend = (undefined == options.prepend) ? '' : options.prepend;


  var selectorType = selector.substr(0, 1);
  var jquerySelector = (selectorType == '#')
    ? '#' + prepend + UrbemSonata.uniqId + '_' + selector.substr(1, selector.length)
    : inputType + '[name="' + UrbemSonata.uniqId + '[' + selector + ']' + '"]';

  return $(jquerySelector);
};

/**
 * @param options Default options of DataTable may be set here
 * @constructor
 */
jQuery.fn.UrbemDataTable = function (options) {
  /**
   * jQuery DataTable Plugin
   * Usage: $(selector).DataTable(options)
   *
   * Urbem Mod
   * Usage: $(selector).UrbemDataTable(options)
   * Tradução automática
   *
   * É possível trabalhar com alto volume de dados:
   * https://datatables.net/extensions/scroller/examples/initialisation/large_js_source.html
   */
  var languageOptions = {
    'language': {
      "sEmptyTable": "Nenhum registro encontrado",
      "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
      "sInfoFiltered": "(Filtrados de _MAX_ registros)",
      "sInfoPostFix": "",
      "sInfoThousands": ".",
      "sLengthMenu": "_MENU_ resultados por página",
      "sLoadingRecords": "Carregando...",
      "sProcessing": "Processando...",
      "sZeroRecords": "Nenhum registro encontrado",
      "sSearch": "Pesquisar",
      "oPaginate": {
        "sNext": "Próximo",
        "sPrevious": "Anterior",
        "sFirst": "Primeiro",
        "sLast": "Último"
      },
      "oAria": {
        "sSortAscending": ": Ordenar colunas de forma ascendente",
        "sSortDescending": ": Ordenar colunas de forma descendente"
      }
    }
  };

  options = _.merge(options, languageOptions);

  $(this).DataTable(options);
};

// https://j11y.io/javascript/regex-selector-for-jquery/
jQuery.expr[':'].regex = function(elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ?
                        matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
    return regex.test(jQuery(elem)[attr.method](attr.property));
}

if (!String.prototype.padStart) {
    String.prototype.padStart = function padStart(targetLength,padString) {
        targetLength = targetLength>>0; //floor if number or convert non-number to 0;
        padString = String(padString || ' ');
        if (this.length > targetLength) {
            return String(this);
        }
        else {
            targetLength = targetLength-this.length;
            if (targetLength > padString.length) {
                padString += padString.repeat(targetLength/padString.length); //append to original to ensure we are longer than needed
            }
            return padString.slice(0,targetLength) + String(this);
        }
    };
}
