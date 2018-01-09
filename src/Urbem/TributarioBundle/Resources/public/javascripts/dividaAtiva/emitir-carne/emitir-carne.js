$(document).ready(function () {

	var emitirCarne = {
		initialize: function () {
			window.varJsCodLocalizacao = $('.js-localizacao').val();

			$('body').on('change', '.js-localizacao', function (e) {
				window.varJsCodLocalizacao = $(this).val();
			});

			$('body').on('submit', 'form', function (e) {
				var me = $(this);

				var uri = location.pathname.split('/');
				if (!uri[uri.length - 1].startsWith('filtro')) {
					return;
				}

				var formSerialized = me.serializeArray()
				for (var key in formSerialized) {
					if (formSerialized[key]['name'].search('token') >= 0) {
						continue;
					}

					if (formSerialized[key]['value']) {
						return;
					}
				}

				e.preventDefault();
				alert('Selecionar ao menos um filtro para esta consulta.');
			});

			$('body').on('change', '.js-parcela-dt-vencimento', function () {
				var me = $(this);
				var tr = me.closest('tr');

				if (!me.val()) {
					tr.find('.js-parcela-reemitir').iCheck('disable');

					return;
				}

				tr.find('.js-parcela-reemitir').iCheck('enable');
			});
		}
	}

	emitirCarne.initialize();
}());
