$(document).ready(function () {

	var consultaLote = {
		getAgencias: function (banco) {
			var $this = this;
			var agenciaSelect = $('.js-select-agencia');

			this.clearSelect(agenciaSelect);
			agenciaSelect.trigger('change');

			if (!banco.val()) {
				return;
			}

			$.ajax({
				method: 'GET',
				url: '/tributario/cadastro-monetario/agencia/index?codBanco=' + banco.val(),
				dataType: 'json',
				beforeSend: function () {
					agenciaSelect.append($('<option style="display:none" selected></option>').text('Carregando...'));
					agenciaSelect.trigger('change', true);
				},
				success: function (data) {
					$this.clearSelect(agenciaSelect);
					agenciaSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));
					$.each(data, function (index, item) {
						agenciaSelect.append($('<option style="display:none"></option>').attr('value', item.cod_agencia).text(item.num_agencia));
					});

					agenciaSelect.trigger('change', true);
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

			$('body').on('change', '.js-select-banco', function () {
				var me = $(this);

				$this.getAgencias(me);
			});
		}
	}

	consultaLote.initialize();
}());
