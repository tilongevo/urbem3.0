$(document).ready(function() {
	var templateCgmMatricula = '<tr data-index="{index}">\
		<td class="control-group">\
			<span>{codRegistro}</span>\
			<input type="hidden" name="cgmMatriculas[{index}][codContrato]" class="{class}" value="{codContrato}" readonly>\
			<input type="hidden" name="cgmMatriculas[{index}][codRegistro]" value="{codRegistro}" readonly>\
		</td>\
		<td class="control-group">\
			<span>{nomCgm}</span>\
			<input type="hidden" name="cgmMatriculas[{index}][numcgm]" value="{numcgm}" readonly>\
		</td>\
		<td class="control-group">\
			<button type="button" class="js-delete-row">Remover</button>\
		</td>\
	</tr>';

	var templateCodEstagioCgm = '<tr data-index="{index}">\
		<td class="control-group">\
			<span>{numeroEstagio}</span>\
			<input type="hidden" name="estagios[{index}][codEstagio]" class="{class}" value="{codEstagio}" readonly>\
		</td>\
		<td class="control-group">\
			<span>{nomCgm}</span>\
			<input type="hidden" name="estagios[{index}][numcgm]" value="{numcgm}" readonly>\
		</td>\
		<td class="control-group">\
			<button type="button" class="js-delete-row">Remover</button>\
		</td>\
	</tr>';

	var templateCgm = '<tr data-index="{index}">\
		<td class="control-group">\
			<span>{nomCgm}</span>\
			<input type="hidden" name="cgms[{index}][numcgm]" class="{class}" value="{numcgm}" readonly>\
		</td>\
		<td class="control-group">\
			<button type="button" class="js-delete-row">Remover</button>\
		</td>\
	</tr>';

	var RelatorioPensaoJudicialFiltro = {
		competencia: UrbemSonata.giveMeBackMyField('competencia'),
		tipoCalculo: UrbemSonata.giveMeBackMyField('tipoCalculo'),
		folhaComplementar: UrbemSonata.giveMeBackMyField('folhaComplementar'),
		tipoFiltro: UrbemSonata.giveMeBackMyField('tipoFiltro'),
		matricula: UrbemSonata.giveMeBackMyField('matricula'),
		cgm: UrbemSonata.giveMeBackMyField('cgm'),
		cgmMatricula: UrbemSonata.giveMeBackMyField('cgmMatricula'),
		lotacao: UrbemSonata.giveMeBackMyField('lotacao'),
		local: UrbemSonata.giveMeBackMyField('local'),
		addMatriculaButton: $('button[name="incluir-matricula-btn"]'),
		addCgmMatriculaButton: $('button[name="incluir-cgm-matricula-btn"]'),
		listaMatriculasTable: $('.js-table-lista-matriculas'),
		listaCgmMatriculasTable: $('.js-table-lista-cgm-matriculas'),
		atributosDinamicos: $('#atributos-dinamicos'),
		agrupamento: UrbemSonata.giveMeBackMyField('agrupamento'),
		addRow: function (type, table) {
			table.find('tbody').append(this.populateTemplate(type, table));
		},
		deleteRow: function (row) {
			row.remove();
		},
		getMatriculas: function (cgm, field) {
			var $this = this;

			this.clearSelect(field);
			if (!cgm.val()) {
				return;
			}

			$.ajax({
				method: 'GET',
				url: '/recursos-humanos/informacoes/exportar-pagamentos/banrisul/api/matriculas',
				data: {numcgm: cgm.val()},
				dataType: 'json',
				beforeSend: function () {
					field.append($('<option style="display:none" selected></option>').text('Carregando...'));
					field.trigger('change');
				},
				success: function (data) {
					$this.clearSelect(field);
					field.append($('<option value="" style="display:none" selected>Selecione</option>'));
					$.each(data.items, function (index, item) {
						field.append($('<option style="display:none"></option>').attr('value', item.id).text(item.label));
					});

					field.trigger('change');
				}
			});
		},
		getFolhasComplementaresPorCompetencia: function(field) {
			var $this = this;
			
			$.ajax({
				method: 'POST',
				url: '/recursos-humanos/folha-pagamento/bancario-pensao-judicial/relatorio/folhas-por-competencia',
				data: {competencia: $this.competencia.val()},
				dataType: 'json',
				beforeSend: function () {
					field.append($('<option style="display:none" selected></option>').text('Carregando...'));
					field.trigger('change');
				},
				success: function (data) {
					$this.clearSelect(field);
					field.append($('<option value="" style="display:none" selected>Selecione</option>'));
					$.each(data.dados, function (index, item) {
						field.append($('<option style="display:none"></option>').attr('value', item).text(item));
					});

					field.trigger('change');
				}
			});
		},
		toggleTipoCalculo: function () {
			this.folhaComplementar.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			

			if (!this.tipoCalculo.val()) {
				return;
			}

			var tipoCalculoData = this.tipoCalculo.val();
			if (tipoCalculoData == 0) {
				this.folhaComplementar.select2('enable', true).attr('required', true).closest('.form_row').removeClass('hidden');
			}
		},
		toggleTipoFiltro: function () {
			this.clearSelect(this.matricula);
			this.clearSelect(this.cgm);
			this.clearSelect(this.cgmMatricula);
			this.lotacao.select2('val', '');
			this.local.select2('val', '');
			
			this.matricula.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			this.cgm.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			this.cgmMatricula.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			this.lotacao.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			this.local.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			this.addMatriculaButton.parent().parent().addClass('hidden').find('.alert').html('').addClass('hidden');
			this.addCgmMatriculaButton.parent().parent().addClass('hidden').find('.alert').html('').addClass('hidden');
			this.folhaComplementar.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');

			this.listaMatriculasTable.addClass('hidden').find('tbody').html('');
			this.listaCgmMatriculasTable.addClass('hidden').find('tbody').html('');

			this.atributosDinamicos.html('').addClass('hidden');
			this.agrupamento.iCheck('uncheck').removeAttr('required').closest('.form_row').addClass('hidden');

			if (this.tipoFiltro.val() == 'contrato') {
				this.matricula.select2('enable', true).closest('.form_row').removeClass('hidden');
				this.addMatriculaButton.parent().parent().removeClass('hidden');
				this.listaMatriculasTable.removeClass('hidden');
			}

			if (this.tipoFiltro.val() == 'cgm_contrato') {
				this.cgm.select2('enable', true).closest('.form_row').removeClass('hidden');
				this.cgmMatricula.select2('enable', true).closest('.form_row').removeClass('hidden');
				this.addCgmMatriculaButton.parent().parent().removeClass('hidden');
				this.listaCgmMatriculasTable.removeClass('hidden');
			}

			if (this.tipoFiltro.val() == 'lotacao_grupo') {
				this.lotacao.select2('enable', true).attr('required', 'required').closest('.form_row').removeClass('hidden');
			}

			if (this.tipoFiltro.val() == 'local_grupo') {
				this.local.select2('enable', true).attr('required', 'required').closest('.form_row').removeClass('hidden');
			}

			if (this.tipoFiltro.val() == 'atributo_servidor_grupo') {
				this.atributosDinamicos.removeClass('hidden');

				atributoDinamicoParams = {
					codModulo: 22,
					codCadastro: 5
				};

				window.AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(atributoDinamicoParams);
				this.agrupamento.closest('.form_row').removeClass('hidden');
			}

			if (this.tipoFiltro.val() == 'atributo_pensionista') {
				this.atributosDinamicos.removeClass('hidden');
				
				atributoDinamicoParams = {
					codModulo: 22,
					codCadastro: 7
				};

				window.AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(atributoDinamicoParams);
			}
		},
		populateTemplate: function (type, table) {
			template = '';
			if (type == 'contrato') {
				template = templateCgmMatricula;
				cgmData = this.matricula.select2('data');
				cgm = cgmData.label.split(' - ');
				template = template.replaceAll('{codContrato}', cgmData.id)
					.replaceAll('{codRegistro}', cgm[0])
					.replaceAll('{numcgm}', cgm[1])
					.replaceAll('{nomCgm}', cgm.splice(1).join(' - '))
					.replaceAll('{class}', 'js-lista-matriculas-matricula');
			}

			if (type == 'cgm_contrato') {
				template = templateCgmMatricula;
				cgmMatriculaData = this.cgmMatricula.select2('data');
				cgmData = this.cgm.select2('data');
				template = template.replaceAll('{codContrato}', cgmMatriculaData.id)
					.replaceAll('{codRegistro}', cgmMatriculaData.text)
					.replaceAll('{numcgm}', cgmData.id)
					.replaceAll('{nomCgm}', cgmData.label)
					.replaceAll('{class}', 'js-lista-cgm-matriculas-matricula');
			}

			return template.replaceAll('{index}', this.getIndex(table) + 1);
		},
		getIndex: function (table) {
			return parseInt(table.find('tr:last').attr('data-index')) || 0;
		},
		validarMatricula: function () {
			var errors = '';

			if (!this.matricula.val()) {
				errors += 'Selecione a matrícula.<br>';
			}

			if ($('input.js-lista-matriculas-matricula[value="' + this.matricula.val() + '"]').length >= 1) {
				errors += 'Matrícula já inserida na lista.<br>';
			}

			$('.js-incluir-matricula-errors').html(errors);

			return !errors;
		},
		validarCgmMatricula: function () {
			var errors = '';

			if (!this.cgmMatricula.val()) {
				errors += 'Selecione a matrícula.<br>';
			}

			if ($('input.js-lista-cgm-matriculas-matricula[value="' + this.cgmMatricula.val() + '"]').length >= 1) {
				errors += 'Matrícula já inserida na lista.<br>';
			}

			$('.js-incluir-cgm-matricula-errors').html(errors);

			return !errors;
		},
		clearSelect: function (select) {
			select.val('');
			select.select2('val', '');
			select.find('option').each(function (index, option) {
				option.remove();
			});
		},
		initialize: function () {
			this.toggleTipoFiltro();
			var $this = this;			

			var uri = location.pathname.split('/');
			if (uri[uri.length - 1].startsWith('detalhe')) {
				$('body').on('click', 'form.downloadArquivo a', function (e) {
					e.preventDefault();

					var me = $(this);
					var form = me.closest('form');

					form.find('input[name="q"]').val(me.siblings('div.q').html().trim());
					form.find('input[name="nomeArquivo"]').val(me.attr('data-nome-arquivo'));

					form.submit();
				});
				
				return;
			}

			this.competencia.on('change', function() {
				$this.getFolhasComplementaresPorCompetencia($this.folhaComplementar);
			});
			
			this.tipoFiltro.on('change', function () {
				$this.toggleTipoFiltro();
			});

			this.tipoCalculo.on('change', function () {
				$this.toggleTipoCalculo();
			});

			this.cgm.on('change', function () {
				var me = $(this);

				$this.getMatriculas(me, $this.cgmMatricula);
			});

			this.addMatriculaButton.on('click', function (e) {
				e.preventDefault();

				$('.js-incluir-matricula-errors').addClass('hidden');
				if (!$this.validarMatricula()) {
					$('.js-incluir-matricula-errors').removeClass('hidden');

					return;
				}

				$this.addRow($this.tipoFiltro.val(), $this.listaMatriculasTable);
			});

			this.addCgmMatriculaButton.on('click', function (e) {
				e.preventDefault();

				$('.js-incluir-cgm-matricula-errors').addClass('hidden');
				if (!$this.validarCgmMatricula()) {
					$('.js-incluir-cgm-matricula-errors').removeClass('hidden');

					return;
				}

				$this.addRow($this.tipoFiltro.val(), $this.listaCgmMatriculasTable);
				$this.matricula.select2('val', '');
			});

			$('body').on('click', '.js-delete-row', function (e) {
				e.preventDefault();
				var me = $(this);
				var row = me.closest('tr');

				$this.deleteRow(row);
			});

			var ultimaCompetencia = $('input[name$="[ultimaCompetencia]"]');
			this.competencia.val(ultimaCompetencia.val());
			this.competencia.datetimepicker({'format':'MM/YYYY', 'minDate':'01/1900', 'maxDate':ultimaCompetencia.val(), 'minViewMode':'months', 'viewMode':'months', 'language':'pt_BR', 'disabledDates':[], 'enabledDates':[], 'useStrict':false, 'sideBySide':false, 'collapse':true, 'calendarWeeks':false, 'pickTime':false, 'icons':{'time':'fa fa-clock-o', 'date':'fa fa-calendar', 'up':'fa fa-chevron-up', 'down':'fa fa-chevron-down'}});

			$('body').on('submit', 'form', function () {
				$this.cgmMatricula.select2('val', '');
			});
		}
	}
	
	RelatorioPensaoJudicialFiltro.initialize();
});