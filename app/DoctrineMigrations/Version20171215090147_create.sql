-- tcepr.agrupamento_receita
CREATE TABLE tcepr.agrupamento_receita (
  id_tipo_categoria_agrupamento_receita INTEGER DEFAULT NULL,
  id_tipo_agrupamento_receita INTEGER DEFAULT NULL,
  cd_categoria_economica VARCHAR(1) DEFAULT NULL,
  cd_origem VARCHAR(1) DEFAULT NULL,
  cd_especie VARCHAR(1) DEFAULT NULL,
  cd_rubrica VARCHAR(1) DEFAULT NULL,
  cd_alinea VARCHAR(2) DEFAULT NULL,
  cd_sub_alinea VARCHAR(2) DEFAULT NULL,
  cd_desdobramento VARCHAR(2) DEFAULT NULL,
  cd_detalhamento VARCHAR(2) DEFAULT NULL,
  nr_ano_aplicacao VARCHAR(4) DEFAULT NULL,
  ds_agrupamento VARCHAR(106) DEFAULT NULL,
  PRIMARY KEY (id_tipo_categoria_agrupamento_receita, id_tipo_agrupamento_receita, cd_categoria_economica, cd_origem, cd_especie, cd_rubrica, cd_alinea, cd_sub_alinea, cd_desdobramento, cd_detalhamento)
);

-- tcepr.aplicacao_recurso
CREATE TABLE tcepr.aplicacao_recurso (
  cd_aplicacao VARCHAR(2) DEFAULT NULL,
  ds_aplicacao VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (cd_aplicacao)
);

-- tcepr.area_projecao_receita
CREATE TABLE tcepr.area_projecao_receita (
  cd_area VARCHAR(2) DEFAULT NULL,
  ds_area VARCHAR(55) DEFAULT NULL,
  PRIMARY KEY (cd_area)
);

-- tcepr.avaliacao_licitacao
CREATE TABLE tcepr.avaliacao_licitacao (
  id_avaliacao_licitacao INTEGER DEFAULT NULL,
  ds_avaliacao_licitacao VARCHAR(30) DEFAULT NULL,
  PRIMARY KEY (id_avaliacao_licitacao)
);

-- tcepr.banco
CREATE TABLE tcepr.banco (
  id_banco INTEGER DEFAULT NULL,
  nm_banco VARCHAR(83) DEFAULT NULL,
  PRIMARY KEY (id_banco)
);

-- tcepr.classificacao_intervencao
CREATE TABLE tcepr.classificacao_intervencao (
  id_classificacao_intervencao INTEGER DEFAULT NULL,
  ds_classificacao_intervencao VARCHAR(12) DEFAULT NULL,
  PRIMARY KEY (id_classificacao_intervencao)
);

-- tcepr.classificacao_objeto_licitacao
CREATE TABLE tcepr.classificacao_objeto_licitacao (
  id_classificacao_objeto_licitacao INTEGER DEFAULT NULL,
  ds_classificacao_objeto_licitacao VARCHAR(33) DEFAULT NULL,
  PRIMARY KEY (id_classificacao_objeto_licitacao)
);

-- tcepr.classificacao_objeto_licitacao_x_regime_execucao_licitacao
CREATE TABLE tcepr.classificacao_objeto_licitacao_x_regime_execucao_licitacao (
  id_classificacao_objeto_licitacao INTEGER DEFAULT NULL,
  id_regime_execucao_licitacao INTEGER DEFAULT NULL,
  ds_regime_execucao_licitacao VARCHAR(60) DEFAULT NULL,
  PRIMARY KEY (id_classificacao_objeto_licitacao, id_regime_execucao_licitacao)
);

-- tcepr.classificacao_obra
CREATE TABLE tcepr.classificacao_obra (
  id_classificacao_obra INTEGER DEFAULT NULL,
  ds_classificacao_obra VARCHAR(27) DEFAULT NULL,
  PRIMARY KEY (id_classificacao_obra)
);

-- tcepr.consolidacao_divida
CREATE TABLE tcepr.consolidacao_divida (
  id_tipo_origem INTEGER DEFAULT NULL,
  id_tipo_natureza_divida INTEGER DEFAULT NULL,
  id_tipo_grupo_divida INTEGER DEFAULT NULL,
  id_tipo_divida INTEGER DEFAULT NULL,
  PRIMARY KEY (id_tipo_origem, id_tipo_natureza_divida, id_tipo_grupo_divida, id_tipo_divida)
);

-- tcepr.consolidacao_tipo_documento_x_escopo
CREATE TABLE tcepr.consolidacao_tipo_documento_x_escopo (
  id_tipo_documento INTEGER DEFAULT NULL,
  id_escopo INTEGER DEFAULT NULL,
  ds_escopo VARCHAR(101) DEFAULT NULL,
  PRIMARY KEY (id_tipo_documento, id_escopo)
);

-- tcepr.desdobramento_fonte
CREATE TABLE tcepr.desdobramento_fonte (
  cd_desdobramento VARCHAR(2) DEFAULT NULL,
  ds_desdobramento VARCHAR(38) DEFAULT NULL,
  PRIMARY KEY (cd_desdobramento)
);

-- tcepr.detalhamento_fonte
CREATE TABLE tcepr.detalhamento_fonte (
  cd_detalhamento VARCHAR(2) DEFAULT NULL,
  ds_detalhamento VARCHAR(102) DEFAULT NULL,
  PRIMARY KEY (cd_detalhamento)
);

-- tcepr.escopo
CREATE TABLE tcepr.escopo (
  id_escopo INTEGER DEFAULT NULL,
  ds_escopo VARCHAR(101) DEFAULT NULL,
  fl_plurianual BOOLEAN DEFAULT NULL,
  PRIMARY KEY (id_escopo)
);

-- tcepr.evento_padrao
CREATE TABLE tcepr.evento_padrao (
  id_evento_padrao INTEGER DEFAULT NULL,
  ds_evento_padrao VARCHAR(178) DEFAULT NULL,
  PRIMARY KEY (id_evento_padrao)
);

-- tcepr.fonte_padrao
CREATE TABLE tcepr.fonte_padrao (
  cd_fonte_padrao VARCHAR(4) DEFAULT NULL,
  ds_fonte_padrao VARCHAR(131) DEFAULT NULL,
  fl_permite_desdobramento BOOLEAN DEFAULT NULL,
  PRIMARY KEY (cd_fonte_padrao)
);

-- tcepr.grupo_fonte_padrao
CREATE TABLE tcepr.grupo_fonte_padrao (
  cd_grupo_fonte VARCHAR(1) DEFAULT NULL,
  ds_grupo VARCHAR(25) DEFAULT NULL,
  PRIMARY KEY (cd_grupo_fonte)
);

-- tcepr.modalidade_licitacao
CREATE TABLE tcepr.modalidade_licitacao (
  id_modalidade_licitacao INTEGER DEFAULT NULL,
  ds_modalidade_licitacao VARCHAR(43) DEFAULT NULL,
  PRIMARY KEY (id_modalidade_licitacao)
);

