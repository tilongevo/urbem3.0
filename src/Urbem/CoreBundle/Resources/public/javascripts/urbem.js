$(function() {
    'use strict';

    var Urbem = {
        createDeleteForm: function (action, data) {
            var form = $('<form name="form" action="' + action + '" method="POST"></form>');
            for (var input in data) {
                if (data.hasOwnProperty(input)) {
                    if (input == "_token") {
                        form.append('<input type="hidden" name="form[' + input + ']" value="' + data[input] + '">');
                    } else {
                        form.append('<input type="hidden" name="' + input + '" value="' + data[input] + '">');
                    }
                }
            }

            return form;
        },
        deleteItemList: function (action, token) {
            var form = this.createDeleteForm(action, {
                _method: 'DELETE',
                _token: token
            }).hide();

            $('body').append(form);
            form.submit();
        },
        submitDeleteForm: function () {

        }
    };

    $("button[data-action]").on("click", function() {
        Urbem.deleteItemList($(this).data("action"), $(this).data("token"));
    });

    $("div.deletar > a").on("click", function () {
        var r = confirm("Excluir esse registro?");
        if (r == true) {
          $("form[name='form']").submit();
        }
    });
});
