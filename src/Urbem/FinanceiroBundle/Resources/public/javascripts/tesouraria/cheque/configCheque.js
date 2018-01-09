var config = {
    urlBanco: "/financeiro/tesouraria/cheque/agencias-por-banco/",
    urlAgencia: "/financeiro/tesouraria/cheque/cc-por-agencia/",
    urlLastNumCheque: "/financeiro/tesouraria/cheque/ultimo-cheque/",
    banco : jQuery("#" + UrbemSonata.uniqId + "_codBanco"),
    contaCorrente : jQuery("#" + UrbemSonata.uniqId + "_codContaCorrente"),
    agencia : jQuery("#" + UrbemSonata.uniqId + "_codAgencia"),
    lastNumCheque : jQuery("#" + UrbemSonata.uniqId + "_lastNumCheque"),
    numCheque : jQuery("#" + UrbemSonata.uniqId + "_numCheque"),
    opcaoTalaoNumCheque : jQuery("#" + UrbemSonata.uniqId + "_opcaoTalaoNumCheque"),
    wrapOpcaoTalaoNumCheque : jQuery("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_opcaoTalaoNumCheque"),
    opcaoTalao : jQuery("#" + UrbemSonata.uniqId + "_opcaoTalao")
};