-- tcepr.modalidade_x_natureza_licitacao
CREATE TABLE tcepr.modalidade_x_natureza_licitacao (
  id_modalidade_licitacao INTEGER DEFAULT NULL,
  ds_modalidade_licitacao VARCHAR(45) DEFAULT NULL,
  id_natureza_licitacao INTEGER DEFAULT NULL,
  ds_natureza_procedimento VARCHAR(30) DEFAULT NULL,
  PRIMARY KEY (id_modalidade_licitacao, id_natureza_licitacao)
);

-- tcepr.motivo_paralisacao
CREATE TABLE tcepr.motivo_paralisacao (
  id_motivo_paralisacao INTEGER DEFAULT NULL,
  ds_motivo_paralisacao VARCHAR(113) DEFAULT NULL,
  PRIMARY KEY (id_motivo_paralisacao)
);

-- tcepr.natureza_acao
CREATE TABLE tcepr.natureza_acao (
  id_natureza_acao INTEGER DEFAULT NULL,
  ds_natureza_acao VARCHAR(42) DEFAULT NULL,
  PRIMARY KEY (id_natureza_acao)
);

-- tcepr.natureza_cargo_comissao
CREATE TABLE tcepr.natureza_cargo_comissao (
  id_natureza_cargo_comissao INTEGER DEFAULT NULL,
  ds_natureza_cargo_comissao VARCHAR(21) DEFAULT NULL,
  PRIMARY KEY (id_natureza_cargo_comissao)
);

-- tcepr.natureza_indicador
CREATE TABLE tcepr.natureza_indicador (
  cd_natureza_indicador VARCHAR(1) DEFAULT NULL,
  ds_natureza_indicador VARCHAR(22) DEFAULT NULL,
  PRIMARY KEY (cd_natureza_indicador)
);

-- tcepr.natureza_licitacao
CREATE TABLE tcepr.natureza_licitacao (
  id_natureza_licitacao INTEGER DEFAULT NULL,
  ds_natureza_licitacao VARCHAR(19) DEFAULT NULL,
  PRIMARY KEY (id_natureza_licitacao)
);

-- tcepr.natureza_x_funcao_quadro_estatal
CREATE TABLE tcepr.natureza_x_funcao_quadro_estatal (
  id_tipo_natureza_quadro_estatal INTEGER DEFAULT NULL,
  ds_tipo_natureza_funcao_quadro_estatal VARCHAR(27) DEFAULT NULL,
  id_tipo_funcao_quadro_estatal INTEGER DEFAULT NULL,
  ds_tipo_funcao_quadro_estatal_suplente VARCHAR(18) DEFAULT NULL,
  PRIMARY KEY (id_tipo_natureza_quadro_estatal, id_tipo_funcao_quadro_estatal)
);

-- tcepr.objetivo_milenio
CREATE TABLE tcepr.objetivo_milenio (
  id_objetivo_milenio INTEGER DEFAULT NULL,
  ds_objetivo_milenio VARCHAR(46) DEFAULT NULL,
  PRIMARY KEY (id_objetivo_milenio)
);

-- tcepr.operacao_loa
CREATE TABLE tcepr.operacao_loa (
  id_operacao_loa INTEGER DEFAULT NULL,
  ds_operacao VARCHAR(41) DEFAULT NULL,
  PRIMARY KEY (id_operacao_loa)
);

-- tcepr.origem_acompanhamento
CREATE TABLE tcepr.origem_acompanhamento (
  id_origem_acompanhamento INTEGER DEFAULT NULL,
  ds_origem_acompanhamento VARCHAR(14) DEFAULT NULL,
  PRIMARY KEY (id_origem_acompanhamento)
);

-- tcepr.origem_recurso
CREATE TABLE tcepr.origem_recurso (
  cd_origem VARCHAR(2) DEFAULT NULL,
  ds_origem VARCHAR(47) DEFAULT NULL,
  PRIMARY KEY (cd_origem)
);

-- tcepr.produto
CREATE TABLE tcepr.produto (
  id_produto INTEGER DEFAULT NULL,
  ds_produto VARCHAR(44) DEFAULT NULL,
  PRIMARY KEY (id_produto)
);

-- tcepr.produto_x_unidade_medida
CREATE TABLE tcepr.produto_x_unidade_medida (
  id_produto INTEGER DEFAULT NULL,
  ds_produto VARCHAR(44) DEFAULT NULL,
  id_unidade_medida INTEGER DEFAULT NULL,
  ds_unidade_medida VARCHAR(25) DEFAULT NULL,
  PRIMARY KEY (id_produto, id_unidade_medida)
);

-- tcepr.regime_execucao_licitacao
CREATE TABLE tcepr.regime_execucao_licitacao (
  id_regime_execucao_licitacao INTEGER DEFAULT NULL,
  ds_regime_execucao_licitacao VARCHAR(60) DEFAULT NULL,
  PRIMARY KEY (id_regime_execucao_licitacao)
);

-- tcepr.risco_fiscal
CREATE TABLE tcepr.risco_fiscal (
  id_risco_fiscal INTEGER DEFAULT NULL,
  ds_risco_fiscal VARCHAR(36) DEFAULT NULL,
  PRIMARY KEY (id_risco_fiscal)
);

-- tcepr.status_licitacao
CREATE TABLE tcepr.status_licitacao (
  id_status_licitacao INTEGER DEFAULT NULL,
  ds_status_licitacao VARCHAR(10) DEFAULT NULL,
  PRIMARY KEY (id_status_licitacao)
);

-- tcepr.tipo_a_baixa_quadro_deliberativo_executivo
CREATE TABLE tcepr.tipo_a_baixa_quadro_deliberativo_executivo (
  id_tipo_baixa_quadro_deliberativo_executivo INTEGER DEFAULT NULL,
  ds_tipo_baixa_quadro_deliberativo_executivo VARCHAR(14) DEFAULT NULL,
  PRIMARY KEY (id_tipo_baixa_quadro_deliberativo_executivo)
);

-- tcepr.tipo_acao
CREATE TABLE tcepr.tipo_acao (
  id_tipo_acao INTEGER DEFAULT NULL,
  ds_tipo_acao VARCHAR(32) DEFAULT NULL,
  fltp_acao BOOLEAN DEFAULT NULL,
  PRIMARY KEY (id_tipo_acao)
);

-- tcepr.tipo_acompanhamento
CREATE TABLE tcepr.tipo_acompanhamento (
  id_tipo_acompanhamento INTEGER DEFAULT NULL,
  ds_tipo_acompanhamento VARCHAR(29) DEFAULT NULL,
  PRIMARY KEY (id_tipo_acompanhamento)
);

-- tcepr.tipo_aditivo_contrato
CREATE TABLE tcepr.tipo_aditivo_contrato (
  id_tipo_aditivo_contrato INTEGER DEFAULT NULL,
  ds_tipo_aditivo_contrato VARCHAR(24) DEFAULT NULL,
  PRIMARY KEY (id_tipo_aditivo_contrato)
);

