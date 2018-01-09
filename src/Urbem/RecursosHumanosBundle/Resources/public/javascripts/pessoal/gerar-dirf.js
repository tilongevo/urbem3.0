$(document).ready(function() {
    var tipo = $('#' + UrbemSonata.uniqId + "_tipoRelatorio");
    var cgmMatricula = $('#' + UrbemSonata.uniqId + "_cgmMatricula_autocomplete_input");
    var lotacao = $('#' + UrbemSonata.uniqId + "_lotacao");
    var local = $('#' + UrbemSonata.uniqId + "_local");
    var atrDinamicoServidor = $('#' + UrbemSonata.uniqId + "_atributoDinamicoServidor");
    var atrDinamicoPensionista = $('#' + UrbemSonata.uniqId + "_atributoDinamicoPensionista");
    var regime = $('#' + UrbemSonata.uniqId + "_regime");
    var subDivisao = $('#' + UrbemSonata.uniqId + "_subDivisao");
    var cargo = $('#' + UrbemSonata.uniqId + "_cargo");
    var especialidade = $('#' + UrbemSonata.uniqId + "_especialidade");
    
    var adcPrestadorServico = $('#' + UrbemSonata.uniqId + "_adcPrestadorServico");
    var infoTodos = $('#' + UrbemSonata.uniqId + "_infoTodos");
    
    var regSubCarEspStr = $('#' + UrbemSonata.uniqId + "_regSubCarEspStr");

    desabilitaCampoComExcecao([]);
    toggleInfoTodos(adcPrestadorServico.iCheck('update')[0].checked);
    
    adcPrestadorServico.on('ifChecked', function(){
    	toggleInfoTodos(true)
    });
    adcPrestadorServico.on('ifUnchecked', function(){
    	toggleInfoTodos(false)
    });
    
    regime.on('change', function(){
    	var values = $(this).val();
    	if (values == "") {
			return null;
		}
    	getAjaxData(
		    '/recursos-humanos/informacoes/configuracao/dirf/subdivisao-por-regime',
		    {'regimes': values},
		    subDivisao
    	);
    });
    
    subDivisao.on('change', function(){
    	var values = $(this).val();
    	if (values == "") {
			return null;
		}
    	getAjaxData(
		    '/recursos-humanos/informacoes/configuracao/dirf/cargos-por-subdivisao',
		    {'subdivisoes': values},
		    cargo
    	);
    });
    
    cargo.on('change', function(){
    	var values = $(this).val();
    	if (values == "") {
			return null;
		}
    	getAjaxData(
		    '/recursos-humanos/informacoes/configuracao/dirf/especialidade-por-cargo',
		    {'cargos': values},
		    especialidade
    	);
    });
    
    tipo.on("change", function () {
        switch (tipo.val()) {
            case "cgm_contrato_todos":
                desabilitaCampoComExcecao([cgmMatricula]);
                break;
            case "lotacao":
                desabilitaCampoComExcecao([lotacao]);
                break;
            case "local":
                desabilitaCampoComExcecao([local]);
                break;
            case "atributo_servidor":
            	desabilitaCampoComExcecao([]);
            	showAttrDinServidor();
            	break;
            case "atributo_pensionista":
            	desabilitaCampoComExcecao([]);
            	showAttrDinDependete();
            	break;
            case "reg_sub_fun_esp":
                desabilitaCampoComExcecao([regime, subDivisao, cargo, especialidade]);
                break;
            default:
                desabilitaCampoComExcecao([]);
        }
    });

    function desabilitaCampoComExcecao(camposExcecoes) {

        var campos = [
        	cgmMatricula, 
        	lotacao, 
        	local, 
        	atrDinamicoServidor, 
        	atrDinamicoPensionista, 
        	regime, 
        	subDivisao,
        	cargo,
        	especialidade
        ];

        campos.forEach(function(campo) {
            campo.select2('data', '');
            campo.select2('enable', false).removeAttr('required').closest('.form_row').addClass('hidden').removeClass('select2-container-multi-options-overflow');
        });
        
        $("#atributos-dinamicos").html('').addClass('hidden');
        
        camposExcecoes.forEach(function(campoExcecao) {
	        campoExcecao.select2('enable', true).attr('required', 'required').closest('.form_row').removeClass('hidden').addClass('select2-container-multi-options-overflow');
        });
    }
    
    function showAttrDinServidor() {
    	$("#atributos-dinamicos").removeClass('hidden');
    	
		atributoDinamicoParams = {
			codModulo: 22,
			codCadastro: 5
		};

		window.AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(atributoDinamicoParams);
	}

	function showAttrDinDependete() {
		$("#atributos-dinamicos").removeClass('hidden');
		
		atributoDinamicoParams = {
			codModulo: 22,
			codCadastro: 7
		};

		window.AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(atributoDinamicoParams);
	}
    
	$("#atributos-dinamicos").bind("DOMSubtreeModified",function(){
		$("#atributos-dinamicos").find('.form_row.s3').addClass('s6');
	});
	
	function toggleInfoTodos(check)
	{
		var action = check?'enable':'disable';
		infoTodos.iCheck(action);
		if (!check) {
			infoTodos.iCheck('uncheck');
		}
	}
	
	function getAjaxData(resource, filtro, tag)
	{
		clear(tag);
	    habilitarDesabilitar(tag, true);
	    ajax(resource, filtro, tag);
	}
	
	var sucesso = function (data, tag) {
	    habilitarDesabilitar(tag, false);
	    var tagName = tag.prop("tagName");
	    if (tagName == "SELECT") {
	        $.each(data.dados, function (index, value) {
	            var aux = tag.val();
	            if (index == aux) {
	                tag
	                    .append("<option value='" + index +"'>" + value + "</option>");
	            } else {
	                tag
	                    .append("<option value='" + index + "'>" + value + "</option>");
	            }
	        });
	        tag.select2();
	    }
	};
	var clear = function(select) {
		select.html("");
	};
	var ajax = function (url, dados, tag) {
	    jQuery.ajax({
	        url: url,
	        method: "POST",
	        data: dados,
	        dataType: "json",
	        success: function (data) {
	            sucesso(data, tag);
	        }
	    });
	};

	var habilitarDesabilitar = function habilitarDesabilitarSelect(target, optionBoolean) {
	    target.prop('disabled', optionBoolean);
	};
	
	$('form').on('submit', function(){
		if (tipo.val() == "reg_sub_fun_esp") {
			var aux = "";
			if (regime.val() != "") {
				aux += regime.val().join();
			}
			regime.select2('disable', true);
			aux += "#";
			if (subDivisao.val() != "") {
				aux += subDivisao.val().join();
			}
			subDivisao.select2('disable', true);
			aux += "#";
			if (cargo.val() != "") {
				aux += cargo.val().join();
			}
			aux += "#";
			cargo.select2('disable', true);
			if (especialidade.val() != "") {
				aux += especialidade.val().join();
			}
			especialidade.select2('disable', true);
			regSubCarEspStr.val(aux);
		}
	});
	
});
