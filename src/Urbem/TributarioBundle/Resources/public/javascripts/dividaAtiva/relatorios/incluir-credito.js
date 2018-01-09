$(document).ready(function () {

	var credito = $('#' + UrbemSonata.uniqId + "_credito");
	var exercicio = $('#' + UrbemSonata.uniqId + "_exercicio");

	var template = '<tr data-index="{index}">\
		<td class="control-group">\
			\
		</td>\
		<td class="control-group">\
			<span>{exercicio}</span>\
			<input type="hidden" name="creditos[{index}][exercicio]" class="js-lista-exercicio" value="{exercicio}" readonly>\
		</td>\
		<td class="control-group">\
			<span>{codigo}</span>\
		</td>\
		<td class="control-group">\
			<span>{creditoLabel}</span>\
			<input type="hidden" name="creditos[{index}][credito]" class="js-lista-credito" value="{credito}" readonly>\
		</td>\
		<td class="control-group">\
			<button type="button" class="js-delete-row">Remover</button>\
		</td>\
	</tr>';

	var incluirCredito = {
		listaCreditosTable: $('.js-table-lista-creditos'),
		addCreditoButton: $('button[name="incluir-credito-btn"]'),
		addRow: function () {
			this.listaCreditosTable.find('tbody').append(this.populateTemplate());
			this.updateRowNumber();
		},
		deleteRow: function (row) {
			row.remove();

			this.updateRowNumber();
		},
		getCredito: function () {
			var $this = this;

			if (!credito) {
				return;
			}

			if (!exercicio.val()) {
				return;
			}
			var codigo = 1999;
			var valores = [codigo, credito, exercicio]
			$this.addRow(valores);
		},
		populateTemplate: function () {
			var creditoData = credito.select2('data');

			var splittedId = creditoData.id.split('~');
			var codigo = '';
			for (var i = 0; i < splittedId.length; i++) {
				var formattedId = '0000' + splittedId[i];
				if (i == 0) {

					codigo += formattedId.substr(formattedId.length - 3, 3) + '.';

					continue;
				}

				if (i == 1) {
					codigo += formattedId.substr(formattedId.length - 3, 3) + '.';

					continue;
				}

				if (i == 2) {
					codigo += formattedId.substr(formattedId.length - 2, 2) + '.';

					continue;
				}

				if (i == 3) {
					codigo += formattedId.substr(formattedId.length - 1, 1);

					continue;
				}
			}

			return template
				.replaceAll('{exercicio}', exercicio.val())
				.replaceAll('{codigo}', codigo)
				.replaceAll('{creditoLabel}', creditoData.text)
				.replaceAll('{credito}', creditoData.id)
				.replaceAll('{index}', this.getIndex() + 1);
		},
		getIndex: function () {
			return parseInt(this.listaCreditosTable.find('tr:last').attr('data-index')) || 0;
		},
		validarCredito: function () {
			var errors = '';

			if (!credito.val()) {
				errors += 'Selecione o crédito.<br>';
			}

			if (!exercicio.val()) {
				errors += 'Selecione o exercício.<br>';
			}

			if ($('.js-lista-credito[value="' + credito.val() + '"]').length &&
				$('.js-lista-exercicio[value="' + exercicio.val() + '"]').length) {

				errors += 'Valor já informado!<br>';
			}

			$('.js-incluir-credito-errors').html(errors);

			return !errors;
		},
		updateRowNumber: function () {
			this.listaCreditosTable.find('tr').each(function (index, row) {
				$(row).find('td:first').text($(row).index() + 1);
			});
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

			this.addCreditoButton.on('click', function (e) {
				e.preventDefault();

				$('.js-incluir-credito-errors').addClass('hidden');
				if (!$this.validarCredito()) {
					$('.js-incluir-credito-errors').removeClass('hidden');

					return;
				}

				$this.addRow();
			});

			$('body').on('click', '.js-delete-row', function (e) {
				e.preventDefault();
				var me = $(this);
				var row = me.closest('tr');

				$this.deleteRow(row, row.closest('table'));
			});
		}
	}

	incluirCredito.initialize();
}());
