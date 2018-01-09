$(document).ready(function () {

	var modalTitle = 'Recusar Requisição';

	var modalContent = '<div class="sonata-ba-form">'+
			'<div class="row">'+
				'<div class="box box-primary">'+
					'<div class="box-body">'+
						'<div class="sonata-ba-collapsed-fields">'+
							'<div class="form_row col s12 campo-sonata">'+
								'<form method="POST" action="/compras-governamentais/controle-itens/recusar-requisicao/{id}">'+								
									'<p>Deseja recusar esta requisição?</p>'+
									'<div class="sonata-ba-form-actions well well-small form-actions row">'+                                                                                                                                                                
										'<div class="col s12">'+
											'<div class="col s6 center-align initial">'+
                                            	'<button type="submit" class="white-text red darken-4 btn btn-danger js-modal-close">'+
                                            		'<i class="fa fa-arrow-left"></i> '+
                                            		'Não'+
                                            	'</button>'+
                                            '</div>'+
                                    		'<div class="col s6 center-align initial">'+
                                            	'<button type="submit" class="white-text blue darken-4 btn btn-success save">'+
                                            		'<i class="fa fa-thumbs-down"></i> '+
                                            		'Sim'+
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

	var controleItens = {
		initialize: function () {
			var modal = $.urbemModal();

			$('body').on('click', '.js-requisicao-recusar', function (e) {
				e.preventDefault();

				var me = $(this);

				modalContent = modalContent.replace('{id}', me.attr('data-id'));

				modal.setTitle(modalTitle).setContent(modalContent).open();
			});

			$('body').on('click', '.js-modal-close', function (e) {
				e.preventDefault();

				modal.close();
			});

			$('body').on('ifChanged', '.js-tipo-autorizacao', function (e) {
				e.preventDefault();

				var tipoAutorizacao = $('[name$="[tipoAutorizacao]"]:checked');
				if (tipoAutorizacao.val() == 'autorizada-total') {
					UrbemSonata.giveMeBackMyField('qtdAprovada').removeAttr('required').closest('.form_row').hide();
					UrbemSonata.giveMeBackMyField('recusarPendente').removeAttr('required').closest('.form_row').hide();

					return;
				}

				UrbemSonata.giveMeBackMyField('qtdAprovada').attr('required', 'required').closest('.form_row').show();
				UrbemSonata.giveMeBackMyField('recusarPendente').attr('required', 'required').closest('.form_row').show();
			});

			$('.js-tipo-autorizacao').trigger('ifChanged');
		}
	}

	controleItens.initialize();
}());
