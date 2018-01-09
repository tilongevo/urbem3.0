var sucesso = function (data, tag) {
    habilitarDesabilitar(tag, false);
    var tagName = tag.prop("tagName");
    if (tagName == "SELECT") {
        $.each(data.dados, function (index, value) {
            var aux = tag.val();
            if (index == aux) {
                tag
                    .append("<option value=" + index + " selected>" + value + "</option>");
            } else {
                tag
                    .append("<option value=" + index + ">" + value + "</option>");
            }
        });
        tag.select2();
    }

    if (tagName == "INPUT") {
        var type = tag.prop("type");
        if (type == "text") {
            tag.val(data.value);
            config.numCheque.val((parseInt(data.value) + 1));
        }
    }
};
var clear = function(select) {
    select.empty().append("<option value=\"\">Selecione</option>").select2("val", "").val('').trigger("change");
};
var ajax = function (url, dados, tag) {
    jQuery.ajax({
        url: url,
        method: "POST",
        data: dados,
        dataType: "json",
        success: function (data) {
            sucesso(data, tag);
        }
    });
};

var habilitarDesabilitar = function habilitarDesabilitarSelect(target, optionBoolean) {
    target.prop('disabled', optionBoolean);
};