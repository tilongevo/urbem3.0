(function ($) {
  jQuery(function () {
    jQuery(document).find('.button-collapse').sideNav();
    jQuery(document).find('.parallax').parallax();

    jQuery(document).find('.sonata-medium-date').mask("99/99/9999");
    jQuery(document).find('.date input').mask("99/99/9999");
    jQuery(document).find('input.horacampo-sonata ').mask("99:99");

    jQuery(document).find('input.fone')
      .mask('(00) 0000-00009')
      .attr('maxlength', 15);

    jQuery(document).find("input.money").each(function( index ) {
        var price = jQuery( this ).val();
        if ( !UrbemSonata.checkModule('financeiro') ) {
            if ( price != '' ) {
                if ( price.indexOf(',') == -1 ) {
                    price = price + ',00';
                }

                if ( price.indexOf(',') != -1 ) {
                    price = price.padRight(price.indexOf(',') + 3);
                }
                jQuery(this).val(price);
            }
            jQuery(this).mask('#.##0,00', { reverse: true });
        } else {
            jQuery(this).mask('#.##0,00', { reverse: true });
        }
    });

    jQuery(document).find("input.decimal").mask('#.##0,00', { reverse: true });
    jQuery(document).find('input.quantity').mask('#.##0,0000', { reverse: true });
    jQuery(document).find('input.percent').mask('##0,00', { reverse: true });
    jQuery(document).find('input.percent').on('focus', function (event) { this.select(); });
    jQuery(document).find('input.percentNew').mask('000,00', {reverse: false});
    jQuery(document).find('input.km').mask('000.000', { reverse: true });
    jQuery(document).find('input.ano').mask('0000', {reverse: false});
    jQuery(document).find('input.numero').mask('0#');

    jQuery(document).find('input.percentNew').on('focus', function (event) { this.select(); });
    jQuery(document).find('input.km').on('focus', function (event) { this.select(); });


    jQuery(document).find('input.alfa').on( "keyup", function() {
        var value = $(this).val();
        var valueExp = value.replace(/\W/g, "");
        $(this).val(valueExp);
    });
      jQuery(document).find('input.numeric').mask('#0', { reverse: true });
  });

  jQuery(document).on('submit', 'form', function() {
    jQuery("input.money").each(function( index ) {
      jQuery( this ).val((jQuery(this).val().replace(/\./g,'') ).replace(/\,/g,'.'));
    });

    jQuery("input.quantity").each(function( index ) {
      jQuery(this).val((jQuery(this).val().replace(/\./g,'')).replace(/\,/g,'.'));
    });

    jQuery("input.decimal").each(function( index ) {
      jQuery(this).val((jQuery(this).val().replace(/\./g,'')).replace(/\,/g,'.'));
    });
  });

  $(document).ready(function () {
    $("input[data-mask]").each(function (index) {
      var campo = $(this)
        , mascara = campo.attr('data-mask')
        , mascaraReversa = campo.attr('data-mask-reverse');

      campo.mask(mascara, { placeholder: mascara.replaceAll('9', 0) });
    });
  });
})(jQuery);

var quantityUnmask = function() {
  jQuery("input.quantity").each(function( index ) {
    var val = $(this).val();
    val = val
      .replace(/\./g, '')
      .replace(/\,/g, '.');
    $(this).val(val);
  });
};

var quantityMask = function() {
  jQuery(document).find('input.quantity').mask('#.##0,0000', { reverse: true });
};

var moneyUnmask = function() {
  $("input.money,input.km").each(function (index) {
    var val = $(this).val();
    val = val
      .replace(/\./g, '')
      .replace(/\,/g, '.');
    $(this).val(val);
  });
};

var moneyMask = function() {
  $(document).find("input.money").each(function( index ) {
    var val = jQuery( this ).val();
    var milharSep = '.';
    var decimalSep = ',';

    if (UrbemSonata.checkModule('financeiro')) {
      milharSep = ',';
      decimalSep = '.'
    }

    if( val.indexOf(decimalSep) < val.indexOf(milharSep) ) {
      val = val
        .replace(/\,/g, '')
        .replace(/\./g, ',');
    }

    if (val != ''){
      if(val.indexOf(decimalSep) == -1) {
        val = val + decimalSep + '00';
      }

      if(val.indexOf(decimalSep) != -1) {
        val = val.padRight(val.indexOf(decimalSep) + 3);
      }
      jQuery(this).val(val);
    }

    jQuery(this).mask('#' + milharSep + '##0' + decimalSep + '00', { reverse: true });
  });
};

$(document).on('sonata.add_element', moneyMask);

function StringUrbem() {}

StringUrbem.prototype = {};

