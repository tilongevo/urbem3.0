var UrbemSonata = UrbemSonata || {};

(function(){
  'use strict';

  var especialidade = $('#' + UrbemSonata.uniqId + '_cargoEspecialidade').prop("checked");
  if (especialidade) {
    showEspecialidade();
  } else {
    hideEspecialidade();
  }

  $('#' + UrbemSonata.uniqId + '_cargoEspecialidade').on('ifChecked', function() {
    showEspecialidade();
  });

  $('#' + UrbemSonata.uniqId + '_cargoEspecialidade').on('ifUnchecked', function() {
    hideEspecialidade();
  });

  function hideEspecialidade() {
    $('.dados-especialidade').hide();
    UrbemSonata.sonataFieldContainerShow('_codCboCargo');
    UrbemSonata.sonataFieldContainerShow('_codCargoPadrao');
    UrbemSonata.sonataFieldContainerHide('_espDescricao');
    UrbemSonata.sonataFieldContainerHide('_espCbo');
    UrbemSonata.sonataFieldContainerHide('_espPadrao');
    $('#' + UrbemSonata.uniqId + '_codCboCargo').attr('required', true);
    $('#' + UrbemSonata.uniqId + '_codCargoPadrao').attr('required', true);
    $('#' + UrbemSonata.uniqId + '_espDescricao').attr('required', false);
    $('#' + UrbemSonata.uniqId + '_espCbo').attr('required', false);
    $('#' + UrbemSonata.uniqId + '_espPadrao').attr('required', false);
  };

  function showEspecialidade() {
    $('.dados-especialidade').show();
    UrbemSonata.sonataFieldContainerHide('_codCboCargo');
    UrbemSonata.sonataFieldContainerHide('_codCargoPadrao');
    UrbemSonata.sonataFieldContainerShow('_espDescricao');
    UrbemSonata.sonataFieldContainerShow('_espCbo');
    UrbemSonata.sonataFieldContainerShow('_espPadrao');
    $('#' + UrbemSonata.uniqId + '_espDescricao').attr('required', true);
    $('#' + UrbemSonata.uniqId + '_espCbo').attr('required', true);
    $('#' + UrbemSonata.uniqId + '_espPadrao').attr('required', true);
    $('#' + UrbemSonata.uniqId + '_codCboCargo').attr('required', false);
    $('#' + UrbemSonata.uniqId + '_codCargoPadrao').attr('required', false);
  };

  var options = [];
  var selectOptions = [];
  var selecteds = [];

  function getAllOptionsSubDivisao() {
      $(document).find('select[id*=_codSubDivisao]').each(function () {
        $(this).find('option').each(function () {
          if ($(this).val() > 0) {
            selecteds.push($(this).val());
          }
        });
        return false;
      });
  }

  function checkItemDefault(element, defaultValue) {

  }

  if (typeof currentRequestId === 'undefined' || !currentRequestId > 0) {
    getAllOptionsSubDivisao();

    var t = 0;
    $(document).find('select[id*=_codSubDivisao]').each(function(){
      $(this).val(selecteds[t]);
      t++;
    });
  }

  $(document).find('select[id*=_codSubDivisao]').each(function(){
      var selectId = $(this).attr('id');
      var selectedOption = $(this).find('option:selected');

      if ($(selectedOption).val() > 0 && typeof selectOptions[selectId] === 'undefined') {
        selectOptions[selectId] = $(selectedOption).val();
        selecteds.push($(selectedOption).val());
      } else if($(selectedOption).val() > 0 &&  selectOptions[selectId] != $(selectedOption).val()) {
        var index = selecteds.indexOf(selectOptions[selectId]);
        selecteds.splice(index, 1);

        selecteds.push($(selectedOption).val());
        selectOptions[selectId] = $(selectedOption).val();
      }

      if (options.length === 0) {
        $(this).find('option').each(function(){
          options.push($(this).val());
        });
      }
      if ((selecteds.length) >= ((options.length)-1)) {
        $('#field_actions_' + UrbemSonata.uniqId + '_codCargoSubDivisao').hide();
        $('#field_actions_' + UrbemSonata.uniqId + '_codCargoEspecialidadeSubDivisao').hide();
      }
  });

  $(document).find('select[id*=_codSubDivisao]').each(function(){
      var elem = this;
      $(this).find('option').each(function(){
          if ($.inArray($(this).val(), selecteds) > -1) {
            if (selectOptions[$(elem).attr('id')] == $(this).val()) $(this).attr('disabled', false);
            else $(this).attr('disabled', true);
          } else {
            $(this).attr('disabled', false);
          }
      });
  });

  $(document).on('sonata.add_element', function() {
    var selects = $(document).find('select[id*=_codSubDivisao]');
    $.each(selects, function () {
      if (options.length === 0) {
        $("#" + $(this).attr('id') + " option").each(function() {
          options.push($(this).val());
        });
      }
    });
    if (((selects.length) >= ((options.length)-1))&&(options.length != 0)) {
      $('#field_actions_' + UrbemSonata.uniqId + '_codCargoSubDivisao').hide();
      $('#field_actions_' + UrbemSonata.uniqId + '_codCargoEspecialidadeSubDivisao').hide();
    }
  });

  $(document).on('sonata.add_element', function() {
    var selects = $(document).find('select[id*=_codSubDivisao]');
    $.each(selects, function () {
      var selectElem = this;

      var selectedOption = $(selectElem).find('option:selected');

      $("#" + $(selectElem).attr('id') + " option").each(function() {
        if ($(this).val() != $(selectedOption).val()) {

          if($.inArray($(this).val(), selecteds) > -1) $(this).attr('disabled', true);
          else $(this).attr('disabled', false);
        }
      });
    });
  });

  $(document).on('change', 'select[id*=_codSubDivisao]', function(e) {
    e.stopPropagation();

    var selectId = $(this).attr('id');
    var selectedOption = $(this).find('option:selected');

    if (typeof selectOptions[selectId] === 'undefined') {
      selectOptions[selectId] = $(selectedOption).val();
      selecteds.push($(selectedOption).val());
    } else if(selectOptions[selectId] != $(selectedOption).val()) {
      var index = selecteds.indexOf(selectOptions[selectId]);
      selecteds.splice(index, 1);

      selecteds.push($(selectedOption).val());
      selectOptions[selectId] = $(selectedOption).val();
    }

    $(document).find('select[id*=_codSubDivisao]').each(function(){
        var elem = this;
    		$(this).find('option').each(function(){
            if ($.inArray($(this).val(), selecteds) > -1) {
              if (selectOptions[$(elem).attr('id')] == $(this).val()) $(this).attr('disabled', false);
              else $(this).attr('disabled', true);
            } else {
              $(this).attr('disabled', false);
            }
    		});
  	});
  });
}());
