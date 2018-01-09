$(document).ready(function() {

    $(".btn_meta").on("click", function() {
        var numPrograma = $(this).attr('data-numPrograma');
        var codPpa = $(this).attr('data-codPpa');

        if ($(this).html() == 'add') {
            if ($('#meta_' + numPrograma).html() != '') {
                $('#meta_' + numPrograma).show();
                $(this).html('remove');
                return ;
            }

            $.ajax({
                url: "/financeiro/api/search/ppa/consulta-ppa-acao?codPpa=" + codPpa + "&numPrograma=" + numPrograma,
                method: "GET",
                dataType: "json",
                success: function (data) {
                    $('#meta_' + numPrograma).html(data);
                }
            });

            $('#meta_' + numPrograma).show();
            $(this).html('remove');
        } else {
            $('#meta_' + numPrograma).hide();
            $(this).html('add');  
        }
    });
});