-- tcepr.tipo_aditivo_convenio
CREATE TABLE tcepr.tipo_aditivo_convenio (
  id_tipo_aditivo_convenio INTEGER DEFAULT NULL,
  ds_tipo_aditivo_convenio VARCHAR(13) DEFAULT NULL,
  PRIMARY KEY (id_tipo_aditivo_convenio)
);

-- tcepr.tipo_agrupamento_bem
CREATE TABLE tcepr.tipo_agrupamento_bem (
  id_tipo_natureza_bem INTEGER DEFAULT NULL,
  id_tipo_categoria_bem INTEGER DEFAULT NULL,
  id_tipo_detalhamento_bem INTEGER DEFAULT NULL,
  id_tipo_utilizacao_bem INTEGER DEFAULT NULL,
  ds_detalhamento VARCHAR(80) DEFAULT NULL,
  id_tipo_medidor INTEGER DEFAULT NULL,
  fl_usa_combustivel BOOLEAN DEFAULT NULL,
  fl_exige_fipe BOOLEAN DEFAULT NULL,
  fl_exige_placa BOOLEAN DEFAULT NULL,
  fl_exige_renavam BOOLEAN DEFAULT NULL,
  fl_aceita_movimento BOOLEAN DEFAULT NULL,
  PRIMARY KEY (id_tipo_natureza_bem, id_tipo_categoria_bem, id_tipo_detalhamento_bem, id_tipo_utilizacao_bem, id_tipo_medidor)
);

-- tcepr.tipo_agrupamento_receita
CREATE TABLE tcepr.tipo_agrupamento_receita (
  id_tipo_agrupamento_receita INTEGER DEFAULT NULL,
  ds_tipo_agrupamento_receita VARCHAR(63) DEFAULT NULL,
  PRIMARY KEY (id_tipo_agrupamento_receita)
);

-- tcepr.tipo_alteracao_credito_adicional
CREATE TABLE tcepr.tipo_alteracao_credito_adicional (
  id_tipo_alteracao_credito_adicional INTEGER DEFAULT NULL,
  ds_tipo_alteracao_credito_adicional VARCHAR(33) DEFAULT NULL,
  PRIMARY KEY (id_tipo_alteracao_credito_adicional)
);

-- tcepr.tipo_aplicacao_plano_contabil
CREATE TABLE tcepr.tipo_aplicacao_plano_contabil (
  id_tipo_aplicacao INTEGER DEFAULT NULL,
  ds_tipo_aplicacao VARCHAR(49) DEFAULT NULL,
  PRIMARY KEY (id_tipo_aplicacao)
);

-- tcepr.tipo_area_consorcio
CREATE TABLE tcepr.tipo_area_consorcio (
  id_tipo_area_consorcio INTEGER DEFAULT NULL,
  ds_tipo_area_consorcio VARCHAR(52) DEFAULT NULL,
  PRIMARY KEY (id_tipo_area_consorcio)
);

-- tcepr.tipo_arrecadacao
CREATE TABLE tcepr.tipo_arrecadacao (
  id_tipo_arrecadacao INTEGER DEFAULT NULL,
  ds_tipo_arrecadacao VARCHAR(20) DEFAULT NULL,
  PRIMARY KEY (id_tipo_arrecadacao)
);

-- tcepr.tipo_ato_contrato
CREATE TABLE tcepr.tipo_ato_contrato (
  id_tipo_ato_contrato INTEGER DEFAULT NULL,
  ds_tipo_ato_contrato VARCHAR(26) DEFAULT NULL,
  PRIMARY KEY (id_tipo_ato_contrato)
);

-- tcepr.tipo_atribuicao_comissao
CREATE TABLE tcepr.tipo_atribuicao_comissao (
  id_tipo_atribuicao_comissao INTEGER DEFAULT NULL,
  ds_tipo_atribuicao_comissao VARCHAR(18) DEFAULT NULL,
  PRIMARY KEY (id_tipo_atribuicao_comissao)
);

-- tcepr.tipo_atualizacao_orcamentaria
CREATE TABLE tcepr.tipo_atualizacao_orcamentaria (
  id_tipo_atualizacao_orcamentaria INTEGER DEFAULT NULL,
  ds_tipo_atualizacao_orcamentaria VARCHAR(58) DEFAULT NULL,
  PRIMARY KEY (id_tipo_atualizacao_orcamentaria)
);

-- tcepr.tipo_baixa_reponsavel
CREATE TABLE tcepr.tipo_baixa_reponsavel (
  id_tipo_baixa_responsavel INTEGER DEFAULT NULL,
  ds_tipo_baixa_responsavel VARCHAR(34) DEFAULT NULL,
  PRIMARY KEY (id_tipo_baixa_responsavel)
);

-- tcepr.tipo_base_calculo
CREATE TABLE tcepr.tipo_base_calculo (
  id_tipo_base_calculo INTEGER DEFAULT NULL,
  ds_base_tipo_base_calculo VARCHAR(7) DEFAULT NULL,
  PRIMARY KEY (id_tipo_base_calculo)
);

-- tcepr.tipo_cargo_quadro_societario
CREATE TABLE tcepr.tipo_cargo_quadro_societario (
  id_tipo_cargo_quadro_societario INTEGER DEFAULT NULL,
  ds_tipo_cargo_quadro_societario VARCHAR(36) DEFAULT NULL,
  PRIMARY KEY (id_tipo_cargo_quadro_societario)
);

-- tcepr.tipo_categoria_agrupamento_receita
CREATE TABLE tcepr.tipo_categoria_agrupamento_receita (
  id_tipo_categoria_agrupamento_receita INTEGER DEFAULT NULL,
  ds_tipo_categoria_agrupamento_receita VARCHAR(27) DEFAULT NULL,
  PRIMARY KEY (id_tipo_categoria_agrupamento_receita)
);

-- tcepr.tipo_categoria_bem
CREATE TABLE tcepr.tipo_categoria_bem (
  id_tipo_categoria_bem INTEGER DEFAULT NULL,
  ds_tipo_categoria_bem VARCHAR(85) DEFAULT NULL,
  PRIMARY KEY (id_tipo_categoria_bem)
);

-- tcepr.tipo_categoria_objeto_despesa
CREATE TABLE tcepr.tipo_categoria_objeto_despesa (
  id_tipo_categoria_objeto_despesa INTEGER DEFAULT NULL,
  ds_tipo_categoria_objeto_despesa VARCHAR(38) DEFAULT NULL,
  PRIMARY KEY (id_tipo_categoria_objeto_despesa)
);

-- tcepr.tipo_categoria_x_agrupamento_receita
CREATE TABLE tcepr.tipo_categoria_x_agrupamento_receita (
  id_tipo_categoria_agrupamento_receita INTEGER DEFAULT NULL,
  id_tipo_agrupamento_receita INTEGER DEFAULT NULL,
  ds_tipo_agrupamento_receita VARCHAR(63) DEFAULT NULL,
  PRIMARY KEY (id_tipo_categoria_agrupamento_receita, id_tipo_agrupamento_receita)
);

