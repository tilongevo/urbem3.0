$(document).ready(function () {

	var template = '<tr data-index="{index}">\
		<td class="control-group">\
			\
		</td>\
		<td class="control-group">\
			<span>{numcgm}</span>\
			<input type="hidden" name="socios[{index}][numcgm]" class="js-lista-socios-numcgm" value="{numcgm}" readonly>\
		</td>\
		<td class="control-group">\
			<span>{nomCgm}</span>\
		</td>\
		<td class="control-group">\
			<span>{quotaSocioFormatted}</span>\
			<input type="hidden" name="socios[{index}][quotaSocio]" value="{quotaSocio}" readonly>\
		</td>\
		<td class="control-group">\
			<button type="button" class="js-delete-row">Remover</button>\
		</td>\
	</tr>';

	var responsavelTecnicoCadastroEconomico = {
		listaSociosTable: $('.js-table-lista-socios'),
		addSocioButton: $('button[name="incluir-socio-btn"]'),
		addRow: function () {
			this.listaSociosTable.find('tbody').append(this.populateTemplate());

			this.updateRowNumber();
		},
		deleteRow: function (row) {
			row.remove();

			this.updateRowNumber();
		},
		getAssuntos: function (classificacao) {
			var $this = this;
			var assuntoSelect = $('.js-select-processo-assunto');
			var processo = $('input[id$="fkSwProcesso_autocomplete_input"]');

			window.varJsCodClassificacao = classificacao.val();
			window.varJsCodAssunto = null;

			this.clearSelect(assuntoSelect);
			assuntoSelect.trigger('change', true);
			processo.select2('val', '');
			$('input[name$="[fkSwProcesso]"]').val('');
			if (!classificacao.val()) {
				return;
			}

			$.ajax({
				method: 'POST',
				url: '/tributario/cadastro-imobiliario/lote/consultar-assunto',
				data: {codClassificacao: classificacao.val()},
				dataType: 'json',
				beforeSend: function () {
					assuntoSelect.append($('<option style="display:none" selected></option>').text('Carregando...'));
					assuntoSelect.trigger('change', true);
				},
				success: function (data) {
					$this.clearSelect(assuntoSelect);
					assuntoSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));
					$.each(data, function (index, item) {
						assuntoSelect.append($('<option style="display:none"></option>').attr('value', index).text(item));
					});

					assuntoSelect.trigger('change', true);
				}
			});
		},
		populateTemplate: function (data) {
			var cgm = $('input[id$="socio_autocomplete_input"]').select2('data');
			var nomCgm = cgm.label.split(' - ');
			var quota = $('.js-quota-socio').val();

			return template.replaceAll('{numcgm}', cgm.id)
				.replaceAll('{nomCgm}', nomCgm[nomCgm.length - 1])
				.replaceAll('{quotaSocioFormatted}', $('.js-quota-socio').val())
				.replaceAll('{quotaSocio}', quota.replace('.', '').replace(',', '.'))
				.replaceAll('{index}', this.getIndex() + 1);
		},
		getIndex: function () {
			return parseInt(this.listaSociosTable.find('tr:last').attr('data-index')) || 0;
		},
		validarSocio: function () {
			var errors = '';

			if (!$('.js-quota-socio').val()) {
				errors += 'Selecione o Sócio.<br>';
			}

			if (!$('.js-quota-socio').val()) {
				errors += 'Informe a Quota.<br>';
			}

			$('.js-incluir-socio-errors').html(errors);

			return !errors;
		},
		updateRowNumber: function () {
			this.listaSociosTable.find('tr').each(function (index, row) {
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

			window.varJsInscricaoEconomica = $('.js-inscricao-economica').val();
			window.varJsCodClassificacao = $('.js-select-processo-classificao').val();
			window.varJsCodAssunto = $('.js-select-processo-assunto').val();

			this.addSocioButton.on('click', function (e) {
				e.preventDefault();

				$('.js-incluir-socio-errors').addClass('hidden');
				if (!$this.validarSocio()) {
					$('.js-incluir-socio-errors').removeClass('hidden');

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

			if (!$('.js-select-processo-classificacao').val()) {
				$('.js-select-processo-assunto').empty();
			}

			$('body').on('change', '.js-select-processo-classificacao', function (e) {
				$this.getAssuntos($(this));
			});

			$('body').on('change', '.js-select-processo-assunto', function (e, reinitializingComponent) {
				if (reinitializingComponent) {
					return;
				}

				window.varJsCodAssunto = $(this).val();

				$('input[id$="fkSwProcesso_autocomplete_input"]').select2('val', '');
			});
		}
	}

	responsavelTecnicoCadastroEconomico.initialize();
}());
