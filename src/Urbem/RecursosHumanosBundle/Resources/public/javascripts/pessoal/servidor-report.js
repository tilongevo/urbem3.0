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
		'ativo' : 'contrato,cgm_contrato,lotacao,local,atributo_servidor',
		'aposentado': 'contrato,cgm_contrato,lotacao,local,atributo_servidor',
		'pensionista': 'contrato,cgm_contrato,lotacao,local',
		'rescindido': 'contrato,cgm_contrato,lotacao,local,atributo_servidor',
		'todos': 'contrato,cgm_contrato,lotacao,local,atributo_servidor'
	}

	var servidores = {
		tipoCadastro: UrbemSonata.giveMeBackMyField('tipoCadastro'),
		tipoFiltro: UrbemSonata.giveMeBackMyField('tipoFiltro'),
		matricula: UrbemSonata.giveMeBackMyField('matricula'),
		cgm: UrbemSonata.giveMeBackMyField('cgm'),
		cgmMatricula: UrbemSonata.giveMeBackMyField('cgmMatricula'),
		lotacao: UrbemSonata.giveMeBackMyField('lotacao'),
		local: UrbemSonata.giveMeBackMyField('local'),
		atributoSelecao: UrbemSonata.giveMeBackMyField('atributoSelecao'),
		addMatriculaButton: $('button[name="incluir-matricula-btn"]'),
		addCgmMatriculaButton: $('button[name="incluir-cgm-matricula-btn"]'),
		listaMatriculasTable: $('.js-table-lista-matriculas'),
		listaCgmMatriculasTable: $('.js-table-lista-cgm-matriculas'),
		atributosDinamicos: $('#atributos-dinamicos'),
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
			tipoCadastroVal = this.tipoCadastro.val();

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

			this.listaMatriculasTable.addClass('hidden').find('tbody').html('');
			this.listaCgmMatriculasTable.addClass('hidden').find('tbody').html('');

			this.atributosDinamicos.html('').addClass('hidden');
			this.atributoSelecao.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden');

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

                this.atributoSelecao.select2('enable', true).closest('.form_row').removeClass('hidden');

                var atributos = this.atributosDinamicos;

                 this.atributoSelecao.on('change', function () {
                    var me = $(this);
                    if (me.val() != '') {
                        atributos.removeClass('hidden');
                        atributoDinamicoParams = {
                            codModulo: 22,
                            codCadastro: 5
                        };
                        window.AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(atributoDinamicoParams, me.val());
					} else {
                        $('#atributos-dinamicos').children('div').hide();
					}
                });
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
			var $this = this;

			this.tipoCadastro.on('change', function (e) {
				var me = $(this);

				$('.box-header').eq(1).find('.box-title').html(me.find('option[value="' + me.val() + '"]').html());
				
				$this.toggleTipoCadastro();
				$this.toggleTipoFiltro();
			});

			this.tipoFiltro.on('change', function (e) {
                var me = $(this);

                $('.box-header').eq(2).find('.box-title').html("Filtrar por " + me.find('option[value="'+ me.val() + '"]').html());
				$this.toggleTipoFiltro();
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

			this.tipoCadastro.trigger('change');

			$('body').on('submit', 'form', function () {
				$this.cgmMatricula.select2('val', '');
			});
		}
	}

	servidores.initialize();
}());
