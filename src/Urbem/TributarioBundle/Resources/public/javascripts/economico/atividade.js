$(document).ready(function () {

	var atividadeTemplate = '<tr data-index="{index}">\
		<td class="control-group">\
			\
		</td>\
		<td class="control-group">\
			<span>{codEstrutural}</span>\
			<input type="hidden" name="servicos[{index}][codServico]" class="js-lista-servicos-cod-servico" value="{codServico}" readonly>\
		</td>\
		<td class="control-group">\
			<span>{nomServico}</span>\
		</td>\
		<td class="control-group">\
			<button type="button" class="js-delete-row">Remover</button>\
		</td>\
	</tr>';

	var atividade = {
		listaServicosTable: $('.js-table-lista-servicos'),
		addServicoButton: $('button[name="incluir-servico-btn"]'),
		addRow: function () {
			this.listaServicosTable.find('tbody').append(this.populateTemplate());

			this.updateRowNumber();
		},
		deleteRow: function (row) {
			row.remove();

			this.updateRowNumber();
		},
		toggleCampos: function () {
			var codAtividade = $('input[name$="[codAtividade]"]').val();
			var nivelAtividade = $('select[name$="[fkEconomicoNivelAtividade]"]').val();
			var ultimoNivelAtividade = $('input[name$="[ultimoCodNivel]"]').val();

			if (codAtividade || nivelAtividade == 1) {
				$('input[id$="atividade_autocomplete_input"]').closest('.form_row').addClass('hidden');
				$('input[id$="atividade_autocomplete_input"]').select2('enable', false);
				$('input[id$="atividade_autocomplete_input"]').removeAttr('required');
			}

			if (!codAtividade && nivelAtividade > 1) {
				$('input[id$="atividade_autocomplete_input"]').closest('.form_row').removeClass('hidden');
				$('input[id$="atividade_autocomplete_input"]').select2('enable', true);
				$('input[id$="atividade_autocomplete_input"]').attr('required', 'required');
			}

			if (!codAtividade || nivelAtividade == 1) {
				$('input[name$="[atividadeSuperior]"]').closest('.form_row').addClass('hidden');
				$('input[name$="[atividadeSuperior]"]').select2('enable', false);
				$('input[name$="[atividadeSuperior]"]').removeAttr('required');
			}

			if (nivelAtividade == ultimoNivelAtividade) {
				$('input[name$="[aliquota]"]').closest('.form_row').removeClass('hidden');
				$('input[name$="[aliquota]"]').select2('enable', true);
				$('input[name$="[aliquota]"]').attr('required', 'required');

				$('select[name$="[profissao][]"]').closest('.box').show();
				$('select[name$="[profissao][]"]').select2('enable', true);

				$('select[name$="[elemento][]"]').closest('.box').show();
				$('select[name$="[elemento][]"]').select2('enable', true);

				$('select[name$="[vigenciaServico]"]').closest('.box').show();
				$('select[name$="[vigenciaServico]"]').select2('enable', true);

				$('.js-table-lista-servicos').closest('.box').show();
			}

			if (nivelAtividade != ultimoNivelAtividade) {
				$('input[name$="[aliquota]"]').closest('.form_row').addClass('hidden');
				$('input[name$="[aliquota]"]').select2('enable', false);
				$('input[name$="[aliquota]"]').removeAttr('required');

				$('select[name$="[profissao][]"]').closest('.box').hide();
				$('select[name$="[profissao][]"]').select2('enable', false);

				$('select[name$="[elemento][]"]').closest('.box').hide();
				$('select[name$="[elemento][]"]').select2('enable', false);

				$('select[name$="[vigenciaServico]"]').closest('.box').hide();
				$('select[name$="[vigenciaServico]"]').select2('enable', false);

				$('.js-table-lista-servicos').closest('.box').hide();
			}
		},
		populateTemplate: function (data) {
			var servico = $('input[id$="servico_autocomplete_input"]').select2('data');
			var servicoLabel = servico.label.split(' - ');

			if ($('.js-lista-servicos-cod-servico[value="' + servico.id + '"]').length) {
				return;
			}

			template = atividadeTemplate.replaceAll('{codServico}', servico.id)
				.replaceAll('{codEstrutural}', servicoLabel[0])
				.replaceAll('{nomServico}',  servicoLabel[1])
				.replaceAll('{index}', this.getIndex() + 1);

			return template;
		},
		getIndex: function () {
			return parseInt(this.listaServicosTable.find('tr:last').attr('data-index')) || 0;
		},
		validarServico: function () {
			var errors = '';

			if (!$('select[name$="[vigenciaServico]"]').val()) {
				errors += 'Selecione a vigência.<br>';
			}

			if (!$('input[name$="[servico]"]').val()) {
				errors += 'Selecione o serviço.<br>';
			}

			$('.js-incluir-servico-errors').html(errors);

			return !errors;
		},
		updateRowNumber: function () {
			this.listaServicosTable.find('tr').each(function (index, row) {
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
			var uri = location.pathname.split('/');
			if (!uri[uri.length - 1].startsWith('create') && !uri[uri.length - 1].startsWith('edit')) {
				return;
			}

			var $this = this;

			window.varJsCodNivel = $('select[name$="[fkEconomicoNivelAtividade]"]').val();
			window.varJsCodVigenciaServico = $('select[name$="[vigenciaServico]"]').val();

			$('.js-aliquota').mask('999,99');

			var mascaras = JSON.parse($('input[name$="[mascaras]"]').val());

			$('body').on('change', 'select[name$="[fkEconomicoNivelAtividade]"]', function (e) {
				var me = $(this);

				window.varJsCodNivel = me.val();

				$this.clearSelect($('input[id$="atividade_autocomplete_input"]').val(''));
				$('input[id$="atividade_autocomplete_input"]').select2('enable', false);

				if (!$('input[name$="[codAtividade]"]').val() && me.val()) {
					$('input[id$="atividade_autocomplete_input"]').select2('enable', true);

					$('input[name$="[codEstrutural]"]').val('');
					$('input[name$="[codEstrutural]"]').mask(mascaras[me.val()]);
				}

				$this.toggleCampos();
			});

			$('select[name$="[fkEconomicoNivelAtividade]"]').trigger('change');

			$('body').on('change', 'select[name$="[vigenciaServico]"]', function (e) {
				var me = $(this);

				window.varJsCodVigenciaServico = me.val();

				$('input[id$="servico_autocomplete_input"]').select2('enable', false);
				if (me.val()) {
					$('input[id$="servico_autocomplete_input"]').select2('enable', true);
				}
			});

			this.addServicoButton.on('click', function (e) {
				e.preventDefault();

				$('.js-incluir-servico-errors').addClass('hidden');
				if (!$this.validarServico()) {
					$('.js-incluir-servico-errors').removeClass('hidden');

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

	atividade.initialize();
}());
