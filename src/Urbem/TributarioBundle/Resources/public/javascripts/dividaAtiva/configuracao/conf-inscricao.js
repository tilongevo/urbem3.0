var CONFIG_INSCRICAO = (function() {
   var private = {
      'TIPO_VALOR_REF_OPTION': '#' +  UrbemSonata.uniqId + '_tipoValorReferencia option',
      'TIPO_VALOR_REF': '#' +  UrbemSonata.uniqId + '_tipoValorReferencia',
      'WRAP_FORM': '#sonata-ba-field-container-' +  UrbemSonata.uniqId + '_',
      'VALOR_MOEDA': '#' + UrbemSonata.uniqId + '_valorReferencia__valorMoeda',
      'INPUT': '#' + UrbemSonata.uniqId + '_',
      'NAO': 'Não'
   };
   return {
      get: function(name) { return private[name]; }
   };
})();

var factoryObjeto = function (id, value) {
   var retorno = jQuery(CONFIG_INSCRICAO.get(id));
   if (value) {
      retorno = jQuery(CONFIG_INSCRICAO.get(id) + value);
   }
   return retorno;
};

var initOpcaoReferencia = function() {
   factoryObjeto('TIPO_VALOR_REF_OPTION').each(function()
   {
      factoryObjeto('INPUT', jQuery(this).val()).prop('required',false);
      factoryObjeto('WRAP_FORM', jQuery(this).val()).hide();
   });
   if (factoryObjeto('TIPO_VALOR_REF').val()) {
      factoryObjeto('WRAP_FORM', factoryObjeto('TIPO_VALOR_REF').val()).show();
   }
};

var clearInputs = function () {
   factoryObjeto('INPUT', 'valorReferencia__valorMoeda').val('');
   factoryObjeto('INPUT', "valorReferencia__minMax").select2("val", "").val('').trigger("change");
};

var habilitarDesabilitar = function (value) {
   var inputs = [
      factoryObjeto('INPUT', 'tipoValorReferencia'),
      factoryObjeto('INPUT', 'moeda'),
      factoryObjeto('INPUT', 'valorReferencia__minMax'),
      factoryObjeto('INPUT', 'valorReferencia__valorMoeda'),
      factoryObjeto('TIPO_VALOR_REF')
   ];

   inputs.forEach(function (element) {
      element.prop('disabled',true);
   });

   var disabled = false;
   if (value === CONFIG_INSCRICAO.get('NAO')) {
      factoryObjeto('TIPO_VALOR_REF').select2("val", "").val('').trigger("change");
      disabled = true;
   }

   inputs.forEach(function (element) {
      element.prop('disabled',disabled);
   });
};

jQuery(function() {
   initOpcaoReferencia();
   habilitarDesabilitar(factoryObjeto('INPUT', "utilizarValorReferencia").val());

   factoryObjeto('TIPO_VALOR_REF').on("change", function() {
      clearInputs();
      initOpcaoReferencia();
   });

   factoryObjeto('INPUT', "utilizarValorReferencia").on("change", function() {
      habilitarDesabilitar(jQuery(this).val());
   });
});

