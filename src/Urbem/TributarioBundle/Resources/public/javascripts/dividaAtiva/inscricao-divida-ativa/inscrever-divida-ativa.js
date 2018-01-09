$(document).ready(function () {

	var inscreverDividaAtiva = {
		initialize: function () {
			var $this = this;

			var uri = location.pathname.split('/');
			if (uri[uri.length - 1].startsWith('create')) {
				window.varJsCodGrupoCredito = UrbemSonata.giveMeBackMyField('grupoCredito').val();

				UrbemSonata.giveMeBackMyField('exercicio').datetimepicker({'format':'YYYY', 'maxDate':(new Date()).getUTCFullYear() + 1, 'minViewMode':'years', 'viewMode':'years', 'language':'pt_BR', 'disabledDates':[], 'enabledDates':[], 'useStrict':false, 'sideBySide':false, 'collapse':true, 'calendarWeeks':false, 'pickTime':false, 'icons':{'time':'fa fa-clock-o', 'date':'fa fa-calendar', 'up':'fa fa-chevron-up', 'down':'fa fa-chevron-down'}});
				
				UrbemSonata.giveMeBackMyField('grupoCredito').on('change', function () {
					UrbemSonata.giveMeBackMyField('credito').select2('val', '');

					window.varJsCodGrupoCredito = $(this).val();
				});

				$('form').find('button[type="submit"]').prop('disabled', true);
				$('body').on('change', 'input, select', function (e) {
					var me = $(this);

					var formSerialized = me.closest('form').serializeArray();
					for (var key in formSerialized) {
						if (formSerialized[key]['name'].search('token') >= 0
							|| formSerialized[key]['name'].search('grupoCredito') >= 0
							|| formSerialized[key]['name'].search('credito') >= 0
							|| formSerialized[key]['name'].search('periodo') >= 0
							|| formSerialized[key]['name'].search('valor') >= 0
							|| formSerialized[key]['name'].search('modalidade') >= 0
							|| formSerialized[key]['name'].search('dtInscricao') >= 0) {
							continue;
						}

						if (!UrbemSonata.giveMeBackMyField('grupoCredito').val()
							&& !UrbemSonata.giveMeBackMyField('credito').val()) {
							break;
						}

						if (formSerialized[key]['value']) {
							me.closest('form').find('button[type="submit"]').prop('disabled', false);

							return;
						}
					}

					me.closest('form').find('button[type="submit"]').prop('disabled', true);
				});
			}

			if (uri[uri.length - 1].startsWith('detalhe')) {
				$('body').on('ifChanged', '.js-divida-selecionar-todos', function () {
					var me = $(this);

					if (me.is(':checked')) {
						$('.js-divida-inscrever').iCheck('check');

						return;
					}

					if (!me.is(':checked')) {
						$('.js-divida-inscrever').iCheck('uncheck');

						return;
					}
				});

				$('form input[name="uniqid"]').val($('meta[name="uniqid"]').attr('content'));
				$('form').find('input, select, button').each(function () {
					var me = $(this);

					if (me.attr('id') && me.attr('id').startsWith('form')) {
						me.attr('id', me.attr('id').replace('form', $('meta[name="uniqid"]').attr('content')));
					}

					if (me.attr('name') && me.attr('name').startsWith('form')) {
						me.attr('name', me.attr('name').replace('form', $('meta[name="uniqid"]').attr('content')));
					}
				});
			}
		}
	}

	inscreverDividaAtiva.initialize();
}());
