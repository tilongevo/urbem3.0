$(document).ready(function () {

	var template = '<tr data-index="{index}">\
		<td class="control-group">\
			<button class="js-delete-conta-corrente">Remover</button>\
		</td>\
		<td class="control-group">\
			<select name="contaCorrentes[{index}][codBanco]" class="select2-parameters js-select-banco" style="width:100%" required>\
				<option>Carregando...</option>\
			</select>\
		</td>\
		<td class="control-group">\
			<select name="contaCorrentes[{index}][codAgencia]" class="select2-parameters js-select-agencia" style="width:100%" required>\
				<option></option>\
			</select>\
		</td>\
		<td class="control-group">\
			<select name="contaCorrentes[{index}][codContaCorrente]" class="select2-parameters js-select-conta-corrente" style="width:100%" required>\
				<option></option>\
			</select>\
		</td>\
		<td class="control-group">\
			<input name="contaCorrentes[{index}][variacao]" type="number" class="campo-sonata form-control" min="0" max="2147483647">\
		</td>\
	</tr>';

	var contaCorrenteConvenio = {
		contaCorrenteTable: $('.js-table-conta-corrente'),
		addContaCorrenteButton: $('.js-add-conta-corrente'),
		bancos: [],
		agencias: [],
		contaCorrentes: [],
		addRow: function () {
			if (this.contaCorrenteTable.hasClass('hidden')) {
				this.contaCorrenteTable.removeClass('hidden');
			}

			this.contaCorrenteTable.find('tbody').append(this.populateTemplate());

			var row = this.contaCorrenteTable.find('tbody').find('tr:last');
			this.initializePlugins(row);
			this.getBancos(row);
		},
		deleteRow: function (row) {
			row.remove();
			if (!this.contaCorrenteTable.find('tbody').find('tr:last').length) {
				this.contaCorrenteTable.addClass('hidden');
			}
		},
		getBancos: function (row) {
			var $this = this;
			var bancoSelect = row.find('.js-select-banco');
			if (this.bancos.length > 0) {
				this.clearSelect(bancoSelect);
				bancoSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));
				$.each(this.bancos, function (index, item) {
					bancoSelect.append($('<option style="display:none"></option>').attr('value', item.cod_banco).text(item.num_banco + '-' + item.nom_banco));
				});

				bancoSelect.trigger('change');

				return;
			}

			$.ajax({
				method: 'GET',
				url: '/tributario/cadastro-monetario/banco/index',
				dataType: 'json',
				success: function (data) {
					$this.clearSelect(bancoSelect);
					bancoSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));
					$.each(data, function (index, item) {
						bancoSelect.append($('<option style="display:none"></option>').attr('value', item.cod_banco).text(item.num_banco + '-' + item.nom_banco));
					});

					bancoSelect.trigger('change', true);
					$this.bancos = data;
				}
			});
		},
		getAgencias: function (banco, row) {
			var $this = this;
			var agenciaSelect = row.find('.js-select-agencia');
			var contaCorrenteSelect = row.find('.js-select-conta-corrente');

			this.clearSelect(agenciaSelect);
			agenciaSelect.trigger('change');
			this.clearSelect(contaCorrenteSelect);
			contaCorrenteSelect.trigger('change');

			if (!banco.val()) {
				return;
			}

			if (this.agencias[banco.val()]) {
				agenciaSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));
				$.each(this.agencias[banco.val()], function (index, item) {
					agenciaSelect.append($('<option style="display:none"></option>').attr('value', item.cod_agencia).text(item.num_agencia));
				});

				agenciaSelect.trigger('change');

				return;
			}

			$.ajax({
				method: 'GET',
				url: '/tributario/cadastro-monetario/agencia/index?codBanco=' + banco.val(),
				dataType: 'json',
				beforeSend: function () {
					$this.clearSelect(agenciaSelect);
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
					$this.agencias[banco.val()] = data;
				}
			});
		},
		getContaCorrentes: function (banco, agencia, row) {
			var $this = this;
			var contaCorrenteSelect = row.find('.js-select-conta-corrente');

			this.clearSelect(contaCorrenteSelect);
			contaCorrenteSelect.trigger('change');
			if (!banco.val() || !agencia.val()) {
				return;
			}

			if (this.contaCorrentes[banco.val()] && this.contaCorrentes[banco.val()][agencia.val()]) {
				contaCorrenteSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));
				$.each(this.contaCorrentes[agencia.val()], function (index, item) {
					contaCorrenteSelect.append($('<option style="display:none"></option>').attr('value', item.cod_conta_corrente).text(item.num_conta_corrente));
				});

				contaCorrenteSelect.trigger('change');

				return;
			}

			$.ajax({
				method: 'GET',
				url: '/tributario/cadastro-monetario/conta-corrente/index?codBanco=' + banco.val() + '&codAgencia=' + agencia.val(),
				dataType: 'json',
				beforeSend: function () {
					$this.clearSelect(contaCorrenteSelect);
					contaCorrenteSelect.append($('<option style="display:none" selected></option>').text('Carregando...'));
					contaCorrenteSelect.trigger('change');
				},
				success: function (data) {
					$this.clearSelect(contaCorrenteSelect);
					contaCorrenteSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));
					$.each(data, function (index, item) {
						contaCorrenteSelect.append($('<option style="display:none"></option>').attr('value', item.cod_conta_corrente).text(item.num_conta_corrente));
					});

					contaCorrenteSelect.trigger('change');
					$this.contaCorrentes[banco.val()][agencia.val()] = data;
				}
			});
		},
		populateTemplate: function () {
			return template.replaceAll('{index}', this.getIndex() + 1);
		},
		getIndex: function () {
			return parseInt(this.contaCorrenteTable.find('tr:last').attr('data-index')) || 0;
		},
		clearSelect: function (select) {
			select.val('');
			select.select2('val', '');
			select.find('option').each(function (index, option) {
				option.remove();
			});
		},
		initializePlugins: function (row) {
			row.find('.js-select-banco').select2();
			row.find('.js-select-agencia').select2();
			row.find('.js-select-conta-corrente').select2();
		},
		initialize: function () {
			var $this = this;

			this.addContaCorrenteButton.on('click', function (e) {
				e.preventDefault();

				$this.addRow();
			});

			$('body').on('click', '.js-delete-conta-corrente', function (e) {
				e.preventDefault();
				var me = $(this);
				var row = me.closest('tr');

				$this.deleteRow(row);
			});

			$('body').on('change', '.js-select-banco', function (e, reinitializingComponent) {
				if (reinitializingComponent) {
					return;
				}

				var me = $(this);
				var row = me.closest('tr');

				$this.getAgencias(me, row);
			});

			$('body').on('change', '.js-select-agencia', function (e, reinitializingComponent) {
				if (reinitializingComponent) {
					return;
				}

				var me = $(this);
				var row = me.closest('tr');
				var banco = row.find('.js-select-banco').last();

				$this.getContaCorrentes(banco, me, row);
			});
		}
	}

	contaCorrenteConvenio.initialize();
}());