-- tcepr.tipo_categoria_x_objeto_despesa
CREATE TABLE tcepr.tipo_categoria_x_objeto_despesa (
  id_tipo_categoria_objeto_despesa INTEGER DEFAULT NULL,
  id_tipo_objeto_despesa INTEGER DEFAULT NULL,
  ds_tipo_objeto_despesa VARCHAR(42) DEFAULT NULL,
  PRIMARY KEY (id_tipo_categoria_objeto_despesa, id_tipo_objeto_despesa)
);

-- tcepr.tipo_certidao
CREATE TABLE tcepr.tipo_certidao (
  id_tipo_certidao INTEGER DEFAULT NULL,
  ds_tipo_certidao VARCHAR(98) DEFAULT NULL,
  PRIMARY KEY (id_tipo_certidao)
);

-- tcepr.tipo_conta_bancaria
CREATE TABLE tcepr.tipo_conta_bancaria (
  id_tipo_conta_bancaria INTEGER DEFAULT NULL,
  ds_tipo_conta_bancaria VARCHAR(31) DEFAULT NULL,
  PRIMARY KEY (id_tipo_conta_bancaria)
);

-- tcepr.tipo_contrapartida_execucacao_antecipada
CREATE TABLE tcepr.tipo_contrapartida_execucacao_antecipada (
  id_tipo_contrapartida_execucao_antecipada INTEGER DEFAULT NULL,
  ds_tipo_contrapartida_execucao_antecipada VARCHAR(23) DEFAULT NULL,
  PRIMARY KEY (id_tipo_contrapartida_execucao_antecipada)
);

-- tcepr.tipo_contribuicao_diferenciada
CREATE TABLE tcepr.tipo_contribuicao_diferenciada (
  id_tipo_contribuicao_diferenciada INTEGER DEFAULT NULL,
  ds_tipo_contribuicao_diferenciada VARCHAR(23) DEFAULT NULL,
  PRIMARY KEY (id_tipo_contribuicao_diferenciada)
);

-- tcepr.tipo_contribuicao_previdencia
CREATE TABLE tcepr.tipo_contribuicao_previdencia (
  id_tipo_contribuicao_previdencia INTEGER DEFAULT NULL,
  ds_tipo_contribuicao_previdencia VARCHAR(8) DEFAULT NULL,
  PRIMARY KEY (id_tipo_contribuicao_previdencia)
);

-- tcepr.tipo_controle_acao
CREATE TABLE tcepr.tipo_controle_acao (
  id_tipo_controle_acao INTEGER DEFAULT NULL,
  ds_tipo_controle_acao VARCHAR(38) DEFAULT NULL,
  PRIMARY KEY (id_tipo_controle_acao)
);

-- tcepr.tipo_controle_conta
CREATE TABLE tcepr.tipo_controle_conta (
  tp_controle_conta VARCHAR(1) DEFAULT NULL,
  ds_tipo_controle_conta VARCHAR(23) DEFAULT NULL,
  PRIMARY KEY (tp_controle_conta)
);

-- tcepr.tipo_credito_adicional
CREATE TABLE tcepr.tipo_credito_adicional (
  id_tipo_credito_adicional INTEGER DEFAULT NULL,
  ds_tipo_credito_adicional VARCHAR(15) DEFAULT NULL,
  PRIMARY KEY (id_tipo_credito_adicional)
);

-- tcepr.tipo_credito_adicional_x_escopo
CREATE TABLE tcepr.tipo_credito_adicional_x_escopo (
  id_tipo_credito_adicional INTEGER DEFAULT NULL,
  ds_tipo_credito_adicional VARCHAR(14) DEFAULT NULL,
  id_escopo INTEGER DEFAULT NULL,
  PRIMARY KEY (id_tipo_credito_adicional, id_escopo)
);

-- tcepr.tipo_credito_inicial
CREATE TABLE tcepr.tipo_credito_inicial (
  id_tipo_credito_inicial INTEGER DEFAULT NULL,
  ds_tipo_credito_inicial VARCHAR(62) DEFAULT NULL,
  PRIMARY KEY (id_tipo_credito_inicial)
);

-- tcepr.tipo_deposito_restituivel_passivo
CREATE TABLE tcepr.tipo_deposito_restituivel_passivo (
  id_tipo_deposito_restituivel_passivo INTEGER DEFAULT NULL,
  ds_tipo_deposito_restituivel_passivo VARCHAR(96) DEFAULT NULL,
  PRIMARY KEY (id_tipo_deposito_restituivel_passivo)
);

-- tcepr.tipo_detalhamento_bem
CREATE TABLE tcepr.tipo_detalhamento_bem (
  id_tipo_detalhamento_bem INTEGER DEFAULT NULL,
  ds_tipo_detalhamento_bem VARCHAR(80) DEFAULT NULL,
  PRIMARY KEY (id_tipo_detalhamento_bem)
);

-- tcepr.tipo_divida
CREATE TABLE tcepr.tipo_divida (
  id_tipo_divida INTEGER DEFAULT NULL,
  ds_tipo_divida VARCHAR(57) DEFAULT NULL,
  PRIMARY KEY (id_tipo_divida)
);

-- tcepr.tipo_documento
CREATE TABLE tcepr.tipo_documento (
  id_tipo_documento INTEGER DEFAULT NULL,
  ds_tipo_documento VARCHAR(70) DEFAULT NULL,
  fl_exige_numero_documento BOOLEAN DEFAULT NULL,
  PRIMARY KEY (id_tipo_documento)
);

-- tcepr.tipo_documento_financeiro
CREATE TABLE tcepr.tipo_documento_financeiro (
  id_tipo_documento_financeiro INTEGER DEFAULT NULL,
  ds_tipo_documento_financeiro VARCHAR(46) DEFAULT NULL,
  fl_entrada_saida BOOLEAN DEFAULT NULL,
  PRIMARY KEY (id_tipo_documento_financeiro)
);

-- tcepr.tipo_documento_fiscal
CREATE TABLE tcepr.tipo_documento_fiscal (
  id_tipo_documento_fiscal INTEGER DEFAULT NULL,
  ds_tipo_documento_fiscal VARCHAR(45) DEFAULT NULL,
  PRIMARY KEY (id_tipo_documento_fiscal)
);

-- tcepr.tipo_documento_orgao_classe
CREATE TABLE tcepr.tipo_documento_orgao_classe (
  id_tipo_documento_orgao_classe INTEGER DEFAULT NULL,
  ds_tipo_documento_orgao_classe VARCHAR(10) DEFAULT NULL,
  PRIMARY KEY (id_tipo_documento_orgao_classe)
);

-- tcepr.tipo_documento_pessoa
CREATE TABLE tcepr.tipo_documento_pessoa (
  id_tipo_documento_pessoa INTEGER DEFAULT NULL,
  sg_tipo_documento VARCHAR(5) DEFAULT NULL,
  ds_tipo_documento VARCHAR(45) DEFAULT NULL,
  fl_exige_uf BOOLEAN DEFAULT NULL,
  fl_exige_validade BOOLEAN DEFAULT NULL,
  PRIMARY KEY (id_tipo_documento_pessoa)
);

-- tcepr.tipo_empenho
CREATE TABLE tcepr.tipo_empenho (
  id_tipo_empenho INTEGER DEFAULT NULL,
  ds_tipo_empenho VARCHAR(10) DEFAULT NULL,
  PRIMARY KEY (id_tipo_empenho)
);

