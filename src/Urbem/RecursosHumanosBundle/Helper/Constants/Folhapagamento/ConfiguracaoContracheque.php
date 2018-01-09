<?php

namespace Urbem\RecursosHumanosBundle\Helper\Constants\Folhapagamento;

/**
 * Class ConfiguracaoContracheque
 * @package Urbem\RecursosHumanosBundle\Helper\Constants\Folhapagamento
 */
abstract class ConfiguracaoContracheque
{
    const MULTIPLE = 5;

    const CAMPOS = [
        'nome_entidade',
        'estado_entidade',
        'registro',
        'nom_cgm',
        'cbo',
        'competencia',
        'tipo_calculo',
        'funcao_especialidade',
        'orgao',
        'local',
        'pispasep',
        'cpf',
        'cnpj',
        'rg',
        'num_banco',
        'nom_banco',
        'num_agencia',
        'nom_agencia',
        'nr_conta',
        'eventos',
        'desc_eventos',
        'quantidades',
        'proventos',
        'descontos',
        'mensagem',
        'total_vencimentos',
        'total_descontos',
        'liquido',
        'salario_base',
        'base_inss',
        'base_fgts',
        'recolhido_fgts',
        'base_irrf',
        'faixa_irrf',
        'dependentes',
        'desdobramento',
        'dt_posse',
    ];
}
