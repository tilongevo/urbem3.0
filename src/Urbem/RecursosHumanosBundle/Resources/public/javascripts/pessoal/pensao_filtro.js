jQuery(function() {
    if (! UrbemSonata.checkModule('pensao'))
        return;

    jQuery('#filter-'+UrbemSonata.uniqId+'-tipoFiltro').after('<br clear="all" />');
    var config = {
        'filtros' : jQuery("#filter_tipoFiltro_value label div.iradio_square-blue .iCheck-helper"),
        'labelFiltro' : jQuery("#filter_tipoFiltro_value label"),
        'icoElement' : jQuery('#filter_tipoFiltro_value label .iradio_square-blue'),
        'checkedInput' : '#filter_tipoFiltro_value_0',
        'url' : window.location.href
    };

    var checkedIcon = config.icoElement.eq(0);
    var url = config.url.split('?');

    //Faz o checked no input e exibe o icon azul
    var checkedTipoFiltro = function (checkedInput,checkedIcon) {
        jQuery(checkedInput).attr('checked', 'checked');
        checkedIcon.addClass('checked', 'checked');
    };

    //Pega o valor do input checked para fazer o filtro url
    var callClickFiltro = function (url) {
        var value = jQuery('.iradio_square-blue.checked input').val();
        window.location.replace(url + "?filter[tipoFiltro][type]=" + value);
    };

    if (url[1]) {
        var select = url[1].split('=');
        if(select[1] == "1" || select[1] == "0"){
            config.checkedInput = '#filter_tipoFiltro_value_' + select[1];
            checkedIcon = config.icoElement.eq(select[1]);
            checkedTipoFiltro(config.checkedInput,checkedIcon);
        }
    }else{
        checkedTipoFiltro(config.checkedInput,checkedIcon);
    }

    config.labelFiltro.on('click',function () {
        callClickFiltro(url[0]);
    });
    config.filtros.on('click',function () {
        callClickFiltro(url[0]);
    });
});