-- tcepr.tipo_entrada_combustivel
CREATE TABLE tcepr.tipo_entrada_combustivel (
  id_tipo_entrada_combustivel INTEGER DEFAULT NULL,
  ds_tipo_entrada_combustivel VARCHAR(37) DEFAULT NULL,
  PRIMARY KEY (id_tipo_entrada_combustivel)
);

-- tcepr.tipo_entrega_produto
CREATE TABLE tcepr.tipo_entrega_produto (
  id_tipo_entrega_produto INTEGER DEFAULT NULL,
  ds_tipo_entrega_produto VARCHAR(14) DEFAULT NULL,
  PRIMARY KEY (id_tipo_entrega_produto)
);

-- tcepr.tipo_escrituracao
CREATE TABLE tcepr.tipo_escrituracao (
  tp_escrituracao VARCHAR(1) DEFAULT NULL,
  ds_tipo_escrituracao VARCHAR(18) DEFAULT NULL,
  PRIMARY KEY (tp_escrituracao)
);

-- tcepr.tipo_esfera_governo
CREATE TABLE tcepr.tipo_esfera_governo (
  tp_esfera_governo VARCHAR(1) DEFAULT NULL,
  ds_tipo_esfera_governo VARCHAR(13) DEFAULT NULL,
  PRIMARY KEY (tp_esfera_governo)
);

-- tcepr.tipo_estorno_empenho
CREATE TABLE tcepr.tipo_estorno_empenho (
  id_tipo_estorno_empenho INTEGER DEFAULT NULL,
  ds_tipo_estorno_empenho VARCHAR(84) DEFAULT NULL,
  PRIMARY KEY (id_tipo_estorno_empenho)
);

-- tcepr.tipo_exclusao_credito_adicional
CREATE TABLE tcepr.tipo_exclusao_credito_adicional (
  id_tipo_exclusao_credito_adicional INTEGER DEFAULT NULL,
  ds_tipo_exclusao_credito_adicional VARCHAR(45) DEFAULT NULL,
  PRIMARY KEY (id_tipo_exclusao_credito_adicional)
);

-- tcepr.tipo_execucao_acao
CREATE TABLE tcepr.tipo_execucao_acao (
  id_tipo_execucao_acao INTEGER DEFAULT NULL,
  ds_tipo_execucao_acao VARCHAR(37) DEFAULT NULL,
  PRIMARY KEY (id_tipo_execucao_acao)
);

-- tcepr.tipo_execucao_antecipada
CREATE TABLE tcepr.tipo_execucao_antecipada (
  id_tipo_execucao_antecipada INTEGER DEFAULT NULL,
  ds_tipo_execucao_antecipada VARCHAR(38) DEFAULT NULL,
  PRIMARY KEY (id_tipo_execucao_antecipada)
);

-- tcepr.tipo_exigencia_conta_bancaria_credor
CREATE TABLE tcepr.tipo_exigencia_conta_bancaria_credor (
  id_tipo_operacao_financeira INTEGER DEFAULT NULL,
  ds_tipo_operacao_financeira VARCHAR(58) DEFAULT NULL,
  id_tipo_documento_financeiro INTEGER DEFAULT NULL,
  ds_tipo_documento_financeiro VARCHAR(35) DEFAULT NULL,
  PRIMARY KEY (id_tipo_operacao_financeira, id_tipo_documento_financeiro)
);

-- tcepr.tipo_financeiro_patrimonial
CREATE TABLE tcepr.tipo_financeiro_patrimonial (
  id_tipo_financeiro_patrimonial INTEGER DEFAULT NULL,
  ds_tipo_financeiro_patrimonial VARCHAR(42) DEFAULT NULL,
  PRIMARY KEY (id_tipo_financeiro_patrimonial)
);

-- tcepr.tipo_fluxo_interferencia
CREATE TABLE tcepr.tipo_fluxo_interferencia (
  id_tipo_fluxo_interferencia INTEGER DEFAULT NULL,
  ds_tipo_fluxo_interferencia VARCHAR(8) DEFAULT NULL,
  PRIMARY KEY (id_tipo_fluxo_interferencia)
);

-- tcepr.tipo_forma_pagamento_contrato
CREATE TABLE tcepr.tipo_forma_pagamento_contrato (
  id_tipo_forma_pagamento_contrato INTEGER DEFAULT NULL,
  ds_tipo_forma_pagamento_contrato VARCHAR(8) DEFAULT NULL,
  PRIMARY KEY (id_tipo_forma_pagamento_contrato)
);

-- tcepr.tipo_funcao_quadro_estatal
CREATE TABLE tcepr.tipo_funcao_quadro_estatal (
  id_tipo_funcao_quadro_estatal INTEGER DEFAULT NULL,
  ds_tipo_funcao_quadro_estatal VARCHAR(18) DEFAULT NULL,
  PRIMARY KEY (id_tipo_funcao_quadro_estatal)
);

-- tcepr.tipo_garantia_contrato
CREATE TABLE tcepr.tipo_garantia_contrato (
  id_tipo_garantia_contrato INTEGER DEFAULT NULL,
  ds_tipo_garantia_contrato VARCHAR(27) DEFAULT NULL,
  PRIMARY KEY (id_tipo_garantia_contrato)
);

-- tcepr.tipo_grupo_divida
CREATE TABLE tcepr.tipo_grupo_divida (
  id_tipo_grupo_divida INTEGER DEFAULT NULL,
  ds_tipo_grupo_divida VARCHAR(31) DEFAULT NULL,
  PRIMARY KEY (id_tipo_grupo_divida)
);

-- tcepr.tipo_indicador
CREATE TABLE tcepr.tipo_indicador (
  id_tipo_indicador INTEGER DEFAULT NULL,
  ds_tipo_indicador VARCHAR(74) DEFAULT NULL,
  PRIMARY KEY (id_tipo_indicador)
);

-- tcepr.tipo_intervencao
CREATE TABLE tcepr.tipo_intervencao (
  id_tipo_intervencao INTEGER DEFAULT NULL,
  ds_tipo_intervencao VARCHAR(27) DEFAULT NULL,
  PRIMARY KEY (id_tipo_intervencao)
);

-- tcepr.tipo_medicao
CREATE TABLE tcepr.tipo_medicao (
  id_tipo_medicao INTEGER DEFAULT NULL,
  ds_tipo_medicao VARCHAR(30) DEFAULT NULL,
  PRIMARY KEY (id_tipo_medicao)
);

-- tcepr.tipo_medidor
CREATE TABLE tcepr.tipo_medidor (
  id_tipo_medidor INTEGER DEFAULT NULL,
  ds_tipo_medidor VARCHAR(30) DEFAULT NULL,
  PRIMARY KEY (id_tipo_medidor)
);

-- tcepr.tipo_modulo
CREATE TABLE tcepr.tipo_modulo (
  id_tipo_modulo INTEGER DEFAULT NULL,
  ds_tipo_modulo VARCHAR(25) DEFAULT NULL,
  PRIMARY KEY (id_tipo_modulo)
);

