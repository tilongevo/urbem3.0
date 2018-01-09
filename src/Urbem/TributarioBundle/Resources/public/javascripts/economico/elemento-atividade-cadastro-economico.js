$(document).ready(function () {

	var template = '<tr data-index="{index}" data-signature="{signature}">\
		<td class="control-group">\
			\
		</td>\
		<td class="control-group">\
			<span>{nomAtividade}</span>\
			<input type="hidden" name="elementoAtividade[{index}][codAtividade]" class="js-lista-elemento-atividade-codAtividade" value="{codAtividade}" readonly>\
		</td>\
		<td class="control-group">\
			<span>{nomElemento}</span>\
			<input type="hidden" name="elementoAtividade[{index}][codElemento]" class="js-lista-elemento-atividade-codElemento" value="{codElemento}" readonly>\
		</td>\
		<td class="control-group">\
			<button type="button" class="js-delete-row">Remover</button>\
		</td>\
	</tr>';

	var elementoAtividadeCadastroEconomico = {
		table: $('.js-table-lista-elemento-atividade'),
		addButton: $('button[name="incluir-elemento-atividade-btn"]'),
		addRow: function () {
			this.table.find('tbody').append(this.populateTemplate());

			this.updateRowNumber();
		},
		deleteRow: function (row) {
			row.remove();

			this.updateRowNumber();
		},
		populateTemplate: function (data) {
			var atividade = $('.js-select-atividade').last().select2('data');
			var elemento = $('.js-select-elemento').last().select2('data');

			if ($('tr[data-signature="' + elemento.id + '-' + atividade.id + '"]').length) {
				return;
			}

			return template.replaceAll('{signature}', elemento.id + '-' + atividade.id)
				.replaceAll('{codAtividade}', atividade.id)
				.replaceAll('{nomAtividade}', atividade.text)
				.replaceAll('{codElemento}', elemento.id)
				.replaceAll('{nomElemento}', elemento.text)
				.replaceAll('{index}', this.getIndex() + 1);
		},
		getIndex: function () {
			return parseInt(this.table.find('tr:last').attr('data-index')) || 0;
		},
		validarElementoAtividade: function () {
			var errors = '';

			if (!$('.js-select-atividade').last().val()) {
				errors += 'Selecione a Atividade.<br>';
			}

			if (!$('.js-select-elemento').last().val()) {
				errors += 'Informe o Elemento.<br>';
			}

			$('.js-incluir-elemento-atividade-errors').html(errors);

			return !errors;
		},
		updateRowNumber: function () {
			this.table.find('tr').each(function (index, row) {
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

			this.addButton.on('click', function (e) {
				e.preventDefault();

				$('.js-incluir-elemento-atividade-errors').addClass('hidden');
				if (!$this.validarElementoAtividade()) {
					$('.js-incluir-elemento-atividade-errors').removeClass('hidden');

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

	elementoAtividadeCadastroEconomico.initialize();
}());