jQuery.fn.StringUrbem = function(){
  var pattern = /[-()]+/g;

  this.clearString = function(patternReceived) {
    string = jQuery(this).val();

    if (string !== undefined) {
      jQuery(this).val(string.replace(
        (patternReceived == undefined)
          ? pattern
          : patternReceived
        , ''
      ));
    }
  };

  return this;
};

jQuery('.button-collapse').sideNav({
  menuWidth: 300,
  edge: 'right',
  closeOnClick: true
});

var modalLoad;

/**
 * Função para abrir um modal simples na tela, com título e corpo
 * @param title
 * @param body
 */
function abreModal(title,body){
  if(typeof modalLoad == 'undefined') {
    modalLoad = new UrbemModal();
  }

  modalLoad.setTitle(title);
  modalLoad.setBody(body);
  modalLoad.disableBackdrop();
  modalLoad.open();
}

/**
 * Função para fechar um modal aberto
 */
function fechaModal(){
  if(typeof modalLoad != 'undefined') {
    modalLoad.close();
  }
}

String.prototype.padRight = function(length, char) {
  if (char == null) {
    char = '0';
  }
  var str = this.toString();
  while (str.length < length) str =  str + char;
  return str;
};

String.prototype.replaceAll = function(str1, str2, ignore)
{
  return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
};

function float2moeda(num) {
  x = 0;
  if(num<0) {
    num = Math.abs(num);
    x = 1;
  }
  if(isNaN(num)) num = "0";
  cents = Math.floor((num*100+0.5)%100);
  num = Math.floor((num*100+0.5)/100).toString();
  if(cents < 10) cents = "0" + cents;
  for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
    num = num.substring(0,num.length-(4*i+3))+'.'
        +num.substring(num.length-(4*i+3));
  ret = num + ',' + cents;
  if (x == 1) ret = ' - ' + ret;return ret;
}

var formataInputs = function (input) {
  var valorNovo = input.val().replaceAll(".", "").replaceAll(",",".");
  input.val(float2moeda(valorNovo));
};

$(document).ready(function() {
  var classeMaskMonetaria = jQuery('.mask-monetaria');

  classeMaskMonetaria.each(function( index ) {
    jQuery(this).val(float2moeda(jQuery(this).val()));
  });

  classeMaskMonetaria.focusout(function() {
    if (!jQuery(this).val()) {
      return false;
    }
    formataInputs(jQuery(this));
  });

  classeMaskMonetaria.focus("input", function() {
    if (! $(this).is('[readonly]') ) {
      if ($(this).val() == "0,00" || $(this).val() == "0") {
        $(this).val("")
      }
    }
  });

  $( "form" ).submit(function( event ) {
    classeMaskMonetaria.each(function( index ) {
      jQuery(this).val(jQuery(this).val().replaceAll(".", "").replaceAll(",","."));
    });
  });

  function escapeRegExpInit(str) {
    var paraNove = str.replace(/[\w\s\d]/gi, '9');
    return paraNove.replace(/[\s)(-+-_=§¨,*<>;:^/~!@#%&|]/gi, '.');
  }

  function escapeRegExpOn(str) {
    var paraNove = str.replace(/[a-zA-Z0-8]/gi, "");
    return paraNove.replace(/[\s)(-+-_=§¨,*<>;:^/~!@#%&|]/gi, "")
  }

  var classeMaskClassificacao = jQuery('.mask-classifacao');
  classeMaskClassificacao.each(function( index ) {
    jQuery(this).val(escapeRegExpInit($(this).val()));
  });

  classeMaskClassificacao.on("input", function() {
    jQuery(this).val(escapeRegExpOn($(this).val()));
  });
});

/**
 * Function Menu Module Events
 */
$(document).ready(function () {
    function menuModuleEvents() {
        var totalNumberModules = $(".menu-module li").length;

        switch (totalNumberModules) {
            case 1:
                $(".menu-module").addClass("one-item");
                break;
            case 2:
                $(".menu-module").addClass("two-items");
                break;
            case 3:
                $(".menu-module").addClass("three-items");
                break;
            case 4:
                $(".menu-module").addClass("four-items");
                break;
            case 5:
                $(".menu-module").addClass("five-items");
                break;
            case 6:
                $(".menu-module").addClass("six-items");
                break;
            case 7:
                $(".menu-module").addClass("seven-items");
                break;
            default:
                $(".menu-module").addClass("many-items");
        }

        $(".click-to-toggle").click(function (event) {
            $(".menu-module .gridbox").fadeToggle();
            $(".menu-module .arrow").fadeToggle();
            event.stopPropagation();
        });

        $("body").click(function () {
            $(".menu-module .gridbox").fadeOut();
            $(".menu-module .arrow").fadeOut();
        });

        $(".menu-module li").mouseover(function () {
            $(this).find("span.text").addClass("show-complete");
        });

        $(".menu-module li").mouseout(function () {
            $(this).find("span.text").removeClass("show-complete");
        });
    }

    menuModuleEvents();
});