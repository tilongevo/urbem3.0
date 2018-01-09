$(document).ready(function () {

	var autonomo = {
		lastTipoDomicilioValue: null,
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
		toggleCamposDomicilio: function () {
			var tipoDomicilio = $('[name$="[tipoDomicilio]"]:checked');
			var imovelCadastrado = $('input[id$="fkImobiliarioLote_autocomplete_input"], .js-imovel-cadastrado');
			var enderecoInformado = $('input[id$="fkSwLogradouro_autocomplete_input"]');

			if (tipoDomicilio.val() && tipoDomicilio.val() == this.lastTipoDomicilioValue) {
				return;
			}

			this.lastTipoDomicilioValue = tipoDomicilio.val();

			if (!tipoDomicilio.val()) {
				imovelCadastrado.closest('.form_row').addClass('hidden');
				imovelCadastrado.select2('enable', false);

				enderecoInformado.closest('.form_row').addClass('hidden');
				enderecoInformado.select2('enable', false);
				$('.js-endereco-informado').closest('.form_row').addClass('hidden');
				$('.js-endereco-informado').attr('disabled', 'disabled');
			}

			if (tipoDomicilio.val() == 'cadastrado') {
				imovelCadastrado.closest('.form_row').removeClass('hidden');
				imovelCadastrado.select2('enable', true);

				enderecoInformado.closest('.form_row').addClass('hidden');
				enderecoInformado.select2('enable', false);
				$('.js-endereco-informado').closest('.form_row').addClass('hidden');
				$('.js-endereco-informado').attr('disabled', 'disabled');
			}

			if (tipoDomicilio.val() == 'informado') {
				enderecoInformado.closest('.form_row').removeClass('hidden');
				enderecoInformado.select2('enable', true);
				$('.js-endereco-informado').closest('.form_row').removeClass('hidden');
				$('.js-endereco-informado:not([class*="js-endereco-informado-disabled"])').removeAttr('disabled');

				imovelCadastrado.closest('.form_row').addClass('hidden');
				imovelCadastrado.select2('enable', false);
			}
		},
		getLogradouro: function (logradouro) {
			var $this = this;
			var bairroSelect = $('.js-select-endereco-informado-bairro');
			var cepSelect = $('.js-select-endereco-informado-cep');

			$('input[type="text"].js-endereco-informado').val('');
			this.clearSelect(bairroSelect);
			bairroSelect.trigger('change');
			this.clearSelect(cepSelect);
			cepSelect.trigger('change');
			if (!logradouro.val()) {
				return;
			}

			$.ajax({
				method: 'GET',
				url: '/administrativo/logradouro/consultar-logradouro/' + logradouro.val(),
				dataType: 'json',
				beforeSend: function () {
					bairroSelect.append($('<option style="display:none" selected></option>').text('Carregando...'));
					bairroSelect.trigger('change');
					cepSelect.append($('<option style="display:none" selected></option>').text('Carregando...'));
					cepSelect.trigger('change');
				},
				success: function (data) {
					$this.clearSelect(bairroSelect);
					bairroSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));

					$this.clearSelect(cepSelect);
					cepSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));

					if (data.bairros) {
						$.each(data.bairros, function (index, item) {
							bairroSelect.append($('<option style="display:none"></option>').attr('value', item.cod_bairro).text(item.nom_bairro));
						});
					}

					if (data.ceps) {
						$.each(data.ceps, function (index, item) {
							cepSelect.append($('<option style="display:none"></option>').attr('value', item.cep).text(item.cep));
						});
					}

					bairroSelect.trigger('change');
					cepSelect.trigger('change');

					$('.js-select-endereco-informado-municipio').val(data.municipio);
					$('.js-select-endereco-informado-uf').val(data.uf);
				}
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

			window.varJsCodClassificacao = $('.js-select-processo-classificao').val();
			window.varJsCodAssunto = $('.js-select-processo-assunto').val();
			window.varJsCodLocalizacao = $('.js-imovel-localizacao').val();

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

			$('body').on('ifChanged', '.js-tipo-domicilio', function (e) {
				$this.toggleCamposDomicilio();
			});

			$('body').on('change', '.js-imovel-localizacao', function (e) {
				window.varJsCodLocalizacao = $(this).val();
			});

			$('body').on('change', 'input[id$="fkSwLogradouro_autocomplete_input"]', function (e) {
				$this.getLogradouro($(this));
			});

			$('.js-tipo-domicilio').trigger('ifChanged');

			if (!$('.js-endereco-informado:first-of-type').val()) {
				$('.js-endereco-informado').empty();
			}

			var uri = location.pathname.split('/');
			if (!uri[uri.length - 1].startsWith('create') && !uri[uri.length - 1].startsWith('edit')) {
				return;
			}

			atributoDinamicoParams = {
				entidade: 'CoreBundle:Economico\\CadastroEconomicoAutonomo',
				fkEntidadeAtributoValor: 'getFkEconomicoAtributoCadEconAutonomoValores',
				codModulo: 14,
				codCadastro: 3
			};

			if (uri[uri.length - 1].startsWith('edit')) {
				atributoDinamicoParams.codEntidade = {
					inscricaoEconomica: uri[uri.length - 2]
				};
			}

			window.AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(atributoDinamicoParams);
		}
	}

	autonomo.initialize();
}());
