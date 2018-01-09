<?php

namespace Urbem\PrestacaoContasBundle\Enum;

/**
 * Class FieldsAndData
 * @package Urbem\PrestacaoContasBundle\Enum
 */
abstract class FieldsAndData
{
    const INITIAL_DATE_NAME = 'data_inicio';
    const FINAL_DATE_NAME = 'data_fim';
    const FINANCIAL_YEAR_NAME = 'exercicio';
    const GOVERNMENT_AGENCY_NAME = 'orgao';
    const ST_CNPJ_SETOR_NAME = 'st_cnpj_setor';
    const ENTIDADE_NAME = 'entidade';
    const TWO_MONTHS_NAME = 'bimestre';
    const QUARTER_NAME = 'trimestre';
    const FOUR_MONTH_PERIOD_NAME = 'quadrimestre';
    const REPORT_TYPE_NAME = 'tipo_relatorio';
    const CNPJ_SETOR_NAME = 'cnpjsetor';
    const FILE_NAME = 'arquivo';
    const MONTH_NAME = 'mes';

    const PREFIX_NAME = 'cmb_';

    const GOVERNMENT_AGENCY_VALUE = '0201';

    /**
     * @var array
     */
    public static $fieldsConfiguracao = [
        'cod_entidade_prefeitura',
        'cod_entidade_rpps',
        'cod_entidade_camara',
        'orgao_unidade_outros'
    ];
}