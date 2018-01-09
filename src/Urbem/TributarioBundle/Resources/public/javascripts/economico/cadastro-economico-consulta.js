$(document).ready(function () {

	var atividadeTemplate = '<tr class="sonata-ba-view-container">\
		<td>\
			<span>{index}</span>\
		</td>\
		<td>\
			<span>{codAtividade}</span>\
		</td>\
		<td>\
			<span>{atividade}</span>\
		</td>\
	</tr>';

	var diaSemanaTemplate = '<tr class="sonata-ba-view-container">\
		<td>\
			<span>{index}</span>\
		</td>\
		<td>\
			<span>{nomDia}</span>\
		</td>\
		<td>\
			<span>{hrInicio}</span>\
		</td>\
		<td>\
			<span>{hrTermino}</span>\
		</td>\
	</tr>';

	var cadastroEconomicoConsulta = {
		licencaTable: $('.js-lista-licenca-table'),
		licencaAtividadeContainer: $('.js-lista-licenca-atividade-container'),
		licencaAtividadeTable: $('.js-lista-licenca-atividade-table'),
		licencaDiasSemanaContainer: $('.js-lista-licenca-dias-semana-container'),
		licencaDiasSemanaTable: $('.js-lista-licenca-dias-semana-table'),
		getLicenca: function (codLicenca, exercicio, tr) {
			var $this = this;

			$.ajax({
				method: 'GET',
				url: '/tributario/cadastro-economico/consulta/api/licenca',
				data: {codLicenca: codLicenca, exercicio: exercicio},
				dataType: 'json',
				beforeSend: function () {
					$this.licencaTable.find('tbody tr:not(:eq(' + tr.index() + '))').css('display', 'none');
					tr.find('.js-consulta-licenca').css('display', 'none');
					tr.find('.js-consulta-licenca-voltar').css('display', 'inline');

					$this.licencaAtividadeTable.find('tbody').html('<td cols-span="3">Aguarde...</td>');
					$this.licencaDiasSemanaTable.find('tbody').html('<td cols-span="4">Aguarde...</td>');

					if ($this.licencaAtividadeContainer.css('display') == 'none') {
						$this.licencaAtividadeContainer.slideToggle();
					}

					if ($this.licencaDiasSemanaContainer.css('display') == 'none') {
						$this.licencaDiasSemanaContainer.slideToggle();
					}
				},
				success: function (data) {
					licencaAtividades = [];
					$(data.licencaAtividades).each(function (index, licencaAtividade) {
						licencaAtividades.push($this.populateTemplate('licencaAtividade', licencaAtividade, index));
					});

					licencaDiasSemana = [];
					$(data.licencaDiasSemana).each(function (index, licencaDiaSemana) {
						licencaDiasSemana.push($this.populateTemplate('licencaDiaSemana', licencaDiaSemana, index));
					});

					$this.licencaAtividadeTable.find('tbody').html(licencaAtividades.join('\n'));
					$this.licencaDiasSemanaTable.find('tbody').html(licencaDiasSemana.join('\n'));
				}
			});
		},
		populateTemplate: function (type, data, index) {
			if (type == 'licencaAtividade') {
				return atividadeTemplate.replaceAll('{index}', ++index)
					.replaceAll('{codAtividade}', data.codAtividade)
					.replaceAll('{atividade}', data.atividade);
			}

			return diaSemanaTemplate.replaceAll('{index}', ++index)
					.replaceAll('{nomDia}', data.nomDia)
					.replaceAll('{hrInicio}', data.hrInicio)
					.replaceAll('{hrTermino}', data.hrTermino);
		},
		initialize: function () {
			var $this = this;

			window.varJsLocalizacao = $('.js-localizacao').val();

			$('.js-cnpj').mask('999.999.999/9999-99');
			$('.js-cpf').mask('999.999.999-99');


			$('body').on('change', '.js-localizacao', function (e) {
				window.varJsLocalizacao = $(this).val();

				$('#filter_lote_value_autocomplete_input').select2('val', '');
			});

			$('body').on('click', '.js-consulta-licenca', function (e) {
				e.preventDefault();

				var me = $(this);

				$this.getLicenca(me.attr('data-cod-licenca'), me.attr('data-exercicio'), me.closest('tr'));
			});

			$('body').on('click', '.js-consulta-licenca-voltar', function (e) {
				e.preventDefault();

				var me = $(this);

				me.css('display', 'none');
				me.siblings('.js-consulta-licenca').css('display', 'inline');
				$this.licencaTable.find('tbody tr').css('display', 'table-row');
				$this.licencaAtividadeContainer.slideToggle();
				$this.licencaDiasSemanaContainer.slideToggle();
				$this.licencaAtividadeTable.find('tbody').html('');
				$this.licencaDiasSemanaTable.find('tbody').html('');
			});
		}
	}

	cadastroEconomicoConsulta.initialize();
}());
