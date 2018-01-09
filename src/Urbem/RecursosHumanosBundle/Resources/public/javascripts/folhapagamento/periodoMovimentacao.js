(function ($, urbem, global) {
  'use strict';

  if ($("[name='_method']").val() == 'DELETE') {
      $('button').on('click', function () {
          abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde...</h4>', '');
      })
  }

  var dtInicial = $('#periodo_movimentacao_dtFinal'),
    dtFinal = $('#periodo_movimentacao_dtFinal'),
    contratos = $('#periodo_movimentacao_contratos'),
    contratosStr = $('#periodo_movimentacao_contratosStr'),
    modal,
    progressBar = $(".progress-bar")
  ;

  if (urbem.isFunction($.urbemModal)) {
    modal = $.urbemModal();
  }

  function addProgress(percentual) {
    var width = progressBar.width() + 15;
    progressBar.width(width);
  };

  var deletarInformacoesCalculo = function (codContrato, index, total, arrayContratos, contratosStr) {
    $.ajax({
      url: "/recursos-humanos/folha-pagamento/periodo-movimentacao/deletar-informacoes-calculo",
      data: {
        contratosStr: contratosStr
      },
      success: function (data) {
        if(total > 0) {
          consultaContrato(codContrato, index, total, arrayContratos);
        }
      }
    })
  };

  var abrirPeriodoMovimentacao = function (codContrato, index, total, arrayContratos, contratosStr) {
    $.ajax({
      url: "/recursos-humanos/folha-pagamento/periodo-movimentacao/abrir-periodo-movimentacao",
      data: {
        dtInicial: dtInicial.val(),
        dtFinal: dtFinal.val()
      },
      success: function (data) {
       deletarInformacoesCalculo(codContrato, index, total, arrayContratos, contratosStr);
      }
    })
  };

  var consultaContrato = function (codContrato, index, total, arrayContratos) {
    $.ajax({
      xhr: function () {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function (evt) {
          if (evt.lengthComputable) {
            var percentComplete = evt.loaded / contratos.val();
            addProgress(percentComplete * 100 + '%');
          }
        }, false);
        xhr.addEventListener("progress", function (evt) {
          if (evt.lengthComputable) {
            var percentComplete = evt.loaded / contratos.val();
            addProgress((percentComplete * 100) + '%');
          }
        }, false);
        return xhr;
      },
      url: "/recursos-humanos/folha-pagamento/periodo-movimentacao/monta-calcula-folha",
      data: {
        contrato: codContrato,
      },
      success: function (data) {
        if (index != (total - 1)) {
          var calc = index + 1;
          var percentComplete = (calc / total) * 100 + '%';
          $('.progress-bar').width(percentComplete);
          index++;
          consultaContrato(arrayContratos[index], index, total, arrayContratos);
        } else {
          $('.progress-bar').width('100%');
          modal.close();
          $("form[name='periodo_movimentacao']").submit();
        }
      }
    })
  };

  var createGroupedArray = function (arr, chunkSize) {
    var groups = [], i;
    for (i = 0; i < arr.length; i += chunkSize) {
      groups.push(arr.slice(i, i + chunkSize));
    }
    return groups;
  }

  jQuery('button[name="btn_create_and_list"]').on('click', function (event) {
    event.preventDefault();
    modal.disableBackdrop()
      .setBody(
        '<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Calculando Contratos...</h4>' +
        '<div class="container">\n' +
        '  <br>\n' +
        '  <div class="container">\n' +
        '    <div class="progress">\n' +
        '      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">\n' +
        '<span class="sr-only"></span>\n' +
        '</div>\n' +
        '    </div>\n' +
        '  </div>')
      .open();
    contratosStr = contratosStr.val();
    var arrayContratos = contratosStr.split(",");
    var arrayContratos = createGroupedArray(arrayContratos, 10);
    abrirPeriodoMovimentacao(arrayContratos[0], 0, arrayContratos.length, arrayContratos, contratosStr);
  });

    dtFinal.on('change', function () {
        validarData();
    });
    function validarData() {
        var minDate = convertStrToDate(dtFinal.attr('dp_min_date'));
        var maxDate = convertStrToDate(dtFinal.attr('dp_max_date'));
        var date = convertStrToDate(dtFinal.val());
        if (!((date > minDate) && (date <= maxDate))) {
            dtFinal.val(dtFinal.attr('dp_max_date'));
            UrbemSonata.setFieldErrorMessage('dtFinal', 'Data Final inválida! Data Final precisa ser maior que ' + dtFinal.attr('dp_min_date') + ' e menor ou igual a ' + dtFinal.attr('dp_max_date'), dtFinal.parent().parent());
        }
    }

    function convertStrToDate(str) {
        var res = str.split('/');
        return new Date(res[2], res[1], res[0]);
    }
})(jQuery, UrbemSonata, window);
