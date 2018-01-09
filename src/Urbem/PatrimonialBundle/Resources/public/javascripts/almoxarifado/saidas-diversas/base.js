(function ($) {
  'use strict';

  String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
  };

  $.saidasDiversasHelper = function () {
    return new SaidasDiversasHelper();
  };

  $.fieldBuilderHelper = function () {
    return new FieldBuilderHelper();
  };

  $.catalogoItemEndPoint = function (codItem) {
    return new CatalogoItemEndPoint().requestData(codItem);
  };

  $.perecivelEndPoint = function (codAlmoxarifado, codItem, codMarca, codCentro) {
    return new PerecivelEndPoint(codAlmoxarifado, codItem, codMarca, codCentro);
  };

  $.atributoDinamicoEndPoint = function (codItem, prefix) {
    return new AtributoDinamicoEndPoint(codItem, prefix);
  };

})(jQuery);

function SaidasDiversasHelper() {

  var uniqueId = UrbemSonata.uniqId
    , collectionItemAdminPrefix = uniqueId + "_fkAlmoxarifadoLancamentoMateriais_";

  /**
   * Retorna um prefixo dos campos de item.
   *
   * @returns {string}
   */
  this.getCollectionItemAdminPrefix = function () {
    return collectionItemAdminPrefix;
  };

  this.setCollectionItemAdminPrefix = function (prefix) {
    collectionItemAdminPrefix = prefix;
  };

  /**
   * Retorna o numero da collection recebendo um campo da mesma como parametro.
   *
   * @param field
   * @returns {*}
   */
  this.getFieldCollectionNumber = function (field) {
    var elementId = jQuery(field).attr('id').split('_');

    return elementId[2];
  };

  /**
   * Retornar todos os elementos input, select de uma collection especifica
   *
   * @param collectionNumber
   * @returns {*}
   */
  this.getFieldsInCollection = function (collectionNumber) {
    var partFieldName = collectionItemAdminPrefix + collectionNumber
      , fields
      , fieldsInCollection = {};

    fields = jQuery('input[id*=term], select[id*=term]'.replaceAll('term', partFieldName));

    jQuery.each(fields, function (index, elem) {
      var input = jQuery(elem)
        , elementId = input.attr('id').split('_')
        , objectKey = elementId[3] == "" ? elementId[4] : elementId[3];

      fieldsInCollection[objectKey] = input;
    });

    return fieldsInCollection;
  };

  /**
   * * Retornar todos os customs input de uma collection especifica
   *
   * @param collectionNumber
   * @returns {*}
   */
  this.getCustomInCollection = function (collectionNumber) {
    var partFieldName = collectionItemAdminPrefix + collectionNumber
      , customFields
      , customFieldsInCollection = {};

    customFields = jQuery('div[id^=term]'.replace('term', partFieldName));

    jQuery.each(customFields, function (index, elem) {
      var customElem = jQuery(elem)
        , elementId = customElem.attr('id').split('_');

      customFieldsInCollection[elementId[3]] = customElem;
    });

    return customFieldsInCollection;
  };

  /**
   * Return fieldset in collection.
   * @param field
   */
  this.getFieldsetInCollection = function (field) {
    var collectionNumber = this.getFieldCollectionNumber(field)
      , idStartsWith = 's'
      , idEndsWith = "_" + (parseInt(collectionNumber) + 1) + "_1"
      , idRegexp = "div[id^=starts][id$=ends].tab-pane";

    idRegexp = idRegexp
      .replace('starts', idStartsWith)
      .replace('ends', idEndsWith);

    return jQuery(idRegexp).find('div.sonata-ba-collapsed-fields');
  };

  this.getFieldContainer = function (field) {
    return field.parent().parent();
  };

  this.getFieldLabel = function (field) {
    return this.getFieldContainer(field).find('label');
  };

  this.removeRequired = function (field) {
    var fieldLabel = this.getFieldLabel(field);
    fieldLabel.removeClass('required');

    field.prop('required', false);
  };

  this.setAsInvisible = function (field) {
    this.removeRequired(field);
    this.getFieldContainer(field).hide();
  };

  this.setAsVisible = function (field) {
    this.setAsRequired(field);
    this.getFieldContainer(field).show();
  };

  this.setAsRequired = function (field) {
    var fieldLabel = this.getFieldLabel(field);
    fieldLabel.addClass('required');

    field.prop('required', true);
  };
}

