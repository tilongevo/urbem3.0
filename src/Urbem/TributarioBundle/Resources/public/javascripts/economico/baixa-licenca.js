$(document).ready(function () {

	var baixaLicenca = {
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

	baixaLicenca.initialize();
}());