-- tcepr.tipo_motivo_rescisao_contrato
CREATE TABLE tcepr.tipo_motivo_rescisao_contrato (
  id_tipo_motivo_rescisao_contrato INTEGER DEFAULT NULL,
  ds_tipo_motivo_rescisao_contrato VARCHAR(252) DEFAULT NULL,
  PRIMARY KEY (id_tipo_motivo_rescisao_contrato)
);

-- tcepr.tipo_movimento
CREATE TABLE tcepr.tipo_movimento (
  id_tipo_movimento INTEGER DEFAULT NULL,
  ds_tipo_movimento VARCHAR(62) DEFAULT NULL,
  PRIMARY KEY (id_tipo_movimento)
);

-- tcepr.tipo_movimento_contabil
CREATE TABLE tcepr.tipo_movimento_contabil (
  id_tipo_movimento_contabil INTEGER DEFAULT NULL,
  ds_tipo_movimento_contabil VARCHAR(26) DEFAULT NULL,
  PRIMARY KEY (id_tipo_movimento_contabil)
);

-- tcepr.tipo_movimento_realizavel
CREATE TABLE tcepr.tipo_movimento_realizavel (
  id_tipo_movimento_realizavel INTEGER DEFAULT NULL,
  ds_tipo_movimento_realizavel VARCHAR(63) DEFAULT NULL,
  fl_inscricao BOOLEAN DEFAULT NULL,
  PRIMARY KEY (id_tipo_movimento_realizavel)
);

-- tcepr.tipo_multa_contrato
CREATE TABLE tcepr.tipo_multa_contrato (
  id_tipo_multa_contrato INTEGER DEFAULT NULL,
  ds_tipo_multa_contrato VARCHAR(35) DEFAULT NULL,
  PRIMARY KEY (id_tipo_multa_contrato)
);

-- tcepr.tipo_natureza_base_folha
CREATE TABLE tcepr.tipo_natureza_base_folha (
  id_tipo_natureza_base_folha INTEGER DEFAULT NULL,
  ds_tipo_natureza_base_folha VARCHAR(26) DEFAULT NULL,
  PRIMARY KEY (id_tipo_natureza_base_folha)
);

-- tcepr.tipo_natureza_bem
CREATE TABLE tcepr.tipo_natureza_bem (
  id_tipo_natureza_bem INTEGER DEFAULT NULL,
  ds_tipo_natureza_bem VARCHAR(13) DEFAULT NULL,
  PRIMARY KEY (id_tipo_natureza_bem)
);

-- tcepr.tipo_natureza_divida
CREATE TABLE tcepr.tipo_natureza_divida (
  id_tipo_natureza_divida INTEGER DEFAULT NULL,
  ds_tipo_natureza_divida VARCHAR(37) DEFAULT NULL,
  PRIMARY KEY (id_tipo_natureza_divida)
);

-- tcepr.tipo_natureza_informacao
CREATE TABLE tcepr.tipo_natureza_informacao (
  tp_natureza_informacao VARCHAR(1) DEFAULT NULL,
  ds_tipo_natureza_informacao VARCHAR(14) DEFAULT NULL,
  PRIMARY KEY (tp_natureza_informacao)
);

-- tcepr.tipo_natureza_juridica_consorcio
CREATE TABLE tcepr.tipo_natureza_juridica_consorcio (
  id_tipo_natureza_juridica_consorcio INTEGER DEFAULT NULL,
  ds_tipo_natureza_juridica_consorcio VARCHAR(21) DEFAULT NULL,
  PRIMARY KEY (id_tipo_natureza_juridica_consorcio)
);

-- tcepr.tipo_natureza_quadro_estatal
CREATE TABLE tcepr.tipo_natureza_quadro_estatal (
  id_tipo_natureza_quadro_estatal INTEGER DEFAULT NULL,
  ds_tipo_natureza_quadro_estatal VARCHAR(27) DEFAULT NULL,
  PRIMARY KEY (id_tipo_natureza_quadro_estatal)
);

-- tcepr.tipo_natureza_saldo
CREATE TABLE tcepr.tipo_natureza_saldo (
  tp_natureza_saldo VARCHAR(1) DEFAULT NULL,
  ds_tipo_natureza_saldo VARCHAR(8) DEFAULT NULL,
  PRIMARY KEY (tp_natureza_saldo)
);

-- tcepr.tipo_natureza_transferencia
CREATE TABLE tcepr.tipo_natureza_transferencia (
  id_tipo_natureza_transferencia INTEGER DEFAULT NULL,
  ds_tipo_natureza_transferencia VARCHAR(36) DEFAULT NULL,
  PRIMARY KEY (id_tipo_natureza_transferencia)
);

-- tcepr.tipo_nivel_conta
CREATE TABLE tcepr.tipo_nivel_conta (
  cd_tipo_nivel_conta VARCHAR(1) DEFAULT NULL,
  ds_tipo_nivel_conta VARCHAR(10) DEFAULT NULL,
  PRIMARY KEY (cd_tipo_nivel_conta)
);

-- tcepr.tipo_objetivo_diaria
CREATE TABLE tcepr.tipo_objetivo_diaria (
  id_tipo_objetivo_diaria INTEGER DEFAULT NULL,
  ds_tipo_objetivo_diaria VARCHAR(66) DEFAULT NULL,
  PRIMARY KEY (id_tipo_objetivo_diaria)
);

-- tcepr.tipo_objeto_despesa
CREATE TABLE tcepr.tipo_objeto_despesa (
  id_tipo_objeto_despesa INTEGER DEFAULT NULL,
  ds_tipo_objeto_despesa VARCHAR(42) DEFAULT NULL,
  fl_exige_quantidade BOOLEAN DEFAULT NULL,
  PRIMARY KEY (id_tipo_objeto_despesa)
);

-- tcepr.tipo_obra
CREATE TABLE tcepr.tipo_obra (
  id_tipo_obra INTEGER DEFAULT NULL,
  ds_tipo_obra VARCHAR(21) DEFAULT NULL,
  PRIMARY KEY (id_tipo_obra)
);

-- tcepr.tipo_operacao_aditivo_contrato
CREATE TABLE tcepr.tipo_operacao_aditivo_contrato (
  id_tipo_operacao_aditivo_contrato INTEGER DEFAULT NULL,
  ds_tipo_operacao_aditivo_contrato VARCHAR(62) DEFAULT NULL,
  PRIMARY KEY (id_tipo_operacao_aditivo_contrato)
);

-- tcepr.tipo_operacao_cisao_fusao
CREATE TABLE tcepr.tipo_operacao_cisao_fusao (
  id_tipo_operacao_cisao_fusao INTEGER DEFAULT NULL,
  ds_tipo_operacao_cisao_fusao VARCHAR(14) DEFAULT NULL,
  PRIMARY KEY (id_tipo_operacao_cisao_fusao)
);

