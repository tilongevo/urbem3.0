$(document).ready(function () {

	var catalogoItemAnalitico = {
		initialize: function () {
			var $this = this;

			var periodo = UrbemSonata.giveMeBackMyField('periodo');
			var periodoInicial = UrbemSonata.giveMeBackMyField('periodoInicial');
			var periodoFinal = UrbemSonata.giveMeBackMyField('periodoFinal');

			periodo.on('change', function () {
				var me = $(this);

				if (me.val() != 'definir') {
					periodoInicial.closest('.form_row').hide();
					periodoFinal.closest('.form_row').hide();

					return;
				}

				periodoInicial.closest('.form_row').show();
				periodoFinal.closest('.form_row').show();
			});

			periodo.trigger('change');
		}
	}

	catalogoItemAnalitico.initialize();
}());
