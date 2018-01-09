$(document).ready(function () {

    var credito = {
        getGeneros: function (natureza) {
            var $this = this;
            var generoSelect = $('.js-select-genero');
            var especieSelect = $('.js-select-especie');

            this.clearSelect(generoSelect);
            generoSelect.trigger('change');
            this.clearSelect(especieSelect);
            especieSelect.trigger('change');
            if (!natureza.val()) {
                return;
            }

            $.ajax({
                method: 'GET',
                url: '/tributario/cadastro-monetario/genero/index?natureza=' + natureza.val(),
                dataType: 'json',
                beforeSend: function () {
                    generoSelect.append($('<option style="display:none" selected></option>').text('Carregando...'));
                    generoSelect.trigger('change', true);
                },
                success: function (data) {
                    $this.clearSelect(generoSelect);
                    generoSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));
                    $.each(data, function (index, item) {
                        generoSelect.append($('<option style="display:none"></option>').attr('value', item.cod_genero).text(item.nom_genero));
                    });

                    generoSelect.trigger('change', true);
                }
            });
        },
        getEspecies: function (genero) {
            var $this = this;
            var naturezaSelect = $('.js-select-natureza').last();
            var especieSelect = $('.js-select-especie');

            this.clearSelect(especieSelect);
            especieSelect.trigger('change');
            if (!naturezaSelect.val() || !genero.val()) {
                return;
            }

            $.ajax({
                method: 'GET',
                url: '/tributario/cadastro-monetario/especie/index?codNatureza=' + naturezaSelect.val() + '&codGenero=' + genero.val(),
                dataType: 'json',
                beforeSend: function () {
                    especieSelect.append($('<option style="display:none" selected></option>').text('Carregando...'));
                    especieSelect.trigger('change', true);
                },
                success: function (data) {
                    $this.clearSelect(especieSelect);
                    especieSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));
                    $.each(data, function (index, item) {
                        especieSelect.append($('<option style="display:none"></option>').attr('value', item.id).text(item.nom_especie));
                    });

                    especieSelect.trigger('change', true);
                }
            });
        },
        getBancos: function (convenio, bancoId, agenciaId, contaCorrentId) {
            var $this = this;
            var bancoSelect = $('.js-select-banco').last();
            var agenciaSelect = $('.js-select-agencia').last();
            var contaCorrenteSelect = $('.js-select-conta-corrente').last();

            this.clearSelect(bancoSelect);
            bancoSelect.trigger('change');
            this.clearSelect(agenciaSelect);
            agenciaSelect.trigger('change');
            this.clearSelect(contaCorrenteSelect);
            contaCorrenteSelect.trigger('change');
            if (!convenio.val()) {
                return;
            }

            $.ajax({
                method: 'GET',
                url: '/tributario/cadastro-monetario/banco/index?codConvenio=' + convenio.val(),
                dataType: 'json',
                beforeSend: function () {
                    $this.clearSelect(bancoSelect);
                    bancoSelect.append($('<option style="display:none" selected></option>').text('Carregando...'));
                    bancoSelect.trigger('change', true);
                },
                success: function (data) {
                    $this.clearSelect(bancoSelect);
                    bancoSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));

                    var selected = '';
                    $.each(data, function (index, item) {
                        selected = '';
                        if (item.cod_banco == bancoId) {
                            selected = 'selected';
                        }

                        bancoSelect.append($('<option style="display:none" ' + selected + '></option>').attr('value', item.cod_banco).text(item.num_banco + '-' + item.nom_banco));
                    });

                    bancoSelect.trigger('change', true);
                }
            });
        },
        getAgencias: function (banco, convenio, bancoId, agenciaId, contaCorrenteId) {
            var $this = this;
            var agenciaSelect = $('.js-select-agencia').last();
            var contaCorrenteSelect = $('.js-select-conta-corrente').last();

            this.clearSelect(agenciaSelect);
            agenciaSelect.trigger('change');
            this.clearSelect(contaCorrenteSelect);
            contaCorrenteSelect.trigger('change');

            var bancoId = banco.val() || bancoId;
            if (!convenio.val() || !bancoId) {
                return;
            }

            $.ajax({
                method: 'GET',
                url: '/tributario/cadastro-monetario/agencia/index?codBanco=' + bancoId + '&codConvenio=' + convenio.val(),
                dataType: 'json',
                beforeSend: function () {
                    $this.clearSelect(agenciaSelect);
                    agenciaSelect.append($('<option style="display:none" selected></option>').text('Carregando...'));
                    agenciaSelect.trigger('change', true);
                },
                success: function (data) {
                    $this.clearSelect(agenciaSelect);
                    agenciaSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));

                    var selected = '';
                    $.each(data, function (index, item) {
                        selected = '';
                        if (item.id == agenciaId) {
                            selected = 'selected';
                        }

                        agenciaSelect.append($('<option style="display:none" ' + selected + '></option>').attr('value', item.id).text(item.num_agencia));
                    });

                    agenciaSelect.trigger('change', true);
                }
            });
        },
        getContaCorrentes: function (agencia, convenio, bancoId, agenciaId, contaCorrenteId) {
            var $this = this;
            var bancoSelect = $('.js-select-banco').last();
            var contaCorrenteSelect = $('.js-select-conta-corrente').last();

            this.clearSelect(contaCorrenteSelect);
            contaCorrenteSelect.trigger('change');

            var bancoId = bancoSelect.val() || bancoId;
            var agenciaId = agencia.val() || agenciaId;
            if (!convenio.val() || !bancoId || !agenciaId) {
                return;
            }

            codAgencia = agenciaId.split('~').pop();

            $.ajax({
                method: 'GET',
                url: '/tributario/cadastro-monetario/conta-corrente/index?codBanco=' + bancoId + '&codAgencia=' + codAgencia + '&codConvenio=' + convenio.val(),
                dataType: 'json',
                beforeSend: function () {
                    $this.clearSelect(contaCorrenteSelect);
                    contaCorrenteSelect.append($('<option style="display:none" selected></option>').text('Carregando...'));
                    contaCorrenteSelect.trigger('change');
                },
                success: function (data) {
                    $this.clearSelect(contaCorrenteSelect);
                    contaCorrenteSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));

                    var selected = '';
                    $.each(data, function (index, item) {
                        selected = '';
                        if (item.id == contaCorrenteId) {
                            selected = 'selected';
                        }

                        contaCorrenteSelect.append($('<option style="display:none" ' + selected + '></option>').attr('value', item.id).text(item.num_conta_corrente));
                    });

                    contaCorrenteSelect.trigger('change');
                }
            });
        },
        getCarteiras: function (convenio, carteiraId) {
            var $this = this;
            var carteiraSelect = $('.js-select-carteira').last();

            this.clearSelect(carteiraSelect);
            carteiraSelect.trigger('change');
            if (!convenio.val()) {
                return;
            }

            $.ajax({
                method: 'GET',
                url: '/tributario/cadastro-monetario/carteira/index?codConvenio=' + convenio.val(),
                dataType: 'json',
                beforeSend: function () {
                    $this.clearSelect(carteiraSelect);
                    carteiraSelect.append($('<option style="display:none" selected></option>').text('Carregando...'));
                    carteiraSelect.trigger('change');
                },
                success: function (data) {
                    $this.clearSelect(carteiraSelect);
                    carteiraSelect.append($('<option value="" style="display:none" selected>Selecione</option>'));

                    var selected = '';
                    $.each(data, function (index, item) {
                        selected = '';
                        if (item.cod_carteira == carteiraId) {
                            selected = 'selected';
                        }

                        carteiraSelect.append($('<option style="display:none" ' + selected + '></option>').attr('value', item.cod_carteira).text(item.num_carteira));
                    });

                    carteiraSelect.trigger('change');
                }
            });
        },
        toggleIndexacao: function () {
            var tipoIndexacao = $('[name$="[tipoIndexacao]"]:checked');
            var indicadorEconomico = $('select[name$="[fkMonetarioIndicadorEconomico]"]');
            var moeda = $('select[name$="[fkMonetarioMoeda]"]');

            if (!tipoIndexacao.val()) {
                indicadorEconomico.closest('.form_row').addClass('hidden');
                indicadorEconomico.removeAttr('required').select2('enable', false);

                moeda.closest('.form_row').addClass('hidden');
                moeda.removeAttr('required').select2('enable', false);
            }

            if (tipoIndexacao.val() == 'indicador-economico') {
                indicadorEconomico.closest('.form_row').removeClass('hidden');
                indicadorEconomico.attr('required', 'required').select2('enable', true);

                moeda.closest('.form_row').addClass('hidden');
                moeda.removeAttr('required').select2('enable', false);
            }

            if (tipoIndexacao.val() == 'moeda') {
                indicadorEconomico.closest('.form_row').addClass('hidden');
                indicadorEconomico.removeAttr('required').select2('enable', false);

                moeda.closest('.form_row').removeClass('hidden');
                moeda.attr('required', 'required').select2('enable', true);
            }
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
            var convenio = $('input[name$="[fkMonetarioConvenio]"]').last();
            var ids = {};

            $('body').on('change', '.js-select-natureza', function (e) {
                $this.getGeneros($(this));
            });

            $('body').on('change', '.js-select-genero', function (e, reinitializingComponent) {
                if (reinitializingComponent) {
                    return;
                }

                $this.getEspecies($(this));
            });

            $('body').on('change', 'input[name$="[fkMonetarioConvenio]"]', function (e, reinitializingComponent) {
                if (reinitializingComponent) {
                    return;
                }
                $this.getCarteiras($(this), ids.carteiraId);
                $this.getBancos($(this), ids.bancoId, ids.agenciaId, ids.contaCorrenteId);
            });

            $('body').on('change', 'select.js-select-banco', function (e, reinitializingComponent) {
                if (reinitializingComponent) {
                    return;
                }

                $this.getAgencias($(this), convenio, ids.bancoId, ids.agenciaId, ids.contaCorrenteId);
            });

            $('body').on('change', 'select.js-select-agencia', function (e, reinitializingComponent) {
                if (reinitializingComponent) {
                    return;
                }

                $this.getContaCorrentes($(this), convenio, ids.bancoId, ids.agenciaId, ids.contaCorrenteId);

                ids = {};
            });

            $('body').on('change', 'select.js-select-credito-acrescimo', function (e, reinitializingComponent) {
                if (reinitializingComponent) {
                    return;
                }

                var me = $(this);
                var values = me.val();
                if (!values) {
                    return;
                }

                $.each(me.select2('data').reverse(), function (index, object) {
                    var value = object.id;
                    splittedValue = value.split('~');
                    if ($('.js-select-credito-acrescimo option[value$="~' + splittedValue[splittedValue.length - 1] + '"]:selected').length > 1) {
                        values.splice(values.indexOf(value), 1);
                        $('div.js-select-credito-acrescimo ').find('li:contains("' + object.text + '")').remove();
                        me.val(values);
                        me.trigger('change', true);

                        alert('Este tipo de acrescimo já está na lista de acréscimos para este crédito!');
                    }
                });
            });

            if (!$('.js-select-especie').val()) {
                $('.js-select-especie').empty();
            }

            $('body').on('change', 'input[id$="fkNormasNorma_autocomplete_input"]', function (e) {
                var me = $(this);
                if (!me.val()) {
                    return;
                }

                if ($('input[name$="[fkNormasNorma]"][value="' + me.val() + '"]').length < 2) {
                    return;
                }

                $this.clearSelect(me);
                alert('Esta Norma já se encontra na lista!');
            });

            $('body').on('ifChanged', '.js-indexacao', function (e) {
                $this.toggleIndexacao();
            });

            $('.js-indexacao').trigger('ifChanged');

            var uri = location.pathname.split('/');
            if (uri[uri.length - 1].startsWith('create')) {
                $('select.js-select-genero').empty();
                $('select.js-select-especie').empty();
                $('select.js-select-banco').empty();
                $('select.js-select-agencia').empty();
                $('select.js-select-conta-corrente').empty();
                $('select.js-select-carteira').empty();
            }

            if (!uri[uri.length - 1].startsWith('edit') && !location.search.match('uniqid')) {
                return;
            }

            ids.bancoId = $('select.js-select-banco').val();
            ids.agenciaId = $('select.js-select-agencia').val();
            ids.contaCorrenteId = $('select.js-select-conta-corrente').val();
            ids.carteiraId = $('select.js-select-carteira').val();

            $('input[name$="[fkMonetarioConvenio]"]').trigger('change');
        }
    }

    credito.initialize();
}());