-- tcepr.tipo_operacao_conciliacao
CREATE TABLE tcepr.tipo_operacao_conciliacao (
  id_tipo_operacao_conciliacao INTEGER DEFAULT NULL,
  ds_tipo_operacao_conciliacao VARCHAR(85) DEFAULT NULL,
  PRIMARY KEY (id_tipo_operacao_conciliacao)
);

-- tcepr.tipo_operacao_credito_adicional
CREATE TABLE tcepr.tipo_operacao_credito_adicional (
  id_tipo_operacao_credito_adicional INTEGER DEFAULT NULL,
  ds_tipo_operacao_credito_adicional VARCHAR(30) DEFAULT NULL,
  PRIMARY KEY (id_tipo_operacao_credito_adicional)
);

-- tcepr.tipo_operacao_divida
CREATE TABLE tcepr.tipo_operacao_divida (
  id_tipo_operacao_divida INTEGER DEFAULT NULL,
  ds_tipo_operacao_divida VARCHAR(44) DEFAULT NULL,
  PRIMARY KEY (id_tipo_operacao_divida)
);

-- tcepr.tipo_operacao_financeira
CREATE TABLE tcepr.tipo_operacao_financeira (
  id_tipo_operacao_financeira INTEGER DEFAULT NULL,
  ds_tipo_operacao_financeira VARCHAR(85) DEFAULT NULL,
  fl_exige_id_conta_transferencia BOOLEAN DEFAULT NULL,
  fl_exige_id_conta_contabil_contrapartida BOOLEAN DEFAULT NULL,
  fl_exige_id_origem_destino BOOLEAN DEFAULT NULL,
  PRIMARY KEY (id_tipo_operacao_financeira)
);

-- tcepr.tipo_operacao_pagamento
CREATE TABLE tcepr.tipo_operacao_pagamento (
  id_tipo_operacao_pagamento INTEGER DEFAULT NULL,
  ds_tipo_operacao_pagamento VARCHAR(37) DEFAULT NULL,
  PRIMARY KEY (id_tipo_operacao_pagamento)
);

-- tcepr.tipo_operacao_programacao_financeira
CREATE TABLE tcepr.tipo_operacao_programacao_financeira (
  id_tipo_operacao_programacao_financeira INTEGER DEFAULT NULL,
  ds_tipo_operacao_programacao_financeira VARCHAR(52) DEFAULT NULL,
  PRIMARY KEY (id_tipo_operacao_programacao_financeira)
);

-- tcepr.tipo_orgao_oficial
CREATE TABLE tcepr.tipo_orgao_oficial (
  id_tipo_orgao_oficial INTEGER DEFAULT NULL,
  ds_tipo_orgao_oficial VARCHAR(38) DEFAULT NULL,
  PRIMARY KEY (id_tipo_orgao_oficial)
);

-- tcepr.tipo_origem_contrato
CREATE TABLE tcepr.tipo_origem_contrato (
  id_tipo_origem_contrato INTEGER DEFAULT NULL,
  ds_tipo_origem_contrato VARCHAR(23) DEFAULT NULL,
  PRIMARY KEY (id_tipo_origem_contrato)
);

-- tcepr.tipo_origem_divida
CREATE TABLE tcepr.tipo_origem_divida (
  id_tipo_origem_divida INTEGER DEFAULT NULL,
  ds_tipo_origem_divida VARCHAR(12) DEFAULT NULL,
  PRIMARY KEY (id_tipo_origem_divida)
);

-- tcepr.tipo_origem_receita
CREATE TABLE tcepr.tipo_origem_receita (
  id_tipo_origem_receita INTEGER DEFAULT NULL,
  ds_tipo_origem_receita VARCHAR(54) DEFAULT NULL,
  PRIMARY KEY (id_tipo_origem_receita)
);

-- tcepr.tipo_parecer_licitacao
CREATE TABLE tcepr.tipo_parecer_licitacao (
  id_tipo_parecer_licitacao INTEGER DEFAULT NULL,
  ds_tipo_parecer_licitacao VARCHAR(29) DEFAULT NULL,
  PRIMARY KEY (id_tipo_parecer_licitacao)
);

-- tcepr.tipo_parte_contrato
CREATE TABLE tcepr.tipo_parte_contrato (
  id_tipo_parte_contrato INTEGER DEFAULT NULL,
  ds_tipo_parte_contrato VARCHAR(46) DEFAULT NULL,
  PRIMARY KEY (id_tipo_parte_contrato)
);

-- tcepr.tipo_permuta_status_divida
CREATE TABLE tcepr.tipo_permuta_status_divida (
  id_tipo_permuta_status_divida INTEGER DEFAULT NULL,
  ds_tipo_permuta_status_divida VARCHAR(67) DEFAULT NULL,
  PRIMARY KEY (id_tipo_permuta_status_divida)
);

-- tcepr.tipo_planilha_orcamento
CREATE TABLE tcepr.tipo_planilha_orcamento (
  id_tipo_planilha_orcamento INTEGER DEFAULT NULL,
  ds_tipo_planilha_orcamento VARCHAR(73) DEFAULT NULL,
  PRIMARY KEY (id_tipo_planilha_orcamento)
);

-- tcepr.tipo_propriedade_bem
CREATE TABLE tcepr.tipo_propriedade_bem (
  id_tipo_propriedade_bem INTEGER DEFAULT NULL,
  ds_tipo_propriedade_bem VARCHAR(8) DEFAULT NULL,
  PRIMARY KEY (id_tipo_propriedade_bem)
);

-- tcepr.tipo_publico_alvo
CREATE TABLE tcepr.tipo_publico_alvo (
  id_tipo_publico_alvo INTEGER DEFAULT NULL,
  ds_tipo_publico_alvo VARCHAR(20) DEFAULT NULL,
  PRIMARY KEY (id_tipo_publico_alvo)
);

-- tcepr.tipo_recurso_credito_adicional
CREATE TABLE tcepr.tipo_recurso_credito_adicional (
  id_tipo_recurso_credito_adicional INTEGER DEFAULT NULL,
  ds_tipo_recurso_credito_adicional VARCHAR(37) DEFAULT NULL,
  PRIMARY KEY (id_tipo_recurso_credito_adicional)
);

-- tcepr.tipo_redimensionamento_objeto_contrato
CREATE TABLE tcepr.tipo_redimensionamento_objeto_contrato (
  id_tipo_redimensionamento_objeto_contrato INTEGER DEFAULT NULL,
  ds_tipo_redimensionamento_contrato VARCHAR(32) DEFAULT NULL,
  PRIMARY KEY (id_tipo_redimensionamento_objeto_contrato)
);

-- tcepr.tipo_regime_execucao_contrato
CREATE TABLE tcepr.tipo_regime_execucao_contrato (
  id_tipo_regime_execucao_contrato INTEGER DEFAULT NULL,
  ds_tipo_regime_execucao_contrato VARCHAR(19) DEFAULT NULL,
  PRIMARY KEY (id_tipo_regime_execucao_contrato)
);

-- tcepr.tipo_regime_intervencao
CREATE TABLE tcepr.tipo_regime_intervencao (
  id_tipo_regime_intervencao INTEGER DEFAULT NULL,
  ds_tipo_regime_intervencao VARCHAR(25) DEFAULT NULL,
  PRIMARY KEY (id_tipo_regime_intervencao)
);

