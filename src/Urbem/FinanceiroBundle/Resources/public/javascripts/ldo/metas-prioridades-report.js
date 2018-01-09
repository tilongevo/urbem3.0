var config = {
    ppa : jQuery("#" + UrbemSonata.uniqId + "_ppa"),
    programa : jQuery("#" + UrbemSonata.uniqId + "_programa"),
    exercicioLdo : jQuery("#" + UrbemSonata.uniqId + "_exercicioLdo"),
    urlPrograma :  "/financeiro/ldo/metas-prioridades-report/programas-por-cod-ppa",
    urlExercicio : "/financeiro/ldo/metas-prioridades-report/exercicio-por-cod-ppa"
};

var clearExerciciosLdo = function() {
    config.exercicioLdo.empty().append("<option value=\"\">Selecione</option>").select2("val", "");
};

var clearPrograma = function() {
    config.programa.empty().append("<option value=\"\">Selecione</option>").select2("val", "");
};

var carregaExercicios = function (codPpa) {
    carregarDados(codPpa,config.urlExercicio);
};

var carregaProgramas = function (codPpa) {
    carregarDados(codPpa,config.urlPrograma);
};

var sucesso = function (data) {
    if (data.exercicios) {
        $.each(data.exercicios, function (index, value) {
            var exercicioLdo = config.exercicioLdo.val();
            if (index == exercicioLdo) {
                config.exercicioLdo
                    .append("<option value=" + index + " selected>" + value + "</option>");
            } else {
                config.exercicioLdo
                    .append("<option value=" + index + ">" + value + "</option>");
            }
        });
        config.programa.select2();
    }
    if (data.programas) {
        $.each(data.programas, function (index, value) {
            var programa = config.programa.val();
            if (index == programa) {
                config.programa
                    .append("<option value=" + index + " selected>" + value + "</option>");
            } else {
                config.programa
                    .append("<option value=" + index + ">" + value + "</option>");
            }
        });
        config.programa.select2();
    }
};

config.ppa.on("change", function() {
    var codPpa = $(this).val();

    clearExerciciosLdo();
    carregaExercicios(codPpa);

    clearPrograma();
    carregaProgramas(codPpa);
});

if (config.exercicioLdo.val() == '') {
    clearExerciciosLdo();
} else {
    carregaExercicios(codPpa);
}

if (config.programa.val() == '') {
    clearPrograma();
} else {
    carregaProgramas(codPpa);
}

function carregarDados(codPpa,url) {
    $.ajax({
        url: url,
        method: "POST",
        data: {codPpa: codPpa},
        dataType: "json",
        success: function (data) {
            sucesso(data);
        }
    });
};