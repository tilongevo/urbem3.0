$(document).ready(function () {

	var copiarGrupoCredito = {
		initialize: function () {
			var $this = this;

			window.varJsExercicioOrigem = $('.js-select-exercicio-origem').val();

			$('body').on('change', '.js-select-exercicio-origem', function () {
				window.varJsExercicioOrigem = $(this).val();
			});
		}
	}

	copiarGrupoCredito.initialize();
}());
