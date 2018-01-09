$(document).ready(function () {

	var compraEstoque = {
		initialize: function () {
			var $this = this;

			$('select[name="filter[periodo][value]"]').on('change', function () {
				var me = $(this);

				if (me.val() != 'definir') {
					$('input[name="filter[periodoInicial][value]"]').closest('.field-filtro').hide();
					$('input[name="filter[periodoFinal][value]"]').closest('.field-filtro').hide();

					return;
				}

				$('input[name="filter[periodoInicial][value]"]').closest('.field-filtro').show();
				$('input[name="filter[periodoFinal][value]"]').closest('.field-filtro').show();
			});

			$('select[name="filter[periodo][value]"]').trigger('change');

			var splitUrl = location.pathname.split('/');
			splitUrl[splitUrl.length-1] = 'export'

			if (location.search) {
				var url = splitUrl.join('/') + location.search; 
				$('table').first().before('<a href="' + url + '" class="btn" target="_blank">Exportar</a><hr>');
			}
		}
	}

	compraEstoque.initialize();
}());
