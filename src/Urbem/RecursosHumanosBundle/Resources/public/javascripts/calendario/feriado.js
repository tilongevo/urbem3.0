$(document).ready(function (){
    var setFeriado = 'input[name="' + UrbemSonata.uniqId + '[tipoferiado]"]';
    var setAbrangOptions = 'input[name="' + UrbemSonata.uniqId + '[abrangencia]"]';
    var listAbrang = '#' + UrbemSonata.uniqId + '_abrangencia';

    $(listAbrang).prop('disabled', false);
    $(setAbrangOptions).prop('disabled', true);

    $(setFeriado).on('ifChecked', function() {
        var tipo = $(this).val();
        switch (tipo){

            case 'F':
                releaseAbrang()
                break;
            case 'V':
                releaseAbrang()
                break;
            case 'P':
                blockAbrang();
                break;
            case 'D':
                blockAbrang();
                break;
        }
    });

    function blockAbrang(){
        $(listAbrang).prop('disabled', true);
        $(listAbrang).val('').change();
        $(setAbrangOptions).prop('disabled', true);
        console.log('hide');
    }

    function releaseAbrang(){
        $(listAbrang).prop('disabled', false);
        if($(listAbrang).val() == ''){
            $(listAbrang).val('F').change();
        }
        $(setAbrangOptions).prop('disabled', false);
        $(listAbrang).css({ opacity: 1 });
    }

});
