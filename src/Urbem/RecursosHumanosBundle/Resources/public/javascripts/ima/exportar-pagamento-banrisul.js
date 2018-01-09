$(document).ready(function () {

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

	var tipoCadastroFiltros = {
		'ativo' : 'contrato,cgm_contrato,lotacao,local,atributo_servidor,geral',
		'aposentado': 'contrato,cgm_contrato,lotacao,local,atributo_servidor,geral',
		'pensionista': 'contrato,cgm_contrato,lotacao,local,atributo_pensionista,geral',
		'estagiario': 'codigo-estagio,atributo_estagiario,lotacao,local,geral',
		'rescindido': 'contrato,cgm_contrato,lotacao,local,atributo_servidor,geral',
		'pensao-judicial': 'cgm-dependente-pensao,cgm-matricula-servidor,geral',
		'todos': 'lotacao,geral'
	}

	var exportarPagamentoBanrisul = {
		tipoCadastro: UrbemSonata.giveMeBackMyField('tipoCadastro'),
		competencia: UrbemSonata.giveMeBackMyField('competencia'),
		tipoFolha: UrbemSonata.giveMeBackMyField('tipoFolha'),
		folhaComplementar: UrbemSonata.giveMeBackMyField('folhaComplementar'),
		desdobramento: UrbemSonata.giveMeBackMyField('desdobramento'),
		tipoFiltro: UrbemSonata.giveMeBackMyField('tipoFiltro'),
		matricula: UrbemSonata.giveMeBackMyField('matricula'),
		cgm: UrbemSonata.giveMeBackMyField('cgm'),
		cgmMatricula: UrbemSonata.giveMeBackMyField('cgmMatricula'),
		lotacao: UrbemSonata.giveMeBackMyField('lotacao'),
		local: UrbemSonata.giveMeBackMyField('local'),
		codEstagio: UrbemSonata.giveMeBackMyField('codEstagio'),
		cgmDependente: UrbemSonata.giveMeBackMyField('cgmDependente'),
		cgmServidorDependente: UrbemSonata.giveMeBackMyField('cgmServidorDependente'),
		cgmServidorDependenteMatricula: UrbemSonata.giveMeBackMyField('cgmServidorDependenteMatricula'),
		addMatriculaButton: $('button[name="incluir-matricula-btn"]'),
		addCgmMatriculaButton: $('button[name="incluir-cgm-matricula-btn"]'),
		addCodEstagioButton: $('button[name="incluir-cod-estagio-btn"]'),
		addCgmDependenteButton: $('button[name="incluir-cgm-dependente-btn"]'),
		addCgmServidorDependenteButton: $('button[name="incluir-cgm-servidor-dependente-btn"]'),
		listaMatriculasTable: $('.js-table-lista-matriculas'),
		listaCgmMatriculasTable: $('.js-table-lista-cgm-matriculas'),
		listaCodEstagiosTable: $('.js-table-lista-cod-estagios'),
		listaCgmDependentesTable: $('.js-table-lista-cgm-dependentes'),
		listaCgmServidorDependentesTable: $('.js-table-lista-cgm-servidor-dependentes'),
		atributosDinamicos: $('#atributos-dinamicos'),
		agrupamentoAtributoDinamicoEstagiario: UrbemSonata.giveMeBackMyField('agrupamentoAtributoDinamicoEstagiario'),
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
		toggleTipoCadastro: function () {
			this.competencia.attr('required', true).closest('.form_row').removeClass('hidden');
			this.tipoFolha.select2('enable', true).select2('val', 1).attr('required', true).closest('.form_row').removeClass('hidden');

			tipoCadastroVal = this.tipoCadastro.val();
			if (tipoCadastroVal == 'estagiario') {
				this.competencia.removeAttr('required').closest('.form_row').addClass('hidden');
				this.tipoFolha.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			}

			var optionsArray = tipoCadastroFiltros[tipoCadastroVal].split(',');
			this.tipoFiltro.find('option').each(function (index, item) {
				var option = $(this);
				if (optionsArray.indexOf(option.val()) >= 0) {
					option.removeClass('hidden');

					return true;
				}

				option.addClass('hidden');
			});

			this.tipoFiltro.select2('val', 'geral');	
		},
		toggleTipoFolha: function () {
			this.folhaComplementar.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			this.desdobramento.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');

			if (!this.tipoFolha.val()) {
				return;
			}

			var tipoFolhaData = this.tipoFolha.select2('data');
			if (tipoFolhaData.text == 'Complementar') {
				this.folhaComplementar.select2('enable', true).attr('required', true).closest('.form_row').removeClass('hidden');
			}

			if (tipoFolhaData.text == '13º salário') {
				this.desdobramento.select2('enable', true).closest('.form_row').removeClass('hidden');
			}
		},
		toggleTipoFiltro: function () {
			this.clearSelect(this.matricula);
			this.clearSelect(this.cgm);
			this.clearSelect(this.cgmMatricula);
			this.lotacao.select2('val', '');
			this.local.select2('val', '');
			this.clearSelect(this.codEstagio);
			this.clearSelect(this.cgmDependente);
			this.clearSelect(this.cgmServidorDependente);
			this.clearSelect(this.cgmServidorDependenteMatricula);

			this.matricula.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			this.cgm.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			this.cgmMatricula.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			this.cgmServidorDependenteMatricula.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			this.lotacao.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			this.local.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			this.codEstagio.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			this.cgmDependente.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			this.cgmServidorDependente.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');
			this.cgmServidorDependenteMatricula.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');

			this.addMatriculaButton.parent().parent().addClass('hidden').find('.alert').html('').addClass('hidden');
			this.addCgmMatriculaButton.parent().parent().addClass('hidden').find('.alert').html('').addClass('hidden');
			this.addCodEstagioButton.parent().parent().addClass('hidden').find('.alert').html('').addClass('hidden');
			this.addCgmDependenteButton.parent().parent().addClass('hidden').find('.alert').html('').addClass('hidden');
			this.addCgmServidorDependenteButton.parent().parent().addClass('hidden').find('.alert').html('').addClass('hidden');

			this.listaMatriculasTable.addClass('hidden').find('tbody').html('');
			this.listaCgmMatriculasTable.addClass('hidden').find('tbody').html('');
			this.listaCodEstagiosTable.addClass('hidden').find('tbody').html('');
			this.listaCgmDependentesTable.addClass('hidden').find('tbody').html('');
			this.listaCgmServidorDependentesTable.addClass('hidden').find('tbody').html('');
			this.listaCgmServidorDependentesTable.addClass('hidden').find('tbody').html('');

			this.atributosDinamicos.html('').addClass('hidden');
			this.agrupamentoAtributoDinamicoEstagiario.iCheck('uncheck').removeAttr('required').closest('.form_row').addClass('hidden');

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

			if (this.tipoFiltro.val() == 'lotacao') {
				this.lotacao.select2('enable', true).attr('required', 'required').closest('.form_row').removeClass('hidden');
			}

			if (this.tipoFiltro.val() == 'local') {
				this.local.select2('enable', true).attr('required', 'required').closest('.form_row').removeClass('hidden');
			}

			if (this.tipoFiltro.val() == 'atributo_servidor') {
				this.atributosDinamicos.removeClass('hidden');

				atributoDinamicoParams = {
					codModulo: 22,
					codCadastro: 5
				};

				window.AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(atributoDinamicoParams);
			}

			if (this.tipoFiltro.val() == 'atributo_pensionista') {
				this.atributosDinamicos.removeClass('hidden');
				
				atributoDinamicoParams = {
					codModulo: 22,
					codCadastro: 7
				};

				window.AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(atributoDinamicoParams);
			}

			if (this.tipoFiltro.val() == 'codigo-estagio') {
				this.codEstagio.select2('enable', true).closest('.form_row').removeClass('hidden');
				this.addCodEstagioButton.parent().parent().removeClass('hidden');
				this.listaCodEstagiosTable.removeClass('hidden');
			}

			if (this.tipoFiltro.val() == 'atributo_estagiario') {
				this.atributosDinamicos.removeClass('hidden');
				
				atributoDinamicoParams = {
					codModulo: 39,
					codCadastro: 1
				};

				window.AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(atributoDinamicoParams);

				this.agrupamentoAtributoDinamicoEstagiario.closest('.form_row').removeClass('hidden');
			}

			if (this.tipoFiltro.val() == 'cgm-dependente-pensao') {
				this.cgmDependente.select2('enable', true).closest('.form_row').removeClass('hidden');
				this.addCgmDependenteButton.parent().parent().removeClass('hidden');
				this.listaCgmDependentesTable.removeClass('hidden');
			}

			if (this.tipoFiltro.val() == 'cgm-matricula-servidor') {
				this.cgmServidorDependente.select2('enable', true).closest('.form_row').removeClass('hidden');
				this.cgmServidorDependenteMatricula.select2('enable', true).closest('.form_row').removeClass('hidden');
				this.addCgmServidorDependenteButton.parent().parent().removeClass('hidden');
				this.listaCgmServidorDependentesTable.removeClass('hidden');
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

			if (type == 'codigo-estagio') {
				template = templateCodEstagioCgm;
				codEstagioData = this.codEstagio.select2('data');
				template = template.replaceAll('{codEstagio}', codEstagioData.id)
					.replaceAll('{numeroEstagio}', codEstagioData.label.split(' - ').shift())
					.replaceAll('{numcgm}', codEstagioData.label.split(' - ').slice(1).shift())
					.replaceAll('{nomCgm}', codEstagioData.label.split(' - ').slice(1).join(' - '))
					.replaceAll('{class}', 'js-lista-cod-estagios-cod-estagio');
			}

			if (type == 'cgm-dependente-pensao') {
				template = templateCgm;
				cgmDependenteData = this.cgmDependente.select2('data');
				template = template.replaceAll('{numcgm}', cgmDependenteData.id)
					.replaceAll('{nomCgm}', cgmDependenteData.label)
					.replaceAll('{class}', 'js-lista-cgm-dependentes-cgm');
			}

			if (type == 'cgm-matricula-servidor') {
				template = templateCgmMatricula;
				cgmServidorDependenteMatriculaData = this.cgmServidorDependenteMatricula.select2('data');
				cgmServidorDependente = this.cgmServidorDependente.select2('data');
				template = template.replaceAll('{codContrato}', cgmServidorDependenteMatriculaData.id)
					.replaceAll('{codRegistro}', cgmServidorDependenteMatriculaData.text)
					.replaceAll('{numcgm}', cgmServidorDependente.id)
					.replaceAll('{nomCgm}', cgmServidorDependente.label)
					.replaceAll('{class}', 'js-lista-cgm-servidor-dependentes-matricula');
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
		validarCodEstagio: function () {
			var errors = '';
			var codEstagio = $('input[id$="codEstagio_autocomplete_input"]');

			if (!codEstagio.val()) {
				errors += 'Selecione o Código Estágio.<br>';
			}

			if ($('input.js-lista-cod-estagios-cod-estagio[value="' + codEstagio.val() + '"]').length >= 1) {
				errors += 'Estágio já inserido na lista.<br>';
			}

			$('.js-incluir-cod-estagio-errors').html(errors);

			return !errors;
		},
		validarCgmDependente: function () {
			var errors = '';

			if (!this.cgmDependente.val()) {
				errors += 'Selecione o CGM do dependente.<br>';
			}

			if ($('input.js-lista-cgm-dependentes-cgm[value="' + this.cgmDependente.val() + '"]').length >= 1) {
				errors += 'CGM já inserido na lista.<br>';
			}

			$('.js-incluir-cgm-dependente-errors').html(errors);

			return !errors;
		},
		validarCgmServidorDependente: function () {
			var errors = '';

			if (!this.cgmServidorDependenteMatricula.val()) {
				errors += 'Selecione a matrícula.<br>';
			}

			if ($('input.js-lista-cgm-servidor-dependentes-matricula[value="' + this.cgmServidorDependenteMatricula.val() + '"]').length >= 1) {
				errors += 'Matrícula já inserida na lista.<br>';
			}

			$('.js-incluir-cgm-servidor-dependente-errors').html(errors);

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

			this.tipoCadastro.on('change', function (e) {
				var me = $(this);

				$('.box-header').eq(1).find('.box-title').html(me.find('option[value="' + me.val() + '"]').html());
				
				$this.toggleTipoCadastro();
				$this.toggleTipoFolha();
				$this.toggleTipoFiltro();
			});

			this.tipoFiltro.on('change', function () {
				$this.toggleTipoFiltro();
			});

			this.tipoFolha.on('change', function () {
				$this.toggleTipoFolha();
			});

			this.cgm.on('change', function () {
				var me = $(this);

				$this.getMatriculas(me, $this.cgmMatricula);
			});

			this.cgmServidorDependente.on('change', function () {
				var me = $(this);

				$this.getMatriculas(me, $this.cgmServidorDependenteMatricula);
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

			this.addCodEstagioButton.on('click', function (e) {
				e.preventDefault();

				$('.js-incluir-cod-estagio-errors').addClass('hidden');
				if (!$this.validarCodEstagio()) {
					$('.js-incluir-cod-estagio-errors').removeClass('hidden');

					return;
				}

				$this.addRow($this.tipoFiltro.val(), $this.listaCodEstagiosTable);
			});

			this.addCgmDependenteButton.on('click', function (e) {
				e.preventDefault();

				$('.js-incluir-cgm-dependente-errors').addClass('hidden');
				if (!$this.validarCgmDependente()) {
					$('.js-incluir-cgm-dependente-errors').removeClass('hidden');

					return;
				}

				$this.addRow($this.tipoFiltro.val(), $this.listaCgmDependentesTable);
			});

			this.addCgmServidorDependenteButton.on('click', function (e) {
				e.preventDefault();

				$('.js-incluir-cgm-servidor-dependente-errors').addClass('hidden');
				if (!$this.validarCgmServidorDependente()) {
					$('.js-incluir-cgm-servidor-dependente-errors').removeClass('hidden');

					return;
				}

				$this.addRow($this.tipoFiltro.val(), $this.listaCgmServidorDependentesTable);
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

			this.tipoCadastro.trigger('change');

			$('body').on('submit', 'form', function () {
				$this.cgmMatricula.select2('val', '');
				$this.cgmServidorDependenteMatricula.select2('val', '');
			});
		}
	}

	exportarPagamentoBanrisul.initialize();
}());