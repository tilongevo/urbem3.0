var CONFIG_DOCUMENTOS = (function() {
   var private = {
      'INPUT': '#' + UrbemSonata.uniqId + '_',
      'URL_DOCUMENTOS': '/tributario/divida-ativa/configuracao/configurar-documentos/',
      'DADOS' : '',
      'SHOW_OPTION_1': ['campo-extra'],
      'SHOW_OPTION_2': ['ce-1', 'ce-3']
   };
   return {
      get: function(name) { return private[name]; },
      set: function(name, value) { private[name] = value; }
   };
})();

var sucesso = function(data, select) {
   factoryObjeto('INPUT', select).prop('disabled', false);
   factoryObjeto('INPUT', 'secretaria').val(data.dados.secretaria);
   factoryObjeto('INPUT', 'setorArrecadacao').val(data.dados.setor_arrecadacao);
   factoryObjeto('INPUT', 'coordenador').val(data.dados.coordenador);
   factoryObjeto('INPUT', 'chefeDepartamento').val(data.dados.chefe_departamento);
   factoryObjeto('INPUT', 'mensagem').val(data.dados.msg_doc);
   factoryObjeto('INPUT', 'leiMunicipalCertidaoDA').val(data.dados.nro_lei_inscricao_da);
   factoryObjeto('INPUT', 'metodologiaCalculo').val(data.dados.metodologia_calculo);
   factoryObjeto('INPUT', 'incidenciaSobreValorDebitoDA').val(data.dados.utilincval_doc);
};

var ajax = function (url, select) {
   factoryObjeto('INPUT', select).prop('disabled', true);
   jQuery.ajax({
      url: url,
      method: "GET",
      dataType: "json",
      success: function (data) {
         sucesso(data, select);
      }
   });
};


var factoryObjeto = function (id, value) {
   var retorno = jQuery(CONFIG_DOCUMENTOS.get(id));
   if (value) {
      retorno = jQuery(CONFIG_DOCUMENTOS.get(id) + value);
   }
   return retorno;
};

var initDocumentos = function() {
   var dados = [];
   factoryObjeto('INPUT', "documentos option").each(function()
   {
      if (jQuery(this).val()) {
         switch(jQuery(this).val()) {
            case '1':
               dados.push({
                  option: jQuery(this).val(),
                  show:  CONFIG_DOCUMENTOS.get('SHOW_OPTION_1')
               });
               break;
            case '2':
               dados.push({
                  option: jQuery(this).val(),
                  show:  CONFIG_DOCUMENTOS.get('SHOW_OPTION_2')
               });
               break;
            default:
               dados.push({
                  option: jQuery(this).val(),
                  show: null
               });
         }
      }
   });
   CONFIG_DOCUMENTOS.set('DADOS', dados);
   factoryObjeto('INPUT', 'chefeDepartamento').prop('required', false);
   factoryObjeto('INPUT', 'mensagem').prop('required', false);
   factoryObjeto('INPUT', 'leiMunicipalCertidaoDA').prop('required', false);
   factoryObjeto('INPUT', 'metodologiaCalculo').prop('required', false);
   factoryObjeto('INPUT', 'incidenciaSobreValorDebitoDA').prop('required', false);
};

var exibeCamposPorDocumentos = function (option) {
   jQuery('.campo-extra').prop('disabled',true);
   if (CONFIG_DOCUMENTOS.get('DADOS')) {
      jQuery.each(CONFIG_DOCUMENTOS.get('DADOS'), function (index, value) {
         if (value.option == option) {
            if (value.show) {
               value.show.forEach(function (item) {
                  jQuery('.' + item).prop('disabled', false);
               });
            }
            ajax(CONFIG_DOCUMENTOS.get('URL_DOCUMENTOS') + option, "documentos");
         }
      });
   }
};

jQuery(function() {
   initDocumentos();
   exibeCamposPorDocumentos();
   factoryObjeto('INPUT', "documentos").on("change", function() {
      exibeCamposPorDocumentos(jQuery(this).val());
   });
});

