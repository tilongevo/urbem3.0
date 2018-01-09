$(document).ready(function () {

    var tipoComissao = UrbemSonata.giveMeBackMyField('fkLicitacaoTipoComissao'),
        dataComissaoForm = UrbemSonata.giveMeBackMyField('dataComissao'),
        vigencia = UrbemSonata.giveMeBackMyField('vigencia'),

        fkSwCgm = UrbemSonata.giveMeBackMyField('fkSwCgm'),
        normaMembro = UrbemSonata.giveMeBackMyField('normaMembro'),
        dataComissaoMembro = UrbemSonata.giveMeBackMyField('dataComissaoMembro'),
        vigenciaMembro = UrbemSonata.giveMeBackMyField('vigenciaMembro'),
        cargoMembro = UrbemSonata.giveMeBackMyField('cargo'),
        fkLicitacaoTipoMembro = UrbemSonata.giveMeBackMyField('fkLicitacaoTipoMembro'),
        fkLicitacaoNaturezaCargo = UrbemSonata.giveMeBackMyField('fkLicitacaoNaturezaCargo');

    var template = '<tr class="js-lista-membros-tr" data-index="{index}">\
		<td class="control-group">\
		</td>\
		<td class="control-group">\
			<input type="hidden" name="membros[{index}][fkSwCgm]" value="{numCgm}" readonly>\
			<input type="hidden" name="membros[{index}][normaMembro]" value="{normaId}" readonly>\
			<input type="hidden" name="membros[{index}][dataComissaoMembro]" value="{dataComissao}" readonly>\
			<input type="hidden" name="membros[{index}][vigenciaMembro]" value="{vigencia}" readonly>\
			<input type="hidden" name="membros[{index}][cargo]" value="{cargo}" readonly>\
			<input type="hidden" name="membros[{index}][fkLicitacaoTipoMembro]" value="{licitacaoTipoCodigo}" readonly>\
			<input type="hidden" name="membros[{index}][fkLicitacaoNaturezaCargo]" value="{naturezaCargoCodigo}" readonly>\
			<span>{nomCgm}</span>\
		</td>\
		<td class="control-group">\
			<span>{norma}</span>\
		</td>\
		<td class="control-group">\
			<span>{dataComissao}</span>\
		</td>\
		<td class="control-group">\
			<span>{vigencia}</span>\
		</td>\
		<td class="control-group">\
			<span>{cargo}</span>\
		</td>\
		<td class="control-group">\
			<span class="tipoMembro">{licitacaoTipo}</span>\
		</td>\
		<td class="control-group">\
			<span>{naturezaCargo}</span>\
		</td>\
		<td class="control-group">\
			<button type="button" class="js-delete-row">Remover</button>\
		</td>\
	</tr>';

    var adicionaMembro = {
        listaMembrosTable: $('#js-table-lista-membros'),
        addMembroButton: $('input[name="incluir-membro-btn"]'),
        submitCreateButton: $('button[name="btn_create_and_list"]'),
        submitUpdateButton: $('button[name="btn_update_and_list"]'),

        addRow: function () {
            this.listaMembrosTable.find('tbody').append(this.populateTemplate());
            this.updateRowNumber();
            this.clearSelect(fkSwCgm);
            this.clearSelect(normaMembro);
            this.clearSelect(dataComissaoMembro);
            this.clearSelect(vigenciaMembro);
            this.clearSelect(cargoMembro);
            this.clearSelect(fkLicitacaoTipoMembro);
            this.clearSelect(fkLicitacaoNaturezaCargo);
        },
        deleteRow: function (row) {
            row.remove();

            this.updateRowNumber();
        },
        populateTemplate: function (data) {
            var numCgm = fkSwCgm.val();
            var normaId = normaMembro.val();
            var licitacaoTipoCodigo = fkLicitacaoTipoMembro.val();
            var naturezaCargoCodigo = fkLicitacaoNaturezaCargo.val();

            var nomCgm = fkSwCgm.select2('data').label;
            var norma = normaMembro.select2('data').label;
            var dataComissao = dataComissaoMembro.val();
            var vigencia = vigenciaMembro.val();
            var cargo = cargoMembro.val();
            var licitacaoTipo = $('select#' + UrbemSonata.uniqId + '_fkLicitacaoTipoMembro option:selected').text();
            var naturezaCargo = $('select#' + UrbemSonata.uniqId + '_fkLicitacaoNaturezaCargo option:selected').text();

            return template.replaceAll('{numCgm}', numCgm)
                .replaceAll('{normaId}', normaId)
                .replaceAll('{licitacaoTipoCodigo}', licitacaoTipoCodigo)
                .replaceAll('{naturezaCargoCodigo}', naturezaCargoCodigo)
                .replaceAll('{nomCgm}', nomCgm)
                .replaceAll('{norma}', norma)
                .replaceAll('{dataComissao}', dataComissao)
                .replaceAll('{vigencia}', vigencia)
                .replaceAll('{cargo}', cargo)
                .replaceAll('{licitacaoTipo}', licitacaoTipo)
                .replaceAll('{naturezaCargo}', naturezaCargo)
                .replaceAll('{index}', this.getIndex() + 1);
        },
        getIndex: function () {
            return parseInt(this.listaMembrosTable.find('tr:last').attr('data-index')) || 0;
        },
        validarMembro: function () {
            var errors = '';
            var dataHoje = (moment()).format("YYYYMMDD");
            var dtPublicacaoArray = (dataComissaoMembro.val()).split('/');
            var dataPublicacao = dtPublicacaoArray[2] + dtPublicacaoArray[1] + dtPublicacaoArray[0];
            var dtTerminoArray  = (vigenciaMembro.val()).split('/');
            var dataTermino  = dtTerminoArray[2] + dtTerminoArray[1] + dtTerminoArray[0];

            if (fkSwCgm.select2('data').label == '') {
                var label =$("label[for='" + UrbemSonata.uniqId + "_fkSwCgm']").text();
                errors += 'Campo ' + label + ' Obrigatório. <br>';
            }

            if (normaMembro.select2('data').label == '') {
                var label =$("label[for='" + UrbemSonata.uniqId + "_normaMembro']").text();
                errors += 'Campo ' + label + ' Obrigatório. <br>';
            }

            if (cargoMembro.val() == '') {
                var label =$("label[for='" + UrbemSonata.uniqId + "_cargo']").text();
                errors += 'Campo ' + label + ' Obrigatório. <br>';
            }

            if (fkLicitacaoTipoMembro.val() == '') {
                var label =$("label[for='" + UrbemSonata.uniqId + "_fkLicitacaoTipoMembro']").text();
                errors += 'Campo ' + label + ' Obrigatório. <br>';
            }

            if (fkLicitacaoNaturezaCargo.val() == '') {
                var label =$("label[for='" + UrbemSonata.uniqId + "_fkLicitacaoNaturezaCargo']").text();
                errors += 'Campo ' + label + ' Obrigatório. <br>';
            }

            if ($('#js-table-lista-membros tr input[value="' + fkSwCgm.val() + '"]').length) {
                errors += 'Membro já consta na lista!<br>';
            }

            var presidente = false;
            var pregoeiro = false;
            $('#js-table-lista-membros tr .tipoMembro').each(function (index, value) {

                if (value.innerHTML == 'Presidente') {
                    presidente = true;
                }

                if (value.innerHTML == 'Pregoeiro') {
                    pregoeiro = true;
                }
            });

            if (presidente && $('select#' + UrbemSonata.uniqId + '_fkLicitacaoTipoMembro option:selected').text() == 'Presidente') {
                errors += 'Já existe um presidente para esta comissão.<br>';
            }

            if (pregoeiro && $('select#' + UrbemSonata.uniqId + '_fkLicitacaoTipoMembro option:selected').text() == 'Presidente') {
                errors += 'Já existe um pregoeiro para esta comissão.<br>';
            }

            if ((dataPublicacao <= dataHoje) && (dataTermino >= dataHoje ) && (vigenciaMembro.val() != "Não informado")) {

            } else {

                if (vigenciaMembro.val() == "Não informado") {
                    var message = 'Efetue a alteração da norma para este membro, para informar a data de término!';
                    errors += message + '<br>';
                } else {
                    var message = 'A norma para este membro expirou, utilize outra!';
                    errors += message + '<br>';
                }
            }

            $('.js-incluir-membro-errors').html(errors);

            return errors;
        },
        validarSubmit: function () {

            var errors = '';
            var dataHoje = (moment()).format("YYYYMMDD");
            var dtPublicacaoArray = (dataComissaoForm.val()).split('/');
            var dataPublicacao = dtPublicacaoArray[2] + dtPublicacaoArray[1] + dtPublicacaoArray[0];
            var dtTerminoArray  = (vigencia.val()).split('/');
            var dataTermino  = dtTerminoArray[2] + dtTerminoArray[1] + dtTerminoArray[0];

            if ($('#js-table-lista-membros tr .tipoMembro').length == 0) {
                errors += 'Escolha ao menos um membro para a comissão.<br>';
            }

            var presidente = false;
            var pregoeiro = false;
            $('#js-table-lista-membros tr .tipoMembro').each(function (index, value) {

                if (value.innerHTML == 'Presidente') {
                    presidente = true;
                }

                if (value.innerHTML == 'Pregoeiro') {
                    pregoeiro = true;
                }
            });

            if ((!presidente) && tipoComissao.val() == 1) {
                errors += 'Escolha um presidente para a comissão.<br>';
            }

            if ((!presidente && !pregoeiro) && tipoComissao.val() == 2) {
                errors += 'Escolha um presidente ou pregoeiro para a comissão.<br>';
            }

            if ((!pregoeiro) && tipoComissao.val() == 3) {
                errors += 'Escolha um pregoeiro para a comissão.<br>';
            }

            if ((dataPublicacao <= dataHoje) && (dataTermino >= dataHoje ) && (vigencia.val() != "Não informado")) {

            } else {

                if (vigencia.val() == "Não informado") {
                    var message = 'Efetue a alteração da norma da comissão, para informar a data de término!';
                    errors += message + '<br>';
                } else {
                    var message = 'A norma para comissão expirou, utilize outra!';
                    errors += message + '<br>';
                }
            }

            $('.js-incluir-membro-errors').html(errors);
            return errors;
        },
        updateRowNumber: function () {
            this.listaMembrosTable.find('tr').each(function (index, row) {
                $(row).find('td:first').text($(row).index() + 1);
            });
        },
        clearSelect: function (select) {
            select.val('');
            select.select2('val', '');
        },
        initialize: function () {
            var $this = this;

            this.addMembroButton.on('click', function (e) {
                e.preventDefault();

                $('.js-incluir-membro-errors').addClass('hidden');
                if ($this.validarMembro()) {
                    $('.js-incluir-membro-errors').removeClass('hidden');

                    return;
                }

                $this.addRow();
            });

            this.submitCreateButton.on('click', function (e) {

                $('.js-incluir-membro-errors').addClass('hidden');
                if ($this.validarSubmit()) {
                    e.preventDefault();
                    $('.js-incluir-membro-errors').removeClass('hidden');
                    return;
                }
            });

            this.submitUpdateButton.on('click', function (e) {

                $('.js-incluir-membro-errors').addClass('hidden');
                if ($this.validarSubmit()) {
                    e.preventDefault();
                    $('.js-incluir-membro-errors').removeClass('hidden');
                    return;
                }
            });

            $('body').on('click', '.js-delete-row', function (e) {
                e.preventDefault();
                var me = $(this);
                var row = me.closest('tr');

                $this.deleteRow(row, row.closest('table'));
            });
        }
    };

    adicionaMembro.initialize();
}());

