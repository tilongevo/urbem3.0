var config = {
    periodicidade: jQuery("#" + UrbemSonata.uniqId + "_periodicidade"),
    dia: jQuery("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_dia"),
    mes: jQuery("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_mes"),
    ano: jQuery("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_ano"),
    intervaloDe: jQuery("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_intervaloDe"),
    intervaloAte: jQuery("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_intervaloAte")
};

config.periodicidade.val("1");
config.dia.hide();
config.ano.hide();
config.intervaloDe.hide();
config.intervaloAte.hide();

var habilitar = function (valor) {
    config.dia.hide();
    config.dia.find("#" + UrbemSonata.uniqId + "_dia").val("");
    config.mes.hide();
    config.ano.hide();
    config.intervaloDe.hide();
    config.intervaloDe.find("#" + UrbemSonata.uniqId + "_intervaloDe").val("");
    config.intervaloAte.hide();
    config.intervaloAte.find("#" + UrbemSonata.uniqId + "_intervaloAte").val("");

    if (valor == '0') {
        config.dia.show();

        config.intervaloDe.find("#" + UrbemSonata.uniqId + "_intervaloDe").prop('required', false);
        config.intervaloAte.find("#" + UrbemSonata.uniqId + "_intervaloAte").prop('required', false);
    }
    else if (valor == '1') {
        config.mes.show();

        config.dia.find("#" + UrbemSonata.uniqId + "_dia").prop('required', false);
        config.intervaloDe.find("#" + UrbemSonata.uniqId + "_intervaloDe").prop('required', false);
        config.intervaloAte.find("#" + UrbemSonata.uniqId + "_intervaloAte").prop('required', false);
    }
    else if (valor == '2') {
        config.ano.show();

        config.dia.find("#" + UrbemSonata.uniqId + "_dia").prop('required', false);
        config.intervaloDe.find("#" + UrbemSonata.uniqId + "_intervaloDe").prop('required', false);
        config.intervaloAte.find("#" + UrbemSonata.uniqId + "_intervaloAte").prop('required', false);
    }
    else if (valor == '3') {
        config.intervaloDe.show();
        config.intervaloAte.show();

        config.dia.find("#" + UrbemSonata.uniqId + "_dia").prop('required', false);
    }

};

config.periodicidade.on("change", function () {
    var valor = $(this).val();
    habilitar(valor);
});
