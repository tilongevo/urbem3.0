$(document).ready(function() {

    var entidade = $("select#" + UrbemSonata.uniqId + "_codEntidade");
    disableForm();

    entidade.change(function() {
        var text = $("#" + UrbemSonata.uniqId + "_codEntidade option:selected").text();
        if (text) {
            enableForm();
            buscaParametros();
        } else {
            disableForm();
        }
    });

     //ObjectModal
    var modal = $.urbemModal();

    // Function Test
    function buscaParametros() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        $.post(UrlServiceProviderTCE, $("form").serializeArray())
            .success(function (data) {
                var count = 0;
                if (data.response == true) {
                    $.each(data, function(index, value) {
                        if  ($("#" + UrbemSonata.uniqId + "_" + index).length && index != "codEntidade") {
                            var input = $("#" + UrbemSonata.uniqId + "_" + index);
                            input.val(value);
                        }
                        count++;
                    });
                }
                if (count <= 1) {
                    $('input[type=text]').val('');
                }
                modal.close();
            }
            );
    }

    function disableForm()
    {
        $('input[type=text]').prop('disabled', true);
        $('input[type=text]').val('');
        $('input[type=submit]').prop('disabled', true);
    }

    function enableForm()
    {
        $('input[type=text]').prop('disabled', false);
        $(':input[type=submit]').prop('disabled', false);
    }
}());