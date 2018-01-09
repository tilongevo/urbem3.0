$(document).ready(function () {

	var emitirDocumento = {
		initialize: function () {
			window.varJsCodTipoDocumento = UrbemSonata.giveMeBackMyField('tipoDocumento').val();

			UrbemSonata.giveMeBackMyField('tipoDocumento').on('change', function () {
				window.varJsCodTipoDocumento = $(this).val();
			});

			$('body').on('change', 'input, select', function (e) {
				var me = $(this);

				var uri = location.pathname.split('/');
				if (!uri[uri.length - 1].startsWith('filtro')) {
					return;
				}

				var formSerialized = me.closest('form').serializeArray();
				for (var key in formSerialized) {
					if (formSerialized[key]['name'].search('token') >= 0
						|| formSerialized[key]['name'].search('tipo') >= 0
						|| formSerialized[key]['name'].search('tipoDocumento') >= 0
						|| formSerialized[key]['name'].search('documento') >= 0
						|| formSerialized[key]['name'].search('inscricaoAnoInicial') >= 0
						|| formSerialized[key]['name'].search('inscricaoAnoFinal') >= 0) {
						continue;
					}

					if (formSerialized[key]['value']) {
						me.closest('form').find('button[type="submit"]').prop('disabled', false);

						return;
					}
				}

				me.closest('form').find('button[type="submit"]').prop('disabled', true);
			});

			$('body').on('ifChanged', '.js-documento-selecionar-todos', function () {
				var me = $(this);

				if (me.is(':checked')) {
					$('.js-documento-emitir').iCheck('check');

					return;
				}

				if (!me.is(':checked')) {
					$('.js-documento-emitir').iCheck('uncheck');

					return;
				}
			});

			$('body').on('change', '.js-filtro-select-tipo', function () {
				var me = $(this);

				if (me.val() == 'emissao') {
					$('.js-filtro-num-documento').closest('.form_row').addClass('hidden');
					$('.js-filtro-num-documento').select2('enable', false);

					return;
				}

				$('.js-filtro-num-documento').closest('.form_row').removeClass('hidden');
				$('.js-filtro-num-documento').select2('enable', true);
			});

			$('.js-filtro-select-tipo').trigger('change');
		}
	}

	emitirDocumento.initialize();
}());
