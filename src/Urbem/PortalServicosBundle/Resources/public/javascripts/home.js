$(document).ready(function () {

	var rowTemplate = '<tr>\
		<td>\
			<a href="{url}">\
				<i class="material-icons">description</i>\
				{codInscricao}\
			</a>\
		</td>\
		<td>\
			{situacao}\
		</td>\
	</tr>';

	var home = {
		populateImoveis: function () {
			var $this = this;

			var baseUrl = '/portal-cidadao/consulta-imovel';

			$.ajax({
				method: 'GET',
				url: baseUrl + '/export?orderBy=timestamp&sort=desc',
				dataType: 'json',
				success: function (data) {
					if (!data.length) {
						$('#chart-meus-imoveis')
							.css("background", "url('/bundles/portalservicos/images/chart1.png') no-repeat center")
							.find('img')
							.css('display', 'block');
						
						$('.js-table-lista-imoveis tbody').append('<tr><td colspan="2">Nenhum registro encontrado!</td></tr>');

						return;
					}

					var rows = [];
					var imoveis = {};
					var colors = [];
					$.each(data, function (index, imovel) {
						imoveis[imovel.situacao] = imoveis[imovel.situacao] ? ++imoveis[imovel.situacao] : 1;
						if (index > 5) {
							return true;
						}

						template = rowTemplate.replace('{url}', $this.imoveisBaseUrl + '/' + imovel.inscricaoMunicipal + '/relatorio')
							.replace('{codInscricao}', imovel.inscricaoMunicipal)
							.replace('{situacao}', imovel.situacao);

						rows.push(template);
						colors.push($this.getRandomColor());
					});

					var imoveisTotal = [];
					$.each(imoveis, function (situacao, total) {
						imoveisTotal.push({label: situacao, value: total});
					});

					Morris.Donut({
	                    element: 'chart-meus-imoveis',
	                    data: imoveisTotal,
	                    resize: true,
	                    hideHover: 'auto',
	                    colors: colors,
	                });
					
					$('.js-table-lista-imoveis tbody').append(rows);
				}
			});
		},
		populateCadastroEconomico: function () {
			var $this = this;

			var baseUrl = '/portal-cidadao/cadastro-economico/consulta';

			$.ajax({
				method: 'GET',
				url: baseUrl + '/export?orderBy=timestamp&sort=desc',
				dataType: 'json',
				success: function (data) {
					if (!data.length) {
						$('#chart-inscricao-economica')
							.css("background", "url('/bundles/portalservicos/images/chart2.png') no-repeat center")
							.find('img')
							.css('display', 'block');

						$('.js-table-lista-cadastro-economico tbody').append('<tr><td colspan="2">Nenhum registro encontrado!</td></tr>');

						return;
					}

					var rows = [];
					var inscricaoEconomica = {};
					var colors = [];
					$.each(data, function (index, cadastroEconomico) {
						inscricaoEconomica[cadastroEconomico.situacao] = inscricaoEconomica[cadastroEconomico.situacao] ? ++inscricaoEconomica[cadastroEconomico.situacao] : 1;
						if (index > 5) {
							return true;
						}

						template = rowTemplate.replace('{url}', baseUrl + '/' + cadastroEconomico.inscricaoEconomica + '/show')
							.replace('{codInscricao}', cadastroEconomico.inscricaoEconomicaLabel)
							.replace('{situacao}', cadastroEconomico.situacao);

						rows.push(template);
						colors.push($this.getRandomColor());
					});

					var inscricaoEconomicaTotal = [];
					$.each(inscricaoEconomica, function (situacao, total) {
						inscricaoEconomicaTotal.push({label: situacao, value: total});
					});

					Morris.Donut({
	                    element: 'chart-inscricao-economica',
	                    data: inscricaoEconomicaTotal,
	                    resize: true,
	                    hideHover: 'auto',
	                    colors: colors,
	                });
					
					$('.js-table-lista-cadastro-economico tbody').append(rows);
				}
			});
		},
		populateInscricaoDividaAtiva: function () {
			var $this = this;

			var baseUrl = '/portal-cidadao/divida-ativa/consulta/inscricao';

			$.ajax({
				method: 'GET',
				url: baseUrl + '/export?orderBy=dtInscricao&sort=desc',
				dataType: 'json',
				success: function (data) {
					if (!data.length) {
						$('#chart-divida-ativa')
							.css("background", "url('/bundles/portalservicos/images/chart3.png') no-repeat center")
							.find('img')
							.css('display', 'block');

						$('.js-table-lista-inscricao-divida-ativa tbody').append('<tr><td colspan="2">Nenhum registro encontrado!</td></tr>');

						return;
					}

					var rows = [];
					var dividaAtiva = {};
					var colors = [];
					$.each(data, function (index, inscricaoDividaAtiva) {
						dividaAtiva[inscricaoDividaAtiva.situacao] = dividaAtiva[inscricaoDividaAtiva.situacao] ? ++dividaAtiva[inscricaoDividaAtiva.situacao] : 1;
						if (index > 5) {
							return true;
						}

						template = rowTemplate.replace('{url}', baseUrl + '/' + inscricaoDividaAtiva.exercicio + '~' + inscricaoDividaAtiva.cod_inscricao + '/show')
							.replace('{codInscricao}', inscricaoDividaAtiva.cod_inscricao + '/' + inscricaoDividaAtiva.exercicio)
							.replace('{situacao}', inscricaoDividaAtiva.situacao);

						rows.push(template);
						colors.push($this.getRandomColor());
					});

					var dividaAtivaTotal = [];
					$.each(dividaAtiva, function (situacao, total) {
						dividaAtivaTotal.push({label: situacao, value: total});
					});

					Morris.Donut({
	                    element: 'chart-divida-ativa',
	                    data: dividaAtivaTotal,
	                    resize: true,
	                    hideHover: 'auto',
	                    colors: colors,
	                });
					
					$('.js-table-lista-inscricao-divida-ativa tbody').append(rows);
				}
			});
		},
		populateArrecadacaoIPTU: function () {
			var $this = this;

			var baseUrl = '/portal-cidadao/arrecadacao/consulta/iptu';

			$.ajax({
				method: 'GET',
				url: baseUrl + '/export?orderBy=vencimento&sort=desc',
				dataType: 'json',
				success: function (data) {
					if (!data.length) {
						$('#chart-arrecadacao-iptu')
							.css("background", "url('/bundles/portalservicos/images/chart4.png') no-repeat center")
							.find('img')
							.css('display', 'block');

						$('.js-table-lista-arrecadacao-iptu tbody').append('<tr><td colspan="2">Nenhum registro encontrado!</td></tr>');

						return;
					}

					var rows = [];
					var arrecadacaoIptu = {};
					var colors = [];
					$.each(data, function (index, iptu) {
						arrecadacaoIptu[iptu.situacao] = arrecadacaoIptu[iptu.situacao] ? ++arrecadacaoIptu[iptu.situacao] : 1;
						if (index > 5) {
							return true;
						}

						template = rowTemplate.replace('{url}', baseUrl + '/' + iptu.codLancamento + '/show')
							.replace('{codInscricao}', iptu.origemCobranca)
							.replace('{situacao}', iptu.situacao);

						rows.push(template);
						colors.push($this.getRandomColor());
					});

					var arrecadacaoIptuTotal = [];
					$.each(arrecadacaoIptu, function (situacao, total) {
						arrecadacaoIptuTotal.push({label: situacao, value: total});
					});

					Morris.Donut({
	                    element: 'chart-arrecadacao-iptu',
	                    data: arrecadacaoIptuTotal,
	                    resize: true,
	                    hideHover: 'auto',
	                    colors: colors,
	                });
					
					$('.js-table-lista-arrecadacao-iptu tbody').append(rows);
				}
			});
		},
		populateArrecadacaoISS: function () {
			var $this = this;

			var baseUrl = '/portal-cidadao/arrecadacao/consulta/iss';

			$.ajax({
				method: 'GET',
				url: baseUrl + '/export?orderBy=vencimento&sort=desc',
				dataType: 'json',
				success: function (data) {
					if (!data.length) {
						$('#chart-arrecadacao-iss')
							.css("background", "url('/bundles/portalservicos/images/chart5.png') no-repeat center")
							.find('img')
							.css('display', 'block');

						$('.js-table-lista-arrecadacao-iss tbody').append('<tr><td colspan="2">Nenhum registro encontrado!</td></tr>');

						return;
					}

					var rows = [];
					var arrecadacaoIss = {};
					var colors = [];
					$.each(data, function (index, iss) {
						arrecadacaoIss[iss.situacao] = arrecadacaoIss[iss.situacao] ? ++arrecadacaoIss[iss.situacao] : 1;
						if (index > 5) {
							return true;
						}

						template = rowTemplate.replace('{url}', baseUrl + '/' + iss.codLancamento + '/show')
							.replace('{codInscricao}', iss.origemCobranca)
							.replace('{situacao}', iss.situacao);

						rows.push(template);
						colors.push($this.getRandomColor());
					});

					var arrecadacaoIssTotal = [];
					$.each(arrecadacaoIss, function (situacao, total) {
						arrecadacaoIssTotal.push({label: situacao, value: total});
					});

					Morris.Donut({
	                    element: 'chart-arrecadacao-iss',
	                    data: arrecadacaoIssTotal,
	                    resize: true,
	                    hideHover: 'auto',
	                    colors: colors,
	                });
					
					$('.js-table-lista-arrecadacao-iss tbody').append(rows);
				}
			});
		},
		getRandomColor: function () {
            var letters = '0123456789ABCDEF';
            var color = '#';

            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }

            return color;
        },
		initialize: function () {
			this.populateImoveis();
			this.populateCadastroEconomico();
			this.populateInscricaoDividaAtiva();
			this.populateArrecadacaoIPTU();
			this.populateArrecadacaoISS();
		}
	}

	home.initialize();
}());
