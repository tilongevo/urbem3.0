$(document).ready(function () {

	var modalTitle = 'Anular Requisição';

	var modalContent = '<div class="sonata-ba-form">'+
			'<div class="row">'+
				'<div class="box box-primary">'+
					'<div class="box-body">'+
						'<div class="sonata-ba-collapsed-fields">'+
							'<div class="form_row col s12 campo-sonata">'+
								'<form method="POST" action="/compras-governamentais/requisicoes/anular/{id}">'+
									'<label class="control-label">Motivo*</label>'+
									'<div class="sonata-ba-field sonata-ba-field-standard-natural">'+
										'<textarea name="motivo" class="form-control" required></textarea>'+
									'</div>'+
									'<br>'+
									'<div class="sonata-ba-form-actions well well-small form-actions row">'+                                                                                                                                                                
										'<div class="col s12">'+
                                    		'<div class="col s8 initial">'+
                                                '<a class="btn-floating white-text blue darken-4 btn-success js-modal-close" href="#"><i class="material-icons">arrow_back</i>{</a>'+
                                            '</div>'+
                                    		'<div class="col s4 right-align initial">'+
                                            	'<button type="submit" class="white-text blue darken-4 btn btn-success save">'+
                                            		'<i class="fa fa-ban"></i> '+
                                            		'Anular'+
                                            	'</button>'+
                                            '</div>'+
                                		'</div>'+
                                    '</div>'+
								'</form>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>';

	var requisicao = {
		initialize: function () {
			var modal = $.urbemModal();

			$('.js-btn-anular').on('click', function (e) {
				e.preventDefault();

				var uri = location.pathname.split('/');
				var id = uri[uri.length-2];

				modalContent = modalContent.replace('{id}', id);

				modal.setTitle(modalTitle).setContent(modalContent).open();
			});

			$('body').on('click', '.js-modal-close', function (e) {
				e.preventDefault();

				modal.close();
			});
		}
	}

	requisicao.initialize();
}());
