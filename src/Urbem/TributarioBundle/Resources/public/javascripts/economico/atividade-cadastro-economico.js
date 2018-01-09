$(document).ready(function () {

	var atividadeTemplate = '<tr data-index="{index}">\
		<td class="control-group">\
			\
		</td>\
		<td class="control-group">\
			<span>{codEstrutural}</span>\
		</td>\
		<td class="control-group">\
			<span>{nomAtividade}</span>\
			<input type="hidden" name="atividades[{index}][codAtividade]" class="js-lista-atividades-cod-atividade" value="{codAtividade}" readonly>\
		</td>\
		<td class="control-group js-row-lista-atividades-dt-inicio">\
			<span>{dtInicio}</span>\
			<input type="hidden" name="atividades[{index}][dtInicio]" value="{dtInicio}" readonly>\
		</td>\
		<td class="control-group js-row-lista-atividades-dt-termino">\
			<span>{dtTermino}</span>\
			<input type="hidden" name="atividades[{index}][dtTermino]" value="{dtTermino}" readonly>\
		</td>\
		<td class="control-group js-row-lista-atividades-atividade-principal">\
			<span>{atividadePrincipal}</span>\
			<input type="hidden" name="atividades[{index}][atividadePrincipal]" class="js-lista-atividades-principal" value="{atividadePrincipalValue}" readonly>\
		</td>\
		<td class="control-group">\
			<button type="button" class="js-delete-row">Remover</button>\
		</td>\
	</tr>';

	var diaTemplate = '<tr data-index="{index}">\
		<td class="control-group">\
			\
		</td>\
		<td class="control-group">\
			<span>{DiaSemana}</span>\
			<input type="hidden" name="dias[{index}][diaSemana]" class="js-lista-dias-dia-semana" value="{DiaSemanaVal}" readonly>\
		</td>\
		<td class="control-group js-row-lista-dias-hr-inicio">\
			<span>{hrInicio}</span>\
			<input type="hidden" name="dias[{index}][hrInicio]" value="{hrInicio}" readonly>\
		</td>\
		<td class="control-group js-row-lista-dias-hr-termino">\
			<span>{hrTermino}</span>\
			<input type="hidden" name="dias[{index}][hrTermino]" value="{hrTermino}" readonly>\
		</td>\
		<td class="control-group">\
			<button type="button" class="js-delete-row">Remover</button>\
		</td>\
	</tr>';

	var atividadeCadastroEconomico = {
		listaAtividadesTable: $('.js-table-lista-atividades'),
		listaDiasTable: $('.js-table-lista-dias'),
		addAtividadeButton: $('button[name="incluir-atividade-btn"]'),
		addDiaButton: $('button[name="incluir-dia-btn"]'),
		addRow: function (table) {
			table.find('tbody').append(this.populateTemplate(table));

			this.updateRowNumber(table);
		},
		deleteRow: function (row, table) {
			row.remove();

			this.updateRowNumber(table);
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
		populateTemplate: function (table) {
			var index = this.getIndex(table) + 1;
			var template = '';
			if (table.hasClass('js-table-lista-atividades')) {
				template = atividadeTemplate;
				var atividade = $('input[id$="atividade_autocomplete_input"]').select2('data');
				var atividadeLabel = atividade.label.split(' - ');

				var row = $('.js-lista-atividades-cod-atividade[value="' + atividade.id + '"]').closest('tr');
				if (row.length) {
					row.find('.js-row-lista-atividades-dt-inicio span').text($('.js-date-dt-inicio').val());
					row.find('.js-row-lista-atividades-dt-inicio input').val($('.js-date-dt-inicio').val());
					row.find('.js-row-lista-atividades-dt-termino span').text($('.js-date-dt-termino').val());
					row.find('.js-row-lista-atividades-dt-termino input').val($('.js-date-dt-termino').val());
					row.find('.js-row-lista-atividades-atividade-principal span').text(parseInt($('input[name$="[atividadePrincipal]"]:checked').val()) ? 'Sim' : 'Não');
					row.find('.js-row-lista-atividades-atividade-principal input').val(parseInt($('input[name$="[atividadePrincipal]"]:checked').val()));

					return;
				}

				if (!row.length) {
					template = template.replaceAll('{codEstrutural}', atividadeLabel[0])
						.replaceAll('{nomAtividade}', atividadeLabel[1])
						.replaceAll('{codAtividade}', atividade.id)
						.replaceAll('{dtInicio}', $('.js-date-dt-inicio').val())
						.replaceAll('{dtTermino}', $('.js-date-dt-termino').val())
						.replaceAll('{atividadePrincipal}', parseInt($('input[name$="[atividadePrincipal]"]:checked').val()) ? 'Sim' : 'Não')
						.replaceAll('{atividadePrincipalValue}', parseInt($('input[name$="[atividadePrincipal]"]:checked').val()))
						.replaceAll('{index}', index);
				}
			}

			if (table.hasClass('js-table-lista-dias')) {
				baseTemplate = diaTemplate;
				template = '';
				$('input[name$="[diaSemana][]"]:checked').each(function (diaSemanaIndex, dia) {
					dia = $(dia);

					var row = $('.js-lista-dias-dia-semana[value="' + dia.val() + '"]').closest('tr');
					if (row.length) {
						row.find('.js-row-lista-dias-hr-inicio span').text($('.js-date-hr-inicio').val());
						row.find('.js-row-lista-dias-hr-inicio input').val($('.js-date-hr-inicio').val());
						row.find('.js-row-lista-dias-hr-termino span').text($('.js-date-hr-termino').val());
						row.find('.js-row-lista-dias-hr-termino input').val($('.js-date-hr-termino').val());

						return true;
					}

					template += baseTemplate.replaceAll('{DiaSemana}', dia.parent().siblings('span').first().text())
						.replaceAll('{DiaSemanaVal}', dia.val())
						.replaceAll('{hrInicio}', $('.js-date-hr-inicio').val())
						.replaceAll('{hrTermino}', $('.js-date-hr-termino').val())
						.replaceAll('{index}', index);

					index++;
				});
			}

			return template;
		},
		getIndex: function (table) {
			return parseInt(table.find('tr:last').attr('data-index')) || 0;
		},
		validarAtividades: function () {
			var errors = '';

			if (!$('input[id$="atividade_autocomplete_input"]').val()) {
				errors += 'Selecione uma atividade.<br>';
			}

			if (!$('input[name$="[atividadePrincipal]"]:checked').length) {
				errors += 'Informe se a atividade é principal.<br>';
			}

			if (!$('.js-date-dt-inicio').val()) {
				errors += 'Informe a data de início da atividade.<br>';
			}

			if (parseInt($('input[name$="[atividadePrincipal]"]:checked').val()) && $('.js-lista-atividades-principal[value="1"]').length) {
				errors += 'Só pode ser cadastrada uma atividade principal.<br>';
			}

			$('.js-incluir-atividade-errors').html(errors);

			return !errors;
		},
		validarDias: function () {
			var errors = '';

			if (!$('input[name$="[diaSemana][]"]:checked').length) {
				errors += 'Selecione o(s) dia(s).<br>';
			}

			if (!$('.js-date-hr-inicio').val()) {
				errors += 'Informe a hora de início.<br>';
			}

			$('.js-incluir-dia-errors').html(errors);

			return !errors;
		},
		updateRowNumber: function (table) {
			table.find('tr').each(function (index, row) {
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
			$('input[name$="[atividadePrincipal]"]').removeAttr('required');

			this.addAtividadeButton.on('click', function (e) {
				e.preventDefault();

				$('.js-incluir-atividade-errors').addClass('hidden');
				if (!$this.validarAtividades()) {
					$('.js-incluir-atividade-errors').removeClass('hidden');

					return;
				}

				$this.addRow($this.listaAtividadesTable);
			});

			this.addDiaButton.on('click', function (e) {
				e.preventDefault();

				$('.js-incluir-dia-errors').addClass('hidden');
				if (!$this.validarDias()) {
					$('.js-incluir-dia-errors').removeClass('hidden');

					return;
				}

				$this.addRow($this.listaDiasTable);
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

	atividadeCadastroEconomico.initialize();
}());
