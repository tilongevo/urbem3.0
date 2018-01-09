$(document).on('click', '.remove', function () {
        $(this).parent().remove();
        if ($(".row-natureza-transferencia").length <= 0) {
            submitStatus = false;
            $('.empty-row-natureza-transferencia').show();
        }
});

$(document).ready(function(){

    var template = '<tr data-index="{index}">\
            <td class="control-group">\
                <input name="documentoNatureza[{index}][nomDocumento]" type="text" class="campo-sonata form-control" value="" required>\
            </td>\
            <td class="control-group">\
                <select name="documentoNatureza[{index}][obrigatorio]" class="js-select-obrigatorio" style="width:100%" required>\
                    <option></option>\
                </select>\
            </td>\
            <td class="control-group">\
                <button class="js-delete-documento-natureza"><i class="fa fa-trash fa-lg" aria-hidden="true"></i> Remover</button>\
            </td>\
        </tr>';

    var documentoNatureza = {
        documentoNaturezaTable: $(".js-table-documento-natureza"),
        addDocumentoNaturezaButton: $(".js-add-documento-natureza"),
        obrigatorios: [],
        addRow: function() {
            if (this.documentoNaturezaTable.hasClass('hidden')) {
                    this.documentoNaturezaTable.removeClass('hidden');
            }

            this.documentoNaturezaTable.find('tbody').append(this.populateTemplate());

            var row = this.documentoNaturezaTable.find('tbody').find('tr:last');
            this.getObrigatorios(row);
        },
        deleteRow: function (row) {
            row.remove();
            if (!this.documentoNaturezaTable.find('tbody').find('tr:last').length) {
                this.documentoNaturezaTable.addClass('hidden');
            }
        },
        getObrigatorios: function (row) {
            var $this = this;
            var obrigatorioSelect = row.find('.js-select-obrigatorio');
            if (this.obrigatorios.length > 0) {
                this.clearSelect(obrigatorioSelect);
                obrigatorioSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));
                $.each(this.obrigatorios, function (index, item) {
                    obrigatorioSelect.append($('<option style="display:none"></option>').attr('value',  obrigatorio.value).text(obrigatorio.label));
                });

                obrigatorioSelect.trigger('change');

                return;
            }

            $.ajax({
                method: 'GET',
                url: '/tributario/cadastro-imobiliario/documento-natureza/index',
                dataType: 'json',
                beforeSend: function () {
                    $this.clearSelect(obrigatorioSelect);
                    obrigatorioSelect.append($('<option style="display:none" selected></option>').text('Carregando...'));
                    obrigatorioSelect.trigger('change', true);
                },
                success: function (data) {
                    $this.clearSelect(obrigatorioSelect);
                    obrigatorioSelect.append($('<option value=""  selected>Selecione</option>'));
                    $.each(data, function (index, item) {
                        obrigatorioSelect.append($('<option ></option>').attr('value', item.value).text(item.label));
                    });

                    obrigatorioSelect.trigger('change', true);
                    $this.obrigatorios = data;
                }
            });
        },
        getIndex: function () {
            return parseInt(this.documentoNaturezaTable.find('tr:last').attr('data-index')) || 0;
        },
        populateTemplate: function () {
            return template.replaceAll('{index}', this.getIndex() + 1);
        },
        clearSelect: function (select) {
            select.val('');
            select.select2('val', '');
            select.find('option').each(function (index, option) {
                option.remove();
            });
        },
        initialize: function () {
            var $this = this;

            this.addDocumentoNaturezaButton.on('click', function (e) {
                e.preventDefault();
                $this.addRow();
            });

            $('body').on('click', '.js-delete-documento-natureza', function (e) {
                e.preventDefault();
                var me = $(this);
                var row = me.closest('tr');

                $this.deleteRow(row);
            });

            $('body').on('change', '.js-select-obrigatorio', function (e, reinitializingComponent) {
                if (reinitializingComponent) {
                    return;
                }

            });

        }
    }

    documentoNatureza.initialize();

}());
