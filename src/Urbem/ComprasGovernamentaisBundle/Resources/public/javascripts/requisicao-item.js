$(document).ready(function () {

	var requisicaoItem = {
		getMarcas: function (item) {
			var $this = this;
			var marcasSelect = item.closest('tr').find('select[name$="[marca]"]');
			var marcasSelectVal = marcasSelect.val();
			
			this.clearSelect(marcasSelect);

			marcasSelect.removeAttr('disabled').select2('enable');

			$.ajax({
				method: 'GET',
				url: '/compras-governamentais/requisicao-item/api/marcas',
				data: {codItem: item.val()},
				dataType: 'json',
				beforeSend: function () {
					marcasSelect.append($('<option style="display:none" selected></option>').text('Carregando...'));
					marcasSelect.trigger('change', true);
				},
				success: function (data) {
					$this.clearSelect(marcasSelect);
					marcasSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));
					$.each(data.items, function (index, item) {
						marcasSelect.append($('<option style="display:none"></option>').attr('value', item.id).text(item.label).prop('selected', item.id == marcasSelectVal));
					});

					marcasSelect.trigger('change', !marcasSelectVal);
				}
			});
		},
		getCentrosCusto: function (almoxarifado, item, marca) {
			var $this = this;
			var centrosCustoSelect = item.closest('tr').find('select[name$="[centroCusto]"]');
			var centrosCustoSelectVal = centrosCustoSelect.val();

			this.clearSelect(centrosCustoSelect);

			centrosCustoSelect.removeAttr('disabled').select2('enable');

			$.ajax({
				method: 'GET',
				url: '/compras-governamentais/requisicao-item/api/centros-custo',
				data: {codAlmoxarifado: almoxarifado.val(), codItem: item.val(), codMarca: marca.val()},
				dataType: 'json',
				beforeSend: function () {
					centrosCustoSelect.append($('<option style="display:none" selected></option>').text('Carregando...'));
					centrosCustoSelect.trigger('change', true);
				},
				success: function (data) {
					$this.clearSelect(centrosCustoSelect);
					centrosCustoSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));
					$.each(data.items, function (index, item) {
						centrosCustoSelect.append($('<option style="display:none"></option>').attr('value', item.id).text(item.label).prop('selected', item.id == centrosCustoSelectVal));
					});

					centrosCustoSelect.trigger('change', !centrosCustoSelectVal);
				}
			});
		},
		getSaldoEstoque: function (almoxarifado, item, marca, centroCusto) {
			var $this = this;
			var saldoEstoqueInput = item.closest('tr').find('input[name$="[saldoEstoque]"]');

			$.ajax({
				method: 'GET',
				url: '/compras-governamentais/requisicao-item/api/saldo-estoque',
				data: {codAlmoxarifado: almoxarifado.val(), codItem: item.val(), codMarca: marca.val(), codCentro: centroCusto.val()},
				dataType: 'json',
				beforeSend: function () {
					saldoEstoqueInput.val('Carregando...');
				},
				success: function (data) {
					saldoEstoqueInput.val(data.quantidade);
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

			var almoxarifado = UrbemSonata.giveMeBackMyField('fkAlmoxarifadoAlmoxarifado');

			almoxarifado.on('change', function () {
				$('select[name$="[marca]"]').trigger('change');
				$('input[name$="[saldoEstoque]"]').val('0').attr('disabled', 'disabled');
				$('input[name$="[quantidade]"]').val('0');
			});

			$('body').on('change', 'input[id$="item_autocomplete_input"]', function () {
				var me = $(this);

				me.closest('tr').find('select[name$="[marca]"]').attr('disabled', 'disabled').select2('disable');
				me.closest('tr').find('select[name$="[centroCusto]"]').attr('disabled', 'disabled').select2('disable');
				me.closest('tr').find('input[name$="[saldoEstoque]"]').val('0').attr('disabled', 'disabled');

				if (!me.val()) {
					return;
				}

				$this.getMarcas(me);
			});

			$('body').on('change', 'select[name$="[marca]"]', function (e, reinitializing) {
				if (reinitializing) {
					return;
				}

				var me = $(this);

				if (!me.val()) {
					me.closest('tr').find('select[name$="[centroCusto]"]').attr('disabled', 'disabled').select2('disable');
					me.closest('tr').find('input[name$="[saldoEstoque]"]').val('0').attr('disabled', 'disabled');

					return;
				}

				var item = me.closest('tr').find('input[id$="item_autocomplete_input"]');
					
				$this.getCentrosCusto(almoxarifado, item, me);
			});

			$('body').on('change', 'select[name$="[centroCusto]"]', function (e, reinitializing) {
				if (reinitializing) {
					return;
				}

				var me = $(this);

				if (!me.val()) {
					me.closest('tr').find('input[name$="[saldoEstoque]"]').val('0').attr('disabled', 'disabled');

					return;
				}

				var almoxarifado = UrbemSonata.giveMeBackMyField('fkAlmoxarifadoAlmoxarifado');
				var item = me.closest('tr').find('input[id$="item_autocomplete_input"]');
				var marca = me.closest('tr').find('select[name$="[marca]"]');
					
				$this.getSaldoEstoque(almoxarifado, item, marca, me);
			});		

			if (UrbemSonata.giveMeBackMyField('dadosItem').val()) {
				var item = JSON.parse(UrbemSonata.giveMeBackMyField('dadosItem').val());
				$('input[id$="item_autocomplete_input"]').val(item.id);
				$('input[name$="[item]"]').val(item.id);
				$('input[id$="item_autocomplete_input"]').closest('td').find('.select2-chosen').html(item.label).parent('a').removeClass('select2-default');
			}

			if (UrbemSonata.giveMeBackMyField('dadosMarca').val()) {
				var marca = JSON.parse(UrbemSonata.giveMeBackMyField('dadosMarca').val());
				$('select[name$="[marca]"]').val(marca.id);
			}	

			if (UrbemSonata.giveMeBackMyField('dadosCentroCusto').val()) {
				var centroCusto = JSON.parse(UrbemSonata.giveMeBackMyField('dadosCentroCusto').val());
				$('select[name$="[centroCusto]"]').val(centroCusto.id);
			}			

			var uri = location.pathname.split('/');
			if (uri[uri.length - 1].startsWith('create')) {
				$('input[id$="item_autocomplete_input"]').trigger('change');
			}

			if ($('input[id$="item_autocomplete_input"], input[name$="[item]"]').length || uri[uri.length - 1].startsWith('edit')) {
				$('div[id$="fkAlmoxarifadoRequisicaoItens"] span[id^="field_actions"]').find('a').remove();
			}

			$.ajaxSetup({
				complete: function (xhr) {
					if (!xhr.getResponseHeader('Content-Type').startsWith('text/html') || xhr.status != 200) {
						return;
					}

					$('div[id$="fkAlmoxarifadoRequisicaoItens"] span[id^="field_actions"]').find('a').remove();
					$('input[id$="item_autocomplete_input"]').trigger('change');
				},
			});
		}
	}

	requisicaoItem.initialize();
}());