function FieldBuilderHelper() {

  var fieldUniqueId = UrbemSonata.uniqId
    , fieldClass = ['campo-sonata', 'form-control']
    , fieldName
    , fieldType = 'text'
    , fieldId
    , field;

  var buildFieldName = function () {
    fieldName = fieldUniqueId + fieldName;
  }
    , buildFieldId = function () {
    fieldId = fieldUniqueId + '_' + fieldId;
  }
    , buildFieldClass = function () {
    fieldClass = fieldClass.join(" ");
  };

  /**
   * Set field unique id.
   *
   * @param uniqueId
   * @returns {FieldBuilderHelper}
   */
  this.setFieldUniqueId = function (uniqueId) {
    fieldUniqueId = uniqueId;

    return this
  };

  /**
   * Set value to fieldType property.
   *
   * @param type
   * @returns {FieldBuilderHelper}
   */
  this.setFieldType = function (type) {
    fieldType = this.type;

    return this;
  };

  /**
   * Get fieldType property value.
   *
   * @returns {*}
   */
  this.getFieldType = function () {
    return fieldType;
  };

  /**
   * Add class to field.
   *
   * @param className
   * @returns {FieldBuilderHelper}
   */
  this.addClassToField = function (className) {
    fieldClass.push(className);

    return this;
  };

  /**
   * Set field name.
   *
   * @param name
   * @returns {FieldBuilderHelper}
   */
  this.setFieldName = function (name) {
    fieldName = name;

    return this;
  };

  /**
   * Se id string of field.
   *
   * @param id
   */
  this.setFieldId = function (id) {
    fieldId = id;

    return this;
  };

  /**
   * Build field.
   *
   * @returns {FieldBuilderHelper}
   */
  this.build = function () {
    field = jQuery('<input/>');

    buildFieldClass();
    buildFieldName();
    buildFieldId();

    field
      .prop('id', fieldId)
      .prop('name', fieldName)
      .prop('class', fieldClass);

    return this;
  };

  /**
   * Return field.
   *
   * @returns {*}
   */
  this.getField = function () {
    return field;
  };
}

function CatalogoItemEndPoint() {

  var uriEndPoint = '/patrimonial/almoxarifado/catalogo-item/{coditem}/info';

  /**
   * @param codItem
   * @returns {*}
   */
  this.requestData = function (codItem) {

    uriEndPoint = uriEndPoint.replace('{coditem}', codItem);

    return jQuery.get(uriEndPoint);
  };
}

function PerecivelEndPoint(codAlmoxarifado, codItem, codMarca, codCentro) {
  var uriEndPoint = '/patrimonial/almoxarifado/perecivel/search/{codAlmoxarifado}/{codItem}/{codMarca}/{codCentro}';

  uriEndPoint = uriEndPoint
    .replace('{codAlmoxarifado}', codAlmoxarifado)
    .replace('{codItem}', codItem)
    .replace('{codMarca}', codMarca)
    .replace('{codCentro}', codCentro);

  this.requestData = function () {
    return jQuery.get(uriEndPoint);
  };

  this.requestDataAsHtml = function () {
    return jQuery.get(uriEndPoint, {mode: 'table'});
  };
}

function AtributoDinamicoEndPoint(codItem, prefix) {

  this.codItem = undefined;
  this.prefix = undefined;

  /**
   * @param codItem
   * @param prefix
   * @constructor
   */
  this.AtributoDinamicoEndPoint = function (codItem, prefix) {
    this.codItem = codItem;
    this.prefix = prefix !== undefined ? prefix : codItem;
  };

  /**
   * @returns {*}
   */
  this.requestData = function () {
    return jQuery.ajax({
      url: "/administrativo/administracao/atributo/consultar-campos/",
      method: "POST",
      data: {
        tabela: 'CoreBundle:Almoxarifado\\LancamentoMaterial',
        fkTabela: 'getFkAlmoxarifadoAtributoEstoqueMaterialValores',
        tabelaPai: 'CoreBundle:Almoxarifado\\CatalogoItem',
        codTabelaPai: {
          'codItem': codItem
        },
        fkTabelaPaiCollection: 'getFkAlmoxarifadoAtributoCatalogoItens',
        fkTabelaPai: 'getFkAlmoxarifadoAtributoCatalogoItem',
        prefix: prefix
      },
      dataType: "json"
    });
  };
}