-- tcepr.tipo_regime_previdencia
CREATE TABLE tcepr.tipo_regime_previdencia (
  id_tipo_regime_previdencia INTEGER DEFAULT NULL,
  ds_tipo_regime_previdencia VARCHAR(4) DEFAULT NULL,
  PRIMARY KEY (id_tipo_regime_previdencia)
);

-- tcepr.tipo_registro_quadro_societario
CREATE TABLE tcepr.tipo_registro_quadro_societario (
  id_tipo_registro_quadro_societario INTEGER DEFAULT NULL,
  ds_tipo_registro_quadro_societario VARCHAR(44) DEFAULT NULL,
  PRIMARY KEY (id_tipo_registro_quadro_societario)
);

-- tcepr.tipo_renuncia
CREATE TABLE tcepr.tipo_renuncia (
  id_tipo_renuncia INTEGER DEFAULT NULL,
  ds_tipo_renuncia VARCHAR(65) DEFAULT NULL,
  PRIMARY KEY (id_tipo_renuncia)
);

-- tcepr.tipo_responsabilidade_tecnica
CREATE TABLE tcepr.tipo_responsabilidade_tecnica (
  id_tipo_responsabilidade_tecnica INTEGER DEFAULT NULL,
  ds_tipo_responsabilidade_tecnica VARCHAR(22) DEFAULT NULL,
  PRIMARY KEY (id_tipo_responsabilidade_tecnica)
);

-- tcepr.tipo_responsavel_modulo
CREATE TABLE tcepr.tipo_responsavel_modulo (
  id_tipo_responsavel_modulo INTEGER DEFAULT NULL,
  ds_tipo_responsavel_modulo VARCHAR(30) DEFAULT NULL,
  PRIMARY KEY (id_tipo_responsavel_modulo)
);

-- tcepr.tipo_revisao
CREATE TABLE tcepr.tipo_revisao (
  id_tipo_revisao INTEGER DEFAULT NULL,
  ds_tipo_revisao VARCHAR(31) DEFAULT NULL,
  PRIMARY KEY (id_tipo_revisao)
);

-- tcepr.tipo_saida_combustivel
CREATE TABLE tcepr.tipo_saida_combustivel (
  id_tipo_saida_combustivel INTEGER DEFAULT NULL,
  ds_tipo_saida_combustivel VARCHAR(24) DEFAULT NULL,
  PRIMARY KEY (id_tipo_saida_combustivel)
);

-- tcepr.tipo_saldo
CREATE TABLE tcepr.tipo_saldo (
  id_tipo_saldo INTEGER DEFAULT NULL,
  ds_tipo_saldo VARCHAR(21) DEFAULT NULL,
  PRIMARY KEY (id_tipo_saldo)
);

-- tcepr.tipo_serie_doc_fiscal
CREATE TABLE tcepr.tipo_serie_doc_fiscal (
  id_tipo_serie_doc_fiscal INTEGER DEFAULT NULL,
  ds_tipo_serie_doc_fiscal VARCHAR(14) DEFAULT NULL,
  PRIMARY KEY (id_tipo_serie_doc_fiscal)
);

-- tcepr.tipo_situacao_convenio
CREATE TABLE tcepr.tipo_situacao_convenio (
  id_tipo_situacao_convenio INTEGER DEFAULT NULL,
  ds_tipo_situacao_convenio VARCHAR(44) DEFAULT NULL,
  PRIMARY KEY (id_tipo_situacao_convenio)
);

-- tcepr.tipo_situacao_licitacao
CREATE TABLE tcepr.tipo_situacao_licitacao (
  id_tipo_situacao_licitacao INTEGER DEFAULT NULL,
  ds_tipo_situacao_licitacao VARCHAR(35) DEFAULT NULL,
  PRIMARY KEY (id_tipo_situacao_licitacao)
);

-- tcepr.tipo_situacao_participante
CREATE TABLE tcepr.tipo_situacao_participante (
  id_tipo_situacao_participante INTEGER DEFAULT NULL,
  ds_tipo_situacao_participante VARCHAR(15) DEFAULT NULL,
  PRIMARY KEY (id_tipo_situacao_participante)
);

-- tcepr.tipo_superavit_financeiro
CREATE TABLE tcepr.tipo_superavit_financeiro (
  tp_superavit_financeiro VARCHAR(1) DEFAULT NULL,
  ds_tipo_superavit_financeiro VARCHAR(16) DEFAULT NULL,
  PRIMARY KEY (tp_superavit_financeiro)
);

-- tcepr.tipo_utilizacao_bem
CREATE TABLE tcepr.tipo_utilizacao_bem (
  id_tipo_utilizacao_bem INTEGER DEFAULT NULL,
  ds_tipo_utilizacao_bem VARCHAR(20) DEFAULT NULL,
  PRIMARY KEY (id_tipo_utilizacao_bem)
);

-- tcepr.tipo_variacao_qualitativa
CREATE TABLE tcepr.tipo_variacao_qualitativa (
  id_tipo_variacao_qualitativa INTEGER DEFAULT NULL,
  ds_tipo_variacao_qualitativa VARCHAR(28) DEFAULT NULL,
  PRIMARY KEY (id_tipo_variacao_qualitativa)
);

-- tcepr.tipo_verba_folha
CREATE TABLE tcepr.tipo_verba_folha (
  id_tipo_verba_folha INTEGER DEFAULT NULL,
  ds_tipo_verba_folha VARCHAR(32) DEFAULT NULL,
  fl_vantagem BOOLEAN DEFAULT NULL,
  PRIMARY KEY (id_tipo_verba_folha)
);

-- tcepr.tipo_x_classificacao_obra
CREATE TABLE tcepr.tipo_x_classificacao_obra (
  id_tipo_obra INTEGER DEFAULT NULL,
  ds_tipo_obra VARCHAR(21) DEFAULT NULL,
  id_classificacao_obra INTEGER DEFAULT NULL,
  ds_classificacao_obra VARCHAR(27) DEFAULT NULL,
  PRIMARY KEY (id_tipo_obra, id_classificacao_obra)
);

-- tcepr.tipo_x_natureza_indicador
CREATE TABLE tcepr.tipo_x_natureza_indicador (
  id_tipo_indicador INTEGER DEFAULT NULL,
  cd_natureza_indicador VARCHAR(1) DEFAULT NULL,
  PRIMARY KEY (id_tipo_indicador, cd_natureza_indicador)
);

-- tcepr.unidade_medida
CREATE TABLE tcepr.unidade_medida (
  id_unidade_medida INTEGER DEFAULT NULL,
  ds_unidade_medida VARCHAR(25) DEFAULT NULL,
  PRIMARY KEY (id_unidade_medida)
);

-- tcepr.unidade_medida_intervencao
CREATE TABLE tcepr.unidade_medida_intervencao (
  id_unidade_medida_intervencao INTEGER DEFAULT NULL,
  ds_unidade_medida_intervencao VARCHAR(14) DEFAULT NULL,
  PRIMARY KEY (id_unidade_medida_intervencao)
);