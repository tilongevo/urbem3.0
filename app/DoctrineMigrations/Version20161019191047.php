<?php

namespace Application\Migrations;

use Urbem\CoreBundle\Helper\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161019191047 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->insertRoute('urbem_administrativo_organograma_orgao_list', 'Organograma - Orgão', 'administrativo');
        $this->insertRoute('urbem_administrativo_organograma_orgao_create', 'Novo', 'urbem_administrativo_organograma_orgao_list');
        $this->insertRoute('urbem_administrativo_organograma_orgao_edit', 'Editar', 'urbem_administrativo_organograma_orgao_list');
        $this->insertRoute('urbem_administrativo_organograma_orgao_delete', 'Remover', 'urbem_administrativo_organograma_orgao_list');
        $this->insertRoute('urbem_administrativo_organograma_orgao_show', 'Detalhes', 'urbem_administrativo_organograma_orgao_list');
        $this->insertRoute('urbem_patrimonial_frota_transporte_escolar_list', 'Controle Escolar - Transporte Escolar', 'patrimonio_frota_controle_escolar_home');
        $this->insertRoute('urbem_patrimonial_frota_transporte_escolar_create', 'Novo', 'urbem_patrimonial_frota_transporte_escolar_list');
        $this->insertRoute('urbem_patrimonial_frota_transporte_escolar_edit', 'Editar', 'urbem_patrimonial_frota_transporte_escolar_list');
        $this->insertRoute('urbem_patrimonial_frota_transporte_escolar_delete', 'Apagar', 'urbem_patrimonial_frota_transporte_escolar_list');
        $this->insertRoute('urbem_patrimonial_frota_transporte_escolar_show', 'Detalhes', 'urbem_patrimonial_frota_transporte_escolar_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacao_list', 'Compras - Solicitação Compra', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_compras_solicitacao_create', 'Novo', 'urbem_patrimonial_compras_solicitacao_list');
        $this->insertRoute('patrimonio_compras_solicitacao_perfil', 'Perfil', 'urbem_patrimonial_compras_solicitacao_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacao_edit', 'Editar', 'urbem_patrimonial_compras_solicitacao_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacao_delete', 'Apagar', 'urbem_patrimonial_compras_solicitacao_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacao_show', 'Detalhes', 'urbem_patrimonial_compras_solicitacao_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacao_anulacao_create', 'Anular', 'urbem_patrimonial_compras_solicitacao_list');
        $this->insertRoute('urbem_administrativo_protocolo_processo_imprimir_etiqueta_create', 'Protocolo - Processo - Imprimir Etiqueta', 'administrativo');
        $this->insertRoute('urbem_patrimonial_almoxarifado_requisicao_item_list', 'Almoxarifado - Requisição - Itens', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_almoxarifado_requisicao_item_create', 'Novo', 'urbem_patrimonial_almoxarifado_requisicao_item_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_requisicao_item_edit', 'Editar', 'urbem_patrimonial_almoxarifado_requisicao_item_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_requisicao_item_delete', 'Apagar', 'urbem_patrimonial_almoxarifado_requisicao_item_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_requisicao_item_show', 'Detalhes', 'urbem_patrimonial_almoxarifado_requisicao_item_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_requisicao_list', 'Almoxarifado - Requisição', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_almoxarifado_requisicao_create', 'Novo', 'urbem_patrimonial_almoxarifado_requisicao_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_requisicao_edit', 'Editar', 'urbem_patrimonial_almoxarifado_requisicao_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_requisicao_delete', 'Apagar', 'urbem_patrimonial_almoxarifado_requisicao_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_requisicao_show', 'Detalhes', 'urbem_patrimonial_almoxarifado_requisicao_list');
        $this->insertRoute('patrimonio_almoxarifado_requisicao_perfil', 'Perfil', 'urbem_patrimonial_almoxarifado_requisicao_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_catalogo_item_list', 'Item', 'patrimonio_almoxarifado_catalogo_home');
        $this->insertRoute('urbem_patrimonial_almoxarifado_catalogo_item_create', 'Novo', 'urbem_patrimonial_almoxarifado_catalogo_item_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_catalogo_item_edit', 'Editar', 'urbem_patrimonial_almoxarifado_catalogo_item_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_catalogo_item_delete', 'Apagar', 'urbem_patrimonial_almoxarifado_catalogo_item_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_catalogo_item_show', 'Detalhes', 'urbem_patrimonial_almoxarifado_catalogo_item_list');

        //Rotas de Administrativo > Organograma - Configurar Migração do Organograma
        $this->insertRoute('urbem_administrativo_organograma_de_para_orgao_dto_create', 'Organograma - Configurar Migração do Organograma', 'administrativo');
        $this->insertRoute('urbem_administrativo_organograma_de_para_orgao_list', 'Organograma - Configurar Migração do Organograma', 'administrativo');
        $this->insertRoute('urbem_administrativo_organograma_de_para_orgao_edit', 'Editar', 'urbem_administrativo_organograma_de_para_orgao_list');

        //Rotas de Patrimonial > Licitação > Convenio
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_list', 'Convenio', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_create', 'Novo', 'urbem_patrimonial_licitacao_convenio_list');
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_edit', 'Editar', 'urbem_patrimonial_licitacao_convenio_list');
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_delete', 'Apagar', 'urbem_patrimonial_licitacao_convenio_list');
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_show', 'Detalhes', 'urbem_patrimonial_licitacao_convenio_list');

        //Rotas de Patrimonial > Licitação > Convenio > Participantes
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_participante_create', 'Participante - Novo', 'urbem_patrimonial_licitacao_convenio_list');
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_participante_edit', 'Participante - Editar', 'urbem_patrimonial_licitacao_convenio_list');
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_participante_delete', 'Participante - Apagar', 'urbem_patrimonial_licitacao_convenio_list');

        //Rotas de Patrimonial > Licitação > Convenio > Publicacoes
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_publicacao_create', 'Publicação - Novo', 'urbem_patrimonial_licitacao_convenio_list');
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_publicacao_edit', 'Publicação - Editar', 'urbem_patrimonial_licitacao_convenio_list');
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_publicacao_delete', 'Publicação - Apagar', 'urbem_patrimonial_licitacao_convenio_list');

        //Rotas de Patrimonial > Licitação > Convenio > Aditivos
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_aditivos_create', 'Aditivo - Novo', 'urbem_patrimonial_licitacao_convenio_list');
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_aditivos_edit', 'Aditivo - Editar', 'urbem_patrimonial_licitacao_convenio_list');
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_aditivos_delete', 'Aditivo - Apagar', 'urbem_patrimonial_licitacao_convenio_list');

        //Rotas de Patrimonial > Licitação > Convenio > Anulação
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_anulacao_create', 'Anular Convênio', 'urbem_patrimonial_licitacao_convenio_list');

        //Rotas de Patrimonial > Licitação > Convenio > Aditivo Convenio
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_aditivos_create', 'Aditivo - Novo', 'urbem_patrimonial_licitacao_convenio_list');
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_aditivos_edit', 'Aditivo - Editar', 'urbem_patrimonial_licitacao_convenio_list');
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_aditivos_delete', 'Aditivo - Apagar', 'urbem_patrimonial_licitacao_convenio_list');

        //Rotas de Patrimonial > Licitação > Convenio > Rescindir Convenio
        $this->insertRoute('urbem_patrimonial_licitacao_convenio_aditivos_anulacao_create', 'Aditivo - Rescindir', 'urbem_patrimonial_licitacao_convenio_list');

        //Rotas de Recursos humanos > CalendarioCadastro
        $this->insertRoute('urbem_recursos_humanos_calendario_calendario_cadastro_list', 'Calendário', 'recursos_humanos');
        $this->insertRoute('urbem_recursos_humanos_calendario_calendario_cadastro_create', 'Novo', 'urbem_recursos_humanos_calendario_calendario_cadastro_list');
        $this->insertRoute('urbem_recursos_humanos_calendario_calendario_cadastro_edit', 'Editar', 'urbem_recursos_humanos_calendario_calendario_cadastro_list');
        $this->insertRoute('urbem_recursos_humanos_calendario_calendario_cadastro_delete', 'Apagar', 'urbem_recursos_humanos_calendario_calendario_cadastro_list');
        $this->insertRoute('urbem_recursos_humanos_calendario_calendario_cadastro_show', 'Detalhes', 'urbem_recursos_humanos_calendario_calendario_cadastro_list');

        //Rotas de Patrimonial > Compras > Solicitacao > Itens da Solicitacao
        $this->insertRoute('urbem_patrimonial_compras_solicitacao_item_list', 'Solicitação de Compra - Itens', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_compras_solicitacao_item_create', 'Itens - Novo', 'urbem_patrimonial_compras_solicitacao_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacao_item_edit', 'Editar', 'urbem_patrimonial_compras_solicitacao_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacao_item_delete', 'Apagar', 'urbem_patrimonial_compras_solicitacao_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacao_item_show', 'Detalhes', 'urbem_patrimonial_compras_solicitacao_list');

        //Rotas de Patrimonial > Compras > Solicitacao > Itens da Solicitacao
        $this->insertRoute('urbem_patrimonial_compras_mapa_list', 'Mapa de Compras', 'patrimonial');
        $this->insertRoute('patrimonio_compras_mapa_perfil', 'Perfil', 'urbem_patrimonial_compras_mapa_list');
        $this->insertRoute('urbem_patrimonial_compras_mapa_create', 'Novo', 'urbem_patrimonial_compras_mapa_list');
        $this->insertRoute('urbem_patrimonial_compras_mapa_edit', 'Editar', 'urbem_patrimonial_compras_mapa_list');
        $this->insertRoute('urbem_patrimonial_compras_mapa_delete', 'Apagar', 'urbem_patrimonial_compras_mapa_list');
        $this->insertRoute('urbem_patrimonial_compras_mapa_show', 'Detalhes', 'urbem_patrimonial_compras_mapa_list');

        //Rotas de Patrimonial > Compras > Solicitacao > Itens da Solicitacao
        $this->insertRoute('urbem_patrimonial_compras_mapa_solicitacao_list', 'Mapa de Compras - Solicitação', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_compras_mapa_solicitacao_create', 'Mapa de Compras - Solicitação - Novo', 'urbem_patrimonial_compras_mapa_list');
        $this->insertRoute('urbem_patrimonial_compras_mapa_solicitacao_edit', 'Mapa de Compras - Solicitação - Editar', 'urbem_patrimonial_compras_mapa_list');
        $this->insertRoute('urbem_patrimonial_compras_mapa_solicitacao_delete', 'Mapa de Compras - Solicitação - Apagar', 'urbem_patrimonial_compras_mapa_list');
        $this->insertRoute('urbem_patrimonial_compras_mapa_solicitacao_show', 'Mapa de Compras - Solicitação - Detalhes', 'urbem_patrimonial_compras_mapa_list');

        //Rotas de Almoxarifado > Pedido Transferência
        $this->insertRoute('urbem_patrimonial_almoxarifado_pedido_transferencia_list', 'Pedido de Transferência', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_almoxarifado_pedido_transferencia_create', 'Novo', 'urbem_patrimonial_almoxarifado_pedido_transferencia_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_pedido_transferencia_edit', 'Editar', 'urbem_patrimonial_almoxarifado_pedido_transferencia_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_pedido_transferencia_delete', 'Apagar', 'urbem_patrimonial_almoxarifado_pedido_transferencia_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_pedido_transferencia_show', 'Detalhes', 'urbem_patrimonial_almoxarifado_pedido_transferencia_list');

        //Rotas de Almoxarifado > Pedido Transferência Item
        $this->insertRoute('urbem_patrimonial_almoxarifado_pedido_transferencia_item_create', 'Pedido de Transferência Item - Novo', 'urbem_patrimonial_almoxarifado_pedido_transferencia_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_pedido_transferencia_item_edit', 'Pedido de Transferência Item - Editar', 'urbem_patrimonial_almoxarifado_pedido_transferencia_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_pedido_transferencia_item_delete', 'Pedido de Transferência Item - Apagar', 'urbem_patrimonial_almoxarifado_pedido_transferencia_list');

        //Rotas de Patrimonial > Licitação > Licitação > Incluir Processo Licitatório
        $this->insertRoute('urbem_patrimonial_licitacao_licitacao_list', 'Licitação - Processo Licitatório', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_licitacao_create', 'Novo', 'urbem_patrimonial_licitacao_licitacao_list');
        $this->insertRoute('patrimonio_licitacao_licitacao_perfil', 'Perfil', 'urbem_patrimonial_licitacao_licitacao_list');
        $this->insertRoute('urbem_patrimonial_licitacao_licitacao_edit', 'Editar', 'urbem_patrimonial_licitacao_licitacao_list');
        $this->insertRoute('urbem_patrimonial_licitacao_licitacao_delete', 'Apagar', 'urbem_patrimonial_licitacao_licitacao_list');
        $this->insertRoute('urbem_patrimonial_licitacao_licitacao_show', 'Detalhes', 'urbem_patrimonial_licitacao_licitacao_list');

        //Rotas de Patrimonial > Licitação > Licitação > Incluir Processo Licitatório - Membro Adicional
        $this->insertRoute('urbem_patrimonial_licitacao_membro_adicional_list', 'Licitação - Membro Adicional', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_membro_adicional_create', 'Novo', 'urbem_patrimonial_licitacao_membro_adicional_list');
        $this->insertRoute('urbem_patrimonial_licitacao_membro_adicional_edit', 'Editar', 'urbem_patrimonial_licitacao_membro_adicional_list');
        $this->insertRoute('urbem_patrimonial_licitacao_membro_adicional_delete', 'Apagar', 'urbem_patrimonial_licitacao_membro_adicional_list');
        $this->insertRoute('urbem_patrimonial_licitacao_membro_adicional_show', 'Detalhes', 'urbem_patrimonial_licitacao_membro_adicional_list');

        //Rotas de Patrimonial > Licitação > Licitação > Incluir Processo Licitatório - Documentos Exigidos
        $this->insertRoute('urbem_patrimonial_licitacao_documento_list', 'Licitação - Documentos Exigidos', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_documento_create', 'Novo', 'urbem_patrimonial_licitacao_documento_list');
        $this->insertRoute('urbem_patrimonial_licitacao_documento_edit', 'Editar', 'urbem_patrimonial_licitacao_documento_list');
        $this->insertRoute('urbem_patrimonial_licitacao_documento_delete', 'Apagar', 'urbem_patrimonial_licitacao_documento_list');
        $this->insertRoute('urbem_patrimonial_licitacao_documento_show', 'Detalhes', 'urbem_patrimonial_licitacao_documento_list');

        //Rotas de Patrimonial > Almoxarifado > Entrada > Devolução com Requisição
        $this->insertRoute('patrimonial_almoxarifado_entrada_home', 'Almoxarifado - Entrada', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_almoxarifado_entrada_devolucao_requisicao_list', 'Devolução com Requisição', 'patrimonial_almoxarifado_entrada_home');
        $this->insertRoute('urbem_patrimonial_almoxarifado_entrada_devolucao_requisicao_edit', 'Registrar Devolução', 'urbem_patrimonial_almoxarifado_entrada_devolucao_requisicao_list');

        //Rotas de Patrimonial > Licitação > Licitação > Incluir Processo Licitatório - Licitação Documentos
        $this->insertRoute('urbem_patrimonial_licitacao_documentos_list', 'Licitação - Documentos da Licitação', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_documentos_create', 'Novo', 'urbem_patrimonial_licitacao_documentos_list');
        $this->insertRoute('urbem_patrimonial_licitacao_documentos_edit', 'Editar', 'urbem_patrimonial_licitacao_documentos_list');
        $this->insertRoute('urbem_patrimonial_licitacao_documentos_delete', 'Apagar', 'urbem_patrimonial_licitacao_documentos_list');
        $this->insertRoute('urbem_patrimonial_licitacao_documentos_show', 'Detalhes', 'urbem_patrimonial_licitacao_documentos_list');

        //Rotas de Patrimonial > Licitação > Licitação > Incluir Processo Licitatório - Participante
        $this->insertRoute('urbem_patrimonial_licitacao_participante_list', 'Licitação - Participantes', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_participante_create', 'Novo', 'urbem_patrimonial_licitacao_participante_list');
        $this->insertRoute('urbem_patrimonial_licitacao_participante_edit', 'Editar', 'urbem_patrimonial_licitacao_participante_list');
        $this->insertRoute('urbem_patrimonial_licitacao_participante_delete', 'Apagar', 'urbem_patrimonial_licitacao_participante_list');
        $this->insertRoute('urbem_patrimonial_licitacao_participante_show', 'Detalhes', 'urbem_patrimonial_licitacao_participante_list');

        //Rotas de Patrimonial > Licitação > Licitação > Incluir Processo Licitatório - Participante Documento
        $this->insertRoute('urbem_patrimonial_licitacao_participante_documentos_list', 'Licitação - Participantes Documentos', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_participante_documentos_create', 'Novo', 'urbem_patrimonial_licitacao_participante_documentos_list');
        $this->insertRoute('urbem_patrimonial_licitacao_participante_documentos_edit', 'Editar', 'urbem_patrimonial_licitacao_participante_documentos_list');
        $this->insertRoute('urbem_patrimonial_licitacao_participante_documentos_delete', 'Apagar', 'urbem_patrimonial_licitacao_participante_documentos_list');
        $this->insertRoute('urbem_patrimonial_licitacao_participante_documentos_show', 'Detalhes', 'urbem_patrimonial_licitacao_participante_documentos_list');

        //Rotas de Compras > Compra Direta > Manutencao Proposta
        $this->insertRoute('urbem_patrimonial_compras_manutencao_proposta_list', 'Manutenção Proposta', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_compras_manutencao_proposta_show', 'Detalhes', 'urbem_patrimonial_compras_manutencao_proposta_list');
        $this->insertRoute('urbem_patrimonial_compras_manutencao_proposta_edit', 'Editar', 'urbem_patrimonial_compras_manutencao_proposta_list');

        //Rotas de Compras > Compra Direta > Manutencao Proposta Item
        $this->insertRoute('urbem_patrimonial_compras_cotacao_fornecedor_item_create', 'Fornecedor-Item - Novo', 'urbem_patrimonial_compras_manutencao_proposta_list');
        $this->insertRoute('urbem_patrimonial_compras_cotacao_fornecedor_item_edit', 'Fornecedor-Item - Editar', 'urbem_patrimonial_compras_manutencao_proposta_list');
        $this->insertRoute('urbem_patrimonial_compras_cotacao_fornecedor_item_delete', 'Fornecedor-Item - Apagar', 'urbem_patrimonial_compras_manutencao_proposta_list');

        //Rotas de Patrimonial > Licitação > Licitação > Incluir Processo Licitatório - Suspensão Edital
        $this->insertRoute('urbem_patrimonial_licitacao_edital_suspenso_list', 'Licitação - Suspensão Edital', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_edital_suspenso_create', 'Novo', 'urbem_patrimonial_licitacao_edital_suspenso_list');
        $this->insertRoute('urbem_patrimonial_licitacao_edital_suspenso_edit', 'Editar', 'urbem_patrimonial_licitacao_edital_suspenso_list');
        $this->insertRoute('urbem_patrimonial_licitacao_edital_suspenso_delete', 'Apagar', 'urbem_patrimonial_licitacao_edital_suspenso_list');
        $this->insertRoute('urbem_patrimonial_licitacao_edital_suspenso_show', 'Detalhes', 'urbem_patrimonial_licitacao_edital_suspenso_list');

        //Rotas de Patrimonial > Licitação > Licitação > Processo Licitatório - Edital Publicacao
        $this->insertRoute('urbem_patrimonial_licitacao_publicacao_edital_list', 'Licitação - Publicação Edital', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_publicacao_edital_create', 'Novo', 'urbem_patrimonial_licitacao_publicacao_edital_list');
        $this->insertRoute('urbem_patrimonial_licitacao_publicacao_edital_edit', 'Editar', 'urbem_patrimonial_licitacao_publicacao_edital_list');
        $this->insertRoute('urbem_patrimonial_licitacao_publicacao_edital_delete', 'Apagar', 'urbem_patrimonial_licitacao_publicacao_edital_list');
        $this->insertRoute('urbem_patrimonial_licitacao_publicacao_edital_show', 'Detalhes', 'urbem_patrimonial_licitacao_publicacao_edital_list');

        //Rotas de Patrimonial > Licitação > Licitação > Processo Licitatório - Edital
        $this->insertRoute('urbem_patrimonial_licitacao_edital_list', 'Licitação - Edital', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_edital_create', 'Novo', 'urbem_patrimonial_licitacao_edital_list');
        $this->insertRoute('patrimonio_licitacao_edital_perfil', 'Perfil', 'urbem_patrimonial_licitacao_edital_list');
        $this->insertRoute('urbem_patrimonial_licitacao_edital_edit', 'Editar', 'urbem_patrimonial_licitacao_edital_list');
        $this->insertRoute('urbem_patrimonial_licitacao_edital_delete', 'Apagar', 'urbem_patrimonial_licitacao_edital_list');
        $this->insertRoute('urbem_patrimonial_licitacao_edital_show', 'Detalhes', 'urbem_patrimonial_licitacao_edital_list');

        //Rotas de Patrimonial > Patrimonio > Inventario
        $this->insertRoute('urbem_patrimonial_patrimonio_inventario_list', 'Inventário', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_patrimonio_inventario_create', 'Novo', 'urbem_patrimonial_patrimonio_inventario_list');
        $this->insertRoute('urbem_patrimonial_patrimonio_inventario_edit', 'Editar', 'urbem_patrimonial_patrimonio_inventario_list');
        $this->insertRoute('urbem_patrimonial_patrimonio_inventario_delete', 'Apagar', 'urbem_patrimonial_patrimonio_inventario_list');
        $this->insertRoute('urbem_patrimonial_patrimonio_inventario_show', 'Detalhes', 'urbem_patrimonial_patrimonio_inventario_list');

        //Rotas de Patrimonial > Patrimonio > Inventário - Alterar Item
        $this->insertRoute('urbem_patrimonial_patrimonio_inventario_historico_bem_create', 'Inventário - Alterar Item', 'urbem_patrimonial_patrimonio_inventario_list');

        //Rotas de Patrimonial > Licitação > Licitação > Processo Licitatório - Edital Impugnado
        $this->insertRoute('urbem_patrimonial_licitacao_edital_impugnado_list', 'Licitação - Edital Impugnado ', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_edital_impugnado_create', 'Novo', 'urbem_patrimonial_licitacao_edital_impugnado_list');
        $this->insertRoute('urbem_patrimonial_licitacao_edital_impugnado_edit', 'Editar', 'urbem_patrimonial_licitacao_edital_impugnado_list');
        $this->insertRoute('urbem_patrimonial_licitacao_edital_impugnado_delete', 'Apagar', 'urbem_patrimonial_licitacao_edital_impugnado_list');
        $this->insertRoute('urbem_patrimonial_licitacao_edital_impugnado_show', 'Detalhes', 'urbem_patrimonial_licitacao_edital_impugnado_list');

        //Rotas de Patrimonial > Almoxarifado > Inventario
        $this->insertRoute('urbem_patrimonial_almoxarifado_inventario_list', 'Almoxarifado - Inventario', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_almoxarifado_inventario_create', 'Novo', 'urbem_patrimonial_almoxarifado_inventario_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_inventario_edit', 'Editar', 'urbem_patrimonial_almoxarifado_inventario_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_inventario_delete', 'Anular', 'urbem_patrimonial_almoxarifado_inventario_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_inventario_show', 'Detalhes', 'urbem_patrimonial_almoxarifado_inventario_list');

        //Rotas de Patrimonial > Almoxarifado > Inventario Itens
        $this->insertRoute('urbem_patrimonial_almoxarifado_inventario_item_create', 'Item - Novo', 'urbem_patrimonial_almoxarifado_inventario_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_inventario_item_edit', 'Item - Editar', 'urbem_patrimonial_almoxarifado_inventario_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_inventario_item_delete', 'Item - Excluir', 'urbem_patrimonial_almoxarifado_inventario_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_inventario_item_show', 'Item - Detalhe', 'urbem_patrimonial_almoxarifado_inventario_list');

        //Rotas de Patrimonial > Licitação > Licitação > Processo Licitatório - Anulacao Edital Impugnado
        $this->insertRoute('urbem_patrimonial_licitacao_anulacao_impugnacao_edital_list', 'Licitação - Anulação da Impugnação do Edital ', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_anulacao_impugnacao_edital_create', 'Novo', 'urbem_patrimonial_licitacao_anulacao_impugnacao_edital_list');
        $this->insertRoute('urbem_patrimonial_licitacao_anulacao_impugnacao_edital_edit', 'Editar', 'urbem_patrimonial_licitacao_anulacao_impugnacao_edital_list');
        $this->insertRoute('urbem_patrimonial_licitacao_anulacao_impugnacao_edital_delete', 'Apagar', 'urbem_patrimonial_licitacao_anulacao_impugnacao_edital_list');
        $this->insertRoute('urbem_patrimonial_licitacao_anulacao_impugnacao_edital_show', 'Detalhes', 'urbem_patrimonial_licitacao_anulacao_impugnacao_edital_list');

        //Rotas de Patrimonial > Patrimonio > Inventário - Alterar Item
        $this->insertRoute('urbem_patrimonial_patrimonio_inventario_historico_bem_create', 'Inventário - Alterar Item', 'urbem_patrimonial_patrimonio_inventario_list');

        //Rotas de Patrimonial > Patrimonio > Licitação - Edital > Anulação
        $this->insertRoute('urbem_patrimonial_licitacao_edital_anulado_create', 'Anulação', 'patrimonio_licitacao_edital_perfil');

        //Rotas de Patrimonial > Licitacao > Processo Licitatorio > Ata de Encerramento
        $this->insertRoute('urbem_patrimonial_licitacao_processo_licitatorio_ata_encerramento_list', 'Atas de Encerramento', 'patrimonio_licitacao_processo_licitatorio_home');
        $this->insertRoute('urbem_patrimonial_licitacao_processo_licitatorio_ata_encerramento_create', 'Nova', 'urbem_patrimonial_licitacao_processo_licitatorio_ata_encerramento_list');
        $this->insertRoute('urbem_patrimonial_licitacao_processo_licitatorio_ata_encerramento_edit', 'Editar', 'urbem_patrimonial_licitacao_processo_licitatorio_ata_encerramento_list');
        $this->insertRoute('urbem_patrimonial_licitacao_processo_licitatorio_ata_encerramento_show', 'Detalhes', 'urbem_patrimonial_licitacao_processo_licitatorio_ata_encerramento_list');

        //Rotas de Patrimonial > Frota > Veículo > Manutenção de Utilização > Retornar Veículo
        $this->insertRoute('urbem_patrimonial_frota_veiculo_retornar_veiculo_create', 'Retornar Veículo', 'urbem_patrimonial_frota_veiculo_retirar_veiculo_list');

        //Rotas de Patrimonial > Licitação > Convênio - Home
        $this->insertRoute('patrimonio_licitacao_convenios_home', 'Licitação - Convênio', 'patrimonial');

        //Rotas de Patrimonial > Frota > Manutenção
        $this->insertRoute('urbem_patrimonial_frota_manutencao_list', 'Frota - Manutenção', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_frota_manutencao_create', 'Novo', 'urbem_patrimonial_frota_manutencao_list');
        $this->insertRoute('urbem_patrimonial_frota_manutencao_edit', 'Editar', 'urbem_patrimonial_frota_manutencao_list');
        $this->insertRoute('urbem_patrimonial_frota_manutencao_delete', 'Apagar', 'urbem_patrimonial_frota_manutencao_list');
        $this->insertRoute('urbem_patrimonial_frota_manutencao_show', 'Detalhes', 'urbem_patrimonial_frota_manutencao_list');

        //Rotas de Patrimonial > Licitação > Adjudicação
        $this->insertRoute('urbem_patrimonial_licitacao_adjudicacao_create', 'Adjudicação ', 'urbem_patrimonial_licitacao_licitacao_list');

        //Rotas de Patrimonial > Almoxarifado > Implantação - Processar Implantação
        $this->insertRoute('urbem_patrimonial_almoxarifado_processar_implantacao_create', 'Almoxarifado - Implantação - Processar Implantação', 'patrimonial');
        $this->insertRoute('patrimonio_almoxarifado_processar_importacao_perfil', 'Perecivel', 'urbem_patrimonial_almoxarifado_processar_implantacao_create');

        //Rotas de Patrimonial > Almoxarifado > Implantação - Processar Implantação > Perecivel > Adicionar
        $this->insertRoute('urbem_patrimonial_almoxarifado_processar_implantacao_perecivel_create', 'Almoxarifado - Implantação - Processar Implantação - Perecível - Adicionar', 'patrimonial');

        //Rotas de Patrimonial > Licitação > Homologação
        $this->insertRoute('urbem_patrimonial_licitacao_homologacao_create', 'Homologação ', 'urbem_patrimonial_licitacao_licitacao_list');

        $this->insertRoute('urbem_patrimonial_frota_manutencao_item_create', 'Item - Novo', 'urbem_patrimonial_frota_manutencao_list');
        $this->insertRoute('urbem_patrimonial_frota_manutencao_item_edit', 'Item - Editar', 'urbem_patrimonial_frota_manutencao_list');
        $this->insertRoute('urbem_patrimonial_frota_manutencao_item_delete', 'Item - Apagar', 'urbem_patrimonial_frota_manutencao_list');

        //Rotas de Patrimonial > Licitação > Manutenção de Proposta
        $this->insertRoute('urbem_patrimonial_licitacao_manutencao_proposta_list', 'Licitação - Manutenção Proposta ', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_manutencao_proposta_create', 'Novo', 'urbem_patrimonial_licitacao_manutencao_proposta_list');
        $this->insertRoute('urbem_patrimonial_licitacao_manutencao_proposta_edit', 'Editar', 'urbem_patrimonial_licitacao_manutencao_proposta_list');
        $this->insertRoute('urbem_patrimonial_licitacao_manutencao_proposta_delele', 'Apagar', 'urbem_patrimonial_licitacao_manutencao_proposta_list');
        $this->insertRoute('urbem_patrimonial_licitacao_manutencao_proposta_show', 'Detalhe', 'urbem_patrimonial_licitacao_manutencao_proposta_list');

        $this->insertRoute('urbem_patrimonial_licitacao_cotacao_fornecedor_item_edit', 'Editar', 'urbem_patrimonial_licitacao_manutencao_proposta_list');

        //Rotas de Patrimonial > Licitação > Adjudicação
        $this->insertRoute('urbem_patrimonial_frota_manutencao_anulacao_create', 'Anulação ', 'urbem_patrimonial_frota_manutencao_list');

        //Rotas de Patrimonial > Almoxarifado > Saida de Requisicao
        $this->insertRoute('urbem_patrimonial_almoxarifado_saida_devolucao_requisicao_list', 'Saída de Requisição', 'patrimonial_almoxarifado_saida_home');
        $this->insertRoute('urbem_patrimonial_almoxarifado_saida_devolucao_requisicao_edit', 'Registrar Saída', 'urbem_patrimonial_almoxarifado_saida_devolucao_requisicao_list');

        //Rotas de Patrimonial > Compras > Homologação de Proposta
        $this->insertRoute('urbem_patrimonial_compras_homologacao_compra_direta_list', 'Compra Direta - Homologação de Proposta ', 'patrimonio_compras_compra_direta_home');
        $this->insertRoute('urbem_patrimonial_compras_homologacao_compra_direta_create', 'Novo', 'urbem_patrimonial_compras_homologacao_compra_direta_list');
        $this->insertRoute('urbem_patrimonial_compras_homologacao_compra_direta_edit', 'Editar', 'urbem_patrimonial_compras_homologacao_compra_direta_list');
        $this->insertRoute('urbem_patrimonial_compras_homologacao_compra_direta_delete', 'Apagar', 'urbem_patrimonial_compras_homologacao_compra_direta_list');
        $this->insertRoute('urbem_patrimonial_compras_homologacao_compra_direta_show', 'Detalhe', 'urbem_patrimonial_compras_homologacao_compra_direta_list');

        //Rotas de Patrimonial > Compra Direta > Gestão Julgamento
        $this->insertRoute('urbem_patrimonial_compras_compra_direta_gestao_julgamento_list', 'Compra direta - Excluir julgamento de proposta', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_compras_compra_direta_gestao_julgamento_show', 'Detalhe', 'urbem_patrimonial_compras_compra_direta_gestao_julgamento_list');
        $this->insertRoute('urbem_patrimonial_compras_compra_direta_gestao_julgamento_delete', 'Apagar julgamento de proposta', 'urbem_patrimonial_compras_compra_direta_gestao_julgamento_list');

        //Rotas de Patrimonial > Licitação > Gestão Julgamento
        $this->insertRoute('urbem_patrimonial_licitacao_gestao_julgamento_list', 'Licitação - Excluir julgamento de processo', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_gestao_julgamento_show', 'Detalhe', 'urbem_patrimonial_licitacao_gestao_julgamento_list');
        $this->insertRoute('urbem_patrimonial_licitacao_gestao_julgamento_delete', 'Apagar julgamento de proposta', 'urbem_patrimonial_licitacao_gestao_julgamento_list');

        //Rotas de Patrimonial > Licitação > Autorização de Empenho
        $this->insertRoute('urbem_patrimonial_licitacao_autorizacao_empenho_list', 'Licitação - Autorização de Empenho', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_licitacao_autorizacao_empenho_edit', 'Registrar Autorização', 'urbem_patrimonial_licitacao_autorizacao_empenho_list');

        //Rotas de Patrimonial > Compras > Autorização de Empenho
        $this->insertRoute('urbem_patrimonial_compras_autorizacao_empenho_compra_direta_list', 'Compra Direta - Autorização de Empenho', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_compras_autorizacao_empenho_compra_direta_create', 'Registrar Autorização', 'urbem_patrimonial_compras_autorizacao_empenho_compra_direta_list');

        $this->insertRoute('urbem_patrimonial_licitacao_julgamento_proposta_list', 'Julgamento de Proposta', 'patrimonio_licitacao_processo_licitatorio_home');
        $this->insertRoute('urbem_patrimonial_licitacao_julgamento_proposta_show', 'Detalhe', 'urbem_patrimonial_licitacao_julgamento_proposta_list');
        $this->insertRoute('urbem_patrimonial_licitacao_julgamento_proposta_cotacao_show', 'Cotação', 'urbem_patrimonial_licitacao_julgamento_proposta_list');
        $this->insertRoute('urbem_patrimonial_licitacao_julgamento_proposta_cotacao_julgamento_create', 'Incluir', 'urbem_patrimonial_licitacao_julgamento_proposta_list');
        $this->insertRoute('urbem_patrimonial_licitacao_julgamento_proposta_cotacao_julgamento_edit', 'Editar', 'urbem_patrimonial_licitacao_julgamento_proposta_list');

        //Rotas de Patrimonial > Almoxarifado > Entrada > Entrada por Doação
        $this->insertRoute('urbem_patrimonial_almoxarifado_entrada_doacao_list', 'Entrada por Doação', 'patrimonial_almoxarifado_entrada_home');
        $this->insertRoute('urbem_patrimonial_almoxarifado_entrada_doacao_create', 'Incluir', 'urbem_patrimonial_almoxarifado_entrada_doacao_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_entrada_doacao_show', 'Detalhe', 'urbem_patrimonial_almoxarifado_entrada_doacao_list');

        //Rotas de Patrimonial > Almoxarifado > Entrada > Entrada por Ordem de Compras
        $this->insertRoute('urbem_patrimonial_compras_entrada_compras_ordem_list', 'Entrada por Ordem de Compra', 'patrimonial_almoxarifado_entrada_home');
        $this->insertRoute('urbem_patrimonial_compras_entrada_compras_ordem_edit', 'Incluir', 'urbem_patrimonial_compras_entrada_compras_ordem_list');
        $this->insertRoute('urbem_patrimonial_compras_entrada_compras_ordem_show', 'Perfil', 'urbem_patrimonial_compras_entrada_compras_ordem_list');

        $this->insertRoute('urbem_patrimonial_almoxarifado_estoque_material_create', 'Almoxarifado Estoque - Incluir', 'patrimonial_almoxarifado_entrada_home');

        //Rotas de Patrimonial > Almoxarifado > Saidas > Saidas Diversos
        $this->insertRoute('urbem_patrimonial_almoxarifado_saida_diversas_create', 'Saidas Diversas', 'patrimonial_almoxarifado_saida_home');

        //Rotas de Patrimonial > Almoxarifado > Entrada > Entradas Diversas
        $this->insertRoute('urbem_patrimonial_almoxarifado_entrada_diversos_create', 'Entradas Diversas', 'patrimonial_almoxarifado_entrada_home');

        //Rotas de Patrimonial > Almoxarifado > Saídas - Home
        $this->insertRoute('patrimonial_almoxarifado_saida_home', 'Almoxarifado - Saída', 'patrimonial');

        //Rotas de Patrimonial > Almoxarifado > Saida > Saida por Autorização de Abastecimento
        $this->insertRoute('urbem_patrimonial_almoxarifado_saida_autorizacao_abastecimento_list', 'Saída por Autorização de Abastecimento', 'patrimonial_almoxarifado_saida_home');
        $this->insertRoute('urbem_patrimonial_almoxarifado_saida_autorizacao_abastecimento_edit', 'Incluir', 'urbem_patrimonial_almoxarifado_saida_autorizacao_abastecimento_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_saida_autorizacao_abastecimento_show', 'Detalhe', 'urbem_patrimonial_almoxarifado_saida_autorizacao_abastecimento_list');

        //Rotas de Patrimonial > Almoxarifado > Saidas > Saida por Transferencia
        $this->insertRoute('urbem_patrimonial_almoxarifado_saida_transferencia_list', 'Saída por Tranferência', 'patrimonial_almoxarifado_saida_home');
        $this->insertRoute('urbem_patrimonial_almoxarifado_saida_transferencia_show', 'Detalhe', 'urbem_patrimonial_almoxarifado_saida_transferencia_list');

        //Rotas de Patrimonial > Almoxarifado > Saidas > Saida por Estorno de Entrada
        $this->insertRoute('urbem_patrimonial_almoxarifado_saida_estorno_list', 'Saída por Estorno de Entrada', 'patrimonial_almoxarifado_saida_home');
        $this->insertRoute('urbem_patrimonial_almoxarifado_saida_estorno_show', 'Detalhe', 'urbem_patrimonial_almoxarifado_saida_estorno_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_saida_estorno_item_create', 'Estornar Item', 'urbem_patrimonial_almoxarifado_saida_estorno_list');

        //Rotas de Patrimonial > Almoxarifado > Saidas > Saida por Estorno de Entrada > Estornar Item
        $this->insertRoute('urbem_patrimonial_almoxarifado_lancamento_material_create', 'Estornar Item', 'urbem_patrimonial_almoxarifado_saida_estorno_list');

        //Rotas de Patrimonial > Almoxarifado > Entradas > Entrada por Transferencia
        $this->insertRoute('urbem_patrimonial_almoxarifado_entrada_transferencia_list', 'Entrada por Tranferência', 'patrimonial_almoxarifado_entrada_home');
        $this->insertRoute('urbem_patrimonial_almoxarifado_entrada_transferencia_show', 'Detalhe', 'urbem_patrimonial_almoxarifado_entrada_transferencia_list');

        //Rotas de Patrimonial > Frota > Configuração
        $this->insertRoute('patrimonio_frota_configuracao_home', 'Frota - Configuracao', 'patrimonial');

        //Rotas de Patrimonial > Compra Direta > Julgamento das Propostas
        $this->insertRoute('urbem_patrimonial_compras_julgamento_list', 'Compra Direta :: Julgamento das Propostas', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_compras_julgamento_edit', 'Julgamento das Propostas', 'urbem_patrimonial_compras_julgamento_list');

        $this->insertRoute('urbem_patrimonial_compras_julgamento_proposta_list', 'Compra Direta :: Julgamento das Propostas', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_compras_julgamento_proposta_show', 'Itens', 'urbem_patrimonial_compras_julgamento_proposta_list');
        $this->insertRoute('urbem_patrimonial_compras_julgamento_proposta_item_edit', 'Julgamento', 'urbem_patrimonial_compras_julgamento_proposta_list');

        //Rotas de Administrativo > Protocolo - Configuração
        $this->insertRoute('urbem_administrativo_protocolo_configuracao', 'Protocolo - Configuração', 'administrativo');

        //Rotas de Patrimonial > Compras - Configuração
        $this->insertRoute('urbem_patrimonial_compras_configuracao', 'Compras - Configuração', 'patrimonial');
        $this->insertRoute('patrimonio_compras_compra_direta_home', 'Compra Direta', 'patrimonial');

        //Rotas de Patrimonial > Patrimonio - Configuração
        $this->insertRoute('urbem_patrimonial_patrimonio_configuracao', 'Patrimonio - Configuração', 'patrimonio_patrimonial_configuracao_home');

        //Rotas de RH > Pessoal - Configuração
        $this->insertRoute('urbem_rh_pessoal_configuracao', 'Pessoal - Configuração', 'recursos_humanos');

        //Rotas de Patrimonial > Almoxarifado - Configuração
        $this->insertRoute('urbem_patrimonial_almoxarifado_configuracao', 'Almoxarifado - Configuração', 'patrimonial');

        //Rotas de Administrativo > Sistema - Configuração
        $this->insertRoute('urbem_administrativo_sistema_configuracao', 'Alterar Mensagem', 'administracao_sistema_home');

        //Rotas de Patrimonial > Almoxarifado > Centro de Custo
        $this->insertRoute('urbem_patrimonial_almoxarifado_centro_custo_list', 'Centro de Custo - Almoxarifado', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_almoxarifado_centro_custo_create', 'Novo', 'urbem_patrimonial_almoxarifado_centro_custo_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_centro_custo_edit', 'Editar', 'urbem_patrimonial_almoxarifado_centro_custo_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_centro_custo_delete', 'Apagar', 'urbem_patrimonial_almoxarifado_centro_custo_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_centro_custo_show', 'Detalhes', 'urbem_patrimonial_almoxarifado_centro_custo_list');

        //Rotas de Patrimonial > Almoxarifado > Centro de Custo > Dotacao
        $this->insertRoute('urbem_patrimonial_almoxarifado_centro_custo_dotacao_list', 'Centro de Custo - Dotação', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_almoxarifado_centro_custo_dotacao_create', 'Novo', 'urbem_patrimonial_almoxarifado_centro_custo_dotacao_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_centro_custo_dotacao_edit', 'Editar', 'urbem_patrimonial_almoxarifado_centro_custo_dotacao_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_centro_custo_dotacao_delete', 'Apagar', 'urbem_patrimonial_almoxarifado_centro_custo_dotacao_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_centro_custo_dotacao_show', 'Detalhes', 'urbem_patrimonial_almoxarifado_centro_custo_dotacao_list');

        //Rotas de Patrimonial > Almoxarifado > Centro de Custo > Permissões
        $this->insertRoute('urbem_patrimonial_almoxarifado_centro_custo_permissao_create', 'Permissões', 'urbem_patrimonial_almoxarifado_centro_custo_list');
        $this->insertRoute('urbem_patrimonial_almoxarifado_centro_custo_permissao_edit', 'Permissões', 'urbem_patrimonial_almoxarifado_centro_custo_list');

        //Rotas de Patrimonial > Almoxarifado > Processar Implantacao
        $this->insertRoute('urbem_patrimonial_almoxarifado_processar_implantacao_show', 'Almoxarifado - Implantação - Processar Implantação - Perecível - Detalhes', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_almoxarifado_perecivel_delete', 'Almoxarifado - Implantação - Processar Implantação - Perecível - Apagar', 'patrimonial');

        //Rotas de Patrimonial > Compras - Configuração
        $this->insertRoute('urbem_patrimonial_compras_configuracao_list', 'Compras - Configuração', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_compras_configuracao_show', 'Responsável', 'urbem_patrimonial_compras_configuracao_list');
        $this->insertRoute('urbem_patrimonial_compras_configuracao_entidade_create', 'Responsavel - Novo', 'urbem_patrimonial_compras_configuracao_list');
        $this->insertRoute('urbem_patrimonial_compras_configuracao_entidade_delete', 'Responsavel - Apagar', 'urbem_patrimonial_compras_configuracao_list');

        //Rotas de Patrimonial > Compras > Solicitacao > Itens de Outras Solicitações
        $this->insertRoute('urbem_patrimonial_compras_solicitacoes_itens_create', 'Novo', 'urbem_patrimonial_compras_solicitacoes_itens_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacoes_itens_edit', 'Editar', 'urbem_patrimonial_compras_solicitacoes_itens_list');
        $this->insertRoute('urbem_patrimonial_compras_solicitacoes_itens_delete', 'Apagar', 'urbem_patrimonial_compras_solicitacoes_itens_list');

        //Rotas de Patrimonial > Patrimonio > Agendamento > Incluir Agendamento
        $this->insertRoute('urbem_patrimonial_patrimonio_manutencao_list', 'Agendar', 'patrimonio_manutencao_home');
        $this->insertRoute('urbem_patrimonial_patrimonio_manutencao_create', 'Agendamento - Novo', 'urbem_patrimonial_patrimonio_manutencao_list');
        $this->insertRoute('urbem_patrimonial_patrimonio_manutencao_edit', 'Agendamento - Editar', 'urbem_patrimonial_patrimonio_manutencao_list');
        //Recursos Humanos > Folha Pagamento - Configuração > Cálculo de Benefícios
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_configuracao_beneficio_list', 'Cálculo de Benefícios', 'folha_pagamento_configuracao_home');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_configuracao_beneficio_create', 'Criar', 'urbem_recursos_humanos_folha_pagamento_configuracao_configuracao_beneficio_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_configuracao_beneficio_edit', 'Editar', 'urbem_recursos_humanos_folha_pagamento_configuracao_configuracao_beneficio_list');

        //Rotas de Patrimonial > Patrimonio > Manutencao > Incluir Manutencao
        $this->insertRoute('urbem_patrimonial_patrimonio_manutencao_paga_list', 'Inserir Manutenção', 'patrimonio_manutencao_home');
        $this->insertRoute('urbem_patrimonial_patrimonio_manutencao_paga_create', 'Novo', 'urbem_patrimonial_patrimonio_manutencao_paga_list');

        //Rotas de Patrimonial > Patrimonio > Manutencao > Excluir Manutencao
        $this->insertRoute('urbem_patrimonial_patrimonio_excluir_manutencao_paga_list', 'Excluir Manutenção', 'patrimonio_manutencao_home');
        $this->insertRoute('urbem_patrimonial_patrimonio_excluir_manutencao_paga_delete', 'Apagar', 'urbem_patrimonial_patrimonio_excluir_manutencao_paga_list');

        //Rotas de RH > Gerenciamento de Cargo > Cargo
        $this->insertRoute('urbem_recursos_humanos_pessoal_cargo_especialidade_create', 'Especialidade - Novo', 'urbem_recursos_humanos_pessoal_cargo_list', false);
        $this->insertRoute('urbem_recursos_humanos_pessoal_cargo_especialidade_edit', 'Especialidade - Editar', 'urbem_recursos_humanos_pessoal_cargo_list', false);
        $this->insertRoute('urbem_recursos_humanos_pessoal_cargo_especialidade_delete', 'Especialidade - Apagar', 'urbem_recursos_humanos_pessoal_cargo_list', false);
        $this->insertRoute('urbem_recursos_humanos_pessoal_cargo_padrao_create', 'Cargo Padrão - Novo', 'urbem_recursos_humanos_pessoal_cargo_list', false);
        $this->insertRoute('urbem_recursos_humanos_pessoal_cargo_padrao_edit', 'Cargo Padrão - Editar', 'urbem_recursos_humanos_pessoal_cargo_list', false);
        $this->insertRoute('urbem_recursos_humanos_pessoal_cargo_padrao_delete', 'Cargo Padrão - Apagar', 'urbem_recursos_humanos_pessoal_cargo_list', false);

        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configurar_ferias_create', 'Configurar Férias', 'folha_pagamento_configuracao_home');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configurar_ferias_edit', 'Configurar Férias', 'folha_pagamento_configuracao_home');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_create', 'Alterar Configuração', 'folha_pagamento_configuracao_home');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_create', 'Alterar Configuração', 'folha_pagamento_configuracao_home');

        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_list', 'Configuração Contracheque', 'folha_pagamento_configuracao_home');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_create', 'Novo', 'urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_edit', 'Editar', 'urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_delete', 'Remover', 'urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_show', 'Detalhes', 'urbem_recursos_humanos_folha_pagamento_configuracao_contracheque_list');


        //Rotas de Recursos HumanosFolha Pagamento - ConfiguraçãoConfigurar Cálculo de 13º Salário
        $this->insertRoute('urbem_patrimonial_patrimonio_excluir_manutencao_paga_list', 'Configurar Cálculo de 13º Salário', 'folha_pagamento_configuracao_home', false);

        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_evento_list', 'Folha de Pagamento - Evento', 'recursos_humanos');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_evento_create', 'Novo', 'urbem_recursos_humanos_folha_pagamento_evento_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_evento_edit', 'Editar', 'urbem_recursos_humanos_folha_pagamento_evento_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_evento_show', 'Detalhes', 'urbem_recursos_humanos_folha_pagamento_evento_list');

        //Rotas de Recursos Humanos > Folhas > Fechar/Reabrir Folha de Salário
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folha_situacao_create', 'Fechar/Reabrir Folha de Salário', 'folha_pagamento_folhas_index');

        //Rotas de Recursos Humanos > Folhas >  Folha Salário > Registrar Evento por Contrato
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_list', 'Folha Salário - Registrar Evento por Contrato', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_create', 'Novo', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_edit', 'Editar', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_show', 'Detalhes', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_delete', 'Apagar', 'folha_pagamento_folhas_index');

        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_create', 'Evento - Novo', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_list');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_delete', 'Evento - Apagar', 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_list');

        $this->insertRoute('patrimonio_inventario_home', 'Inventário', 'patrimonial');
        $this->insertRoute('urbem_patrimonial_patrimonio_exportacao_arquivo_coletora_list', 'Exportar Arquivo Coletora', 'patrimonio_inventario_home');
        $this->insertRoute('urbem_recursos_humanos_pessoal_contrato_servidor_create', 'Contrato - Novo', 'urbem_recursos_humanos_pessoal_servidor_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_contrato_servidor_edit', 'Contrato - Editar', 'urbem_recursos_humanos_pessoal_servidor_list');

        $this->insertRoute('urbem_recursos_humanos_pessoal_servidor_ctps_create', 'Ctps - Novo', 'urbem_recursos_humanos_pessoal_servidor_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_servidor_ctps_edit', 'Ctps - Editar', 'urbem_recursos_humanos_pessoal_servidor_list');
        $this->insertRoute('urbem_recursos_humanos_pessoal_servidor_ctps_delete', 'Ctps - Apagar', 'urbem_recursos_humanos_pessoal_servidor_list');
        //Rotas de Recursos Humanos > Folhas >  Folha Salário > Calcular Salario
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_calculo_salario_list', 'Folha Salário - Calcular Salário', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_folhas_calculo_salario_batch', 'Folha Salário - Calcular Salário', 'folha_pagamento_folhas_index');

        $this->insertRoute('urbem_patrimonial_patrimonio_exportacao_arquivo_coletora_create', 'Importar Arquivo Coletora', 'patrimonio_inventario_home');
        //Rotas de Recursos Humanos > Folhas >  Folha Salário > Consultar Ficha Financeira
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_list', 'Folha Salário - Consultar Ficha Financeira', 'folha_pagamento_folhas_index');
        $this->insertRoute('urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira_show', 'Folha Salário - Consultar Ficha Financeira', 'folha_pagamento_folhas_index');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
