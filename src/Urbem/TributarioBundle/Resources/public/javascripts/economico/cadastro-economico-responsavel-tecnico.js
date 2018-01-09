$(document).ready(function () {

	var template = '<tr data-index="{index}">\
		<td class="control-group">\
			\
		</td>\
		<td class="control-group">\
			<span>{numcgm}</span>\
			<input type="hidden" name="responsaveis[{index}][numcgm]" class="js-lista-responsaveis-numcgm" value="{numcgm}" readonly>\
		</td>\
		<td class="control-group">\
			<span>{nomCgm}</span>\
		</td>\
		<td class="control-group">\
			<span>{numRegistro}</span>\
		</td>\
		<td class="control-group">\
			<span>{nomProfissao}</span>\
		</td>\
		<td class="control-group">\
			<button type="button" class="js-delete-row">Remover</button>\
		</td>\
	</tr>';

	var responsavelTecnicoCadastroEconomico = {
		listaResponsaveisTable: $('.js-table-lista-responsaveis'),
		addResponsavelButton: $('button[name="incluir-responsavel-btn"]'),
		addRow: function (data) {
			this.listaResponsaveisTable.find('tbody').append(this.populateTemplate(data));

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
		getResponsavel: function () {
			var $this = this;

			var responsavel = $('input[id$="fkEconomicoResponsavelTecnico_autocomplete_input"]');
			if (!responsavel.val()) {
				return;
			}

			$.ajax({
				method: 'GET',
				url: '/tributario/cadastro-economico/inscricao-economica/definir-responsaveis/get/' + parseInt(responsavel.val()),
				dataType: 'json',
				beforeSend: function () {
					$this.addResponsavelButton.attr('disabled', 'disabled');
				},
				success: function (data) {
					$this.addRow(data);

					$('input[id$="fkEconomicoResponsavelTecnico_autocomplete_input"]').select2('val', '');
					$this.addResponsavelButton.removeAttr('disabled');
				},
				error: function () {
					$this.addResponsavelButton.removeAttr('disabled');
				}
			});
		},
		populateTemplate: function (data) {
			return template.replaceAll('{numcgm}', data.numcgm)
				.replaceAll('{nomCgm}', data.nomCgm)
				.replaceAll('{numRegistro}', data.numRegistro + ' - ' + data.siglaUf)
				.replaceAll('{nomProfissao}', data.nomProfissao)
				.replaceAll('{index}', this.getIndex() + 1);
		},
		getIndex: function () {
			return parseInt(this.listaResponsaveisTable.find('tr:last').attr('data-index')) || 0;
		},
		validarResponsavel: function () {
			var errors = '';

			if (!$('input[id$="fkEconomicoResponsavelTecnico_autocomplete_input"]').val()) {
				errors += 'Selecione o Responsável.<br>';
			}

			if ($('.js-lista-responsaveis-numcgm[value="' + parseInt($('input[id$="fkEconomicoResponsavelTecnico_autocomplete_input"]').val()) + '"]').length) {
				errors += 'Responsável já informado!<br>';
			}

			$('.js-incluir-responsavel-errors').html(errors);

			return !errors;
		},
		updateRowNumber: function () {
			this.listaResponsaveisTable.find('tr').each(function (index, row) {
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

			this.addResponsavelButton.on('click', function (e) {
				e.preventDefault();

				$('.js-incluir-responsavel-errors').addClass('hidden');
				if (!$this.validarResponsavel()) {
					$('.js-incluir-responsavel-errors').removeClass('hidden');

					return;
				}

				$this.getResponsavel();
			});

			$('body').on('click', '.js-delete-row', function (e) {
				e.preventDefault();
				var me = $(this);
				var row = me.closest('tr');

				$this.deleteRow(row, row.closest('table'));
			});
		}
	}

	responsavelTecnicoCadastroEconomico.initialize();
}());
