$(document).ready(function () {

	var tipoConvenio = $('.js-tipo-convenio');
	var convenio = $('.js-convenio-edit');
	if (!tipoConvenio.val() && !convenio.prop('disabled')) {
		convenio.find('option').each( function (index, option) {
			option.remove();
		});
		convenio.append($('<option style="display:none" selected></option>'));
		convenio.trigger('change');
	}

	$('body').on('change', '.js-tipo-convenio', function () {
		var tipoConvenio = $(this).val();
		var convenio = $('.js-convenio');

		$.ajax({
			method: 'GET',
			url: '/tributario/cadastro-monetario/convenio/index?tipo_convenio=' + tipoConvenio,
			dataType: 'json',
			beforeSend: function () {
				convenio.find('option').each(function (index, option) {
					option.remove();
				});

				convenio.append($('<option style="display:none" selected></option>').text('Carregando...'));
				convenio.trigger('change');
			},
			success: function (data) {
				convenio.find('option').each(function (index, option) {
					option.remove();
				});

				convenio.append($('<option style="display:none" selected></option>'));
				$.each(data, function (index, item) {
					convenio.append($('<option style="display:none"></option>').attr('value', item.cod_convenio).text(item.num_convenio));
				});

				convenio.trigger('change');
			}
		});
	})
}());
