// para buscar as agencias
function factoryActionBanco(banco) {
    if (banco == "") {
        return;
    }
    clear(config.agencia);
    clear(config.contaCorrente);
    habilitarDesabilitar(config.agencia, true);
    habilitarDesabilitar(config.contaCorrente, true);
    config.lastNumCheque.val(0);
    config.numCheque.val(0);
    ajax(config.urlBanco, {banco: banco}, config.agencia);
}

config.banco.on("change", function() {
    factoryActionBanco(jQuery(this).val());
});

if (config.banco.val() == '') {
    clear(config.agencia);
} else {
    factoryActionBanco(config.banco.val());
}

// para buscar as contas corrente,
function factoryActionAgencia(banco, agencia) {
    if (banco == "" || agencia == "") {
        return;
    }
    clear(config.contaCorrente);
    habilitarDesabilitar(config.contaCorrente, true);
    ajax(config.urlAgencia, {banco: banco, agencia: agencia}, config.contaCorrente);
}
config.agencia.on("change", function() {
    factoryActionAgencia(config.banco.val(), jQuery(this).val());
});

if (config.agencia.val() == '') {
    clear(config.contaCorrente);
} else {
    factoryActionAgencia(config.banco.val(), config.agencia.val());
}

// para buscar o ultimo cheque cadastrado
function factoryActionContaCorrente(contaCorrente, banco, agencia) {
    if (contaCorrente == "" || banco == "" || agencia == "") {
        return;
    }
    ajax(config.urlLastNumCheque, {contaCorrente: contaCorrente, banco: banco, agencia: agencia}, config.lastNumCheque);
}
config.contaCorrente.on("change", function() {
    factoryActionContaCorrente(config.contaCorrente.val(), config.banco.val(), config.agencia.val());
});
if (config.lastNumCheque.val() == '') {
    config.lastNumCheque.empty();
} else {
    factoryActionContaCorrente(config.contaCorrente.val(), config.banco.val(), config.agencia.val());
}

//ações para o campo de talão de cheque
(function(){
    config.wrapOpcaoTalaoNumCheque.hide();
    config.opcaoTalao.on("change", function() {
        if (jQuery(this).val() == "talao") {
            config.wrapOpcaoTalaoNumCheque.show();
        }else{
            config.wrapOpcaoTalaoNumCheque.hide();
        }
    });
})();
