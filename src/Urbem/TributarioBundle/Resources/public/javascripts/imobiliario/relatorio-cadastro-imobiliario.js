$(document).ready(function(){
	tipoRelatorio();
	$("#"+UrbemSonata.uniqId+"_tipoRelatorio").change(tipoRelatorio);
});

function tipoRelatorio(){
	var $tipoRelatorio = $('#'+UrbemSonata.uniqId+'_tipoRelatorio');
	
	var act = ($tipoRelatorio.val() == 'analitico'?'enable':'disable');
	$('.attr-relatorio').each(function(campo){
		$(this).select2(act);
	});
}