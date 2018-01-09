$(document).ready(function () {

	var atividadeTemplate = '<tr data-index="{index}">\
		<td class="control-group">\
			\
		</td>\
		<td class="control-group">\
			<span>{codEstrutural}</span>\
			<input type="hidden" name="atividades[{index}][inscricaoEconomica]" class="js-lista-atividades-cod-atividade" value="{inscricaoEconomica}" readonly>\
			<input type="hidden" name="atividades[{index}][codAtividade]" class="js-lista-atividades-cod-atividade" value="{codAtividade}" readonly>\
		</td>\
		<td class="control-group">\
			<span>{nomAtividade}</span>\
		</td>\
		<td class="control-group">\
			<span>{nomModalidade}</span>\
			<input type="hidden" name="atividades[{index}][codModalidade]" value="{codModalidade}" readonly>\
			<input type="hidden" name="atividades[{index}][dtInicio]" value="{dtInicio}" readonly>\
		</td>\
		<td class="control-group">\
			<span>{valor}</span>\
			<input type="hidden" name="atividades[{index}][tipoValor]" value="{tipoValor}" readonly>\
			<input type="hidden" name="atividades[{index}][valor]" value="{valor}" readonly>\
		</td>\
		<td class="control-group">\
			<span>{nomIndexador}</span>\
			<input type="hidden" name="atividades[{index}][codIndexador]" value="{codIndexador}" readonly>\
		</td>\
		<td class="control-group">\
			<button type="button" class="js-delete-row">Remover</button>\
		</td>\
	</tr>';

	var CadastroEconomicoModalidadeLancamento = {
		listaAtividadesTable: $('.js-table-lista-atividades'),
		addAtividadeButton: $('button[name="incluir-atividade-btn"]'),
		addRow: function () {
			this.listaAtividadesTable.find('tbody').append(this.populateTemplate());

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
		toggleCamposValor: function () {
			var tipoValor = $('[name$="[tipoValor]"]:checked');

			if (tipoValor.val() && tipoValor.val() == this.lastTipoValorValue) {
				return;
			}

			this.lastTipoValorValue = tipoValor.val();

			if (!tipoValor.val() || tipoValor.val() == 'percentual') {
				$('.js-moeda').closest('.form_row').addClass('hidden');
				$('.js-indicador-economico').closest('.form_row').addClass('hidden');
				if (this.addAtividadeButton.length) {
					return;
				}

				$('.js-moeda').select2('enable', false);
				$('.js-moeda').removeAttr('required');
				$('.js-indicador-economico').select2('enable', false);
				$('.js-indicador-economico').removeAttr('required');
			}

			if (tipoValor.val() == 'moeda') {
				$('.js-moeda').closest('.form_row').removeClass('hidden');
				$('.js-indicador-economico').closest('.form_row').addClass('hidden');
				if (this.addAtividadeButton.length) {
					return;
				}

				$('.js-moeda').select2('enable', true);
				$('.js-moeda').attr('required', true);
				$('.js-indicador-economico').select2('enable', false);
				$('.js-indicador-economico').removeAttr('required');
			}

			if (tipoValor.val() == 'indicador_economico') {
				$('.js-moeda').closest('.form_row').addClass('hidden');
				$('.js-indicador-economico').closest('.form_row').removeClass('hidden');
				if (this.addAtividadeButton.length) {
					return;
				}

				$('.js-moeda').select2('enable', false);
				$('.js-moeda').removeAttr('required');
				$('.js-indicador-economico').select2('enable', true);
				$('.js-indicador-economico').attr('required', true);
			}
		},
		populateTemplate: function (data) {
			var template = atividadeTemplate;
			var cadastroEconomico = $('input[id$="cadastroEconomico_autocomplete_input"]');
			var atividade = $('input[id$="fkEconomicoAtividadeCadastroEconomico_autocomplete_input"]').select2('data');
			var atividadeLabel = atividade.label.split(' - ');
			var modalidade = $('select.js-modalidade-lancamento').select2('data');
			var tipoValor = $('[name$="[tipoValor]"]:checked').val();

			if (this.listaAtividadesTable.find('input.js-lista-atividades-cod-atividade[value="' + atividade.id + '"]').length) {
				this.listaAtividadesTable.find('input.js-lista-atividades-cod-atividade[value="' + atividade.id + '"]').closest('tr').remove();
			}

			template = template.replaceAll('{inscricaoEconomica}', cadastroEconomico.val())
				.replaceAll('{codAtividade}', atividade.id)
				.replaceAll('{codEstrutural}', atividadeLabel[0])
				.replaceAll('{nomAtividade}',  atividadeLabel[1])
				.replaceAll('{nomModalidade}',  modalidade.text)
				.replaceAll('{codModalidade}',  modalidade.id)
				.replaceAll('{dtInicio}',  $('input[id$="_dtInicio').val())
				.replaceAll('{valor}', $('.js-valor').val())
				.replaceAll('{tipoValor}', tipoValor)
				.replaceAll('{index}', this.getIndex() + 1);

			if (tipoValor == 'percentual') {
				template = template.replaceAll('{nomIndexador}', '-')
					.replaceAll('{codIndexador}', 0);
			}

			if (tipoValor == 'moeda') {
				var moeda = $('select.js-moeda').select2('data');
				template = template.replaceAll('{nomIndexador}', moeda.text)
					.replaceAll('{codIndexador}', moeda.id);
					console.log(template);
			}

			if (tipoValor == 'indicador_economico') {
				var indicadorEconomico = $('select.js-indicador-economico').select2('data');
				template = template.replaceAll('{nomIndexador}', indicadorEconomico.text)
					.replaceAll('{codIndexador}', indicadorEconomico.id);
			}

			return template;
		},
		getIndex: function () {
			return parseInt(this.listaAtividadesTable.find('tr:last').attr('data-index')) || 0;
		},
		validarAtividade: function () {
			var errors = '';

			if (!$('input[id$="cadastroEconomico_autocomplete_input"]').val()) {
				errors += 'Selecione a Inscrição Econômica.<br>';
			}

			if (!$('input[id$="fkEconomicoAtividadeCadastroEconomico_autocomplete_input').val()) {
				errors += 'Selecione a Atividade.<br>';
			}

			if (!$('input[id$="_dtInicio').val()) {
				errors += 'Selecione a Data de Início.<br>';
			}

			if (!$('select.js-modalidade-lancamento').val()) {
				errors += 'Selecione a Modalidade.<br>';
			}

			var tipoValor = $('[name$="[tipoValor]"]:checked').val();
			if (!tipoValor) {
				errors += 'Informe o Tipo de Valor.<br>';
			}

			if (!$('.js-valor').val()) {
				errors += 'Informe o Valor.<br>';
			}

			if (tipoValor == 'moeda' && !$('select.js-moeda').val()) {
				errors += 'Informe a Moeda.<br>';
			}

			if (tipoValor == 'indicador_economico' && !$('select.js-indicador-economico').val()) {
				errors += 'Informe o Indicador Econômico.<br>';
			}

			$('.js-incluir-atividade-errors').html(errors);

			return !errors;
		},
		updateRowNumber: function () {
			this.listaAtividadesTable.find('tr').each(function (index, row) {
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

			window.varJsInscricaoEconomica = $('input[id$="cadastroEconomico_autocomplete_input"]').val();
			window.varJsCodClassificacao = $('.js-select-processo-classificao').val();
			window.varJsCodAssunto = $('.js-select-processo-assunto').val();

			$('body').on('ifChanged', '.js-tipo-valor', function (e) {
				$this.toggleCamposValor();
			});

			$('.js-tipo-valor').trigger('ifChanged');

			$('form select').each(function (i) {
				this.addEventListener('invalid', function (e) {
			        $('#'+e.target.id).attr('style','display:block;z-index:-1;');

			        setTimeout(function() {
			            $('#'+_s2Id+' ul').removeClass('_invalid');
			        }, 3000);

			        return true;
				}, false);
			});

			if (!this.addAtividadeButton.length) {
				return;
			}

			this.addAtividadeButton.on('click', function (e) {
				e.preventDefault();

				$('.js-incluir-atividade-errors').addClass('hidden');
				if (!$this.validarAtividade()) {
					$('.js-incluir-atividade-errors').removeClass('hidden');

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

			$('body').on('change', 'input[id$="cadastroEconomico_autocomplete_input"]', function () {
				window.varJsInscricaoEconomica = $(this).val();
				$('input[id$="fkEconomicoAtividadeCadastroEconomico_autocomplete_input').select2('val', '');
				$this.listaAtividadesTable.find('tbody').html('');
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

	CadastroEconomicoModalidadeLancamento.initialize();
}());
