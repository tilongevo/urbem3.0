// para buscar as agencias
function factoryActionBanco(banco) {
    if (banco == "") {
        return;
    }
    clear(config.agencia);
    clear(config.contaCorrente);
    clear(config.numCheque);
    habilitarDesabilitar(config.agencia, true);
    habilitarDesabilitar(config.contaCorrente, true);
    habilitarDesabilitar(config.numCheque, true);
    ajax(config.urlBanco, {banco: banco}, config.agencia);
}

config.banco.on("change", function() {
    factoryActionBanco(jQuery(this).val());
});

if (config.banco.val() == '') {
    clear(config.agencia);
} else {
    factoryActionBanco(config.agencia.val());
}


// para buscar as contas corrente
function factoryActionAgencia(banco, agencia) {
    if (banco == "" || agencia == "") {
        return;
    }
    clear(config.contaCorrente);
    clear(config.numCheque);
    habilitarDesabilitar(config.contaCorrente, true);
    habilitarDesabilitar(config.numCheque, true);
    ajax(config.urlAgencia, {banco: banco, agencia: agencia}, config.contaCorrente);
}
config.agencia.on("change", function() {
    factoryActionAgencia(config.banco.val(), jQuery(this).val());
});

if (config.agencia.val() == '') {
    clear(config.contaCorrente);
    clear(config.numCheque);
} else {
    factoryActionAgencia(config.contaCorrente.val());
}

//Buscar cheques da conta corrente
function factoryActionContaCorrenteCheque(banco, agencia, contaCorrente) {
    if (banco == "" || agencia == "" || contaCorrente == "") {
        return;
    }
    clear(config.numCheque);
    habilitarDesabilitar(config.numCheque, true);
    ajax(config.urlNumCheque, {banco: banco, agencia: agencia, contaCorrente: contaCorrente}, config.numCheque);
}
config.contaCorrente.on("change", function() {
    factoryActionContaCorrenteCheque(config.banco.val(), config.agencia.val(), config.contaCorrente.val());
});

if (config.contaCorrente.val() == '') {
    clear(config.numCheque);
} else {
    factoryActionContaCorrenteCheque(config.banco.val(), config.agencia.val(), config.contaCorrente.val(), jQuery(this).val());
}


