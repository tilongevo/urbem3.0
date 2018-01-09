function pagina($el) {
	if ($($el).parent().hasClass('disabled')) {
		return false;
	}
	
	var page = $($el).data('pagina');
	$('#acao_despesa_pagina').val(page);
	$('form[name=acao_despesa]').submit();
}

function actionInsert($el) {
	$('#incluir_despesa_codAno').val($($el).data('ano'));
	$('#incluir_despesa_codAcao').val($($el).data('codacao'));
	
	$('form[name=incluir_despesa]').submit();
}